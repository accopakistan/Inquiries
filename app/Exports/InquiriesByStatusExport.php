<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class InquiriesByStatusExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithCustomStartCell
{
    protected $inquiries;
    protected $status;

    public function __construct($inquiries, $status)
    {
        $this->inquiries = $inquiries;
        $this->status = $status;
    }

    public function startCell(): string
    {
        return 'A4'; // Start data from row 4 to allow space for header
    }

    public function collection()
    {
        return $this->inquiries->map(function ($inquiry) {
            return [
                'id' => $inquiry->id,
                'name' => $inquiry->name,
                'phone' => preg_replace('/[^0-9]/', '', $inquiry->phone),
                'project_type' => $inquiry->projectType->title ?? 'N/A',
                'date' => \Carbon\Carbon::parse($inquiry->date)->format('d-m-Y'),
                'remarks' => '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Phone Number',
            'Project Type',
            'Date of Inquiry',
            'Remarks',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set company header
        $sheet->setCellValue('A1', 'Ahmed Construction Company');
        $sheet->setCellValue('A2', 'Inquiry Call Report - ' . $this->status);
        $sheet->setCellValue('A3', 'Export Date: ' . now()->format('d-m-Y H:i'));

        // Style company header
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 16,
                'bold' => true,
                'color' => ['rgb' => '3858E9'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style subtitle
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 12,
                'italic' => true,
                'color' => ['rgb' => '474747'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
        ]);

        // Style export date
        $sheet->getStyle('A3')->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 10,
                'color' => ['rgb' => '909999'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
        ]);

        // Merge cells for company header
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');

        // Style column headings (row 4)
        $sheet->getStyle('A4:F4')->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 11,
                'bold' => true,
                'color' => ['rgb' => 'E0F2F1'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '3858E9'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '474747'],
                ],
            ],
        ]);

        // Set row height for headings
        $sheet->getRowDimension(4)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(22);

        // Style data rows
        $lastRow = $this->inquiries->count() + 4;

        for ($row = 5; $row <= $lastRow; $row++) {
            // Alternating row colors
            $fillColor = ($row % 2 === 0) ? 'CEDDDD' : 'E0F2F1';

            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
                'font' => [
                    'name' => 'Calibri',
                    'size' => 10,
                    'color' => ['rgb' => '474747'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => $fillColor],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'B2BFBE'],
                    ],
                ],
            ]);

            $sheet->getRowDimension($row)->setRowHeight(18);
        }

        // Center align ID column
        for ($row = 5; $row <= $lastRow; $row++) {
            $sheet->getStyle('A' . $row)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ]);
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getColumnDimension('F')->setWidth(30);

        // Freeze panes to keep header visible
        $sheet->freezePane('A5');

        return [];
    }
}

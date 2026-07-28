<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Inquiry::with('projectType');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search) // <-- Add this line for ID search
                  ->orWhere('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('location', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%");
            });
        }

        $data = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();

        if ($request->ajax()) {
            return view('partials.inquiries-results', compact('data'));
        }

        return view('inquiries', compact('data'));
    }

    public function dashboard()
    {
        // Total inquiries
        $totalInquiries = Inquiry::count();

        // Inquiries by project type (assuming titles: Hospital, Residential, Commercial, Industrial)
        $projectTypes = ProjectType::pluck('id', 'title'); // ['Hospital' => 1, ...]
        $hospitalCount = Inquiry::where('project_type_id', $projectTypes['Hospital'] ?? 0)->count();
        $residentialCount = Inquiry::where('project_type_id', $projectTypes['Residential'] ?? 0)->count();
        $commercialCount = Inquiry::where('project_type_id', $projectTypes['Commercial'] ?? 0)->count();
        $industrialCount = Inquiry::where('project_type_id', $projectTypes['Industrial'] ?? 0)->count();

        // Latest 5 inquiries
        $latestInquiries = Inquiry::with('projectType')->orderBy('id', 'desc')->take(13)->get();

        // Status counts (for progress bars or stats)
        $statusCounts = Inquiry::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Example: For chart data, you can prepare monthly counts
        $monthlyCounts = Inquiry::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        // Pass all data to the dashboard view
        return view('index', compact(
            'totalInquiries',
            'hospitalCount',
            'residentialCount',
            'commercialCount',
            'industrialCount',
            'latestInquiries',
            'statusCounts',
            'monthlyCounts'
        ));
    }

    public function inquiryByType($id)
    {
        // Get latest inquiries for the type and paginate
        $data = Inquiry::with('projectType')
            ->where('project_type_id', $id)
            ->orderBy('id', 'desc')
            ->paginate(40);

        // Optionally, fetch the project type title for display
        $projectType = ProjectType::find($id);

        // Pass data and projectType to the view
        return view('inquiry-by-type', compact('data', 'projectType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectType = ProjectType::all();

        return view('add-inquiry', compact('projectType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $InquiryData = new Inquiry();
        $InquiryData->name = $request->input('name');
        $InquiryData->phone = $request->input('phone');
        $InquiryData->email = $request->input('email') ?: 'admin@email.com';
        $InquiryData->project_type_id = $request->input('project_type');
        $InquiryData->description = $request->input('project_detail');
        $InquiryData->location = $request->input('location');
        $InquiryData->status = $request->input('status');
        $InquiryData->source = $request->input('source'); // <-- Add this line
        $InquiryData->date = $request->input('inquiry_date');
        $InquiryData->response = $request->input('response') ?: 'Not contacted Yet.';
        $InquiryData->credibility = $request->input('credibility', 50); // <-- Add this line

        // Handle Quotation PDF
        if ($request->hasFile('quotation')) {
            $file = $request->file('quotation');
            if ($file->getClientOriginalExtension() === 'pdf') {
                $filename = time().'_quotation_'.$file->getClientOriginalName();
                $file->move(public_path('quotations'), $filename);
                $InquiryData->quotation = $filename;
            } else {
                $InquiryData->quotation = 'nofile.pdf';
            }
        } else {
            $InquiryData->quotation = 'nofile.pdf';
        }

        // Handle Client Documents PDF
        if ($request->hasFile('client_documents')) {
            $clientFile = $request->file('client_documents');
            if ($clientFile->getClientOriginalExtension() === 'pdf') {
                $clientFilename = time().'_client_'.$clientFile->getClientOriginalName();
                $clientFile->move(public_path('documents'), $clientFilename);
                $InquiryData->document = $clientFilename; // Use 'document' here
            }
        }

        $InquiryData->save();

        return redirect('inquiries')->with('success', 'Inquiry saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inquiry = Inquiry::with(['projectType', 'followups' => function ($query) {
            $query->orderBy('followup_date', 'desc')->take(10);
        }])->findOrFail($id);

        return view('view-inquiry', compact('inquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $projectType = ProjectType::all();
        $data = Inquiry::findorfail($id);

        return view('update-inquiry', compact('projectType', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        $id = $request->input('id');
        $Inquiry = Inquiry::findorfail($id);

        $Inquiry->name = $request->input('name');
        $Inquiry->phone = $request->input('phone');
        $Inquiry->email = $request->input('email');
        $Inquiry->project_type_id = $request->input('project_type');
        $Inquiry->description = $request->input('project_detail');
        $Inquiry->location = $request->input('location');
        $Inquiry->status = $request->input('status');
        $Inquiry->source = $request->input('source'); // <-- Add this line
        $Inquiry->date = $request->input('inquiry_date');
        $Inquiry->response = $request->input('response') ?: 'Not contacted Yet.';
        $Inquiry->credibility = $request->input('credibility', 50); // <-- Add this line

        // Handle Quotation PDF
        if ($request->hasFile('quotation')) {
            $file = $request->file('quotation');
            if ($file->getClientOriginalExtension() === 'pdf') {
                $filename = time().'_quotation_'.$file->getClientOriginalName();
                $file->move(public_path('quotations'), $filename);
                $Inquiry->quotation = $filename;
            }
        }

        // Handle Client Documents PDF
        if ($request->hasFile('client_documents')) {
            $clientFile = $request->file('client_documents');
            if ($clientFile->getClientOriginalExtension() === 'pdf') {
                $clientFilename = time().'_client_'.$clientFile->getClientOriginalName();
                $clientFile->move(public_path('documents'), $clientFilename);
                $Inquiry->document = $clientFilename; // Use 'document' here
            }
        }

        $Inquiry->save();

        return redirect('inquiries')->with('success', 'Inquiry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Delete associated files if they exist and are not the default 'nofile.pdf'
        if ($inquiry->quotation && $inquiry->quotation !== 'nofile.pdf') {
            $quotationPath = public_path('quotations/'.$inquiry->quotation);
            if (file_exists($quotationPath)) {
                @unlink($quotationPath);
            }
        }
        if ($inquiry->document && $inquiry->document !== 'nofile.pdf') {
            $documentPath = public_path('documents/'.$inquiry->document);
            if (file_exists($documentPath)) {
                @unlink($documentPath);
            }
        }

        $inquiry->delete();

        return redirect('inquiries')->with('success', 'Inquiry deleted successfully.');
    }

    public function inquiriesByStatus(Request $request)
    {
        $status = $request->input('status');
        $query = Inquiry::with('projectType');

        if ($status) {
            $query->where('status', $status);
        }

        $data = $query->orderBy('id', 'desc')->paginate(25)->withQueryString();

        return view('inquiry-by-status', [
            'data' => $data,
            'selectedStatus' => $status,
            'projectType' => null, // or pass as needed
        ]);
    }

    public function export()
    {
        $inquiries = Inquiry::with('projectType')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inquiries.csv"',
        ];

        $columns = [
            'ID', 'Name', 'Phone', 'Email', 'Project Type', 'Location', 'Detail', 'Status', 'Source', 'Date of Inquiry', 'Response', 'Client Documents', 'Quotation', 'Credibility',
        ];

        $callback = function () use ($inquiries, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($inquiries as $item) {
                fputcsv($file, [
                    // For the main export
                    $item->id,
                    $item->name,
                    "\t".preg_replace('/[^0-9]/', '', $item->phone), // <-- Prepend tab for phone
                    $item->email,
                    $item->projectType->title ?? '',
                    $item->location,
                    $item->description,
                    $item->status,
                    $item->source, // <-- Add this line
                    \Carbon\Carbon::parse($item->date)->format('d F, Y'),
                    $item->response,
                    $item->document,
                    $item->quotation,
                    $item->credibility,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportDateForm()
    {
        return view('export-date');
    }

    public function exportDate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end = $request->end_date;

        $inquiries = Inquiry::whereBetween('date', [$start, $end])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="phone_numbers_'.$start.'_to_'.$end.'.csv"',
        ];

        $columns = ['Phone Number'];

        $callback = function () use ($inquiries, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($inquiries as $item) {
                fputcsv($file, [
                    "\t".preg_replace('/[^0-9]/', '', $item->phone), // <-- Prepend tab for phone
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    
        public function exportProjectTypeForm()
    {
        $projectTypes = ProjectType::all();

        return view('export-project-type', compact('projectTypes'));
    }

    public function exportProjectType(Request $request)
    {
        $request->validate([
            'project_type' => 'required|integer|exists:project_types,id',
        ]);

        $projectType = ProjectType::find($request->project_type);

        $inquiries = Inquiry::with('projectType')
            ->where('project_type_id', $request->project_type)
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inquiries_'.($projectType->title ?? 'project').'.csv"',
        ];

        $columns = [
            'ID', 'Name', 'Phone', 'Email', 'Project Type', 'Location', 'Detail', 'Status', 'Source', 'Date of Inquiry', 'Response', 'Client Documents', 'Quotation', 'Credibility',
        ];

        $callback = function () use ($inquiries, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($inquiries as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    "\t".preg_replace('/[^0-9]/', '', $item->phone),
                    $item->email,
                    $item->projectType->title ?? '',
                    $item->location,
                    $item->description,
                    $item->status,
                    $item->source,
                    \Carbon\Carbon::parse($item->date)->format('d F, Y'),
                    $item->response,
                    $item->document,
                    $item->quotation,
                    $item->credibility,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function todayFollowups()
    {
        // Get today's date (Y-m-d)
        $today = now()->toDateString();

        // Get all followups for today, eager load inquiry (id, name, project_type_id)
        $followups = \App\Models\Followup::with(['inquiry.projectType:id,title'])
            ->whereDate('followup_date', $today)
            ->orderBy('followup_date', 'desc')
            ->get();

        return view('today-followup', compact('followups'));
    }
    
    public function mostImportant()
    {
        $data = Inquiry::with('projectType')
            ->where('credibility', '>=', 80)
            ->where('credibility', '<=', 100)
            ->whereNotIn('status', ['Completed', 'In Progress'])
            ->orderBy('credibility', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('most-important', compact('data'));
    }
    public function exportStatusForm()
    {
        return view('export-status');
    }

    public function exportStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $status = $request->status;

        $inquiries = Inquiry::with('projectType')
            ->where('status', $status)
            ->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\InquiriesByStatusExport($inquiries, $status),
            'Inquiries_'.$status.'.xlsx'
        );
    }
}

<?php

namespace App\Support;

/**
 * Reads quotation details out of an inquiry's free-text description and location.
 *
 * Descriptions are typed by staff or come from the website form, in English and Roman Urdu, e.g.
 * "10 marla grey structure", "1knal", "24 marly ki jaga he", "General Hospital  Construction  5000yards", "40×70 2 floors".
 * Only clearly stated values are returned; the quotation pages show every one as "please check".
 */
class InquiryHints
{
    const SFT = ['marla' => 225, 'kanal' => 4500, 'acre' => 43560, 'sqyd' => 9, 'sft' => 1];

    const CITIES = [
        'lhr' => ['lahore', 'lhr'],
        'isb' => ['islamabad', 'isb'],
        'rwp' => ['rawalpindi', 'pindi'],
        'khi' => ['karachi', 'khi'],
        'fsd' => ['faisalabad', 'fsd'],
        'mul' => ['multan'],
        'grw' => ['gujranwala'],
        'skt' => ['sialkot'],
        'pew' => ['peshawar'],
    ];

    const AUTHS = [
        'dha'    => ['dha', 'defence', 'defense'],
        'bahria' => ['bahria'],
        'lda'    => ['lda'],
        'cda'    => ['cda', 'blue area', 'markaz'],
    ];

    // hospital types as named on the hospital design page
    const HOSPITAL_TYPES = [
        'Clinic / medical centre'          => ['dental', 'dentist', 'clinic'],
        'Teaching hospital'                => ['teaching', 'medical college'],
        'Gynaecology & paediatric hospital'=> ['gynae', 'gyne', 'gynec', 'paediatric', 'pediatric', 'children'],
        'Maternity & neonatal care unit'   => ['maternity', 'neonatal', 'mother'],
        'Oncology & radiology centre'      => ['oncology', 'cancer', 'radiology'],
        'Cardiac & dialysis unit'          => ['cardiac', 'cardio', 'heart', 'dialysis'],
        'Emergency & trauma centre'        => ['emergency', 'trauma'],
        'Diagnostic lab & imaging centre'  => ['laboratory', 'diagnostic', 'imaging', ' lab '],
        'Multi-specialty hospital'         => ['specialty', 'speciality', 'specialist'],
        'General hospital'                 => ['general hospital'],
    ];

    public static function read(?string $description, ?string $location = null): array
    {
        $d = self::normalise($description);
        $loc = self::normalise($location);
        $h = [];

        if ($plot = self::plot($d)) $h['plot'] = $plot;
        if ($floors = self::floors($d)) $h['floors'] = $floors;
        if ($beds = self::beds($d)) $h['beds'] = $beds;
        if ($scope = self::scope($d)) $h['scope'] = $scope;
        if ($city = self::first(self::CITIES, $loc) ?? self::first(self::CITIES, $d)) $h['city'] = $city;
        if ($auth = self::first(self::AUTHS, $loc) ?? self::first(self::AUTHS, $d)) $h['auth'] = $auth;
        if ($type = self::first(self::HOSPITAL_TYPES, ' ' . $d . ' ')) $h['hospital_type'] = $type;

        return $h;
    }

    private static function normalise(?string $s): string
    {
        $s = strtolower((string) $s);
        $s = str_replace(['×', '✕', '*'], 'x', $s);
        return preg_replace('/\s+/u', ' ', $s);
    }

    private static function num(string $s): float
    {
        return (float) str_replace(',', '', $s);
    }

    // plot size: Marla / Kanal / acre first, then frontage × depth, then square yards, then square feet
    private static function plot(string $d): ?array
    {
        $n = '(\d[\d,]*(?:\.\d+)?)\s*-?\s*';
        $units = [
            'marla' => '/' . $n . '(?:marl[aeiy]s?|marly|mrla)\b/',
            'kanal' => '/' . $n . '(?:kanals?|knals?|kanl)\b/',
            'acre'  => '/' . $n . 'acres?\b/',
        ];
        foreach ($units as $unit => $re) {
            if (preg_match($re, $d, $m) && self::num($m[1]) > 0) {
                $v = self::num($m[1]);
                return ['value' => $v, 'unit' => $unit, 'sft' => round($v * self::SFT[$unit]), 'text' => trim($m[0])];
            }
        }
        if (preg_match('/\b(\d{2,3}(?:\.\d+)?)\s*(?:ft|feet|\')?\s*x\s*(\d{2,3}(?:\.\d+)?)\b/', $d, $m)) {
            $w = self::num($m[1]);
            $dp = self::num($m[2]);
            return ['value' => $w * $dp, 'unit' => 'sft', 'sft' => $w * $dp, 'w' => $w, 'd' => $dp, 'text' => trim($m[0])];
        }
        if (preg_match('/' . $n . '(?:sq\.?\s*)?(?:yards?|yds?|yd|gaz)\b/', $d, $m) && self::num($m[1]) > 0) {
            $v = self::num($m[1]);
            return ['value' => $v, 'unit' => 'sqyd', 'sft' => $v * 9, 'text' => trim($m[0])];
        }
        if (preg_match('/' . $n . '(?:sq\.?\s*ft|sqft|sft|sq\.?\s*feet|square\s*f(?:ee|oo)t|sq\s*f)\b/', $d, $m) && self::num($m[1]) > 0) {
            $v = self::num($m[1]);
            return ['value' => $v, 'unit' => 'sft', 'sft' => $v, 'text' => trim($m[0])];
        }
        return null;
    }

    // floors: "G+3" = 3 above ground; "2 floors" / "double storey" = ground + 1; basements counted separately
    private static function floors(string $d): ?array
    {
        $f = [];
        $text = [];
        if (preg_match('/\b(?:(\d)?b\s*\+\s*)?g\s*\+\s*(\d{1,2})\b/', $d, $m)) {
            $f['u'] = (int) $m[2];
            if (strpos($m[0], 'b') !== false) $f['b'] = $m[1] !== '' ? (int) $m[1] : 1;   // "B+G+4", "2B+G+6"
            $text[] = trim($m[0]);
        } elseif (preg_match('/\b(\d{1,2})\s*-?\s*(?:floors?|stor(?:e)?ys?|stories|manzil[ae]?)\b/', $d, $m) && (int) $m[1] > 0) {
            $f['u'] = (int) $m[1] - 1;
            $text[] = trim($m[0]);
        } elseif (preg_match('/\b(single|double|triple)\s*-?\s*(?:stor(?:e)?y|storeys|floor)\b/', $d, $m)) {
            $f['u'] = ['single' => 0, 'double' => 1, 'triple' => 2][$m[1]];
            $text[] = trim($m[0]);
        }
        if (isset($f['b'])) {
            // already read from "B+G+…"
        } elseif (preg_match('/\b(\d)\s*basements?\b/', $d, $m)) {
            $f['b'] = (int) $m[1];
            $text[] = trim($m[0]);
        } elseif (preg_match('/\bbasements?\b/', $d) && !preg_match('/\b(?:no|without|bina)\s+basement/', $d)) {
            $f['b'] = 1;
            $text[] = 'basement';
        }
        if (!$f) return null;
        $f['text'] = implode(', ', $text);
        return $f;
    }

    // hospital beds — "50 bed", "100-bedded"; small numbers are bedrooms in a house, not hospital beds
    private static function beds(string $d): ?int
    {
        if (preg_match('/\b(\d{1,4})\s*-?\s*bed(?:ded|s)?\b/', $d, $m) && (int) $m[1] >= 5) {
            return (int) $m[1];
        }
        return null;
    }

    private static function scope(string $d): ?string
    {
        if (preg_match('/\b(?:design|drawings?|consultation|consultancy)\s+only\b|\bonly\s+(?:design|drawings?|consultation)\b/', $d)) return 'design';
        if (preg_match('/turn\s*-?\s*key/', $d)) return 'turnkey';
        $grey = preg_match('/\bgr[ae]y\b/', $d);
        $finish = preg_match('/\bfinish(?:ing|ed)?\b|full\s+developed/', $d);
        if ($grey && $finish) return 'turnkey';
        if ($grey) return 'gray';
        if ($finish) return 'finish';
        return null;
    }

    private static function first(array $map, string $s): ?string
    {
        if ($s === '') return null;
        foreach ($map as $key => $words) {
            foreach ($words as $w) {
                if (preg_match('/(?<![a-z])' . preg_quote(trim($w), '/') . '(?![a-z])/', $s)) {
                    return $key;
                }
            }
        }
        return null;
    }
}

<?php

namespace App\Support;

/**
 * The quotation builders, and which one an inquiry's project category opens.
 * Adding a quotation page later is one entry in PAGES (and, if a category should open it, in KEYWORDS).
 */
class QuotationPages
{
    const PAGES = [
        'house'    => ['label' => 'House construction', 'short' => 'House',    'url' => '/house-construction-cost-calculator', 'icon' => 'bi-house-door'],
        'plaza'    => ['label' => 'Commercial plaza',   'short' => 'Plaza',    'url' => '/commercial-plaza-cost-calculator',   'icon' => 'bi-building'],
        'hospital' => ['label' => 'Hospital design',    'short' => 'Hospital', 'url' => '/hospital-design-quotation',          'icon' => 'bi-hospital'],
    ];

    // matched against the category title, case-insensitive; first match wins
    const KEYWORDS = [
        'hospital' => ['hospital', 'clinic', 'medical', 'health'],
        'plaza'    => ['commercial', 'plaza', 'shop', 'office', 'mall'],
        'house'    => ['residential', 'house', 'home', 'villa'],
    ];

    /** The page key for a project category title, or null when no page fits (Industrial, Interior, …). */
    public static function forCategory(?string $title): ?string
    {
        $t = strtolower(trim((string) $title));
        if ($t === '') {
            return null;
        }
        foreach (self::KEYWORDS as $page => $words) {
            foreach ($words as $w) {
                if (strpos($t, $w) !== false) {
                    return $page;
                }
            }
        }
        return null;
    }

    public static function exists(?string $page): bool
    {
        return $page !== null && isset(self::PAGES[$page]);
    }

    /** URL of a page opened for an inquiry; the page fetches the inquiry from ?inquiry=. */
    public static function urlFor(string $page, int $inquiryId): string
    {
        return url(self::PAGES[$page]['url']) . '?inquiry=' . $inquiryId;
    }
}

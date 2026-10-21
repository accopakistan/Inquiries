<?php

namespace Tests\Unit;

use App\Support\InquiryHints;
use App\Support\QuotationPages;
use PHPUnit\Framework\TestCase;

/**
 * Reading quotation details from inquiry descriptions, and choosing the quotation page for a category.
 * Description samples are written the way real inquiries are (staff notes and website-form lines).
 * Pure PHP — no database.
 */
class InquiryHintsTest extends TestCase
{
    private function plot(string $text): ?array
    {
        return InquiryHints::read($text)['plot'] ?? null;
    }

    public function test_plot_in_marla_and_kanal_including_common_misspellings()
    {
        $p = $this->plot('10 marla   What are the charges of drawings');
        $this->assertSame(['marla', 10.0, 2250.0], [$p['unit'], $p['value'], $p['sft']]);
        $this->assertSame('marla', $this->plot('Valencia town mein 5 Marla house construct krwana ha')['unit']);
        $this->assertSame(24.0, $this->plot('Sir me hospital bana chahta hun 24 marly ki jaga he')['value']);
        $this->assertSame(8.0, $this->plot('Need to Inspect the 08 Marla Complete House')['value']);
        $this->assertSame(['kanal', 1.0], [$this->plot('Complete House Renovation  1knal  Renovation')['unit'], $this->plot('1knal')['value']]);
        $this->assertSame(4500.0, $this->plot('1 kANAL HOUSE')['sft']);
        $this->assertSame(4.0, $this->plot('General Hospital  Hospital Planning  4 kanal')['value']);
    }

    public function test_plot_in_yards_square_feet_and_dimensions()
    {
        $p = $this->plot('General Hospital  Construction  5000yards  after study');
        $this->assertSame(['sqyd', 5000.0, 45000.0], [$p['unit'], $p['value'], $p['sft']]);
        $this->assertSame('sqyd', $this->plot('Commercial Plaza  Turnkey Construction  + 1000 YDS')['unit']);
        $this->assertSame(22000.0, $this->plot('General Hospital  Consultancy  22000 sq feet')['sft']);
        $this->assertSame(4500.0, $this->plot('Specialty Hospital  Design  4500 Square feet')['sft']);

        $p = $this->plot('hospital 40×70 2 floors');
        $this->assertSame([40.0, 70.0, 2800.0], [$p['w'], $p['d'], $p['sft']]);
        $this->assertSame(3600.0, $this->plot('General Hospital  Design  60x60')['sft']);
    }

    public function test_marla_wins_over_a_square_feet_figure()
    {
        // the SFT figure is usually covered area; the Marla figure is the plot
        $this->assertSame('marla', $this->plot('10 marla plot, 3500 sqft covered')['unit']);
    }

    public function test_no_plot_when_none_is_stated()
    {
        $this->assertNull($this->plot('3d interior design for a dentist clinic drawing share'));
        $this->assertNull($this->plot('02-10-25 Meeting'));
    }

    public function test_floors_and_basements()
    {
        $this->assertSame(['u' => 1], array_diff_key(InquiryHints::read('hospital 40x70 2 floors')['floors'], ['text' => 1]));
        $this->assertSame(['u' => 4, 'b' => 1], array_diff_key(InquiryHints::read('8 marla B+G+4 plaza')['floors'], ['text' => 1]));
        $this->assertSame(['u' => 6, 'b' => 2], array_diff_key(InquiryHints::read('2B+G+6 commercial')['floors'], ['text' => 1]));
        $this->assertSame(['u' => 3], array_diff_key(InquiryHints::read('G+3 building')['floors'], ['text' => 1]));
        $this->assertSame(['u' => 1], array_diff_key(InquiryHints::read('double storey house')['floors'], ['text' => 1]));
        $this->assertSame(['b' => 1], array_diff_key(InquiryHints::read('house with basement')['floors'], ['text' => 1]));
        $this->assertArrayNotHasKey('floors', InquiryHints::read('house without basement'));
    }

    public function test_beds_only_at_hospital_scale()
    {
        $this->assertSame(50, InquiryHints::read('50 bed hospital')['beds']);
        $this->assertSame(100, InquiryHints::read('100-bedded general hospital')['beds']);
        // bedrooms in a house enquiry are not hospital beds
        $this->assertArrayNotHasKey('beds', InquiryHints::read('one bed at ground and 3 beds on second floor'));
    }

    public function test_scope()
    {
        $this->assertSame('gray', InquiryHints::read('How much gray structure for 2 floors')['scope']);
        $this->assertSame('turnkey', InquiryHints::read('construction cost (grey and finish) 4 Marla commercial plaza')['scope']);
        $this->assertSame('turnkey', InquiryHints::read('5 Marla Grey structure   Full Developed')['scope']);
        $this->assertSame('turnkey', InquiryHints::read('Commercial Plaza  Turnkey Construction')['scope']);
        $this->assertSame('finish', InquiryHints::read('only finishing required')['scope']);
        $this->assertSame('design', InquiryHints::read('8 Marla  design only')['scope']);
        $this->assertSame('design', InquiryHints::read('38 Marla  Yes, consultation only')['scope']);
        $this->assertArrayNotHasKey('scope', InquiryHints::read('10 Marla Plot Size'));
    }

    public function test_city_and_society_from_location_first()
    {
        $h = InquiryHints::read('4 Marla commercial plaza', 'DHA Phase 6, Lahore');
        $this->assertSame(['lhr', 'dha'], [$h['city'], $h['auth']]);
        $this->assertSame('khi', InquiryHints::read('', 'karachi, various prime locations')['city']);
        $this->assertSame('rwp', InquiryHints::read('', 'rawalpindi')['city']);
        $this->assertSame('bahria', InquiryHints::read('plot in Bahria Town', 'Lahore')['auth']);
        // a city inside another word is not a match
        $this->assertArrayNotHasKey('city', InquiryHints::read('', 'Mansehra kpk'));
    }

    public function test_hospital_type()
    {
        $this->assertSame('General hospital', InquiryHints::read('General Hospital  Construction')['hospital_type']);
        $this->assertSame('Clinic / medical centre', InquiryHints::read('3d interior design for a dentist clinic')['hospital_type']);
        $this->assertSame('Multi-specialty hospital', InquiryHints::read('Specialty Hospital  Design')['hospital_type']);
        $this->assertSame('Cardiac & dialysis unit', InquiryHints::read('dialysis centre 10 machines')['hospital_type']);
    }

    public function test_category_chooses_the_quotation_page()
    {
        $this->assertSame('house', QuotationPages::forCategory('Residential'));
        $this->assertSame('plaza', QuotationPages::forCategory('Commercial'));
        $this->assertSame('hospital', QuotationPages::forCategory('Hospital'));
        $this->assertSame('hospital', QuotationPages::forCategory('  HOSPITAL '));
        foreach (['Industrial', 'Interior', 'others', 'Renovation', 'Important Contacts', '', null] as $other) {
            $this->assertNull(QuotationPages::forCategory($other), (string) $other);
        }
        $this->assertTrue(QuotationPages::exists('plaza'));
        $this->assertFalse(QuotationPages::exists('industrial'));
        $this->assertFalse(QuotationPages::exists(null));
    }
}

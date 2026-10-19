<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * The hospital design quotation page. Calculations are tested in tests/js/hospital-design-calc.test.js;
 * these checks make sure the page and its inquiry lookup are protected and the page loads that engine.
 * No database access, so they are safe to run against the development database.
 */
class HospitalDesignPageTest extends TestCase
{
    public function test_guests_are_redirected_away_from_the_page()
    {
        $this->get('/hospital-design-quotation')->assertRedirect();
    }

    public function test_guests_cannot_look_up_inquiries()
    {
        $this->get('/hospital-design-quotation/inquiry/1')->assertRedirect();
    }

    public function test_the_page_loads_the_calculation_engine()
    {
        $html = view('hospital-design-quotation')->render();

        $this->assertStringContainsString('js/hospital-design-calc.js', $html);
        $this->assertStringContainsString('window.HospitalCalc', $html);
        $this->assertStringContainsString('/hospital-design-quotation/inquiry', $html);
        $this->assertFileExists(public_path('js/hospital-design-calc.js'));
    }

    public function test_the_quotation_follows_the_office_format()
    {
        $html = view('hospital-design-quotation')->render();

        $this->assertStringContainsString('ACCO/QTN/HOS', $html);
        $this->assertStringContainsString('List of architectural design work', $html);
        $this->assertStringContainsString('Tanveer Ahmed', $html);
    }
}

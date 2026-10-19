<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * The plaza estimator page. Calculations are tested in tests/js/commercial-plaza-calc.test.js;
 * these checks make sure the page is protected and actually loads that engine.
 * No database access, so they are safe to run against the development database.
 */
class CommercialPlazaPageTest extends TestCase
{
    public function test_guests_are_redirected_away_from_the_estimator()
    {
        $this->get('/commercial-plaza-cost-calculator')->assertRedirect();
    }

    public function test_the_page_loads_the_calculation_engine()
    {
        $html = view('commercial-plaza-cost')->render();

        $this->assertStringContainsString('public/js/commercial-plaza-calc.js', $html); // live site serves from the project root, so assets need public/
        $this->assertStringContainsString('window.PlazaCalc', $html);
        $this->assertFileExists(public_path('js/commercial-plaza-calc.js'));
    }

    public function test_the_quotation_is_labelled_as_preliminary()
    {
        $html = view('commercial-plaza-cost')->render();

        $this->assertStringContainsString('Preliminary Quotation', $html);
        $this->assertStringContainsString('It is not a fixed-price offer', $html);
    }
}

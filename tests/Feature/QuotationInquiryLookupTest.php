<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * The inquiry-number lookup shared by the house, commercial plaza and hospital design quotations
 * (public/js/inquiry-lookup.js and /quotation/inquiry/{id}).
 * No database access, so these are safe to run against the development database.
 */
class QuotationInquiryLookupTest extends TestCase
{
    const PAGES = ['house-construction-cost', 'commercial-plaza-cost', 'hospital-design-quotation'];

    public function test_guests_cannot_look_up_inquiries()
    {
        $this->get('/quotation/inquiry/1')->assertRedirect();
    }

    public function test_every_quotation_page_loads_the_lookup()
    {
        $this->assertFileExists(public_path('js/inquiry-lookup.js'));

        foreach (self::PAGES as $page) {
            $html = view($page)->render();

            // live site serves from the project root, so assets need public/
            $this->assertStringContainsString('public/js/inquiry-lookup.js', $html, $page);
            $this->assertStringContainsString('/quotation/inquiry', $html, $page);
            $this->assertStringContainsString('id="qInq"', $html, $page);
            $this->assertStringContainsString('Client ID', $html, $page);
        }
    }
}

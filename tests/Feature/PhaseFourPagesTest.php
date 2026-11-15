<?php

namespace Tests\Feature;

use App\Models\HomepageContent;
use App\Models\Offer;
use Database\Seeders\BusinessInfoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseFourPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_business_details_appear_without_delivery_hours_or_social_guesswork(): void
    {
        $this->seed(BusinessInfoSeeder::class);
        $this->seed(BusinessInfoSeeder::class);
        $content = HomepageContent::findOrFail(1);
        $this->assertSame("Taborstraße 53-55/1/R02\n1020 Wien", $content->address);
        $this->assertSame('+43 660 160 5353', $content->phone);
        $this->assertTrue((bool) $content->hours_provisional);
        $this->assertCount(2, $content->hours);
        $this->get('/kontakt')->assertOk()->assertSee('Taborstraße 53-55/1/R02')
            ->assertSee('+43 660 160 5353')->assertSee('Google Maps öffnen')
            ->assertSee('Vorläufige Öffnungszeiten')->assertSee('Foodora')
            ->assertDontSee('Instagram')->assertDontSee('07:00');
    }

    public function test_inner_pages_have_unique_metadata_and_live_content(): void
    {
        $this->get('/ueber-uns')->assertOk()->assertSee('<h1>Über uns</h1>', false)
            ->assertSee('<link rel="canonical"', false);
        $this->get('/angebote')->assertOk()->assertSee('Derzeit sind keine Angebote veröffentlicht.');
        Offer::create(['title' => 'Testaktion', 'original_price' => 1200, 'offer_price' => 900, 'is_active' => true]);
        $this->get('/angebote')->assertOk()->assertSee('Testaktion')->assertDontSee('Derzeit sind keine Angebote veröffentlicht.');
        $this->get('/impressum')->assertOk()->assertSee('noindex,follow');
    }
}

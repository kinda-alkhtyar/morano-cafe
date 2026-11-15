<?php

namespace Tests\Feature;

use App\Models\HomepageContent;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaunchPreparationTest extends TestCase
{
    use RefreshDatabase;

    public function test_map_waits_for_click_and_offers_show_conditions(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->get('/kontakt')->assertOk()->assertSee('data-map-load', false)
            ->assertDontSee('<iframe', false)->assertSee('Route in Google Maps öffnen');
        $this->get('/')->assertOk()->assertSee('data-map-load', false)->assertDontSee('<iframe', false);
        $this->get('/angebote')->assertOk()->assertSee('<details class="offer-conditions">', false)
            ->assertSee('Bei NeoTaste ansehen')->assertSee('pinsa-margherita.png');
    }

    public function test_legal_pages_are_editable_and_unpublished_pages_stay_out_of_sitemap(): void
    {
        $this->get('/impressum')->assertOk()->assertSee('noindex,follow');
        $this->get('/sitemap.xml')->assertOk()->assertDontSee('/impressum');
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /admin');
        HomepageContent::findOrFail(1)->update(['imprint_content' => 'Vom Eigentümer freigegebener Text']);
        $this->get('/impressum')->assertOk()->assertSee('Vom Eigentümer freigegebener Text')->assertDontSee('noindex,follow');
        $this->get('/sitemap.xml')->assertOk()->assertSee('/impressum');
    }

    public function test_catalog_admin_routes_require_verified_admin(): void
    {
        foreach (['categories', 'products', 'offers', 'allergens', 'homepage-contents'] as $resource) {
            $this->get('/admin/'.$resource)->assertRedirect('/admin/login');
        }
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'test-password']);
        $admin->forceFill(['is_admin' => true, 'email_verified_at' => now()])->save();
        foreach (['categories', 'products', 'offers', 'allergens', 'homepage-contents'] as $resource) {
            $this->actingAs($admin)->get('/admin/'.$resource)->assertOk();
        }
    }
}

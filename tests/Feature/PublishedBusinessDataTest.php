<?php

namespace Tests\Feature;

use App\Models\HomepageContent;
use App\Models\Offer;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishedBusinessDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_data_is_idempotent_and_separates_reference_prices(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);
        $this->assertSame(60, Product::count());
        $this->assertSame(2, Offer::whereNotNull('source_url')->count());
        $this->assertSame(600, Product::where('slug', 'matchamatcha-latte-hot')->firstOrFail()->reference_price);
        $this->assertNull(Product::where('slug', 'matchamatcha-latte-hot')->firstOrFail()->price);
        $this->assertSame(1290, Product::where('slug', 'pinsa-margherita')->firstOrFail()->reference_price);
        $this->assertTrue((bool) HomepageContent::findOrFail(1)->hours_provisional);
    }

    public function test_contact_and_offers_publish_sources_and_redemption_terms(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->get('/kontakt')->assertOk()->assertSee('maps.google.com/maps?q=', false)
            ->assertSee('Wolt')->assertSee('Foodora')->assertSee('NeoTaste')
            ->assertSee('08:00–23:59');
        $this->get('/angebote')->assertOk()->assertSee('2 für 1 Hauptgericht')
            ->assertSee('40 % Rabatt')->assertSee('Zeitfenster vorab in der App buchen');
        $this->get('/speisekarte')->assertOk()->assertSee('Referenzpreise')
            ->assertSee('Restaurantpreise müssen noch bestätigt werden');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\MenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DynamicMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_seed_is_idempotent_and_labels_unverified_prices(): void
    {
        $this->seed(MenuSeeder::class);
        $count = Product::count();
        $this->assertGreaterThan(50, $count);
        $this->seed(MenuSeeder::class);
        $this->assertSame($count, Product::count());

        $product = Product::where('slug', 'pinsa-margherita')->firstOrFail();
        $this->assertSame(1290, $product->reference_price);
        $this->assertNull($product->price);
        $this->get('/speisekarte')->assertOk()->assertSee('Pinsa Margherita')
            ->assertDontSee('Preis auf Anfrage')->assertDontSee('Weitere Angaben folgen')
            ->assertSee('12,90')->assertSee('Referenzpreis');
    }

    public function test_homepage_category_links_target_menu_filters(): void
    {
        $this->seed(MenuSeeder::class);
        $this->get('/')->assertOk()->assertSee('/speisekarte#kategorie-pinsa')
            ->assertSee('/speisekarte#kategorie-drinks')->assertSee('Pinsa Margherita');
    }

    public function test_drink_groups_and_replaced_matcha_image_are_visible(): void
    {
        $this->seed(MenuSeeder::class);
        $response = $this->get('/speisekarte')->assertOk();
        foreach (['Kaffee', 'Iced Coffee', 'Milkshakes', 'Matcha', 'Punsch &amp; Heißgetränke', 'Softdrinks'] as $label) {
            $response->assertSee($label, false);
        }
        $response->assertSee('0,33 l')->assertSee('data-filter-sub="matcha"', false);
        $this->assertSame('products/matcha/matcha-latte-hot.webp', Product::where('slug', 'matchamatcha-latte-hot')->firstOrFail()->image_path);
    }

    public function test_homepage_hides_empty_offers_but_shows_active_offers(): void
    {
        $this->get('/')->assertOk()->assertDontSee('offers-section');
        \App\Models\Offer::create(['title' => 'Testangebot', 'original_price' => 1000, 'offer_price' => 900, 'is_active' => true]);
        $this->get('/')->assertOk()->assertSee('offers-section')->assertSee('Testangebot');
    }
}

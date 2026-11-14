<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Offer;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_pages_are_public(): void
    {
        foreach (['/', '/ueber-uns', '/kontakt', '/impressum', '/datenschutz'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_catalog_pages_are_public(): void
    {
        $this->get('/speisekarte')->assertOk();
        $this->get('/angebote')->assertOk();
        $this->get('/up')->assertOk();
    }

    public function test_homepage_shows_live_catalog_content_without_invented_prices(): void
    {
        $category = Category::create(['name' => 'Testkategorie', 'slug' => 'testkategorie', 'image_path' => 'products/snacks/pinsa-margherita.png']);
        Product::create(['category_id' => $category->id, 'name' => 'Testprodukt', 'slug' => 'testprodukt', 'price' => 1234, 'image_path' => 'products/snacks/pinsa-margherita.png', 'is_featured' => true]);
        Offer::create(['title' => 'Testangebot', 'original_price' => 1500, 'offer_price' => 1200, 'is_active' => true]);

        $this->get('/')->assertOk()->assertSee('Testkategorie')->assertSee('Testprodukt')->assertSee('12,34')->assertSee('Testangebot');
    }

    public function test_empty_catalog_uses_distinct_category_assets_without_prices(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('Unsere Highlights')
            ->assertSee('products/snacks/pinsa-margherita.png')
            ->assertSee('products/salads/caesar-salat.png')
            ->assertSee('products/sandwiches/sandwich-gegrilltes-gemuese.png')
            ->assertSee('products/keks/new-york-cheesecake.png')
            ->assertSee('Produktnamen und Preise erscheinen hier');
    }
}

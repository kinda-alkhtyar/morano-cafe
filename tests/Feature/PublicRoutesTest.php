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

    public function test_all_six_categories_remain_visible_without_images(): void
    {
        Category::query()->update(['image_path' => null]);
        $response = $this->get('/')->assertOk();
        foreach (\App\Support\HomepageCategories::LABELS as $name) {
            $response->assertSee($name);
        }
        $this->assertSame(6, substr_count($response->getContent(), 'class="category-tile"'));
        $response->assertSee('brand-placeholder')->assertDontSee('fallback.svg');
    }

    public function test_homepage_uses_editable_images_and_business_details(): void
    {
        Category::where('homepage_slot', 'kaffee')->update(['image_path' => 'offers/coffee-cake.webp']);
        \App\Models\HomepageContent::findOrFail(1)->update([
            'address' => 'Testadresse 42', 'hours' => [['label' => 'Testtag', 'time' => '10:00–12:00']],
            'about_heading' => 'Testüberschrift', 'phone' => '+43 1234', 'email' => 'test@example.test',
        ]);
        $this->get('/')->assertOk()->assertSee('Testadresse 42')->assertSee('Testtag')->assertSee('10:00–12:00')
            ->assertSee('Testüberschrift')->assertSee('test@example.test')->assertSee('offers/coffee-cake.webp');
    }

    public function test_featured_products_and_current_offers_do_not_require_images(): void
    {
        $category = Category::where('homepage_slot', 'kaffee')->firstOrFail();
        Product::create(['category_id' => $category->id, 'name' => 'Testkaffee', 'slug' => 'testkaffee', 'price' => 420, 'is_featured' => true]);
        Offer::create(['title' => 'Testaktion', 'original_price' => 900, 'offer_price' => 800, 'is_active' => true]);
        Offer::create(['title' => 'Abgelaufene Testaktion', 'original_price' => 900, 'offer_price' => 700, 'is_active' => true, 'ends_at' => now()->subDay()]);
        $this->get('/')->assertOk()->assertSee('Testkaffee')->assertSee('4,20')->assertSee('Testaktion')->assertSee('8,00')->assertDontSee('Abgelaufene Testaktion');
    }

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
        Offer::create(['title' => 'Testangebot', 'original_price' => 1500, 'offer_price' => 1200, 'image_path' => 'offers/coffee-cake.webp', 'is_active' => true]);

        $this->get('/')->assertOk()->assertSee('Testkategorie')->assertSee('Testprodukt')->assertSee('12,34')->assertSee('Testangebot');
    }

    public function test_empty_catalog_uses_distinct_category_assets_without_prices(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('Highlights')->assertSee('Matcha &amp; Drinks', false)->assertSee('Standort &amp;', false)
            ->assertSee('products/snacks/pinsa-margherita.png')
            ->assertSee('products/salads/caesar-salat.png')
            ->assertSee('products/sandwiches/sandwich-gegrilltes-gemuese.png')
            ->assertSee('products/keks/new-york-cheesecake.png')
            ->assertDontSee('Produktnamen und Preise erscheinen hier')
            ->assertDontSee('MORANO+ Moments')
            ->assertDontSee('Dein Weg');
    }
}

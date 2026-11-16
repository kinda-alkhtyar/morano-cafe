<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\MenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersianLocaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_persian_selection_persists_across_public_pages_and_german_remains_default(): void
    {
        $this->get('/')->assertOk()->assertSee('lang="de-AT"', false);
        $this->get('/?lang=fa')->assertOk()->assertSee('lang="fa-IR" dir="rtl"', false)->assertSee('قهوهٔ شما.');
        $this->get('/kontakt')->assertOk()->assertSee('تماس و بازدید');
        $this->get('/angebote')->assertOk()->assertSee('پیشنهادهای ویژه');
        $this->get('/ueber-uns')->assertOk()->assertSee('دربارهٔ ما');
        $this->get('/speisekarte?lang=de')->assertOk()->assertSee('lang="de-AT"', false);
    }

    public function test_all_seeded_products_have_separate_persian_names(): void
    {
        $this->seed(MenuSeeder::class);
        $products = Product::all();
        $this->assertCount(60, $products);
        foreach ($products as $product) {
            $this->assertNotEmpty(config('persian.products')[$product->slug]['name'] ?? null, $product->slug);
            if ($product->description) {
                $this->assertNotEmpty(config('persian.products')[$product->slug]['description'] ?? null, $product->slug.' description');
            }
            foreach (explode(',', (string) $product->ingredients) as $term) {
                if (trim($term) !== '') $this->assertArrayHasKey(trim($term), config('persian.ingredients'), $product->slug.' ingredient: '.trim($term));
            }
        }
        $this->get('/speisekarte?lang=fa')->assertOk()->assertSee('پینسای مارگاریتا')->assertSee('سالاد سزار');
    }
}

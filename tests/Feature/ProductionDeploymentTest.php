<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\ProductionMenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionDeploymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_production_menu_seed_runs_once_without_changing_existing_products(): void
    {
        $this->seed(ProductionMenuSeeder::class);
        $count = Product::count();
        $this->assertSame(60, $count);
        $product = Product::where('slug', 'pinsa-margherita')->firstOrFail();
        $product->update(['name' => 'Owner approved name', 'description' => 'Owner approved description']);
        $this->seed(ProductionMenuSeeder::class);
        $this->assertSame($count, Product::count());
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Owner approved name', 'description' => 'Owner approved description']);
    }

    public function test_production_build_manifest_points_to_css_and_js_files(): void
    {
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true, flags: JSON_THROW_ON_ERROR);
        foreach (['resources/css/app.css', 'resources/js/app.js'] as $entry) {
            $this->assertArrayHasKey($entry, $manifest);
            $this->assertFileExists(public_path('build/'.$manifest[$entry]['file']));
        }
    }
}

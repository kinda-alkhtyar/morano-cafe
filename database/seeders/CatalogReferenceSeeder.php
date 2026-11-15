<?php

namespace Database\Seeders;

use App\Models\Allergen;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CatalogReferenceSeeder extends Seeder
{
    public function run(): void
    {
        // Exact product-name matches from the published Foodora listing. Promotional prices are excluded.
        $foodora = 'https://www.foodora.at/restaurant/bwtv/morano';
        foreach ([
            'new-york-cheesecake' => 490, 'schokoladenkuchen' => 490,
            'apfelstrudel' => 460, 'tiramisu' => 600,
            'vanilla-milkshake' => 650, 'chocolate-milkshake' => 690,
            'strawberry-milkshake' => 690, 'flat-white' => 490,
            'cappuccino' => 450, 'melange' => 470, 'caffe-latte' => 490,
            'caramel-macchiato' => 550, 'mocha' => 520,
            'iced-latte' => 550, 'iced-caramel-latte' => 590,
            'iced-mocha' => 590, 'hot-chocolate' => 500,
            'matchamatcha-latte-hot' => 600, 'matchaiced-matcha-latte' => 640,
        ] as $slug => $price) {
            $product = Product::where('slug', $slug)->first();
            if ($product && $product->price === null) {
                $product->update(['reference_price' => $price, 'reference_source' => $foodora]);
            }
        }

        // Wolt explicitly publishes these allergen codes for unambiguous product matches.
        $codes = [
            'new-york-cheesecake' => ['A', 'G'],
            'schokoladenkuchen' => ['A', 'C', 'G'],
            'apfelstrudel' => ['A', 'C', 'G'],
            'tiramisu' => ['A', 'C', 'G'],
            'cappuccino' => ['G'], 'caffe-latte' => ['G'],
            'flat-white' => ['G'], 'melange' => ['G'],
            'mocha' => ['G'], 'caramel-macchiato' => ['G'],
            'iced-latte' => ['G'], 'iced-caramel-latte' => ['G'],
            'iced-mocha' => ['G'], 'vanilla-milkshake' => ['G'],
            'chocolate-milkshake' => ['G'], 'strawberry-milkshake' => ['G'],
            'hot-chocolate' => ['G'], 'matchamatcha-latte-hot' => ['G'],
            'matchaiced-matcha-latte' => ['G'],
        ];
        foreach ($codes as $slug => $productCodes) {
            $product = Product::where('slug', $slug)->first();
            if (!$product || $product->allergens()->exists()) continue;
            $ids = [];
            foreach ($productCodes as $code) {
                $ids[] = Allergen::firstOrCreate(['code' => $code], ['name' => $code])->id;
            }
            $product->allergens()->syncWithoutDetaching($ids);
        }
    }
}

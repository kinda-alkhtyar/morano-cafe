<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

final class MenuGroups
{
    public const DRINKS = [
        'kaffee' => 'Kaffee',
        'iced-coffee' => 'Iced Coffee',
        'milkshakes' => 'Milkshakes',
        'matcha' => 'Matcha',
        'punsch' => 'Punsch & Heißgetränke',
        'softdrinks' => 'Softdrinks',
    ];

    public static function key(Product $product): string
    {
        $path = (string) $product->image_path;
        $slug = $product->slug;
        if (str_contains($path, '/cold-drinks/')) return 'softdrinks';
        if (str_contains($slug, 'punsch') || str_contains($path, 'hot-chocolate') || str_contains($slug, 'hot-chocolate')) return 'punsch';
        if (str_contains($path, '/matcha/') || str_contains($slug, 'matcha')) return 'matcha';
        if (str_contains($path, 'milkshake')) return 'milkshakes';
        if (str_contains($path, '/coffee/iced-')) return 'iced-coffee';
        return 'kaffee';
    }

    public static function for(Category $category): Collection
    {
        if (!in_array($category->homepage_slot, ['kaffee', 'drinks'], true)) {
            return collect([['key' => null, 'label' => null, 'products' => $category->products]]);
        }

        return collect(self::DRINKS)->map(fn ($label, $key) => [
            'key' => $key,
            'label' => $label,
            'products' => $category->products->filter(fn (Product $product) => self::key($product) === $key),
        ])->filter(fn ($group) => $group['products']->isNotEmpty())->values();
    }
}

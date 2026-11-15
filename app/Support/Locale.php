<?php

namespace App\Support;

use App\Models\Product;

final class Locale
{
    public static function fa(): bool { return app()->getLocale() === 'fa'; }

    public static function text(?string $german): ?string
    {
        if (!self::fa() || $german === null) return $german;
        return config('persian.ui')[$german] ?? $german;
    }

    public static function product(Product $product, string $field): ?string
    {
        if (!self::fa()) return $product->{$field};
        $record = config('persian.products')[$product->slug] ?? null;
        if (is_array($record) && !empty($record[$field])) return $record[$field];
        if ($field === 'ingredients' && $product->ingredients) return self::ingredients($product->ingredients);
        return $product->{$field};
    }

    private static function ingredients(string $ingredients): string
    {
        $terms = config('persian.ingredients');
        return collect(explode(',', $ingredients))->map(fn ($part) => $terms[trim($part)] ?? trim($part))->join('، ');
    }
}

<?php
namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class ImageUrl
{
    public static function for(?string $path): string
    {
        $path = ltrim((string) $path, '/');
        if ($path !== '' && !str_contains($path, '..')) {
            if (is_file(public_path('images/'.$path))) return asset('images/'.$path);
            if (Storage::disk('public')->exists($path)) return Storage::disk('public')->url($path);
        }
        return asset('images/fallback.svg');
    }
}

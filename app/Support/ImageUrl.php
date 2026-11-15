<?php
namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class ImageUrl
{
    public static function exists(?string $path): bool
    {
        $path = ltrim((string) $path, '/');
        return $path !== '' && !str_contains($path, '..')
            && (is_file(public_path('images/'.$path)) || Storage::disk('public')->exists($path));
    }

    public static function for(?string $path): string
    {
        $path = ltrim((string) $path, '/');
        if ($path !== '' && !str_contains($path, '..')) {
            if (is_file(public_path('images/'.$path))) {
                $encodedPath = implode('/', array_map('rawurlencode', explode('/', $path)));
                return asset('images/'.$encodedPath);
            }
            if (Storage::disk('public')->exists($path)) return Storage::disk('public')->url($path);
        }
        return asset('images/fallback.svg');
    }
}

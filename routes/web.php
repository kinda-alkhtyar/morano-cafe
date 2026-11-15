<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PublicLocale;

Route::middleware(PublicLocale::class)->group(function () {

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/speisekarte', [PageController::class, 'menu'])->name('menu');
Route::get('/angebote', [PageController::class, 'offers'])->name('offers');
Route::get('/ueber-uns', [PageController::class, 'about'])->name('about');
Route::get('/kontakt', [PageController::class, 'contact'])->name('contact');
Route::get('/impressum', [PageController::class, 'imprint'])->name('imprint');
Route::get('/datenschutz', [PageController::class, 'privacy'])->name('privacy');
Route::get('/sitemap.xml', function () {
    $business = \App\Models\HomepageContent::find(1);
    $routes = ['home', 'menu', 'offers', 'about', 'contact'];
    if (filled($business?->imprint_content)) $routes[] = 'imprint';
    if (filled($business?->privacy_content)) $routes[] = 'privacy';
    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($routes as $name) $xml .= '<url><loc>'.e(route($name)).'</loc></url>';
    return response($xml.'</urlset>', 200)->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');
Route::get('/robots.txt', fn () => response("User-agent: *\nDisallow: /admin\nSitemap: ".route('sitemap')."\n", 200)->header('Content-Type', 'text/plain; charset=UTF-8'));
});

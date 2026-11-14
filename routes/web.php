<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/speisekarte', [PageController::class, 'menu'])->name('menu');
Route::get('/angebote', [PageController::class, 'offers'])->name('offers');
Route::get('/ueber-uns', [PageController::class, 'about'])->name('about');
Route::get('/kontakt', [PageController::class, 'contact'])->name('contact');
Route::get('/impressum', [PageController::class, 'imprint'])->name('imprint');
Route::get('/datenschutz', [PageController::class, 'privacy'])->name('privacy');

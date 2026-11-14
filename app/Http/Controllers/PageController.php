<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $featured = Product::query()->where('is_available', true)->where('is_featured', true)
            ->whereHas('category', fn ($query) => $query->where('is_active', true))
            ->with('category')->orderBy('sort_order')->limit(6)->get();
        $offers = Offer::query()->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()))
            ->orderByDesc('starts_at')->limit(2)->get();
        $records = Category::query()->whereNotNull('homepage_slot')->get()->keyBy('homepage_slot');
        $homepageCategories = collect(\App\Support\HomepageCategories::LABELS)->map(function ($name, $slot) use ($records) {
            $record = $records->get($slot);
            return ['name' => $name, 'image_path' => $record?->image_path, 'slug' => $record?->slug];
        });
        $content = \App\Models\HomepageContent::query()->find(1) ?? new \App\Models\HomepageContent();
        return view('pages.home', compact('featured', 'offers', 'homepageCategories', 'content'));
    }

    public function menu(): View
    {
        return view('pages.menu', ['categories' => Category::query()->where('is_active', true)->with(['products' => fn ($query) => $query->where('is_available', true)->orderBy('sort_order')->with('allergens')])->orderBy('sort_order')->get()]);
    }
    public function offers(): View
    {
        return view('pages.offers', ['offers' => Offer::query()->where('is_active', true)->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))->where(fn ($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()))->get()]);
    }
    public function about(): View { return view('pages.placeholder', ['title' => 'Über uns']); }
    public function contact(): View { return view('pages.placeholder', ['title' => 'Kontakt']); }
    public function imprint(): View { return view('pages.placeholder', ['title' => 'Impressum']); }
    public function privacy(): View { return view('pages.placeholder', ['title' => 'Datenschutz']); }
}

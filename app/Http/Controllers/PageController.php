<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $featuredCandidates = Product::query()->where('is_available', true)->where('is_featured', true)
            ->whereNotNull('image_path')->with('category')->orderBy('sort_order')->get()
            ->filter(fn (Product $product) => is_file(public_path('images/'.$product->image_path))
                || Storage::disk('public')->exists($product->image_path));
        $featured = $featuredCandidates->unique('category_id')->take(4);
        if ($featured->count() < 4) {
            $featured = $featured->concat($featuredCandidates->whereNotIn('id', $featured->pluck('id'))
                ->take(4 - $featured->count()));
        }
        $offers = Offer::query()->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()))
            ->orderByDesc('starts_at')->limit(2)->get();

        return view('pages.home', compact('featured', 'offers'));
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

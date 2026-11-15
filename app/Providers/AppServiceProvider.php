<?php
namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Offer;
use App\Models\HomepageContent;
use App\Models\Allergen;
use App\Policies\CatalogPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Category::class, CatalogPolicy::class);
        Gate::policy(Product::class, CatalogPolicy::class);
        Gate::policy(Offer::class, CatalogPolicy::class);
        Gate::policy(Allergen::class, CatalogPolicy::class);
        View::composer('components.site-footer', fn ($view) => $view->with('business', HomepageContent::find(1)));
    }
}

<?php

use Database\Seeders\ProductionMenuSeeder;
use Database\Seeders\PublishedOffersSeeder;
use Database\Seeders\BusinessInfoSeeder;
use App\Models\Offer;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        if (app()->environment('production')) {
            app(ProductionMenuSeeder::class)->run();
            app(BusinessInfoSeeder::class)->run();
            if (!Offer::query()->exists()) {
                app(PublishedOffersSeeder::class)->run();
            }
        }
    }

    public function down(): void
    {
        // Keep catalog records and owner edits when rolling back schema changes.
    }
};

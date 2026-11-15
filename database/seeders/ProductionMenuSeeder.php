<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductionMenuSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::query()->exists()) {
            $this->command?->warn('Menu seeding skipped: products already exist. No catalog data was changed.');
            return;
        }

        $this->call(MenuSeeder::class);
    }
}

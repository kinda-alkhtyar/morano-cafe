<?php
namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array { return ['category_id' => Category::factory(), 'name' => fake()->words(2, true), 'slug' => fake()->unique()->slug(), 'price' => fake()->numberBetween(100, 5000)]; }
}

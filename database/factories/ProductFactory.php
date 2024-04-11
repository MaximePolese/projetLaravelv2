<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => fake()->word(),
            'description' => fake()->sentence(20),
            'story' => fake()->sentence(10),
            'image' => fake()->imageUrl(),
            'material' => fake()->word(),
            'color' => fake()->colorName(),
            'size' => fake()->randomElement(['S', 'M', 'L', 'XL']),
            'category' => fake()->randomElement(['art', 'clothing', 'jewelry', 'accessories', 'home']),
            'price' => fake()->randomFloat(2, 0, 1000),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'shop_id' => DB::table('shops')->inRandomOrder()->first()->id,
        ];
    }
}

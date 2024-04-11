<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = DB::table('products')->inRandomOrder()->first();
        return [
            'product_id' => $product->id,
            'order_id' => DB::table('orders')->inRandomOrder()->first()->id,
            'quantity' => fake()->numberBetween(1, 10),
            'price' => $product->price,
        ];
    }
}

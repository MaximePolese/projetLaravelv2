<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        User::factory(50)->create()->each(function ($user) use ($faker) {
            if ($user->role === 'craftman') {
                $user->shops()->saveMany(Shop::factory()->count($faker->numberBetween(1, 3))->make())
                    ->each(function ($shop) {
                        Product::factory()->create(['shop_id' => $shop->id]);
                    });
            }
        });
    }
}

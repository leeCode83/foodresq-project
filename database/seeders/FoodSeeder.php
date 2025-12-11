<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;
use App\Models\Seller;
use Illuminate\Support\Str;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $seller = Seller::where('email', 'seller@example.com')->first();
        $bakery = Seller::where('email', 'bakery@example.com')->first();

        if ($seller) {
            Food::create([
                'id' => Str::uuid(),
                'seller_id' => $seller->id,
                'title' => 'Chicken Parm',
                'description' => 'Breaded chicken breast topped with marinara sauce and melted mozzarella cheese.',
                'category' => 'RESTAURANT',
                'image_url' => 'https://placehold.co/800x600/orange/white?text=Chicken+Parm',
                'original_price' => 15.00,
                'discounted_price' => 8.99,
                'discount_percentage' => 40,
                'quantity' => 10,
                'available_quantity' => 10,
                'pickup_time_start' => now()->addHours(1),
                'pickup_time_end' => now()->addHours(5),
            ]);

            Food::create([
                'id' => Str::uuid(),
                'seller_id' => $seller->id,
                'title' => 'Spaghetti Bolognese',
                'description' => 'Classic meat sauce served over spaghetti.',
                'category' => 'RESTAURANT',
                'image_url' => 'https://placehold.co/800x600/red/white?text=Spaghetti',
                'original_price' => 12.00,
                'discounted_price' => 7.50,
                'discount_percentage' => 37,
                'quantity' => 15,
                'available_quantity' => 15,
                'pickup_time_start' => now()->addHours(1),
                'pickup_time_end' => now()->addHours(5),
            ]);
        }

        if ($bakery) {
            Food::create([
                'id' => Str::uuid(),
                'seller_id' => $bakery->id,
                'title' => 'Croissant Box',
                'description' => 'Box of 6 assorted croissants.',
                'category' => 'BAKERY',
                'image_url' => 'https://placehold.co/800x600/brown/white?text=Croissants',
                'original_price' => 20.00,
                'discounted_price' => 10.00,
                'discount_percentage' => 50,
                'quantity' => 5,
                'available_quantity' => 5,
                'pickup_time_start' => now()->addHours(2),
                'pickup_time_end' => now()->addHours(6),
            ]);
        }
    }
}

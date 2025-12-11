<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        Seller::create([
            'id' => Str::uuid(),
            'email' => 'seller@example.com',
            'password' => 'password12345', // Will be hashed by model cast
            'phone' => '1234567890',
            'business_name' => 'Mario\'s Trattoria',
            'business_type' => 'RESTAURANT',
            'description' => 'Authentic Italian cuisine.',
            'address' => '123 Pasta Lane',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'operating_hours' => ['open' => '10:00', 'close' => '22:00'],
        ]);

        Seller::create([
            'id' => Str::uuid(),
            'email' => 'bakery@example.com',
            'password' => 'password12345',
            'phone' => '0987654321',
            'business_name' => 'Sweet Tooth Bakery',
            'business_type' => 'BAKERY',
            'description' => 'Freshly baked goods daily.',
            'address' => '456 Sugar Ave',
            'latitude' => -6.210000,
            'longitude' => 106.826666,
            'operating_hours' => ['open' => '07:00', 'close' => '20:00'],
        ]);
    }
}

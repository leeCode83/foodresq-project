<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buyer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BuyerSeeder extends Seeder
{
    public function run(): void
    {
        Buyer::create([
            'id' => Str::uuid(),
            'name' => 'John Doe',
            'email' => 'buyer@example.com',
            'password' => 'password12345',
            'phone' => '1122334455',
            'address' => '789 Buyer St',
            'latitude' => -6.220000,
            'longitude' => 106.836666,
        ]);
    }
}

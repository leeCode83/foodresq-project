<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\Food;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = Buyer::where('email', 'buyer@example.com')->first();
        $seller = Seller::where('email', 'seller@example.com')->first();
        
        if ($buyer && $seller) {
            $food = Food::where('seller_id', $seller->id)->first();

            if ($food) {
                Transaction::create([
                    'id' => Str::uuid(),
                    'order_number' => 'FRQ-' . now()->year . '-001',
                    'buyer_id' => $buyer->id,
                    'seller_id' => $seller->id,
                    'food_id' => $food->id,
                    'quantity' => 1,
                    'total_price' => $food->discounted_price,
                    'status' => 'READY_FOR_PICKUP',
                    'payment_method' => 'E_WALLET',
                    'payment_status' => 'success', // Also check payment_status enum
                    'pickup_code' => 'X7K-9P2',
                    'pickup_time' => now()->addHours(2),
                ]);
            }
        }
    }
}

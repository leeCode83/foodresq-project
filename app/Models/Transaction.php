<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_number',
        'buyer_id',
        'seller_id',
        'food_id',
        'quantity',
        'total_price',
        'status',
        'paid_at',
        'completed_at',
        'cancelled_at',
        'cancellation_reason',
        'payment_method',
        'payment_id',
        'payment_proof',
        'payment_status',
        'pickup_code',
        'pickup_time',
        'pickup_verified_at',
    ];

    protected $casts = [
        'total_price' => 'float',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'pickup_time' => 'datetime',
        'pickup_verified_at' => 'datetime',
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}

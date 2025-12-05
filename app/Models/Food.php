<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'seller_id',
        'title',
        'description',
        'category',
        'image_url',
        'original_price',
        'discounted_price',
        'discount_percentage',
        'quantity',
        'available_quantity',
        'pickup_time_start',
        'pickup_time_end',
        'is_active',
    ];

    protected $casts = [
        'original_price' => 'float',
        'discounted_price' => 'float',
        'pickup_time_start' => 'datetime',
        'pickup_time_end' => 'datetime',
        'is_active' => 'boolean',
    ];
}

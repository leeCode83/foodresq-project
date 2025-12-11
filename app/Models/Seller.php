<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'email',
        'password',
        'phone',
        'profile_image',
        'business_name',
        'business_type',
        'description',
        'address',
        'latitude',
        'longitude',
        'operating_hours',
        'rating',
        'total_reviews',
        'total_orders',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'latitude' => 'float',
        'longitude' => 'float',
        'rating' => 'float',
        'operating_hours' => 'array',
    ];
}

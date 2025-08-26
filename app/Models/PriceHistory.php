<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'principal_name',
        'year',
        'price_usd',
    ];

    protected $casts = [
        'price_usd' => 'decimal:2',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBankRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'principal_name',
        'year',
        'price_usd',
        'reliability_score',
        'region',
        'active',
        'aliases',
    ];

    protected $casts = [
        'price_usd' => 'decimal:2',
        'reliability_score' => 'integer',
        'active' => 'boolean',
        'aliases' => 'array',
    ];
}

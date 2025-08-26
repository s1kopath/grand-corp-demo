<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductPrincipal extends Pivot
{
    protected $table = 'product_principals';

    protected $fillable = [
        'product_id',
        'principal_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}

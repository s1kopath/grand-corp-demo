<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'indent_id',
        'product_id',
        'qty',
        'price',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function indent(): BelongsTo
    {
        return $this->belongsTo(Indent::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterOfCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'indent_id',
        'customer_id',
        'bank_name',
        'issue_date',
        'expiry_date',
        'last_shipment_date',
        'amount',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'last_shipment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function indent(): BelongsTo
    {
        return $this->belongsTo(Indent::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'lc_id');
    }
}

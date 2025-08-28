<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indent extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'quotation_id',
        'customer_id',
        'principal_id',
        'status',
        'rate',
        'sample',
        'classification',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function principal(): BelongsTo
    {
        return $this->belongsTo(Principal::class);
    }

    public function letterOfCredits(): HasMany
    {
        return $this->hasMany(LetterOfCredit::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function accountEntries(): HasMany
    {
        return $this->hasMany(AccountEntry::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(IndentItem::class);
    }
}

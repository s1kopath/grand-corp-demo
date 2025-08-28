<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DebitNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'debit_note_number',
        'reference_number',
        'shipment_id',
        'customer_id',
        'status',
        'issue_date',
        'due_date',
        'paid_date',
        'total_amount',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'currency',
        'payment_terms',
        'late_payment_fee',
        'terms_conditions',
        'charges',
        'issued_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'issued_at' => 'datetime',
        'charges' => 'array',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function accountEntries(): HasMany
    {
        return $this->hasMany(AccountEntry::class);
    }
}

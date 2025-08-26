<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'indent_id',
        'type',
        'amount',
        'entry_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'entry_date' => 'date',
    ];

    public function indent(): BelongsTo
    {
        return $this->belongsTo(Indent::class);
    }
}

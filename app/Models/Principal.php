<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Principal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_principals')
            ->withPivot('active')
            ->withTimestamps();
    }

    public function indents(): HasMany
    {
        return $this->hasMany(Indent::class);
    }
}

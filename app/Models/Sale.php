<?php

namespace App\Models;

use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Sale extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    // One sale has many items
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // Optional customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function transaction(): MorphOne
{
    return $this->morphOne(Transaction::class, 'transactionable');
}
}

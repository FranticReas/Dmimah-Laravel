<?php

namespace App\Models;

use App\Models\StockPurchaseItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class StockPurchase extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    // One purchase has many items
    public function items(): HasMany
    {
        return $this->hasMany(StockPurchaseItem::class);
    }

    public function transaction(): MorphOne
{
    return $this->morphOne(Transaction::class, 'transactionable');
}
}

<?php

namespace App\Models;

use App\Models\StockPurchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
    ];

    // One stock item can be used in many products
    public function productIngredients(): HasMany
    {
        return $this->hasMany(ProductIngredient::class);
    }

    // Optional: stock purchases (if you add it later)
    public function purchases(): HasMany
    {
        return $this->hasMany(StockPurchase::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(StockPurchaseItem::class);
    }
}

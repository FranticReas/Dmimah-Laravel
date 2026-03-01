<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // One product has many ingredients
    public function productIngredients(): HasMany
    {
        return $this->hasMany(ProductIngredient::class);
    }

    // One product has many order details
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function stocks()
    {
        return $this->belongsToMany(Stock::class)
            ->withPivot('quantity_required')
            ->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductIngredient extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'quantity_requires' => 'decimal:2',
    ];

    // This ingredient belongs to one product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // This ingredient uses one stock
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}

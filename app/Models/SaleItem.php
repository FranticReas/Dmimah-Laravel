<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'quantity'   => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total'      => 'decimal:2',
    ];

    // Belongs to one sale
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    // Belongs to one product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockPurchaseItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function stockPurchase()
    {
        return $this->belongsTo(StockPurchase::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}

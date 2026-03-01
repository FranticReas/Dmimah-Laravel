<?php

namespace App\Services;

use App\Models\Sale;
use Carbon\Carbon;

class InvoiceService
{
    public function generate()
    {
        $date = Carbon::now()->format('Ymd');

        $lastSale = Sale::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastSale) {
            $lastNumber = (int) substr($lastSale->invoice_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return 'INV-' . $date . '-' . $newNumber;
    }
}
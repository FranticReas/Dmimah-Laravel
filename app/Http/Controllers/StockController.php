<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockPurchase;
use App\Models\StockPurchaseItem;
use App\Models\Transaction;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    function index()
    {
        $stocks = Stock::get();
        $ingredients = Stock::orderBy('name')->get();

        return view('stock.index', compact('stocks', 'ingredients'));
    }

    function store(Request $request, InvoiceService $invoiceService)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|numeric|min:0.01',
            'price' => 'required|numeric|min:0',
            'unit' => 'required',
            'measurement_unit' => 'required',
            'supplier_name' => 'required',
            'min_stock' => 'required|numeric|min:0',
        ]);

        $invoiceNumber = $invoiceService->generate();

        DB::transaction(function () use ($request, $invoiceNumber) {

            $pricePerUnit = $request->price / $request->quantity;
            $taxAmount = $request->price * ($request->tax ?? 0) / 100;
                $discountAmount = $request->price * ($request->discount ?? 0) / 100;
                $totalAmount = $request->price + $taxAmount - $discountAmount;

            // 1️⃣ Cari atau buat stock
            $stock = Stock::firstOrNew([
                'name' => $request->name,
                'measurement_unit' => $request->measurement_unit
            ]);

            if ($stock->exists) {
                $stock->quantity += $request->quantity * $request->unit;
            } else {
                $stock->quantity = $request->quantity * $request->unit;
                $stock->minimum_stock = $request->min_stock;
            }

            $stock->unit_price = $pricePerUnit;
            $stock->save();

            // 2️⃣ Buat header pembelian
            $purchase = StockPurchase::create([
                'invoice_number' => $invoiceNumber,
                'supplier_name' => $request->supplier_name,
                'subtotal' => $request->price,
                'tax' => $taxAmount,
                'discount' => $discountAmount,
                'total' => $totalAmount,
                'purchase_date' => now(),
            ]);

            // 3️⃣ Buat detail pembelian
            StockPurchaseItem::create([
                'stock_purchase_id' => $purchase->id,
                'stock_id' => $stock->id,
                'quantity' => $request->quantity,
                'unit_price' => $pricePerUnit,
                'total' => $request->quantity * $pricePerUnit,
            ]);

            // 5️⃣ Catat ke transactions (expense)
            Transaction::create([
                'type' => 'expense',
                'amount' => $totalAmount,
                'reference_type' => 'stock_purchases',
                'reference_id' => $purchase->id,
                'transaction_date' => now(),
            ]);
        });

        return redirect()->back()->with('message', 'Stock berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|numeric'
        ]);

        $stock = Stock::findOrFail($id);

        $stock->update($request->all());

        return redirect()->back()
            ->with('message', 'Stok berhasil diupdate!');
    }

    public function destroy(Stock $stock)
    {
        Stock::findOrFail($stock->id)->delete();

        return redirect()->back()
            ->with('message', 'Stok berhasil dihapus!');
    }
}

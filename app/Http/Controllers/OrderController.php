<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use App\Models\Transaction;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function index()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $saleItems = SaleItem::with('product')->latest()->get();

        return view('order', compact('customers', 'products', 'saleItems'));
    }

    function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        // hapus semua sale items dulu
        $sale->saleItems()->delete();

        // hapus transaction
        Transaction::where('reference_type', 'sale')
            ->where('reference_id', $sale->id)
            ->delete();

        $sale->delete();

        return redirect()->back()
            ->with('success', 'Order berhasil dihapus!');
    }

    function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('order.index', compact('customers', 'products'));
    }

    public function store(Request $request, InvoiceService $invoiceService)
    {
        try {

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|numeric|min:1',
                'customer_name' => 'required|exists:customers,name',
                'tax' => 'nullable|numeric|min:0',
                'discount' => 'nullable|numeric|min:0',
                'via' => 'required'
            ]);

            $invoiceNumber = $invoiceService->generate();

            DB::transaction(function () use ($request, $invoiceNumber) {

                $product = Product::with('productIngredients.stock')
                    ->lockForUpdate()
                    ->findOrFail($request->product_id);
                $customer = Customer::where('name', $request->customer_name)->first();
                $orderQty = $request->quantity;

                foreach ($product->productIngredients as $ingredient) {

                    $requiredAmount = $ingredient->quantity_required * $orderQty;
                    $stock = $ingredient->stock;

                    if ($stock->quantity < $requiredAmount) {
                        throw new \Exception("Stok {$stock->name} tidak mencukupi!");
                    }
                }

                // Kurangi stok
                foreach ($product->productIngredients as $ingredient) {
                    $requiredAmount = $ingredient->quantity_required * $orderQty;
                    $stock = $ingredient->stock;
                    $stock->quantity -= $requiredAmount;
                    $stock->save();
                }

                $subtotal = $product->selling_price * $orderQty;
                $taxAmount = $subtotal * ($request->tax ?? 0) / 100;
                $discountAmount = $subtotal * ($request->discount ?? 0) / 100;
                $totalAmount = $subtotal + $taxAmount - $discountAmount;

                $sale = Sale::create([
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $customer->id,
                    'subtotal' => $subtotal,
                    'tax' => $taxAmount,
                    'discount' => $discountAmount,
                    'total' => $totalAmount,
                    'payment_method' => $request->via,
                    'sale_date' => now(),
                ]);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $orderQty,
                    'price' => $product->selling_price,
                    'total' => $subtotal,
                ]);

                Transaction::create([
                    'type' => 'income',
                    'amount' => $totalAmount,
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                    'transaction_date' => now(),
                ]);
            });

            return back()->with('message', 'Penjualan berhasil disimpan!');

        } catch (\Exception $e) {

            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function update(Request $request, $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $sale = Sale::findOrFail($order); // data-id passes sale->id
        $sale->status = $request->status;
        $sale->save();

        return back()->with('message', 'Status berhasil diperbarui');
    }
}

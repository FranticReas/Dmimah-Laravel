<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::get();

        return view('product', compact('products'));
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'selling_price' => 'required|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()->back()
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'Produk berhasil dihapus!');
    }

    function edit(Product $product)
    {
        $stocks = Stock::all();

        return view('product.edit', compact('product', 'stocks'));
    }

    function storeBahan(Request $request, Product $product)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'jumlah_dibutuhkan' => 'required|numeric|min:1',
        ]);

        ProductIngredient::create([
            'product_id' => $product->id,
            'stock_id' => $request->stock_id,
            'quantity_required' => $request->jumlah_dibutuhkan,
        ]);


        return back()->with('success', 'Bahan berhasil ditambahkan');
    }

    function destroyBahan(Product $product, Stock $stock)
    {
        $product->stocks()->detach($stock->id);

        return back()->with('success', 'Bahan berhasil dihapus');
    }

    function show($id)
    {
        $product = Product::with('productIngredients.stock')->findOrFail($id);

        return view('product.edit', compact('product'));
    }
}

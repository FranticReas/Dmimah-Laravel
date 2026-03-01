<?php

namespace App\Http\Controllers;

use App\Models\ProductIngredient;
use Illuminate\Http\Request;

class ProductIngredientController extends Controller
{
    public function destroy($id)
    {
        $productIngredient = ProductIngredient::findOrFail($id);
        $productIngredient->delete();

        return redirect()->back()->with('success', 'Produk bahan berhasil dihapus');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_dibutuhkan' => 'required|numeric|min:1'
        ]);

        $ingredient = ProductIngredient::findOrFail($id);
        $ingredient->update([
            'quantity_required' => $request->jumlah_dibutuhkan
        ]);

        return back()->with('success', 'Jumlah berhasil diperbarui');
    }
}

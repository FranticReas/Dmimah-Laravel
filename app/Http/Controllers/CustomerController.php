<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    function index()
    {
        $customers = Customer::get();

        return view('customer', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:customers,phone_number',
            'address' => 'required',
            'description' => 'nullable',
        ]);

        Customer::create($validated);

        return redirect()->route('customer')
            ->with('message', 'Berhasil menambahkan pelanggan baru!');
    }

    function destroy($id)
    {
        Customer::findOrFail($id)->delete();

        Session::flash('message', 'Berhasil menghapus pelanggan!');

        return redirect()->route('customer.index');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->update([
            'name' => $request->nama,
            'phone_number' => $request->no_hp,
            'address' => $request->alamat,
            'description' => $request->deskripsi,
        ]);

        Session::flash('message', 'Berhasil mengubah data pelanggan!');

        return redirect()->route('customer.index');
    }
}

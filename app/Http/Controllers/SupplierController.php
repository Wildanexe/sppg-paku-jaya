<?php

namespace App\Http\Controllers;

use App\Models\Supplier; // Pastikan Model di-import
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Cukup SATU fungsi index
    public function index() {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    // Cukup SATU fungsi store
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        Supplier::create($request->all());

        return redirect()->back()->with('success', 'Supplier berhasil ditambah!');
    }
    public function edit($id) {
    $supplier = \App\Models\Supplier::findOrFail($id);
    return view('suppliers.edit', compact('supplier'));
}

public function update(Request $request, $id) {
    $request->validate(['name' => 'required']);
    \App\Models\Supplier::findOrFail($id)->update($request->all());
    return redirect()->route('suppliers.index')->with('success', 'Data Supplier diperbarui!');
}

public function destroy($id) {
    \App\Models\Supplier::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Supplier berhasil dihapus!');
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Supplier;
use App\Models\StockBatch;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index() {
        // Ambil semua batch stok, urutkan berdasarkan yang MAU EXPIRED duluan (FEFO)
        $stocks = StockBatch::with(['material', 'supplier'])
                            ->orderBy('expiry_date', 'asc')
                            ->get();

        $materials = Material::all();
        $suppliers = Supplier::all();

        return view('stocks.index', compact('stocks', 'materials', 'suppliers'));
    }

    public function store(Request $request) {
        $request->validate([
            'material_id' => 'required',
            'initial_quantity' => 'required|numeric',
            'price_per_unit' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        // current_quantity disamakan dengan initial_quantity saat pertama masuk
        $data = $request->all();
        $data['current_quantity'] = $request->initial_quantity;
        $data['received_date'] = now();

        StockBatch::create($data);

        return redirect()->back()->with('success', 'Stok masuk berhasil dicatat!');
    }
    public function edit($id) {
    $stock = \App\Models\StockBatch::findOrFail($id);
    $materials = \App\Models\Material::all();
    $suppliers = \App\Models\Supplier::all();
    return view('stocks.edit', compact('stock', 'materials', 'suppliers'));
}

public function update(Request $request, $id) {
    $request->validate(['initial_quantity' => 'required|numeric', 'expiry_date' => 'required|date']);
    \App\Models\StockBatch::findOrFail($id)->update($request->all());
    return redirect()->route('stocks.index')->with('success', 'Data stok/batch diperbarui!');
}

public function destroy($id) {
    \App\Models\StockBatch::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Batch stok berhasil dihapus dari gudang!');
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Category;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index() {
        // Ambil data bahan baku sekalian nama kategorinya
        $materials = Material::with('category')->get();
        // Ambil semua kategori untuk isi dropdown di form
        $categories = Category::all();

        return view('materials.index', compact('materials', 'categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'unit' => 'required'
        ]);

        Material::create($request->all());

        return redirect()->back()->with('success', 'Bahan baku berhasil ditambah!');
    }
    public function edit($id) {
    $material = \App\Models\Material::findOrFail($id);
    $categories = \App\Models\Category::all();
    return view('materials.edit', compact('material', 'categories'));
}

public function update(Request $request, $id) {
    $request->validate(['name' => 'required', 'category_id' => 'required', 'unit' => 'required']);
    \App\Models\Material::findOrFail($id)->update($request->all());
    return redirect()->route('materials.index')->with('success', 'Bahan baku diperbarui!');
}

public function destroy($id) {
    \App\Models\Material::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Bahan baku dihapus!');
}
}

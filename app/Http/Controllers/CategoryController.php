<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan halaman daftar kategori & form
    public function index() {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request) {
        $request->validate(['name' => 'required']);
        Category::create($request->all());
        return redirect()->back()->with('success', 'Kategori berhasil ditambah!');
    }
    public function edit($id) {
    $category = \App\Models\Category::findOrFail($id);
    return view('categories.edit', compact('category'));
}

public function update(Request $request, $id) {
    $request->validate(['name' => 'required']);
    \App\Models\Category::findOrFail($id)->update($request->all());
    return redirect()->route('categories.index')->with('success', 'Kategori diperbarui!');
}

public function destroy($id) {
    \App\Models\Category::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Kategori dihapus!');
}
}

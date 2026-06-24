@extends('layouts.app')

@section('content')
<div class="card">
    <h3 style="margin-bottom: 20px;"><i class="fas fa-edit"></i> Edit Kategori Bahan</h3>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT') <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; color: #64748b;">Nama Kategori</label>
            <input type="text" name="name" value="{{ $category->name }}"
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-save"></i> Perbarui Kategori
        </button>
        <a href="{{ route('categories.index') }}" style="margin-left: 10px; color: #64748b; text-decoration: none;">Batal</a>
    </form>
</div>
@endsection

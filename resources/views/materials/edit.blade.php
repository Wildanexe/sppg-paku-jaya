@extends('layouts.app')

@section('content')
<div class="card">
    <h3><i class="fas fa-edit"></i> Edit Bahan Baku</h3>
    <form action="{{ route('materials.update', $material->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 15px;">
            <input type="text" name="name" value="{{ $material->name }}" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>

            <select name="category_id" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $material->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <input type="text" name="unit" value="{{ $material->unit }}" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        <button type="submit" class="btn-primary" style="margin-top: 15px;">Update Bahan</button>
    </form>
</div>
@endsection

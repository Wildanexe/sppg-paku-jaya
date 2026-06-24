@extends('layouts.app')

@section('content')
<div class="card">
    <h3><i class="fas fa-edit"></i> Edit Supplier</h3>
    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <input type="text" name="name" value="{{ $supplier->name }}" placeholder="Nama Supplier" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
            <input type="text" name="phone" value="{{ $supplier->phone }}" placeholder="No Telepon" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
        </div>
        <textarea name="address" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">{{ $supplier->address }}</textarea>
        <button type="submit" class="btn-primary" style="margin-top: 15px;">Simpan Perubahan</button>
    </form>
</div>
@endsection

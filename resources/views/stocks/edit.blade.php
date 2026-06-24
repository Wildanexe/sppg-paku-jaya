@extends('layouts.app')

@section('content')
<div class="card">
    <h3><i class="fas fa-edit"></i> Edit Batch Stok #{{ $stock->id }}</h3>
    <form action="{{ route('stocks.update', $stock->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label>Jumlah Awal:</label>
                <input type="number" name="initial_quantity" value="{{ $stock->initial_quantity }}" style="width:100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            <div>
                <label>Harga Satuan:</label>
                <input type="number" name="price_per_unit" value="{{ $stock->price_per_unit }}" style="width:100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            <div>
                <label>Tanggal Expired:</label>
                <input type="date" name="expiry_date" value="{{ $stock->expiry_date->format('Y-m-d') }}" style="width:100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
        </div>
        <button type="submit" class="btn-primary" style="margin-top: 15px;">Perbarui Batch</button>
    </form>
</div>
@endsection

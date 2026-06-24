@extends('layouts.app')

@section('content')
<div class="card">
    <h3 style="margin-bottom: 20px;"><i class="fas fa-file-import"></i> Pencatatan Barang Masuk</h3>
    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <select name="material_id" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>
                <option value="">-- Pilih Bahan --</option>
                @foreach($materials as $m)
                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->unit }})</option>
                @endforeach
            </select>
            <input type="number" name="initial_quantity" placeholder="Jumlah Masuk" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>
            <input type="number" name="price_per_unit" placeholder="Harga Satuan (Budgeting)" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>
            <div style="display: flex; align-items: center; gap: 10px;">
                <label style="font-size: 0.8rem;">Tgl Expired:</label>
                <input type="date" name="expiry_date" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; flex: 1;" required>
            </div>
        </div>
        <button type="submit" class="btn-primary" style="margin-top: 15px; background: #10b981;">
            <i class="fas fa-plus"></i> Simpan Stok Masuk
        </button>
    </form>
</div>

<div class="card" style="margin-top: 20px;">
    <h3><i class="fas fa-layer-group"></i> Daftar Batch Gudang (Urut FEFO)</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead style="background: #f1f5f9;">
            <tr style="text-align: left;">
                <th style="padding: 12px;">Bahan</th>
                <th>Sisa Stok</th>
                <th>Tgl Expired</th>
                <th>Harga Satuan</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $st)
            <tr style="border-bottom: 1px solid #f1f5f9; background: {{ $st->expiry_date <= now()->addDays(7) ? '#fff1f2' : '' }}">
                <td style="padding: 12px;">
                    <strong>{{ $st->material->name }}</strong><br>
                    <small style="color: #64748b;">Batch #{{ $st->id }}</small>
                </td>
                <td>{{ $st->current_quantity }} {{ $st->material->unit }}</td>
                <td style="color: {{ $st->expiry_date <= now() ? 'red' : 'inherit' }}; font-weight: {{ $st->expiry_date <= now() ? 'bold' : 'normal' }}">
                    {{ $st->expiry_date->format('d M Y') }}
                </td>
                <td>Rp {{ number_format($st->price_per_unit, 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    <a href="{{ route('stocks.edit', $st->id) }}" style="color: #0ea5e9; margin-right: 10px;">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('stocks.destroy', $st->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus batch ini? Stok akan hilang dari gudang!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

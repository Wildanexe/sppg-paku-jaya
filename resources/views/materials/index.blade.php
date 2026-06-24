@extends('layouts.app')

@section('content')
<div class="card">
    <h3 style="margin-bottom: 20px;"><i class="fas fa-boxes-stacked"></i> Registrasi Bahan Baku Baru</h3>
    <form action="{{ route('materials.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 15px;">
            <input type="text" name="name" placeholder="Nama Bahan (ex: Telur)" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>

            <select name="category_id" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>
                <option value="">-- Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <input type="text" name="unit" placeholder="Satuan (Kg/Butir)" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>

            <input type="number" name="min_stock" placeholder="Stok Minimal" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>
        </div>
        <button type="submit" class="btn-primary" style="margin-top: 15px;">Daftarkan Bahan</button>
    </form>
</div>

<div class="card" style="margin-top: 20px;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                <th style="padding: 15px;">Nama Bahan</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Stok Minimal</th>
                <th style="text-align: center;">Aksi</th> </tr>
        </thead>
        <tbody>
            @foreach($materials as $m)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 15px;">{{ $m->name }}</td>
                <td><span style="background: #e0f2fe; padding: 4px 10px; border-radius: 15px; font-size: 0.8rem;">{{ $m->category->name ?? 'N/A' }}</span></td>
                <td>{{ $m->unit }}</td>
                <td>{{ $m->min_stock }}</td>
                <td style="text-align: center;">
                    <a href="{{ route('materials.edit', $m->id) }}" style="color: #0ea5e9; text-decoration: none; margin-right: 15px;">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('materials.destroy', $m->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus bahan ini?')">
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

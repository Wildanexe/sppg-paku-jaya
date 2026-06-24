@extends('layouts.app')

@section('content')
<div class="card">
    <h3 style="margin-bottom: 20px;"><i class="fas fa-store"></i> Tambah Supplier Baru</h3>
    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <input type="text" name="name" placeholder="Nama Supplier / Toko" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>
            <input type="text" name="phone" placeholder="No. Telepon (WA)" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
        </div>
        <textarea name="address" placeholder="Alamat Lengkap" style="width: 100%; margin-top: 15px; padding: 10px; border-radius: 8px; border: 1px solid #ddd;"></textarea>
        <button type="submit" class="btn-primary" style="margin-top: 15px;">Simpan Supplier</button>
    </form>
</div>

<div class="card" style="margin-top: 20px;">
    <h3><i class="fas fa-list"></i> Daftar Supplier Terdaftar</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead style="background: #f8fafc;">
            <tr style="border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 15px; text-align: left;">Supplier</th>
                <th style="text-align: left;">Telepon</th>
                <th style="text-align: left;">Alamat</th>
                <th style="text-align: center;">Aksi</th> </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $s)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 15px;"><strong>{{ $s->name }}</strong></td>
                <td>{{ $s->phone ?? '-' }}</td>
                <td style="font-size: 0.9rem; color: #64748b;">{{ $s->address ?? '-' }}</td>
                <td style="text-align: center;">
                    <a href="{{ route('suppliers.edit', $s->id) }}" style="color: #0ea5e9; margin-right: 15px; text-decoration: none;">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus supplier ini? Pastikan tidak ada stok yang menggantung ke supplier ini.')">
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

@extends('layouts.app')

@section('content')
<div class="card">
    <h3 style="margin-bottom: 20px;"><i class="fas fa-tags"></i> Manajemen Kategori</h3>

    <form action="{{ route('categories.store') }}" method="POST" style="display: flex; gap: 10px; margin-bottom: 30px;">
        @csrf
        <input type="text" name="name" placeholder="Nama Kategori Baru..." style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ddd;" required>
        <button type="submit" class="btn-primary">Tambah</button>
    </form>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                <th style="padding: 15px; width: 50px;">No</th>
                <th>Nama Kategori</th>
                <th style="text-align: center; width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $key => $cat)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 15px;">{{ $key + 1 }}</td>
                <td>{{ $cat->name }}</td>
                <td style="text-align: center;">
                    <a href="{{ route('categories.edit', $cat->id) }}" style="color: var(--accent-blue); margin-right: 15px; text-decoration: none;">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus kategori ini?')">
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

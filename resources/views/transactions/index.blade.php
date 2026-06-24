@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="margin-bottom: 25px;">
    <h1><i class="fas fa-file-export" style="color: #f59e0b;"></i> Pengambilan Bahan (Keluar)</h1>
    <p style="color: #64748b;">Gunakan form ini untuk mengambil bahan baku dengan sistem otomatis FEFO.</p>
</div>

@if(session('success'))
    <div style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 10px; margin-bottom: 20px; border: 1px solid #bbf7d0;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="padding: 15px; background: #fef2f2; color: #991b1b; border-radius: 10px; margin-bottom: 20px; border: 1px solid #fecaca;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

<div class="card">
    <h3 style="margin-bottom: 20px;"><i class="fas fa-edit"></i> Form Pengambilan</h3>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px;">
            <select name="material_id" style="padding: 12px; border-radius: 8px; border: 1px solid #ddd; font-family: 'Poppins';" required>
                <option value="">-- Pilih Bahan yang Diambil --</option>
                @foreach($materials as $m)
                    <option value="{{ $m->id }}">
                        {{ $m->name }} (Tersedia: {{ $m->stockBatches->sum('current_quantity') }} {{ $m->unit }})
                    </option>
                @endforeach
            </select>
            <input type="number" name="quantity" placeholder="Jumlah Ambil" style="padding: 12px; border-radius: 8px; border: 1px solid #ddd;" required min="1">
        </div>
        <button type="submit" class="btn-primary" style="margin-top: 15px; background: #f59e0b; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-bolt"></i> Proses FEFO
        </button>
    </form>
</div>

<div class="card" style="margin-top: 25px;">
    <h3><i class="fas fa-history"></i> Riwayat Pengeluaran Hari Ini</h3>
    <div style="overflow-x: auto; margin-top: 15px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8fafc;">
                <tr style="text-align: left; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 15px;">Waktu</th>
                    <th>Nama Bahan</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px;">
    {{ $trx->created_at ? $trx->created_at->format('H:i') : '--:--' }} WIB
</td>
                    <td><strong>{{ $trx->stockBatch->material->name }}</strong></td>
                    <td><span style="color: #ef4444; font-weight: 600;">-{{ $trx->quantity }}</span> {{ $trx->stockBatch->material->unit }}</td>
                    <td style="font-size: 0.85rem; color: #64748b;">Batch #{{ $trx->stock_batch_id }}</td>
                    <td style="text-align: center;">
                        <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Batalkan transaksi ini? Stok akan otomatis kembali ke gudang.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; display: flex; align-items: center; gap: 5px; margin: 0 auto;">
                                <i class="fas fa-undo"></i> <small>Batalkan</small>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-info-circle" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                        Belum ada transaksi keluar hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

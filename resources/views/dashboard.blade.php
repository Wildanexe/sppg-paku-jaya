@extends('layouts.app')

@section('content')

<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="font-size: 1.8rem;">Halo, Ketua SPPG Paku Jaya!</h1>
    <p style="color: #64748b;">Pantau ketersediaan bahan baku bergizi gratis secara real-time.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">

    <div class="card" style="border-left: 5px solid #0ea5e9; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <small style="color: #64748b; font-weight: 600;">TOTAL BAHAN BAKU</small>
            <h2 style="font-size: 1.8rem; margin-top: 5px;">{{ \App\Models\Material::count() }} <span style="font-size: 0.9rem; font-weight: 400; color: #94a3b8;">Jenis</span></h2>
        </div>
        <div style="background: #e0f2fe; padding: 15px; border-radius: 12px;">
            <i class="fas fa-boxes-stacked" style="font-size: 1.5rem; color: #0ea5e9;"></i>
        </div>
    </div>

    <div class="card" style="border-left: 5px solid #ef4444; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <small style="color: #64748b; font-weight: 600;">HAMPIR EXPIRED</small>
            <h2 style="font-size: 1.8rem; margin-top: 5px; color: #ef4444;">{{ \App\Models\StockBatch::where('expiry_date', '<=', now()->addDays(7))->count() }} <span style="font-size: 0.9rem; font-weight: 400; color: #94a3b8;">Batch</span></h2>
        </div>
        <div style="background: #fee2e2; padding: 15px; border-radius: 12px;">
            <i class="fas fa-hourglass-half" style="font-size: 1.5rem; color: #ef4444;"></i>
        </div>
    </div>

    <div class="card" style="border-left: 5px solid #f59e0b; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <small style="color: #64748b; font-weight: 600;">STOK MENIPIS</small>
            <h2 style="font-size: 1.8rem; margin-top: 5px; color: #f59e0b;">{{ \App\Models\StockBatch::where('current_quantity', '<', 5)->count() }} <span style="font-size: 0.9rem; font-weight: 400; color: #94a3b8;">Item</span></h2>
        </div>
        <div style="background: #fef3c7; padding: 15px; border-radius: 12px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; color: #f59e0b;"></i>
        </div>
    </div>

    <div class="card" style="border-left: 5px solid #10b981; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <small style="color: #64748b; font-weight: 600;">BUDGET BULAN INI</small>
            <h2 style="font-size: 1.4rem; margin-top: 5px; color: #10b981;">Rp {{ number_format(\App\Models\StockBatch::whereMonth('received_date', now()->month)->sum(\DB::raw('initial_quantity * price_per_unit')), 0, ',', '.') }}</h2>
        </div>
        <div style="background: #dcfce7; padding: 15px; border-radius: 12px;">
            <i class="fas fa-wallet" style="font-size: 1.5rem; color: #10b981;"></i>
        </div>
    </div>

</div>

<div class="card">
    <h3><i class="fas fa-history" style="margin-right: 10px;"></i> Transaksi Hari Ini</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                <th style="padding: 15px;">Waktu</th>
                <th>Bahan Baku</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Transaction::whereDate('created_at', now())->get() as $trx)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 15px;">{{ $trx->created_at->format('H:i') }}</td>
                <td>{{ $trx->stockBatch->material->name }}</td>
                <td>
                    <span style="padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; background: {{ $trx->type == 'in' ? '#dcfce7' : '#fee2e2' }}; color: {{ $trx->type == 'in' ? '#166534' : '#991b1b' }}">
                        {{ $trx->type == 'in' ? 'Masuk' : 'Keluar' }}
                    </span>
                </td>
                <td>{{ $trx->quantity }}</td>
                <td>{{ $trx->user->name ?? 'Admin' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

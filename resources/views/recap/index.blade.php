@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1><i class="fas fa-chart-pie" style="color: #fbbf24;"></i> Rekapitulasi & Budgeting</h1>
    <p style="color: #64748b;">Laporan pengeluaran operasional bahan baku SPPG Paku Jaya.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <div class="card" style="border-top: 5px solid #10b981;">
        <small style="color: #64748b; font-weight: 600;">TOTAL PENGELUARAN TAHUN INI ({{ date('Y') }})</small>
        <h2 style="font-size: 2rem; color: #10b981; margin-top: 10px;">
            {{-- Mengambil total dari variabel recap agar konsisten --}}
            Rp {{ number_format($recap->sum('total_spend'), 0, ',', '.') }}
        </h2>
    </div>
    <div class="card" style="border-top: 5px solid #0ea5e9;">
        <small style="color: #64748b; font-weight: 600;">ESTIMASI SISA ANGGARAN</small>
        <h2 style="font-size: 2rem; color: #0ea5e9; margin-top: 10px;">
            Rp {{ number_format(500000000 - $recap->sum('total_spend'), 0, ',', '.') }}
        </h2>
        <small>*Update setiap bulan Tanggal 15</small>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-calendar-alt"></i> Laporan Per Bulan</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background: #f8fafc; text-align: left; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 15px;">Bulan</th>
                <th>Total Belanja</th>
                <th>Jumlah Batch</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recap as $data)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px; font-weight: 600;">{{ $data->month }}</td>
                    <td style="color: #16a34a; font-weight: bold;">
                        Rp {{ number_format($data->total_spend, 0, ',', '.') }}
                    </td>
                    <td>
                        <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-size: 0.85rem;">
                            {{ $data->total_batch }} Batch
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <button class="btn-primary" style="padding: 5px 15px; font-size: 0.8rem;">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 30px; text-align: center; color: #64748b;">
                        <i class="fas fa-info-circle"></i> Belum ada data pengeluaran untuk tahun {{ date('Y') }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

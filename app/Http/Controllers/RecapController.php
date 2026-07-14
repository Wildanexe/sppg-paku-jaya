<?php

namespace App\Http\Controllers;

use App\Models\StockBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RecapController extends Controller
{
    /**
     * Menampilkan laporan rekapitulasi bulanan dan budgeting.
     */
    public function index()
    {
        // 1. Proteksi Akses
        if (!Auth::check() || Auth::user()->role == 'staff') {
            abort(403, 'Akses Ditolak: Halaman ini khusus untuk Ketua atau Sekretaris SPPG.');
        }

        // 2. Query Hitung Pengeluaran Bulanan secara Dinamis
        $recap = StockBatch::selectRaw('
                MONTH(COALESCE(received_date, created_at)) as month_num,
                MONTHNAME(COALESCE(received_date, created_at)) as month,
                SUM(initial_quantity * price_per_unit) as total_spend,
                COUNT(*) as total_batch
            ')
            ->whereYear(DB::raw('COALESCE(received_date, created_at)'), date('Y'))
            ->groupBy('month_num', 'month')
            ->orderBy('month_num', 'asc')
            ->get();

        // 3. Kalkulasi Total untuk Kartu Dasbor
        $totalPengeluaran = $recap->sum('total_spend');
        $anggaranDasar = 500000000; // Anggaran 500 Juta SPPG Paku Jaya
        $sisaAnggaran = $anggaranDasar - $totalPengeluaran;

        // 4. Lempar data ke view (Pastikan compact berisi 3 variabel ini!)
        return view('recap.index', compact('recap', 'totalPengeluaran', 'sisaAnggaran'));
    }
}

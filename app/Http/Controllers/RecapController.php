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
     * Hanya bisa diakses oleh Ketua dan Sekretaris.
     */
    public function index()
    {
        // 1. Keamanan Akses: Proteksi Role
        if (!Auth::check() || Auth::user()->role == 'staff') {
            abort(403, 'Akses Ditolak: Halaman ini khusus untuk Ketua atau Sekretaris SPPG.');
        }

        // 2. Query Data: Menggunakan selectRaw agar lebih bersih
        // Kita masukkan MONTH(received_date) ke SELECT agar bisa masuk ke GROUP BY
        $recap = StockBatch::selectRaw('
                MONTH(received_date) as month_num,
                MONTHNAME(received_date) as month,
                SUM(initial_quantity * price_per_unit) as total_spend,
                COUNT(*) as total_batch
            ')
            ->whereYear('received_date', date('Y'))
            ->groupBy('month_num', 'month') // Harus masuk dua-duanya biar nggak error
            ->orderBy('month_num', 'asc')   // Urutkan berdasarkan angka bulan (1-12)
            ->get();

        // 3. Kirim data ke view
        return view('recap.index', compact('recap'));
    }
}

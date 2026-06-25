<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockBatch;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Tampilkan riwayat transaksi dan form pengambilan barang.
     */
    public function index()
    {
        $materials = Material::with('stockBatches')->get();
        $transactions = Transaction::with(['stockBatch.material', 'user'])->latest()->get();

        return view('transactions.index', compact('materials', 'transactions'));
    }

    /**
     * FITUR REKAPITULASI & BUDGETING (Dikelompokkan Per Bulan)
     */
    public function recap()
    {
        // Mengambil data dan menghitung total spend (sementara pakai initial_quantity agar tidak error kolom price)
        $recap = DB::table('stock_batches')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%M %Y') as month"),
                DB::raw("SUM(initial_quantity) as total_spend"),
                DB::raw("COUNT(id) as total_batch")
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%M %Y')"), DB::raw("YEAR(created_at)"), DB::raw("MONTH(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"), 'asc')
            ->get();

        // Mengarah ke folder views/recap/index.blade.php
        return view('recap.index', compact('recap'));
    }

    /**
     * PROSES BARANG KELUAR (LOGIKA FEFO)
     */
    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $materialId = $request->material_id;
        $requestedQty = $request->quantity;

        $batches = StockBatch::where('material_id', $materialId)
                            ->where('current_quantity', '>', 0)
                            ->orderBy('expiry_date', 'asc')
                            ->get();

        if ($batches->sum('current_quantity') < $requestedQty) {
            return redirect()->back()->with('error', 'Maaf, total stok tidak mencukupi!');
        }

        DB::transaction(function () use ($batches, $requestedQty) {
            foreach ($batches as $batch) {
                if ($requestedQty <= 0) break;

                $take = 0;
                if ($batch->current_quantity >= $requestedQty) {
                    $take = $requestedQty;
                    $batch->decrement('current_quantity', $requestedQty);
                    $requestedQty = 0;
                } else {
                    $take = $batch->current_quantity;
                    $requestedQty -= $batch->current_quantity;
                    $batch->update(['current_quantity' => 0]);
                }

                Transaction::create([
                    'stock_batch_id' => $batch->id,
                    'user_id' => Auth::id() ?? 1,
                    'type' => 'out',
                    'quantity' => $take,
                    'description' => 'Pengeluaran bahan baku (Sistem FEFO)'
                ]);
            }
        });

        return redirect()->back()->with('success', 'Barang berhasil dikeluarkan, stok gudang otomatis terupdate!');
    }

    /**
     * FITUR HAPUS TRANSAKSI
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->type == 'out') {
                $batch = StockBatch::find($transaction->stock_batch_id);
                if ($batch) {
                    $batch->increment('current_quantity', $transaction->quantity);
                }
            }

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi dihapus dan stok telah dikembalikan ke gudang!');
    }
}

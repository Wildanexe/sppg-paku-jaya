<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBatch extends Model
{
    // Tambahkan 'price_per_unit' ke dalam list biar bisa simpan harga belanja
    protected $fillable = [
        'material_id',
        'supplier_id',
        'initial_quantity',
        'current_quantity',
        'price_per_unit', // <-- WAJIB ADA INI buat Rekap & Budgeting
        'expiry_date',
        'received_date'
    ];

    public $timestamps = false;
protected $casts = [
    'expiry_date' => 'date',
    'received_date' => 'date',
];
    // Relasi ke Material (Beras, Daging, dll)
    public function material() {
        return $this->belongsTo(Material::class, 'material_id');
    }

    // Relasi ke Supplier (Vendor)
    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Tips Skripsi: Method ini buat cek apakah stok sudah mau expired
     * Bisa dipakai di Dashboard nanti buat bikin badge warna merah
     */
    public function isExpired()
    {
        return $this->expiry_date <= now();
    }
}

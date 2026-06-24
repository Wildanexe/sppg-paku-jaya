<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['category_id', 'name', 'unit', 'min_stock'];

    // TAMBAHKAN INI: Hubungan ke Tabel StockBatch
    public function stockBatches()
    {
        return $this->hasMany(StockBatch::class, 'material_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

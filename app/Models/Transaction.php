<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'stock_batch_id',
        'user_id',
        'type',
        'quantity',
        'description'
    ];

    // INI HARUS TRUE (atau hapus saja barisnya karena defaultnya true)
    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function stockBatch()
    {
        return $this->belongsTo(StockBatch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegalaOrderDet extends Model
{
    use HasFactory;
    protected $table = 'SEGALA_ORDER_DET';
    protected $fillable = [
        'kd_order',
        'urut',
        'kd_produk',
        'jumlah',
        'status',
        'kd_dokter',
    ];

    // public $timestamps = false;
    public function order()
    {
        return $this->belongsTo(SegalaOrder::class, 'kd_order', 'kd_order');
    }
}

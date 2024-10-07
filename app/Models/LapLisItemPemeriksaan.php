<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapLisItemPemeriksaan extends Model
{
    use HasFactory;
    protected $table = 'LAB_LIS_ITEM_PEMERIKSAAN';


    public function produk()
    {
        return $this->belongsTo(produk::class, 'kd_produk', 'kd_produk');
    }
}

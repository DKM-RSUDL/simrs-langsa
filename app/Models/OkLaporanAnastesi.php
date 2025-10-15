<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkLaporanAnastesi extends Model
{
    use HasFactory;

    protected $table = 'OK_LAPORAN_ANASTESI';
    public $timestamps = false;
    protected $guarded = ['id'];


    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'jenis_operasi', 'kd_produk');
    }
}

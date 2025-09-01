<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeCatatanPemberianObat extends Model
{
    use HasFactory;

    protected $table = 'RME_CATATAN_PEMBERIAN_OBAT';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'kd_petugas', 'kd_karyawan');
    }

    public function petugasValidasi()
    {
        return $this->belongsTo(User::class, 'petugas_validasi', 'kd_karyawan');
    }
}

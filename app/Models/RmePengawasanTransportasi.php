<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengawasanTransportasi extends Model
{
    use HasFactory;

    protected $table = 'rme_pengawasan_transportasi';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function detail()
    {
        return $this->hasMany(RmePengawasanTransportasiDtl::class, 'id_pengawasan', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function perawat()
    {
        return $this->belongsTo(HrdKaryawan::class, 'kd_perawat', 'kd_karyawan');
    }

    public function pramuhusada()
    {
        return $this->belongsTo(HrdKaryawan::class, 'kd_pramuhusada', 'kd_karyawan');
    }

    public function pengemudi()
    {
        return $this->belongsTo(HrdKaryawan::class, 'kd_pengemudi', 'kd_karyawan');
    }
}

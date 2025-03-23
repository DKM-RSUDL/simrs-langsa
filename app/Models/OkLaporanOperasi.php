<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkLaporanOperasi extends Model
{
    use HasFactory;

    protected $table = 'ok_laporan_operasi';

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'nama_tindakan_operasi',
        'kd_jenis_anastesi',
        'pa',
        'kultur',
        'kd_dokter_bedah',
        'kd_dokter_anastesi',
        'pendarahan',
        'diagnosa_pra_operasi',
        'diagnosa_pasca_operasi',
        'laporan_prosedur_operasi',
        'kompleksitas',
        'urgensi',
        'kebersihan',
        'komplikasi',
        'kd_perawat_bedah',
        'kd_penata_anastesi',
        'wb',
        'prc',
        'cryo',
        'tgl_mulai',
        'jam_mulai',
        'tgl_selesai',
        'jam_selesai',
        'lama_operasi',
        'user_create',
        'user_edit',
    ];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeForensikPemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'rme_forensik_pemeriksaan';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tgl_pemeriksaan',
        'jam_pemeriksaan',
        'cara_datang',
        'asal_rujukan',
        'jenis_kasus',
        'nomor_penyidik',
        'nama_penyidik',
        'nrp_penyidik',
        'tgl_penyidik',
        'instansi_penyidik',
        'pemeriksaan',
        'anamnesis',
        'kesadaran',
        'nadi',
        'nafas',
        'sistole',
        'diastole',
        'suhu',
        'pemeriksaan_lain',
        'penatalaksanaan',
        'diagnosos',
        'dibawa_oleh',
        'tgl_pulang',
        'user_create',
        'user_edit',
        'penatalaksanaan_lainnya',
    ];

    protected $casts = [
        'pemeriksaan'       => 'array',
        'penatalaksanaan'   => 'array'
    ];

    public function fisik()
    {
        return $this->hasMany(RmeForensikPemeriksaanFisik::class, 'id_pemeriksaan', 'id');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}

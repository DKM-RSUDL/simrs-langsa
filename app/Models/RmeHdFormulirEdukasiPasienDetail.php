<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdFormulirEdukasiPasienDetail extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_FORMULIR_EDUKASI_PASIEN_DETAIL';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'formulir_edukasi_id',
        'topik_edukasi',
        'tgl_jam',
        'hasil_verifikasi',
        'tgl_reedukasi',
        'edukator_kd',
        'edukator_nama',
        'pasien_nama',
    ];

    protected $dates = [
        'tgl_jam',
        'tgl_reedukasi',
        'created_at',
        'updated_at'
    ];

    // Relasi ke tabel utama
    public function formulirEdukasi()
    {
        return $this->belongsTo(RmeHdFormulirEdukasiPasien::class, 'formulir_edukasi_id');
    }

    // Relasi ke karyawan (edukator)
    public function edukator()
    {
        return $this->belongsTo(HrdKaryawan::class, 'edukator_kd', 'kd_karyawan');
    }
}

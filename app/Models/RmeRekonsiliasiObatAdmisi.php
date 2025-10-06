<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRekonsiliasiObatAdmisi extends Model
{
    use HasFactory;

    protected $table = 'RME_FORMULIR_REKONSILIASI_OBAT_ADMISI';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'kd_pasien',
        'tgl_masuk',
        'urut_masuk',
        'kd_unit',
        'kd_petugas',
        'nama_obat',
        'frekuensi',
        'keterangan',
        'dosis',
        'satuan',
        'catatan',
        'tanggal',
        'freak',
        'is_validasi',
        'petugas_validasi'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'is_validasi' => 'boolean'
    ];

    // Relasi ke pasien jika ada
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    // Relasi ke petugas
    public function petugas()
    {
        return $this->belongsTo(User::class, 'kd_petugas', 'id');
    }

    // Relasi ke petugas validasi
    public function petugasValidasi()
    {
        return $this->belongsTo(User::class, 'petugas_validasi', 'id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dokter;
use App\Models\HrdKaryawan;

class RmeHdAsesmenMedisEvaluasi extends Model
{
    use HasFactory;

    protected $table = 'rme_hd_asesmen_medis_evaluasi';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'evaluasi_medis',
        'dokter_pelaksana',
        'dpjp',
        'perawat',
        'diagnosis_banding',
        'diagnosis_kerja',
    ];
    public function dokterPelaksana()
    {
        // Relasi ini mengambil data Dokter berdasarkan kolom 'dokter_pelaksana'
        return $this->belongsTo(Dokter::class, 'dokter_pelaksana', 'kd_dokter');
    }

    public function dokterDpjp()
    {
        // Relasi ini mengambil data Dokter berdasarkan kolom 'dpjp'
        return $this->belongsTo(Dokter::class, 'dpjp', 'kd_dokter');
    }

    public function perawatPelaksana()
    {
        // Relasi ini mengambil data Karyawan (Perawat) berdasarkan kolom 'perawat'
        return $this->belongsTo(HrdKaryawan::class, 'perawat', 'kd_karyawan');
    }
}

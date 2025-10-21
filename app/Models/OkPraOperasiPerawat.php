<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkPraOperasiPerawat extends Model
{
    use HasFactory;

    protected $table = 'ok_asesmen_pra_operasi_perawat';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'tgl_op',
        'jam_op',
        'sistole',
        'diastole',
        'nadi',
        'nafas',
        'suhu',
        'skala_nyeri',
        'tinggi_badan',
        'berat_badan',
        'imt',
        'lpt',
        'status_mental',
        'penyakit_sekarang',
        'penyakit_dahulu',
        'alat_bantu',
        'jenis_operasi',
        'tgl_bedah',
        'tempat_bedah',
        'alergi',
        'hasil_lab',
        'hasil_lab_lainnya',
        'batuk',
        'haid',
        'verifikasi_pasien',
        'verifikasi_pasien_ruangan',
        'persiapan_fisik_pasien',
        'persiapan_fisik_pasien_ruangan',
        'id_perawat_penerima',
        'tgl_periksa',
        'jam_periksa',
        'site_marking',
        'penjelasan_prosedur',
    ];

    protected $casts = [
        'penyakit_sekarang' => 'array',
        'penyakit_dahulu' => 'array',
        'jenis_operasi' => 'array',
        'alergi' => 'array',
        'hasil_lab' => 'array',
        'verifikasi_pasien' => 'array',
        'verifikasi_pasien_ruangan' => 'array',
        'persiapan_fisik_pasien' => 'array',
        'persiapan_fisik_pasien_ruangan' => 'array',
    ];
}

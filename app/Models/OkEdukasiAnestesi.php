<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkEdukasiAnestesi extends Model
{
    use HasFactory;

    protected $table = 'ok_edukasi_anestesi';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'tgl_op',
        'jam_op',
        'jenis_anestesi',
        'edukasi_prosedur',
        'pemahaman_pasien',
        'informed_consent',
        'nama_keluarga',
        'usia_keluarga',
        'jenis_kelamin',
        'no_telepon',
        'dokter_edukasi',
        'tgl_dilakukan',
        'jam_dilakukan',
        'file_persetujuan',
        'pertanyaan_pasien',
        'rekomendasi_dokter',
        'lainnya',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumSosialEkonomi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_SOSIAL_EKONOMI';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'sosial_ekonomi_pekerjaan',
        'sosial_ekonomi_tingkat_penghasilan',
        'sosial_ekonomi_status_pernikahan',
        'sosial_ekonomi_status_pendidikan',
        'sosial_ekonomi_tempat_tinggal',
        'sosial_ekonomi_tinggal_dengan_keluarga',
        'sosial_ekonomi_curiga_penganiayaan',
        'sosial_ekonomi_keterangan_lain'
    ];
}

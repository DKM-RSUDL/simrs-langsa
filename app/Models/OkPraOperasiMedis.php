<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkPraOperasiMedis extends Model
{
    use HasFactory;

    protected $table = 'ok_asesmen_pra_operasi';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tgl_op',
        'diagnosa_pra_operasi',
        'indikasi_tindakan',
        'rencana_tindakan',
        'prosedur_tindakan',
        'timing_tindakan',
        'alternatif_lain',
        'resiko',
        'pemantauan_khusus',
        'waktu_tindakan',
        'sistole',
        'diastole',
        'nadi',
        'nafas',
        'suhu',
        'evaluasi',
        'penanganan_nyeri'
    ];
}
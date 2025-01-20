<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SjpKunjungan extends Model
{
    use HasFactory;

    protected $table = 'sjp_kunjungan';
    public $timestamps = false;
    
    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'no_sjp',
        'jns_peserta',
        'kls_tanggung',
        'penjamin_laka',
        'cat_laka',
        'katarak',
        'catatan',
        'no_skdp',
        'dpjp',
        'cob',
        'prb',
        'no_register',
        'covid',
        'file_sep',
        'intern',
        'kd_unit_intern',
        'file_gabungan',
        'file_gabungan_counter',
        'status_sep',
        'status_cppt_perawat',
        'status_order_resep',
        'status_lab',
        'status_radiologi',
        'status_icare',
        'status_cppt_dokter',
        'status_resume_medis',
        'status_skdp',
        'status_baca_lab',
        'status_baca_rad',
        'tanggal_buat_sep',
    ];
}

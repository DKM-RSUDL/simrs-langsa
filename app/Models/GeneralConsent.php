<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralConsent extends Model
{
    use HasFactory;
    protected $table = 'dkm_general_consent';

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tanggal', 
        'jam',
        'pj_nama',
        'pj_tgl_lahir',
        'pj_nohp',
        'pj_alamat',
        'pj_hubungan_pasien',
        'saksi_nama',
        'saksi_tgl_lahir',
        'saksi_nohp',
        'saksi_alamat',
        'saksi_hubungan_pasien',
        'setuju_perawatan',
        'setuju_barang',
        'info_nama_1',
        'info_hubungan_pasien_1',
        'info_nama_2',
        'info_hubungan_pasien_2',
        'info_nama_3',
        'info_hubungan_pasien_3',
        'setuju_hak',
        'setuju_akses_privasi',
        'akses_privasi_keterangan',
        'setuju_privasi_khusus',
        'privasi_khusus_keterangan',
        'rawat_inap_keterangan',
        'biaya_status',
        'biaya_setuju',
        'id_user',
        'ttd_petugas',
        'ttd_pj',
        'ttd_saksi'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}

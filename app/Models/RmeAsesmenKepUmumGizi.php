<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumGizi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_GIZI';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'gizi_jenis',
        'gizi_mst_penurunan_bb',
        'gizi_mst_jumlah_penurunan_bb',
        'gizi_mst_nafsu_makan_berkurang',
        'gizi_mst_diagnosis_khusus',
        'gizi_mna_penurunan_asupan_3_bulan',
        'gizi_mna_kehilangan_bb_3_bulan',
        'gizi_mna_mobilisasi',
        'gizi_mna_stress_penyakit_akut',
        'gizi_mna_status_neuropsikologi',
        'gizi_mna_berat_badan',
        'gizi_mna_tinggi_badan',
        'gizi_mna_imt',
        'gizi_strong_status_kurus',
        'gizi_strong_penurunan_bb',
        'gizi_strong_gangguan_pencernaan',
        'gizi_strong_penyakit_berisiko',
        'gizi_nrs_jatuh_saat_masuk_rs',
        'gizi_nrs_jatuh_2_bulan_terakhir',
        'gizi_nrs_status_delirium',
        'gizi_nrs_status_disorientasi',
        'gizi_nrs_status_agitasi',
        'gizi_nrs_menggunakan_kacamata',
        'gizi_nrs_keluhan_penglihatan_buram',
        'gizi_nrs_degenerasi_makula',
        'gizi_nrs_perubahan_berkemih',
        'gizi_nrs_transfer_mandiri',
        'gizi_nrs_transfer_bantuan_1_orang',
        'gizi_nrs_transfer_bantuan_2_orang',
        'gizi_nrs_transfer_bantuan_total',
        'gizi_nrs_mobilitas_mandiri',
        'gizi_nrs_mobilitas_bantuan_1_orang',
        'gizi_nrs_mobilitas_kursi_roda',
        'gizi_nrs_mobilitas_imobilisasi',
        'kesimpulan_mst',
        'kesimpulan_mna',
        'kesimpulan_strong',
        'kesimpulan_nrs',
    ];
}

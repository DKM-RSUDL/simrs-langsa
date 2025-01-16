<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumRisikoJatuh extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_RISIKO_JATUH';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'resiko_jatuh_jenis',
        'risiko_jatuh_umum_usia',
        'risiko_jatuh_umum_kondisi_khusus',
        'risiko_jatuh_umum_diagnosis_parkinson',
        'risiko_jatuh_umum_pengobatan_berisiko',
        'risiko_jatuh_umum_lokasi_berisiko',
        'risiko_jatuh_morse_riwayat_jatuh',
        'risiko_jatuh_morse_diagnosis_sekunder',
        'risiko_jatuh_morse_bantuan_ambulasi',
        'risiko_jatuh_morse_terpasang_infus',
        'risiko_jatuh_morse_cara_berjalan',
        'risiko_jatuh_morse_status_mental',
        'risiko_jatuh_pediatrik_usia_anak',
        'risiko_jatuh_pediatrik_jenis_kelamin',
        'risiko_jatuh_pediatrik_diagnosis',
        'risiko_jatuh_pediatrik_gangguan_kognitif',
        'risiko_jatuh_pediatrik_faktor_lingkungan',
        'risiko_jatuh_pediatrik_pembedahan',
        'risiko_jatuh_pediatrik_penggunaan_mentosa',
        'risiko_jatuh_lansia_jatuh_saat_masuk_rs',
        'risiko_jatuh_lansia_riwayat_jatuh_2_bulan',
        'risiko_jatuh_lansia_status_bingung',
        'risiko_jatuh_lansia_status_disorientasi',
        'risiko_jatuh_lansia_status_agitasi',
        'risiko_jatuh_lansia_katarak',
        'risiko_jatuh_lansia_kelainan_penglihatan',
        'risiko_jatuh_lansia_glukoma',
        'risiko_jatuh_lansia_perubahan_berkemih',
        'risiko_jatuh_lansia_transfer_mandiri',
        'risiko_jatuh_lansia_transfer_bantuan_sedikit',
        'risiko_jatuh_lansia_transfer_bantuan_nyata',
        'risiko_jatuh_lansia_transfer_bantuan_total',
        'risiko_jatuh_lansia_mobilitas_mandiri',
        'risiko_jatuh_lansia_mobilitas_bantuan_1_orang',
        'risiko_jatuh_lansia_mobilitas_kursi_roda',
        'risiko_jatuh_lansia_mobilitas_imobilisasi',
        'kesimpulan_skala_umum',
        'kesimpulan_skala_morse',
        'kesimpulan_skala_pediatrik',
        'kesimpulan_skala_lansia',
        'intervensi_risiko_jatuh'
    ];

    protected $casts = [
        'intervensi_risiko_jatuh' => 'json'
    ];
}

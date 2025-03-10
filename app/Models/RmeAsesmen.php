<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmen extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tindakan_resusitasi',
        'anamnesis',
        'riwayat_penyakit',
        'riwayat_penyakit_keluarga',
        'riwayat_pengobatan',
        'riwayat_alergi',
        'vital_sign',
        'antropometri',
        'skala_nyeri',
        'menjalar_id',
        'frekuensi_nyeri_id',
        'kualitas_nyeri_id',
        'faktor_pemberat_id',
        'faktor_peringan_id',
        'efek_nyeri',
        'diagnosis',
        'alat_terpasang',
        'kondisi_pasien',
        'lokasi',
        'waktu_asesmen',
        'durasi',
        'kategori',
        'sub_kategori'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    public function dataTriage()
    {
        return $this->hasOne(DataTriase::class, 'asesmen_id', 'id');
    }

    public function menjalar()
    {
        return $this->belongsTo(RmeMenjalar::class, 'menjalar_id');
    }

    public function frekuensiNyeri()
    {
        return $this->belongsTo(RmeFrekuensiNyeri::class, 'frekuensi_nyeri_id');
    }

    public function kualitasNyeri()
    {
        return $this->belongsTo(RmeKualitasNyeri::class, 'kualitas_nyeri_id');
    }

    public function faktorPemberat()
    {
        return $this->belongsTo(RmeFaktorPemberat::class, 'faktor_pemberat_id');
    }

    public function faktorPeringan()
    {
        return $this->belongsTo(RmeFaktorPeringan::class, 'faktor_peringan_id');
    }

    public function efekNyeri()
    {
        return $this->belongsTo(RmeEfekNyeri::class, 'efek_nyeri');
    }

    public function retriase()
    {
        return $this->hasMany(DataTriase::class, 'id_asesmen', 'id');
    }

    public function tindaklanjut()
    {
        return $this->hasMany(RmeAsesmenDtl::class, 'id_asesmen', 'id');
    }

    public function spri()
    {
        return $this->hasOne(RmeSpri::class, 'id_asesmen', 'id');
    }


    // aesmen keperawatan
    public function asesmenKepUmum()
    {
        return $this->hasOne(RmeAsesmenKepUmum::class, 'id_asesmen', 'id');
    }
    public function asesmenKepUmumBreathing()
    {
        return $this->hasOne(RmeAsesmenKepUmumBreathing::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumCirculation()
    {
        return $this->hasOne(RmeAsesmenKepUmumCirculation::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumDisability()
    {
        return $this->hasOne(RmeAsesmenKepUmumDisability::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumExposure()
    {
        return $this->hasOne(RmeAsesmenKepUmumExposure::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumSosialEkonomi()
    {
        return $this->hasOne(RmeAsesmenKepUmumSosialEkonomi::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumSkalaNyeri()
    {
        return $this->hasOne(RmeAsesmenKepUmumSkalaNyeri::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumRisikoJatuh()
    {
        return $this->hasOne(RmeAsesmenKepUmumRisikoJatuh::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumGizi()
    {
        return $this->hasOne(RmeAsesmenKepUmumGizi::class, 'id_asesmen', 'id');
    }

    public function pemeriksaanFisik()
    {
        return $this->hasMany(RmeAsesmenPemeriksaanFisik::class, 'id_asesmen', 'id');
    }

    // asesmen tht
    public function rmeAsesmenTht()
    {
        return $this->hasOne(RmeAsesmenTht::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenThtPemeriksaanFisik()
    {
        return $this->hasMany(RmeAsesmenThtPemeriksaanFisik::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenThtRiwayatKesehatanObatAlergi()
    {
        return $this->hasMany(RmeAsesmenThtRiwayatKesehatanObatAlergi::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenThtDischargePlanning()
    {
        return $this->hasMany(RmeAsesmenThtDischargePlanning::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenThtDiagnosisImplementasi()
    {
        return $this->hasMany(RmeAsesmenthtDiagnosisImplementasi::class, 'id_asesmen', 'id');
    }

    // asesmen anak
    public function rmeAsesmenKepAnak()
    {
        return $this->hasOne(RmeAsesmenKepAnak::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakFisik()
    {
        return $this->hasOne(RmeAsesmenKepAnakFisik::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakStatusNyeri()
    {
        return $this->hasOne(RmeAsesmenKepAnakStatusNyeri::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakRiwayatKesehatan()
    {
        return $this->hasOne(RmeAsesmenKepAnakRiwayatKesehatan::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakRisikoJatuh()
    {
        return $this->hasOne(RmeAsesmenKepAnakRisikoJatuh::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakStatusPsikologis()
    {
        return $this->hasOne(RmeAsesmenKepAnakStatusPsikologis::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakGizi()
    {
        return $this->hasOne(RmeAsesmenKepAnakGizi::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakResikoDekubitus()
    {
        return $this->hasOne(RmeAsesmenKepAnakResikoDekubitus::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakStatusFungsional()
    {
        return $this->hasOne(RmeAsesmenKepAnakStatusFungsional::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakRencanaPulang()
    {
        return $this->hasOne(RmeAsesmenKepAnakRencanaPulang::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepAnakSosialEkonomi()
    {
        return $this->hasOne(RmeAsesmenKepAnakSosialEkonomi::class, 'id_asesmen', 'id');
    }


    // Relasi untuk perinatology
    public function rmeAsesmenPerinatology()
    {
        return $this->hasOne(RmeAsesmenKepPerinatology::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyFisik()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyFisik::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyPemeriksaanLanjut()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyPemeriksaanLanjut::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyRiwayatIbu()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyRiwayatIbu::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyStatusNyeri()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyStatusNyeri::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyRisikoJatuh()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyRisikoJatuh::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyResikoDekubitus()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyResikoDekubitus::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyGizi()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyGizi::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyFungsional()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyFungsional::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenPerinatologyRencanaPulang()
    {
        return $this->hasOne(RmeAsesmenKepPerinatologyRencanaPulang::class, 'id_asesmen', 'id');
    }
}

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
        'sub_kategori',
        'user_id'
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


    // aesmen keperawatan IGD
    public function asesmenKepUmum()
    {
        return $this->hasOne(RmeAsesmenKepUmum::class, 'id_asesmen', 'id');
    }

    // Awal
    public function asesmenMedisAwal()
    {
        return $this->hasOne(RmeAsesmenMedisAwal::class, 'id_asesmen', 'id');
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

    public function asesmenKepUmumDetail()
    {
        return $this->hasOne(RmeAsesmenKepUmumDtl::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumStatusNyeri()
    {
        return $this->hasOne(RmeAsesmenKepUmumStatusNyeri::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumRiwayatKesehatan()
    {
        return $this->hasOne(RmeAsesmenKepUmumRiwayatKesehatan::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumRencanaPulang()
    {
        return $this->hasOne(RmeAsesmenKepUmumRencanaPulang::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumRisikoDekubitus()
    {
        return $this->hasOne(RmeAsesmenKepUmumRisikoDekubitus::class, 'id_asesmen', 'id');
    }


    public function asesmenKepUmumStatusPsikologis()
    {
        return $this->hasOne(RmeAsesmenKepUmumStatusPsikologis::class, 'id_asesmen', 'id');
    }

    public function asesmenKepUmumStatusFungsional()
    {
        return $this->hasOne(RmeAsesmenKepUmumStatusFungsional::class, 'id_asesmen', 'id');
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

    // asesmenObstetri
    public function asesmenObstetri()
    {
        return $this->hasOne(RmeAsesmenObstetri::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenObstetriPemeriksaanFisik()
    {
        return $this->hasOne(RmeAsesmenObstetriPemeriksaanFisik::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenObstetriStatusNyeri()
    {
        return $this->hasOne(RmeAsesmenObstetriStatusNyeri::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenObstetriRiwayatKesehatan()
    {
        return $this->hasOne(RmeAsesmenObstetriRiwayatKesehatan::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenObstetriDischargePlanning()
    {
        return $this->hasOne(RmeAsesmenObstetriDischargePlanning::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenObstetriDiagnosisImplementasi()
    {
        return $this->hasOne(RmeAsesmenObstetriDiagnosisImplementasi::class, 'id_asesmen', 'id');
    }

    // asesmen neurologi
    public function rmeAsesmenNeurologi()
    {
        return $this->hasOne(RmeAsesmenNeurologi::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenNeurologiSistemSyaraf()
    {
        return $this->hasOne(RmeAsesmenNeurologiSistemSyaraf::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenNeurologiIntensitasNyeri()
    {
        return $this->hasOne(RmeAsesmenNeurologiIntensitasNyeri::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenNeurologiDischargePlanning()
    {
        return $this->hasOne(RmeAsesmenNeurologiDischargePlanning::class, 'id_asesmen', 'id');
    }

    // Relation for Ophthalmology assessment
    public function rmeAsesmenKepOphtamology()
    {
        return $this->hasOne(RmeAsesmenKepOphtamology::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepOphtamologyFisik()
    {
        return $this->hasOne(RmeAsesmenKepOphtamologyFisik::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepOphtamologyKomprehensif()
    {
        return $this->hasOne(RmeAsesmenKepOphtamologyKomprehensif::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepOphtamologyStatusNyeri()
    {
        return $this->hasOne(RmeAsesmenKepOphtamologyStatusNyeri::class, 'id_asesmen', 'id');
    }

    public function rmeAsesmenKepOphtamologyRencanaPulang()
    {
        return $this->hasOne(RmeAsesmenKepOphtamologyRencanaPulang::class, 'id_asesmen', 'id');
    }

    // asesmen paru
    public function rmeAsesmenParu()
    {
        return $this->hasOne(RmeAsesmenParu::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenParuRencanaKerja()
    {
        return $this->hasOne(RmeAsesmenParuRencanaKerja::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenParuPerencanaanPulang()
    {
        return $this->hasOne(RmeAsesmenParuPerencanaanPulang::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenParuDiagnosisImplementasi()
    {
        return $this->hasOne(RmeAsesmenParuDiagnosisImplementasi::class, 'id_asesmen', 'id');
    }
    public function rmeAlergiPasien()
    {
        return $this->hasMany(RmeAlergiPasien::class, 'kd_pasien', 'kd_pasien');
    }
    public function rmeAsesmenParuPemeriksaanFisik()
    {
        return $this->hasMany(RmeAsesmenParuPemeriksaanFisik::class, 'id_asesmen', 'id');
    }

    // Asesmen Ginekologik
    public function rmeAsesmenGinekologik()
    {
        return $this->hasOne(RmeAsesmenGinekologik::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenGinekologikTandaVital()
    {
        return $this->hasOne(RmeAsesmenGinekologikTandaVital::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenGinekologikEkstremitasGinekologik()
    {
        return $this->hasOne(RmeAsesmenGinekologikEkstremitasGinekologik::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenGinekologikPemeriksaanDischarge()
    {
        return $this->hasOne(RmeAsesmenGinekologikPemeriksaanDischarge::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenGinekologikDiagnosisImplementasi()
    {
        return $this->hasOne(RmeAsesmenGinekologikDiagnosisImplementasi::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenGinekologikPemeriksaanFisik()
    {
        return $this->hasOne(RmeAsesmenGinekologikPemeriksaanFisik::class, 'id_asesmen', 'id');
    }

    // Asesmen Terminal
    public function rmeAsesmenTerminal()
    {
        return $this->hasOne(RmeAsesmenTerminal::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenTerminalFmo()
    {
        return $this->hasOne(RmeAsesmenTerminalFmo::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenTerminalUsk()
    {
        return $this->hasOne(RmeAsesmenTerminalUsk::class, 'id_asesmen', 'id');
    }
    public function rmeAsesmenTerminalAf()
    {
        return $this->hasOne(RmeAsesmenTerminalAf::class, 'id_asesmen', 'id');
    }

    // asesmen pengkajian awal medis
    public function asesmenMedisRanap()
    {
        return $this->hasOne(RmeAsesmenMedisRanap::class, 'id_asesmen', 'id');
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Scope untuk filter berdasarkan sub kategori
    public function scopeBySubKategori($query, $sub_kategori)
    {
        return $query->where('sub_kategori', $sub_kategori);
    }

    // asesmen medis anak
    public function asesmenMedisAnak()
    {
        return $this->hasOne(RmeAsesmenMedisAnak::class, 'id_asesmen', 'id');
    }

    // asesmen medis Neonatologi
    public function asesmenMedisNeonatologi()
    {
        return $this->hasOne(RmeAsesmenMedisNeonatologi::class, 'id_asesmen', 'id');
    }
}
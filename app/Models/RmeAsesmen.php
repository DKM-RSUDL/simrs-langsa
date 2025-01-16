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
        'durasi'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

    //
    public function rmeAsesmenKepUmum()
    {
        return $this->hasOne(RmeAsesmenKepUmum::class, 'id_asesmen');
    }
}

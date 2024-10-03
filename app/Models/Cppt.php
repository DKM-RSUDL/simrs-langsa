<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cppt extends Model
{
    use HasFactory;

    protected $table = 'cppt';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'penanggung',
        'nama_penanggung',
        'tanggal',
        'jam',
        'subyetif',
        'obyektif',
        'assesment',
        'planning',
        'urut',
        'diagnosa_sekunder',
        'tingkat_kesadaran',
        'skala_nyeri',
        'lokasi',
        'durasi',
        'faktor_pemberat_id',
        'faktor_peringan_id',
        'kualitas_nyeri_id',
        'frekuensi_nyeri_id',
        'menjalar_id',
        'jenis_nyeri_id',
        'pemeriksaan_fisik',
        'user_penanggung',
        'verified',
        'user_verified',
        'urut_total'
    ];

    public function dtCppt()
    {
        return $this->belongsTo(DtCppt::class, 'penanggung', 'kode');
    }

    public function pemberat()
    {
        return $this->belongsTo(RmeFaktorPemberat::class, 'faktor_pemberat_id');
    }

    public function peringan()
    {
        return $this->belongsTo(RmeFaktorPeringan::class, 'faktor_peringan_id');
    }

    public function kualitas()
    {
        return $this->belongsTo(RmeKualitasNyeri::class, 'kualitas_nyeri_id');
    }

    public function frekuensi()
    {
        return $this->belongsTo(RmeFrekuensiNyeri::class, 'frekuensi_nyeri_id');
    }

    public function menjalar()
    {
        return $this->belongsTo(RmeMenjalar::class, 'menjalar_id');
    }

    public function jenis()
    {
        return $this->belongsTo(RmeJenisNyeri::class, 'jenis_nyeri_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepAnakStatusNyeri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_ANAK_STATUS_NYERI';
    public $timestamps = false;
    protected $guarded = ['id'];

    // Relasi ke tabel master
    public function frekuensiRelasi()
    {
        return $this->belongsTo(RmeFrekuensiNyeri::class, 'frekuensi', 'id');
    }

    public function kualitasRelasi()
    {
        return $this->belongsTo(RmeKualitasNyeri::class, 'kualitas', 'id');
    }

    public function menjalarRelasi()
    {
        return $this->belongsTo(RmeMenjalar::class, 'menjalar', 'id');
    }

    public function jenisNyeriRelasi()
    {
        return $this->belongsTo(RmeJenisNyeri::class, 'jenis_nyeri', 'id');
    }

    public function faktorPemberatRelasi()
    {
        return $this->belongsTo(RmeFaktorPemberat::class, 'faktor_pemberat', 'id');
    }

    public function faktorPeringanRelasi()
    {
        return $this->belongsTo(RmeFaktorPeringan::class, 'faktor_peringan', 'id');
    }

    public function efekNyeriRelasi()
    {
        return $this->belongsTo(RmeEfekNyeri::class, 'efek_nyeri', 'id');
    }
}

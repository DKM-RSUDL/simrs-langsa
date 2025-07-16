<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeSkalaNumerik extends Model
{
    use HasFactory;

    protected $table = 'RME_SKALA_NUMERIK';
    public $timestamps = false;
    protected $guarded = ['id'];


    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    // Relasi ke user yang mengupdate
    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }

    // Relasi ke master data kualitas nyeri
    public function kualitasNyeri()
    {
        return $this->belongsTo(RmeKualitasNyeri::class, 'kualitas_nyeri');
    }

    // Relasi ke master data faktor pemberat
    public function faktorPemberat()
    {
        return $this->belongsTo(RmeFaktorPemberat::class, 'faktor_pemberat');
    }

    // Relasi ke master data faktor peringan
    public function faktorPeringan()
    {
        return $this->belongsTo(RmeFaktorPeringan::class, 'faktor_peringan');
    }

    // Relasi ke master data efek nyeri
    public function efekNyeri()
    {
        return $this->belongsTo(RmeEfekNyeri::class, 'efek_nyeri');
    }

    // Relasi ke master data jenis nyeri
    public function jenisNyeri()
    {
        return $this->belongsTo(RmeJenisNyeri::class, 'jenis_nyeri');
    }

    // Relasi ke master data frekuensi nyeri
    public function frekuensiNyeri()
    {
        return $this->belongsTo(RmeFrekuensiNyeri::class, 'frekuensi_nyeri');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dokter;

class KonsultasiSpesialis extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_spesialis';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function dokterPengirim(){
        return $this->belongsTo(Dokter::class, 'dokter_pengirim', 'kd_dokter');
    }

    public function dokterTujuan(){
        return $this->belongsTo(Dokter::class, 'dokter_tujuan', 'kd_dokter');
    }

    public function spesialis(){
        return $this->belongsTo(Spesialisasi::class, 'kd_spesial', 'kd_spesial');
    }



}

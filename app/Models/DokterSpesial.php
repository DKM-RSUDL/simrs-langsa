<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterSpesial extends Model
{
    use HasFactory;

    protected $table = 'dokter_spesial';

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function spesialisasi()
    {
        return $this->belongsTo(Spesialisasi::class, 'kd_spesial', 'kd_spesial');
    }
}

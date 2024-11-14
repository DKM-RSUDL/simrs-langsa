<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterKlinik extends Model
{
    use HasFactory;

    protected $table = 'dokter_klinik';

    protected $fillable = [
        'kd_dokter',
        'kd_unit'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'kd_dokter_tujuan', 'kd_dokter');
    }
}

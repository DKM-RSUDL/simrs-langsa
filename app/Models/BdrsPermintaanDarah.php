<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdrsPermintaanDarah extends Model
{
    use HasFactory;

    protected $table = 'BDRS_PERMINTAAN_DARAH';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    public function golDarah()
    {
        return $this->belongsTo(GolonganDarah::class, 'kode_golda', 'kode');
    }

    public function rhesus()
    {
        return $this->belongsTo(Rhesus::class, 'kd_rhesus', 'kd_rhesus');
    }

    public function detail()
    {
        return $this->hasMany(BdrsPermintaanDarahDetail::class, 'id_order', 'id');
    }
}

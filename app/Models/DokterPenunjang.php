<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterPenunjang extends Model
{
    use HasFactory;

    protected $table = 'dokter_penunjang';

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

}

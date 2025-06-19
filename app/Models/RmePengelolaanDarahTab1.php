<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengelolaanDarahTab1 extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGELOLAAN_DARAH_TAB1';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function petugas1()
    {
        return $this->belongsTo(HrdKaryawan::class, 'petugas_1', 'kd_karyawan');
    }

    public function petugas2()
    {
        return $this->belongsTo(HrdKaryawan::class, 'petugas_2', 'kd_karyawan');
    }
}

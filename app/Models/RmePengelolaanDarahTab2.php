<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengelolaanDarahTab2 extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGELOLAAN_DARAH_TAB2';
    public $timestamps = false;
    protected $guarded = ['id'];

    // Di model RmePengelolaanDarahTab2
    public function dokterRelation()
    {
        return $this->belongsTo(Dokter::class, 'dokter', 'kd_dokter');
    }

    public function perawatRelation()
    {
        return $this->belongsTo(HrdKaryawan::class, 'perawat', 'kd_karyawan');
    }
}

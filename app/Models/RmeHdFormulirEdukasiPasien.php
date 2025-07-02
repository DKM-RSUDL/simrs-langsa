<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdFormulirEdukasiPasien extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_FORMULIR_EDUKASI_PASIEN';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function edukasiDetails()
    {
        return $this->hasMany(RmeHdFormulirEdukasiPasienDetail::class, 'formulir_edukasi_id', 'id');
    }

    public function edukator()
    {
        return $this->belongsTo(HrdKaryawan::class, 'edukator_kd', 'kd_karyawan');
    }
}

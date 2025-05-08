<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeSuratKematian extends Model
{
    use HasFactory;

    protected $table = 'RME_SURAT_KEMATIAN';
    public $timestamps = false;

    protected $guarded = ['id'];


    // Di model RmeSuratKematian
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function detailType1()
    {
        return $this->hasMany(RmeSuratKematianDtl::class, 'id_surat', 'id')
            ->where('type', 1);
    }

    public function detailType2()
    {
        return $this->hasMany(RmeSuratKematianDtl::class, 'id_surat', 'id')
            ->where('type', 2);
    }
}

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
    // Add these relationship methods to your RmeSuratKematian model

    /**
     * Get the doctor that wrote the death certificate.
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    /**
     * Get all Type 1 diagnosis details for this death certificate.
     */
    public function detailType1()
    {
        return $this->hasMany(RmeSuratKematianDtl::class, 'id_surat', 'id')
            ->where('type', 1)
            ->orderBy('id', 'asc');
    }

    /**
     * Get all Type 2 diagnosis details for this death certificate.
     */
    public function detailType2()
    {
        return $this->hasMany(RmeSuratKematianDtl::class, 'id_surat', 'id')
            ->where('type', 2)
            ->orderBy('id', 'asc');
    }
}

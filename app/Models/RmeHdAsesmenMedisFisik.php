<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenMedisFisik extends Model
{
    use HasFactory;

    protected $table = 'rme_hd_asesmen_medis_fisik';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'anamnesis',
        'sistole',
        'diastole',
        'nadi',
        'nafas',
        'suhu',
        'so_tb_o2',
        'so_db_o2',
        'avpu',
        'tinggi_badan',
        'berat_badan',
        'imt',
        'lpt',
        'skala_nyeri',
        'penyakit_sekarang',
        'penyakit_dahulu',
        'efek_samping',
        'terapi_obat',
    ];

    protected $casts = [
        'penyakit_sekarang'     => 'array',
        'penyakit_dahulu'       => 'array',
        'terapi_obat'           => 'array',
    ];
}
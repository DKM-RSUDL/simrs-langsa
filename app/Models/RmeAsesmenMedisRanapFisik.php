<?php
// Model RmeAsesmenMedisRanapFisik.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisRanapFisik extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MEDIS_RANAP_FISIK';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'pengkajian_kepala' => 'boolean',
        'pengkajian_mata' => 'boolean',
        'pengkajian_tht' => 'boolean',
        'pengkajian_leher' => 'boolean',
        'pengkajian_mulut' => 'boolean',
        'pengkajian_jantung' => 'boolean',
        'pengkajian_thorax' => 'boolean',
        'pengkajian_abdomen' => 'boolean',
        'pengkajian_tulang_belakang' => 'boolean',
        'pengkajian_sistem_syaraf' => 'boolean',
        'pengkajian_genetalia' => 'boolean',
        'pengkajian_status_lokasi' => 'boolean',
    ];

    public function asesmenMedis()
    {
        return $this->belongsTo(RmeAsesmenMedisRanap::class, 'id_asesmen_medis_ranap', 'id');
    }
}

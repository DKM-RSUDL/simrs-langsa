<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepPerinatologyKeperawatan extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_PERINATOLOGY_KEPERAWATAN';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'diagnosis' => 'array',
        'rencana_bersihan_jalan_nafas' => 'array',
        'rencana_penurunan_curah_jantung' => 'array',
        'rencana_perfusi_perifer' => 'array',
        'rencana_hipovolemia' => 'array',
        'rencana_hipervolemia' => 'array',
        'rencana_diare' => 'array',
        'rencana_retensi_urine' => 'array',
        'rencana_nyeri_akut' => 'array',
        'rencana_nyeri_kronis' => 'array',
        'rencana_hipertermia' => 'array',
        'rencana_gangguan_mobilitas_fisik' => 'array',
        'rencana_resiko_infeksi' => 'array',
        'rencana_konstipasi' => 'array',
        'rencana_resiko_jatuh' => 'array',
        'rencana_gangguan_integritas_kulit' => 'array',
    ];
}

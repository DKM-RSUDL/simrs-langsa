<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumSkalaNyeri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_SKALA_NYERI';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'skala_nyeri',
        'skala_nyeri_lokasi',
        'skala_nyeri_durasi',
        'skala_nyeri_pemberat_id',
        'skala_nyeri_peringan_id',
        'skala_nyeri_kualitas_id',
        'skala_nyeri_frekuensi_id',
        'skala_nyeri_menjalar_id',
        'skala_nyeri_jenis_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenMedisDeskripsi extends Model
{
    use HasFactory;

    protected $table = 'rme_hd_asesmen_medis_deskripsi';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'jenis_hd',
        'rutin',
        'jenis_dialisat',
        'suhu_dialisat',
        'akses_vaskular',
        'lama_hd',
        'qb',
        'qd',
        'uf_goal',
        'dosis_awal',
        'm_kontinyu',
        'm_intermiten',
        'tanpa_heparin',
        'lmwh',
        'ultrafiltrasi_mode',
        'natrium_mode',
        'bicabornat_mode',
    ];
}

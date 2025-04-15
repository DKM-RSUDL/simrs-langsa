<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenKeperawatanPemeriksaanFisik extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_ASESMEN_KEPERAWATAN_PEMERIKSAAN_FISIK';
    public $timestamps = false;

    protected $guarded = ['id'];
}

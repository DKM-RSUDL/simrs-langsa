<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmen extends Model
{
    use HasFactory;

    protected $table = 'rme_hd_asesmen';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'waktu_asesmen',
        'kategori',
    ];


    public function fisik()
    {
        return $this->hasOne(RmeHdAsesmenMedisFisik::class, 'id_asesmen', 'id');
    }

    public function pemFisik()
    {
        return $this->hasOne(RmeHdAsesmenPemeriksaanFisik::class, 'id_asesmen', 'id');
    }

    public function penunjang()
    {
        return $this->hasOne(RmeHdAsesmenMedisPenunjang::class, 'id_asesmen', 'id');
    }

    public function deskripsi()
    {
        return $this->hasOne(RmeHdAsesmenMedisDeskripsi::class, 'id_asesmen', 'id');
    }

    public function evaluasi()
    {
        return $this->hasOne(RmeHdAsesmenMedisEvaluasi::class, 'id_asesmen', 'id');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}

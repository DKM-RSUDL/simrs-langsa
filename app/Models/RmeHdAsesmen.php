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

    // keperawatan
    public function keperawatan()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatan::class, 'id_asesmen', 'id');
    }
    public function keperawatanPemeriksaanFisik()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanPemeriksaanFisik::class, 'id_asesmen', 'id');
    }

    public function pemeriksaanFisik()
    {
        return $this->hasMany(RmeAsesmenPemeriksaanFisik::class, 'id_asesmen', 'id');
    }
    public function keperawatanPempen()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanPempen::class, 'id_asesmen', 'id');
    }
    public function keperawatanStatusGizi()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanStatusGizi::class, 'id_asesmen', 'id');
    }
    public function keperawatanRisikoJatuh()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanRisikoJatuh::class, 'id_asesmen', 'id');
    }
    public function keperawatanStatusPsikososial()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanStatusPsikososial::class, 'id_asesmen', 'id');
    }
    public function keperawatanMonitoringPreekripsi()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanMonitoringPreekripsi::class, 'id_asesmen', 'id');
    }
    public function keperawatanMonitoringHeparinisasi()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanMonitoringHeparinisasi::class, 'id_asesmen', 'id');
    }
    public function keperawatanMonitoringTindakan()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanMonitoringTindakan::class, 'id_asesmen', 'id');
    }
    public function keperawatanMonitoringIntrahd()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanMonitoringIntrahd::class, 'id_asesmen', 'id');
    }
    public function keperawatanMonitoringPosthd()
    {
        return $this->hasOne(RmeHdAsesmenKeperawatanMonitoringPosthd::class, 'id_asesmen', 'id');
    }

}

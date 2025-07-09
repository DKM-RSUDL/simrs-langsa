<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengkajianGiziAnak extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGKAJIAN_GIZI_ANAK';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function asesmenGizi()
    {
        return $this->hasOne(RmePengkajianGiziAnakDtl::class, 'id_gizi', 'id');
    }

    public function intervensiGizi()
    {
        return $this->hasOne(RmePengkajianIntervensiGiziAnak::class, 'id_gizi');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    // Relasi dengan tabel users untuk user_update  
    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'user_update', 'id');
    }

    // Method untuk mendapatkan status gizi berdasarkan IMT
    public function getStatusGiziByImtAttribute()
    {
        if (!$this->imt) return null;

        // Contoh klasifikasi untuk anak (disesuaikan dengan standar medis)
        if ($this->imt < 17) return 'Gizi Buruk';
        if ($this->imt < 18.5) return 'Gizi Kurang';
        if ($this->imt < 25) return 'Gizi Baik/Normal';
        if ($this->imt < 30) return 'Gizi Lebih';
        return 'Obesitas';
    }

    
}

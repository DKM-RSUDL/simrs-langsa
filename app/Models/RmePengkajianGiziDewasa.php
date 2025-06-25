<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengkajianGiziDewasa extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGKAJIAN_GIZI_DEWASA';
    public $timestamps = false;
    protected $guarded = ['id'];


    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    // Relasi dengan tabel users untuk user_update  
    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'user_update', 'id');
    }

    // Di model RmePengkajianGiziDewasa
    public function asesmenGizi()
    {
        return $this->hasOne(RmePengkajianGiziDewasaDtl::class, 'id_gizi', 'id');
    }

    public function intervensiGizi()
    {
        return $this->hasOne(RmePengkajianIntervensiGiziDewasa::class, 'id_gizi', 'id');
    }

}

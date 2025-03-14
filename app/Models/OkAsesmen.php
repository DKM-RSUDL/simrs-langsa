<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkAsesmen extends Model
{
    use HasFactory;

    protected $table = 'ok_asesmen';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'kategori',
        'waktu_asesmen',
        'user_create',
        'user_edit',
    ];

    public function praOperatifMedis()
    {
        return $this->hasOne(OkPraOperasiMedis::class, 'id_asesmen', 'id');
    }

    public function praOperatifPerawat()
    {
        return $this->hasOne(OkPraOperasiPerawat::class, 'id_asesmen', 'id');
    }

    public function edukasiAnestesi()
    {
        return $this->hasOne(OkEdukasiAnestesi::class, 'id_asesmen', 'id');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
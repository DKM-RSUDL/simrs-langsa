<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'RME_EDUKASI';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function edukasiPasien()
    {
        return $this->hasOne(EdukasiPasien::class, 'id_edukasi', 'id');
    }

    public function kebutuhanEdukasi()
    {
        return $this->hasOne(EdukasiKebutuhanEdukasi::class, 'id_edukasi', 'id');
    }
    public function kebutuhanEdukasiLanjutan()
    {
        return $this->hasOne(EdukasiKebutuhanEdukasiLanjutan::class, 'id_edukasi', 'id');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}

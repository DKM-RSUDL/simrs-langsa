<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkCeklistKeselamatanSignin extends Model
{
    use HasFactory;

    protected $table = 'OK_CEKLIST_KESELAMATAN_SIGNIN';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    // Relasi ke dokter anestesi
    public function dokterAnestesi()
    {
        return $this->belongsTo(DokterAnastesi::class, 'ahli_anastesi', 'kd_dokter');
    }

    // Relasi ke perawat
    public function perawatData()
    {
        return $this->belongsTo(Perawat::class, 'perawat', 'kd_perawat');
    }
}

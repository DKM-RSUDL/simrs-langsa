<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkCeklistKeselamatanTimeOut extends Model
{
    use HasFactory;

    protected $table = 'OK_CEKLIST_KESELAMATAN_TIMEOUT';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    // Relasi ke dokter bedah
    public function dokterBedah()
    {
        return $this->belongsTo(Dokter::class, 'ahli_bedah', 'kd_dokter');
    }

    // Relasi ke dokter anestesi
    public function dokterAnastesi()
    {
        return $this->belongsTo(DokterAnastesi::class, 'ahli_anastesi', 'kd_dokter');
    }

    // Relasi ke perawat
    public function perawatData()
    {
        return $this->belongsTo(Perawat::class, 'perawat', 'kd_perawat');
    }
}

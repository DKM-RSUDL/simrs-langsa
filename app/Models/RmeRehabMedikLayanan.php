<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRehabMedikLayanan extends Model
{
    use HasFactory;

    protected $table = 'rme_rehab_medik_layanan';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tgl_pelayanan',
        'jam_pelayanan',
        'subjective',
        'objective',
        'assessment',
        'user_create',
        'user_edit',
    ];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function detail()
    {
        return $this->hasMany(RmeRehabMedikProgramDetail::class, 'id_layanan', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
}

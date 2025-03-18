<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRehabMedikProgram extends Model
{
    use HasFactory;

    protected $table = 'rme_rehab_medik_program';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tgl_pelayanan',
        'jam_pelayanan',
        'user_create',
        'user_edit',
    ];

    public function detail()
    {
        return $this->hasMany(RmeRehabMedikProgramDetail::class, 'id_program', 'id');
    }
}

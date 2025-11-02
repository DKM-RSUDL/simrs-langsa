<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRehabMedikTindakan extends Model
{
    use HasFactory;

    protected $table = 'rme_rehab_medik_tindakan';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tgl_tindakan',
        'jam_tindakan',
        'subjective',
        'objective',
        'assessment',
        'planning_goal',
        'planning_tindakan',
        'planning_edukasi',
        'planning_frekuensi',
        'rencana_tindak_lanjut',
        'user_create',
        'user_edit',
    ];

    public function karyawan()
    {
        return $this->belongsTo(HrdKaryawan::class, 'user_create', 'kd_karyawan');
    }
}

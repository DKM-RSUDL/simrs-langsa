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
        'ppa',
        'hasil',
        'kesimpulan',
        'rekomendasi',
    ];

    public function karyawan()
    {
        return $this->belongsTo(HrdKaryawan::class, 'ppa', 'kd_karyawan');
    }
}

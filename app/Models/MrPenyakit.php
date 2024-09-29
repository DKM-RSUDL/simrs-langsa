<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrPenyakit extends Model
{
    use HasFactory;

    protected $table = 'mr_penyakit';
    public $timestamps = false;

    protected $fillable = [
        'kd_penyakit',
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'urut',
        'stat_diag',
        'kasus',
        'tindakan',
        'perawatan',
        'tgl_cppt',
        'urut_cppt',
    ];

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class, 'kd_penyakit', 'kd_penyakit');
    }
}

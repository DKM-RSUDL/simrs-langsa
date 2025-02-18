<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeResumeDtl extends Model
{
    use HasFactory;
    protected $table = 'RME_RESUME_DTL';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    // protected $keyType = 'float';
    public $timestamps = false;

    protected $fillable = [
        'id_resume',
        'tindak_lanjut_code',
        'tindak_lanjut_name',
        'tgl_kontrol_ulang',
        'unit_rujuk_internal',
        'unit_rawat_inap',
        'rs_rujuk',
        'alasan_rujuk',
        'transportasi_rujuk',
        'tgl_pulang',
        'jam_pulang',
        'alasan_pulang',
        'kondisi_pulang',
        'tgl_rajal',
        'unit_rajal',
        'alasan_menolak_inap',
        'tgl_meninggal',
        'jam_meninggal',
        'tgl_meninggal_doa',
        'jam_meninggal_doa',
    ];

    public function resume()
    {
        return $this->belongsTo(RMEResume::class, 'id_resume', 'id');
    }

    public function unitRujukanInternal()
    {
        return $this->belongsTo(Unit::class, 'unit_rujuk_internal', 'kd_unit');
    }
}

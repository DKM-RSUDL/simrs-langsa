<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeResumeDtl extends Model
{
    use HasFactory;
    protected $table = 'RME_RESUME_DTL';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'float';
    public $timestamps = false;

    protected $fillable = [
        'id_resume',
        'tindak_lanjut_code',
        'tindak_lanjut_name',
        'tgl_kontrol_ulang',
        'unit_rujuk_internal',
        'unit_rawat_inap',
        'rs_rujuk',
        'rs_rujuk_bagian'
    ];

    public function resume()
    {
        return $this->belongsTo(RMEResume::class, 'id_resume', 'id');
    }
}

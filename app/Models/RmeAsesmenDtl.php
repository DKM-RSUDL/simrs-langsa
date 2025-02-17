<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_DTL';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'tindak_lanjut_code',
        'tindak_lanjut_name',
        'tgl_kontrol_ulang',
        'unit_rujuk_internal',
        'unit_rawat_inap',
        'rs_rujuk',
        'rs_rujuk_bagian',
        'keterangan',
    ];

    public function spri()
    {
        return $this->hasOne(RmeSpri::class, 'id_asesmen', 'id_asesmen');
    }

}

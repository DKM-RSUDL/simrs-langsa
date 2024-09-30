<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpptTindakLanjut extends Model
{
    use HasFactory;

    protected $table = 'cppt_tindak_lanjut';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'tanggal',
        'jam',
        'tindak_lanjut_code',
        'tindak_lanjut_name',
        'tgl_kontrol_ulang',
        'unit_rujuk_internal',
        'unit_rawat_inap',
        'rs_rujuk',
        'rs_rujuk_bagian',
        'urut',
    ];
}

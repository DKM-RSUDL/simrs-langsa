<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeFormulirRekonsiliasiObatTransfer extends Model
{
    use HasFactory;

    protected $table = 'RME_FORMULIR_REKONSILIASI_OBAT_TRANSFER';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'kd_pasien',
        'tgl_masuk',
        'urut_masuk',
        'kd_unit',
        'nama_obat',
        'user_created',
        'dosis',
        'frekuensi',
        'perubahanpakai',
        'keterangan',
        'tindak_lanjut',
        'kd_petugas',
    ];

    protected $casts = [
        'tindak_lanjut' => 'integer'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }
}
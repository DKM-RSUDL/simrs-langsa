<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeDokumenBerkasDigital extends Model
{
    use HasFactory;

    protected $table = 'rme_dokumen_berkas_digital';

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'file',
        'jenis_berkas_id',
        'user_create',
        'user_edit',
    ];


    public function jenisBerkas()
    {
        return $this->belongsTo(MasterBerkasDigital::class, 'jenis_berkas_id');
    }
}
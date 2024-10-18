<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTindakanPasien extends Model
{
    use HasFactory;
    protected $table = 'list_tindakan_pasien';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'urut_list',
        'keterangan',
        'tgl_tindakan',
        'jam_tindakan',
        'kd_dokter',
        'status',
        'tgl_realisasi',
        'jam_realisasi',
        'kd_produk',
        'kesimpulan',
        'gambar',
        'laporan_hasil'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kd_produk', 'kd_produk');
    }

    public function ppa()
    {
        return $this->belongsTO(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }
}

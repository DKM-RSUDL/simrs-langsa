<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTriase extends Model
{
    use HasFactory;

    protected $table = 'data_triase';
    public $timestamps = false;

    protected $fillable = [
        'nama_pasien',
        'usia',
        'usia_bulan',
        'jenis_kelamin',
        'tanggal_lahir',
        'status',
        'kd_pasien',
        'keterangan',
        'tanggal_triase',
        'triase',
        'hasil_triase',
        'dokter_triase',
        'kode_triase',
        'kd_pasien_triase',
        'foto_pasien',
        'id_asesmen',
        'vital_sign'
    ];

    // protected $dates = ['tanggal_triase'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien_triase', 'kd_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_triase', 'kd_dokter');
    }

    public function asesmen()
    {
        return $this->belongsTo(RmeAsesmen::class, 'id_asesmen', 'id');
    }
}

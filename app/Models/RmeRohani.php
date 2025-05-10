<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRohani extends Model
{
    use HasFactory;

    protected $table = 'rme_rohani';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'kondisi_pasien'    => 'array'
    ];

    public function penyetuju()
    {
        return $this->belongsTo(HrdKaryawan::class, 'kd_penyetuju', 'kd_karyawan');
    }

    public function keluargaAgama()
    {
        return $this->belongsTo(Agama::class, 'keluarga_agama', 'kd_agama');
    }
}

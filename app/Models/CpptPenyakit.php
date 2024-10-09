<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpptPenyakit extends Model
{
    use HasFactory;
    protected $table = 'cppt_penyakit';
    public $timestamps = false;

    protected $fillable = [
        'no_transaksi',
        'kd_unit',
        'tgl_cppt',
        'urut_cppt',
        'kd_penyakit',
        'nama_penyakit',
    ];
}

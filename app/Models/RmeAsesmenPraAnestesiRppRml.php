<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPraAnestesiRppRml extends Model
{
    //  model ini untuk Riwayat Penyakit Pasien dan Riwayat Medis Lainnya
    use HasFactory;

    protected $table = 'RME_ASESMEN_PRA_ANESTESI_RPP_RML';
    public $timestamps = false;
    protected $guarded = ['id'];
}

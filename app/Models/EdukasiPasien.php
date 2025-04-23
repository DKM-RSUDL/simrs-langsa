<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdukasiPasien extends Model
{
    use HasFactory;

    protected $table = 'RME_EDUKASI_PASIEN';
    public $timestamps = false;
    protected $guarded = ['id'];
}

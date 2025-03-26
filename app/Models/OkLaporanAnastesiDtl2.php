<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkLaporanAnastesiDtl2 extends Model
{
    use HasFactory;

    protected $table = 'OK_LAPORAN_ANASTESI_DTL_2';
    public $timestamps = false;
    protected $guarded = ['id'];
}

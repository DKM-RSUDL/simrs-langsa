<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkLaporanAnastesiDtl extends Model
{
    use HasFactory;
    protected $table = 'OK_LAPORAN_ANASTESI_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];
}

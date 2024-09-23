<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv_rslangsa';
    protected $table = 'KUNJUNGAN';
    protected $primaryKey = 'KD_PASIEN';

    public $incrementing = false;

    protected $keyType = 'string';
    public $timestamps = false;
}

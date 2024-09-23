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


    public function pasien()
    {
        return $this->belongsTo(Pasien::class,'kd_pasien', 'kd_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kd_customer', 'kd_customer');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrdKaryawan extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv_hrd';
    protected $table = 'HRD_KARYAWAN';
    public $incrementing = false;


    public function ruangan()
    {
        return $this->belongsTo(HrdRuangan::class, 'kd_ruangan', 'kd_ruangan');
    }
}

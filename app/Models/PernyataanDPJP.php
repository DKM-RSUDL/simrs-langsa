<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PernyataanDPJP extends Model
{
    use HasFactory;

    protected $table = 'RME_PERNYATAAN_DPJP';
    public $timestamps = false;
    protected $guarded = ['id'];


    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdrsPermintaanDarahDetail extends Model
{
    use HasFactory;

    protected $table = 'BDRS_PERMINTAAN_DARAH_DETAIL';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function golDarah()
    {
        return $this->belongsTo(GolonganDarah::class, 'kd_golda', 'kode');
    }
}

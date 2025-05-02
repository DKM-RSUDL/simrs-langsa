<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdrsPermintaanDarah extends Model
{
    use HasFactory;

    protected $table = 'BDRS_PERMINTAAN_DARAH';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }
}
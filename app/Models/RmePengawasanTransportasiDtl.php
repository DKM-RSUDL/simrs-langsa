<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengawasanTransportasiDtl extends Model
{
    use HasFactory;

    protected $table = 'rme_pengawasan_transportasi_dtl';
    public $timestamps = false;
    protected $guarded = ['id'];
}
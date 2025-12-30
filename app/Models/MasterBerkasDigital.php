<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBerkasDigital extends Model
{
    protected $table = 'RME_MR_BERKAS_DIGITAL'; // Sesuai nama tabel di Navicat Anda

    protected $fillable = [
        'nama_berkas',
        'slug',
        'user_create',
        'user_update'
    ];

    public $timestamps = false;
}

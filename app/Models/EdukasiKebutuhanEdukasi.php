<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdukasiKebutuhanEdukasi extends Model
{
    use HasFactory;

    protected $table = 'RME_EDUKASI_KEBUTUHAN_EDUKASI';
    public $timestamps = false;
    protected $guarded = ['id'];
}

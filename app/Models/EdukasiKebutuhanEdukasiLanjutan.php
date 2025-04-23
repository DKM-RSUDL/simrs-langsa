<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdukasiKebutuhanEdukasiLanjutan extends Model
{
    use HasFactory;

    protected $table = 'EDUKASI_KEBUTUHAN_EDUKASI_LANJUTAN';
    public $timestamps = false;
    protected $guarded = ['id'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RMEEdukasiRoles extends Model
{
    use HasFactory;

    protected $table = 'RME_EDUKASI_ROLES';
    public $timestamps = false;
    protected $guarded = ['id'];
}

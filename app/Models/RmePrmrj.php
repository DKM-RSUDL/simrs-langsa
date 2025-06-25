<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePrmrj extends Model
{
    use HasFactory;

    protected $table = 'RME_PRMRJ';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function rmeAlergiPasien()
    {
        return $this->hasMany(RmeAlergiPasien::class, 'kd_pasien', 'kd_pasien');
    }
}

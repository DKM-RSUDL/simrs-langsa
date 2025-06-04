<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAlergiPasien extends Model
{
    use HasFactory;

    protected $table = 'RME_ALERGI_PASIEN';
    protected $guarded = ['id'];
    public $timestamps = false;


    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

}

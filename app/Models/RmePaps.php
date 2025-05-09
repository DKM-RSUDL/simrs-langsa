<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePaps extends Model
{
    use HasFactory;

    protected $table = 'RME_PAPS';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function detail()
    {
        return $this->hasMany(RmePapsDtl::class, 'id_paps', 'id');
    }
}

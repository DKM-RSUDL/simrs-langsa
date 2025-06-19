<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdrsPermintaanDarahDetail extends Model
{
    use HasFactory;

    protected $table = 'bdrs_permintaan_darah_detail';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function golDarah()
    {
        return $this->belongsTo(GolonganDarah::class, 'kd_golda', 'kode');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}

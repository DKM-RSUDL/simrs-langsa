<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengawasanPerinatology extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGAWASAN_PERINATOLOGY';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasOne(RmePengawasanPerinatologyDtl::class, 'id_pengawasan_perinatology', 'id');
    }
}

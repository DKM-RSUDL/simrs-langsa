<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengawasanPerinatologyDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGAWASAN_PERINATOLOGY_DTL';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function perinatology()
    {
        return $this->belongsTo(RmePengawasanPerinatology::class, 'id_pengawasan_perinatology', 'id');
    }
}

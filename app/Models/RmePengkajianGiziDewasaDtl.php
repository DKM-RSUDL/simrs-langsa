<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengkajianGiziDewasaDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGKAJIAN_GIZI_DEWASA_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function pengkajianGizi()
    {
        return $this->belongsTo(RmePengkajianGiziDewasa::class, 'id_gizi', 'id');
    }
}

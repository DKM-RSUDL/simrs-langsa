<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengkajianIntervensiGiziAnak extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGKAJIAN_INTERVENSI_GIZI_ANAK';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function pengkajianGizi()
    {
        return $this->belongsTo(RmePengkajianGiziAnak::class, 'id_gizi');
    }

}

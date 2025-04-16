<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkPraInduksi extends Model
{
    use HasFactory;

    protected $table = 'OK_PRA_INDUKSI';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function okPraInduksiEpas()
    {
        return $this->hasOne(OkPraInduksiEpas::class, 'id_pra_induksi', 'id');
    }
    public function okPraInduksiPsas()
    {
        return $this->hasOne(OkPraInduksiPsas::class, 'id_pra_induksi', 'id');
    }
    public function okPraInduksiCtkp()
    {
        return $this->hasOne(OkPraInduksiCtkp::class, 'id_pra_induksi', 'id');
    }
    public function okPraInduksiIpb()
    {
        return $this->hasOne(OkPraInduksiIpb::class, 'id_pra_induksi', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPsikiatriDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PSIKIATRI_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function prognosisValue()
    {
        return $this->belongsTo(SatsetPrognosis::class, 'prognosis', 'prognosis_id');
    }
}

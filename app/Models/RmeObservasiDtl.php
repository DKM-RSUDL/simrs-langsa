<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeObservasiDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_OBSERVASI_DTL';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function observasi()
    {
        return $this->belongsTo(RmeObservasi::class, 'observasi_id');
    }
}

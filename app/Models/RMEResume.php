<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RMEResume extends Model
{
    use HasFactory;
    protected $table = 'RME_RESUME';

    public function rmeResumeDet()
    {
        return $this->belongsTo(RmeResumeDtl::class, 'id', 'id_resume');
    }
}

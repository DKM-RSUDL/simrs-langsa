<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupaten';

    public function propinsi()
    {
        return $this->belongsTo(Propinsi::class, 'kd_propinsi', 'kd_propinsi');
    }
}

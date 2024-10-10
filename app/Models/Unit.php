<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit';
    public $timestamps = false;

    public function bagian()
    {
        return $this->belongsTo(Bagian::class, 'kd_bagian', 'kd_bagian');
    }
}

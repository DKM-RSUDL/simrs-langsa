<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    public $timestamps = false;

    public function golonganDarah()
    {
        return $this->belongsTo(GolonganDarah::class, 'gol_darah', 'kode');
    }
}

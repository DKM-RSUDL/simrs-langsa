<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrKonpasDtl extends Model
{
    use HasFactory;

    protected $table = 'mr_konpasdtl';
    public $timestamps = false;

    protected $fillable = [
        'id_konpas',
        'id_kondisi',
        'hasil',
    ];

    public function konpas()
    {
        return $this->belongsTo(MrKonpas::class, 'id_konpas', 'id_konpas');
    }

    public function konpasFisik()
    {
        return $this->belongsTo(MrKondisiFisik::class, 'id_kondisi', 'id_kondisi');
    }
}

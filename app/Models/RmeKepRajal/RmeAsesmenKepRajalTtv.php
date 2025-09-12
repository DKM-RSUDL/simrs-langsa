<?php

namespace App\Models\RmeKepRajal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepRajalTtv extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_RAJAL_TTV';
    public $timestamps = false; // set true jika tabel punya created_at/updated_at

    protected $fillable = [
        'id',
        'id_asesmen',
        'sistolik',
        'diastolik',
        'nadi',
        'nafas_per_menit',
        'suhu',
    ];
}
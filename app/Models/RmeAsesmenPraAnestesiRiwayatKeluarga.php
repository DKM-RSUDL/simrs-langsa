<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPraAnestesiRiwayatKeluarga extends Model
{
    // model ini untuk riwayat keluarga dan komunikasi
    use HasFactory;

    protected $table = 'RME_ASESMEN_PRA_ANESTESI_RIWAYAT_KELUARGA';
    public $timestamps = false;
    protected $guarded = ['id'];
}

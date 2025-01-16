<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepAnakRiwayatKesehatan extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_ANAK_RIWAYAT_KESEHATAN';
    protected $guarded = ['id'];
}

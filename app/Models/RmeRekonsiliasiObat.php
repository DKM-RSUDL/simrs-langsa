<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRekonsiliasiObat extends Model
{
    use HasFactory;

    protected $table = 'RME_REKONSILIASI_OBAT';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'kd_petugas', 'id');
    }
}

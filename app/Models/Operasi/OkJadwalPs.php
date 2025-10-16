<?php

namespace App\Models\Operasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkJadwalPs extends Model
{
    use HasFactory;
    protected $table = 'OK_JADWAL_PS';
    protected $guarded = [];
    public $timestamps = false;
}

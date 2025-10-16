<?php

namespace App\Models\Operasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkJadwalDr extends Model
{
    use HasFactory;
    
    protected $table = 'OK_JADWAL_DR';
    protected $guarded = [];
    public $timestamps = false;
}

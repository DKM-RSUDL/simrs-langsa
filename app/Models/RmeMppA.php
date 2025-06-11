<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeMppA extends Model
{
    use HasFactory;

    protected $table = 'RME_MPP_A';
    protected $guarded = ['id'];


    public function dokterUtama()
    {
        return $this->belongsTo(Dokter::class, 'dpjp_utama', 'kd_dokter');
    }

    public function dokterTambahan()
    {
        return $this->belongsTo(Dokter::class, 'dpjp_tambahan', 'kd_dokter');
    }
    // Relasi dengan user (yang menginput)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

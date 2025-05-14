<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePenundaanPelayanan extends Model
{
    use HasFactory;

    protected $table = 'rme_penundaan_pelayanan';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
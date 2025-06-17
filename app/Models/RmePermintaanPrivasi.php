<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePermintaanPrivasi extends Model
{
    use HasFactory;

    protected $table = 'rme_permintaan_privasi';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'privasi_khusus'    => 'array'
    ];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}

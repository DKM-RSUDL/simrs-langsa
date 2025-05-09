<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeObservasi extends Model
{
    use HasFactory;

    protected $table = 'RME_OBSERVASI';
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date', // Casts to Carbon instance
    ];

    public function details()
    {
        return $this->hasMany(RmeObservasiDtl::class, 'observasi_id');
    }

    public function perawat()
    {
        return $this->belongsTo(Perawat::class, 'kd_perawat', 'kd_perawat');
    }
}

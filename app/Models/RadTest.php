<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadTest extends Model
{
    use HasFactory;

    protected $table = 'rad_test';
    protected $primaryKey = 'kd_test';
    public $timestamps = false;

    protected $guarded = [];

    // Relasi dengan produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kd_test', 'kd_produk');
    }

    // Relasi dengan rad_hasil
    public function radHasil()
    {
        return $this->hasMany(RadHasil::class, 'kd_test', 'kd_test');
    }
}

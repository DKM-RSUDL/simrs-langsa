<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadHasil extends Model
{
    use HasFactory;

    protected $table = 'rad_hasil';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'tgl_masuk' => 'date',
        'urut_masuk' => 'integer',
        'urut' => 'integer',
    ];

    // Relasi dengan rad_test
    public function radTest()
    {
        return $this->belongsTo(RadTest::class, 'kd_test', 'kd_test');
    }

    // Relasi dengan pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    // Relasi dengan produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kd_test', 'kd_produk');
    }

    // Relasi dengan kunjungan
    public function kunjungan()
    {
        // Use simple belongsTo on the patient key. Composite-key constraints
        // referencing the parent table (rad_hasil) can't be placed here because
        // Eloquent may execute the related query without the parent table in
        // scope (causing "could not be bound" SQL errors). Fetch additional
        // matching columns in controller queries when needed.
        return $this->belongsTo(Kunjungan::class, 'kd_pasien', 'kd_pasien');
    }
}

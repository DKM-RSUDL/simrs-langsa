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
        return $this->belongsTo(Kunjungan::class, function ($query) {
            $query->on('rad_hasil.kd_pasien', '=', 'kunjungan.kd_pasien')
                ->on('rad_hasil.kd_unit', '=', 'kunjungan.kd_unit')
                ->on('rad_hasil.tgl_masuk', '=', 'kunjungan.tgl_masuk')
                ->on('rad_hasil.urut_masuk', '=', 'kunjungan.urut_masuk');
        });
    }
}

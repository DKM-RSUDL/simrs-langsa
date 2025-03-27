<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRehabMedikProgramDetail extends Model
{
    use HasFactory;

    protected $table = 'rme_rehab_medik_program_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_program',
        'kd_produk',
        'tarif',
        'tgl_berlaku',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kd_produk', 'kd_produk');
    }

    public function program()
    {
        return $this->belongsTo(RmeRehabMedikProgram::class, 'id_program', 'id');
    }
}

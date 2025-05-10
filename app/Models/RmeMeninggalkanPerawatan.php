<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeMeninggalkanPerawatan extends Model
{
    use HasFactory;

    protected $table = 'rme_meninggalkan_perawatan';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
}

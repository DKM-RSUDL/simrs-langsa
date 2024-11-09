<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPemeriksaanFisik extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PEMERIKSAAN_FISIK';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'id_item_fisik',
        'is_normal',
        'keterangan',
    ];

    public function itemFisik()
    {
        return $this->belongsTo(MrItemFisik::class, 'id_item_fisik', 'id');
    }
}

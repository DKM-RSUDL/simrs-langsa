<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePersetujuanAnestesi extends Model
{
    use HasFactory;

    protected $table = 'rme_persetujuan_anestesi';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $casts = [
        'tindakan'  => 'array'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
}

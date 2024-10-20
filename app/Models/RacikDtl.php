<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RacikDtl extends Model
{
    use HasFactory;

    protected $table = 'RACIK_DTL';
    protected $primaryKey = 'ID_MRRESEP';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;


    protected $fillable = [
        'ID_MRRESEP',
        'URUT',
        'KD_PRD',
        'CARA_PAKAI',
        'JUMLAH',
        'KD_DOKTER',
    ];
}

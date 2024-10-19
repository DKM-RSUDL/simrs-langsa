<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeResumeDtl extends Model
{
    use HasFactory;
    protected $table = 'RME_RESUME_DTL';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'float';
    public $timestamps = false;

    protected $fillable = [
        'id_resume',
        'tindak_lanjut_code',
        'tindak_lanjut_name',
    ];
}

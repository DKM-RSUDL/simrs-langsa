<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeDataHasilLabDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_DATA_HASIL_LAB_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenThtDataMasuk extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_THT_DATA_MASUK';
    public $timestamps = false;
    protected $guarded = ['id'];
}

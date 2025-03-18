<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRujukKeluar extends Model
{
    use HasFactory;

    protected $table = 'RME_RUJUK_KELUAR';
    public $timestamps = false;
    protected $guarded = ['id'];
}

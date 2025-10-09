<?php

namespace App\Models\RawatInap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperasiIBS extends Model
{
    use HasFactory;

    protected $table = 'ORDER_OK';

    protected $guarded = [];
    public $timestamps = false;
}
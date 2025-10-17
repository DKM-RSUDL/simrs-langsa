<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAsalInap extends Model
{
    use HasFactory;

    protected $table = 'unit_asalinap';
    public $timestamps = false;
    protected $guarded = [];
}

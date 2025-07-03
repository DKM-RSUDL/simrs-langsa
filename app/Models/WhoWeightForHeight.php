<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhoWeightForHeight extends Model
{
    use HasFactory;

    protected $table = 'rme_who_weight_for_height';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'sex',
        'height_cm',
        'l',
        'm',
        's'
    ];

    protected $casts = [
        'sex' => 'integer',
        'height_cm' => 'float',
        'L' => 'float',
        'M' => 'float',
        'S' => 'float'
    ];
}

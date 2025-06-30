<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhoWeightForLength extends Model
{
    use HasFactory;

    protected $table = 'rme_who_weight_for_length';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'sex',
        'length_cm',
        'l',
        'm',
        's'
    ];

    protected $casts = [
        'sex' => 'integer',
        'length_cm' => 'float',
        'L' => 'float',
        'M' => 'float',
        'S' => 'float'
    ];
}

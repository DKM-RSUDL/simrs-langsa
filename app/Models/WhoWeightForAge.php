<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhoWeightForAge extends Model
{
    use HasFactory;

    protected $table = 'who_weight_for_age';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'sex',
        'age_months',
        'l',
        'm',
        's'
    ];

    protected $casts = [
        'sex' => 'integer',
        'age_months' => 'float',
        'L' => 'float',
        'M' => 'float',
        'S' => 'float'
    ];
}

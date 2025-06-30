<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhoHeightForAge extends Model
{
    use HasFactory;

    protected $table = 'rme_who_height_for_age';
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

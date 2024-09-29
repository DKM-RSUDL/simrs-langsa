<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';
    public $timestamps = false;

    protected $fillable = [
        'kd_penyakit',
        'parent',
        'penyakit',
        'includes',
        'excludes',
        'notes',
        'status_app',
        'description',
    ];
}

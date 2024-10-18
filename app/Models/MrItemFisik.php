<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrItemFisik extends Model
{
    use HasFactory;

    protected $table = 'mr_item_fisik';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama',
    ];
}

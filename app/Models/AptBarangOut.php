<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AptBarangOut extends Model
{
    use HasFactory;
    protected $table = 'apt_barang_out';
    public $timestamps = false;
    protected $guarded = [];
}

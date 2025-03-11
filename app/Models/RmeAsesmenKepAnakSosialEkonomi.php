<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepAnakSosialEkonomi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_ANAK_SOSIAL_EKONOMI';
    public $timestamps = false;
    protected $guarded = ['id'];
}

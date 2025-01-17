<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumSosialEkonomi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_SOSIAL_EKONOMI';
    public $timestamps = false;

    protected $guarded = ['id'];
}

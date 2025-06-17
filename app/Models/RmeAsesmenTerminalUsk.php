<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenTerminalUsk extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_TERMINAL_USK';
    public $timestamps = false;
    protected $guarded = ['id'];
}

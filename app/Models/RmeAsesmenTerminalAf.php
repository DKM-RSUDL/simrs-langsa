<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenTerminalAf extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_TERMINAL_AF';
    public $timestamps = false;
    protected $guarded = ['id'];
}

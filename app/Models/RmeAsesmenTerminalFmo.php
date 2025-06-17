<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenTerminalFmo extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_TERMINAL_FMO';
    public $timestamps = false;
    protected $guarded = ['id'];
}

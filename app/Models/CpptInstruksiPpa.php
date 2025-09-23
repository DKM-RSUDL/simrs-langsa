<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpptInstruksiPpa extends Model
{
    use HasFactory;
    protected $table = 'CPPT_INSTRUKSI_PPA';
    public $timestamps = false;
    protected $guarded = ['id'];

    
}

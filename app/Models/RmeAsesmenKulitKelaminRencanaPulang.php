<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKulitKelaminRencanaPulang extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KULIT_KELAMIN_RENCANA_PULANG';
    public $timestamps = false;
    protected $guarded = ['id'];
}

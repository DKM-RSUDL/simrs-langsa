<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeSuratKematianDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_SURAT_KEMATIAN_DTL';
    public $timestamps = false;

    protected $guarded = ['id'];
}

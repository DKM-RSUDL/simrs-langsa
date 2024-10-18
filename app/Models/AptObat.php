<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AptObat extends Model
{
    use HasFactory;

    protected $table = 'apt_obat';
    protected $primaryKey = 'kd_prd';
    public $incrementing = false;
    protected $keyType = 'string';

    // anas
    public function mrResepDtl()
    {
        return $this->belongsTo(MrResepDtl::class, 'kd_prd', 'kd_prd');
    }

    public function mrResep()
    {
        return $this->belongsTo(MrResep::class,'id_mrresep', 'id_mrresep');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrdRuangan extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv_hrd';
    protected $table = 'hrd_ruangan';
}

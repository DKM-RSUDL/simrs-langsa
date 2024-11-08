<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as RoleSpatie;

class Role extends RoleSpatie
{
    use HasFactory;
    protected $connection = 'sqlsrv_hrd';
    protected $table = 'roles';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationRole extends Model
{
    use HasFactory;
    // protected $connection = 'sqlsrv_hrd';

    protected $table = 'navigation_role';

    protected $guarded = ['id'];
}

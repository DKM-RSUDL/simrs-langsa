<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv_hrd';
    protected $table = 'navigations';
    // protected $connection = 'sqlsrv_rslangsa';

    protected $guarded = ['id'];

    public function subMenus()
    {
        return $this->hasMany(Navigation::class, 'main_menu');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'navigation_role');
    }
}

<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingBerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read berkas-digital');
    }
    
    public function index()
    {
        return 'Menu Setting Berkas Digital';
    }
}
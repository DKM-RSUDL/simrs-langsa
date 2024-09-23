<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedisGawatDaruratController extends Controller
{
    public function index()
    {
        return view('medis-gawat-darurat.index');
    }
}

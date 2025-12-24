<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanBerkasController extends Controller
{
    public function index(){
        return view('laporan-berkas.index');
    }
}

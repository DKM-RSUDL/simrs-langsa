<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RawatJalanController extends Controller
{
    public function index()
    {
        return view('unit-pelayanan.rawat-jalan.index');
    }
}

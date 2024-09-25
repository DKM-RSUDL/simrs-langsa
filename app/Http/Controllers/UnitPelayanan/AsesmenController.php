<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsesmenController extends Controller
{
    public function index()
    {
        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen');
    }
}

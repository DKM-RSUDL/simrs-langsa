<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BedahController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    public function index()
    {
        return view('unit-pelayanan.rawat-jalan.bedah.index');
    }
}
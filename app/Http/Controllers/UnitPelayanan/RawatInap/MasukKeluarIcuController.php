<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasukKeluarIcuController extends Controller
{
    public function index()
    {
        return view('unit-pelayanan.rawat-inap.masuk-keluar-icu.index');
    }
}

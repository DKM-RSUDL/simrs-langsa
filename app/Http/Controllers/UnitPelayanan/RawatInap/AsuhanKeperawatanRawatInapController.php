<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsuhanKeperawatanRawatInapController extends Controller
{
    public function index()
    {
        return view('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.index');
    }
}

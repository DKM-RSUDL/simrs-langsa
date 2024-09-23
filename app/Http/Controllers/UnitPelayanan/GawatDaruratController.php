<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\TestModel;
use Illuminate\Http\Request;

class GawatDaruratController extends Controller
{
    protected $roleService;
    public function index(Request $request)
    {
        $DataKunjungan = Kunjungan::all();
        if ($request->ajax()) {
            return $this->roleService->dataTable();
        }
        return view('unit-pelayanan.gawat-darurat.index', compact('DataKunjungan'));
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\TestModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GawatDaruratController extends Controller
{
    protected $roleService;
   public function index(Request $request)
{
        if ($request->ajax()) {
            $data = Kunjungan::select(['kd_pasien', 'kd_dokter', 'tgl_masuk'])
            ->where('kd_unit', 3); // Pilih kolom yang diperlukan
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="" class="edit btn btn-secondary btn-sm"><i class="ti-pencil-alt"></i></a>';
                    $btn .= '<a href="" class="btn btn-secondary btn-sm">...</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('unit-pelayanan.gawat-darurat.index');
    }
}

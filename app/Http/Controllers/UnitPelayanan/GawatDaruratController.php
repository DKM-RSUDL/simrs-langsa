<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\TestModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GawatDaruratController extends Controller
{
    protected $roleService;
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Kunjungan::select(['kd_pasien', 'kd_dokter', 'tgl_masuk'])
                        ->where('kd_unit', 3); // Pilih kolom yang diperlukan
        return DataTables::of($data)
            ->addColumn('waktu_masuk', function($row) {
                Carbon::setLocale('id');
                $tgl = Carbon::parse($row->tgl_masuk)->translatedFormat('d M Y');

                // $jamMasukExp = explode(' ', $row->jam_masuk);
                // $jamMasuk = $jamMasukExp[1];
                // $jamExp = explode('.', $jamMasuk);
                // $jam = $jamExp[0];
                // $jamParse = date('H:i', strtotime($jam));

                // return "$tgl $jamParse";
            })
            ->addColumn('action', function($row){
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

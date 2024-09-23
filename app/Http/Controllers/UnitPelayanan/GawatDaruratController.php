<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class GawatDaruratController extends Controller
{
    protected $roleService;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kunjungan::select([
                'kd_pasien',
                'kd_dokter',
                'tgl_masuk',
            ]);

            return DataTables::of($data)
                ->addColumn('Triase', fn($row) => '')
                ->addColumn('Bed', fn($row) => '')
                ->addColumn('No RM/ Reg', fn($row) => $row->kd_pasien ?: 'null')
                ->addColumn('Alamat', fn($row) => '')
                ->addColumn('Jaminan', fn($row) => '')
                ->addColumn('Instruksi', fn($row) => '')
                ->addColumn('kd_dokter', fn($row) => $row->kd_dokter ?: 'null')
                ->addColumn('tgl_masuk', function ($row) {
                    return $row->tgl_masuk
                        ? Carbon::parse($row->tgl_masuk)->format('d M Y h:i A')
                        : 'null';
                })
                ->addColumn('action', fn($row) => $row->kd_pasien)  // Return raw data, no HTML
                ->addColumn('del', fn($row) => $row->kd_pasien)     // Return raw data
                ->addColumn('profile', fn($row) => $row)            // Return the row data for Blade
                ->make(true);
        }

        return view('unit-pelayanan.gawat-darurat.index');
    }

}

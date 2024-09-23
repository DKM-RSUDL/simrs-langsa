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
            $data = Kunjungan::with(['pasien', 'dokter']);

            return DataTables::of($data)
                ->order(function ($query) {
                    $query->orderBy('tgl_masuk', 'desc');
                })
                ->addColumn('triase', fn($row) => $row->kd_triase)
                ->addColumn('bed', fn($row) => '')
                ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: 'null')
                ->addColumn('alamat', fn($row) =>  $row->pasien->alamat)
                ->addColumn('jaminan', fn($row) =>  '')
                ->addColumn('instruksi', fn($row) =>  '')
                ->addColumn('kd_dokter', fn($row) => $row->dokter->nama ?: 'null')
                ->addColumn('tgl_masuk', function($row) {

                    $tglMasuk = Carbon::parse($row->tgl_masuk)->format('d M Y');
                    $jamMasuk = date('H:i', strtotime($row->jam_masuk));
                    
                    // return $row->tgl_masuk
                    //     ? Carbon::parse($row->tgl_masuk)->format('d M Y')
                    //     : 'null';
                    return "$tglMasuk $jamMasuk";
                })
                // Hitung umur dari tabel pasien
                ->addColumn('umur', function ($row) {
                    return $row->pasien && $row->pasien->tgl_lahir
                        ? Carbon::parse($row->pasien->tgl_lahir)->age . ''
                        : 'Tidak diketahui';
                })
                ->addColumn('action', fn($row) => $row->kd_pasien)  // Return raw data, no HTML
                ->addColumn('del', fn($row) => $row->kd_pasien)     // Return raw data
                ->addColumn('profile', fn($row) => $row)
                ->rawColumns(['action', 'del', 'profile'])
                ->make(true);
        }

        return view('unit-pelayanan.gawat-darurat.index');
    }

}

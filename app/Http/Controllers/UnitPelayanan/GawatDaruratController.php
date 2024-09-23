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
                ->addColumn('Alamat', fn($row) =>  '')
                ->addColumn('Jaminan', fn($row) =>  '')
                ->addColumn('tgl_masuk', function($row) {
                    return $row->tgl_masuk
                        ? Carbon::parse($row->tgl_masuk)->format('d M Y h:i A')
                        : 'null';
                })
                ->addColumn('kd_dokter', fn($row) => $row->kd_dokter ?: 'null')
                ->addColumn('Instruksi', fn($row) =>  '')
                ->addColumn('action', fn($row) => '<a href="'.route('medis-gawat-darurat.index').'" class="edit btn btn-secondary btn-sm m-2"><i class="ti-pencil-alt"></i></a><a href="#" class="btn btn-secondary btn-sm">...</a>')
                ->addColumn('del', fn($row) => '<a href="#" class="edit btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>')
                ->addColumn('profile', function ($row) {
                    $imageUrl = $row->foto_pasien ? asset('storage/' . $row->foto_pasien) : asset('assets/images/avatar1.png');
                    $gender = $row->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan';
                    return '<div class="profile">
                                <img src="' . $imageUrl . '" alt="Profile" width="50" height="50" class="rounded-circle"/>
                                <div class="info">
                                    <strong>' . $row->jenis_kelamin . '</strong>
                                    <span>' . $gender . ' / ' . $row->umur . ' Tahun</span>
                                </div>
                            </div>';
                })
                ->rawColumns(['action', 'del', 'profile'])
                ->make(true);
        }

        return view('unit-pelayanan.gawat-darurat.index');
    }
}

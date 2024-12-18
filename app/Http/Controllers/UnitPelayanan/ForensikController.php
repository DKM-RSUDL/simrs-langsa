<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ForensikController extends Controller
{
    public function index()
    {
        $unit = Unit::with(['bagian'])
            ->whereIn('kd_unit', ['228', '76'])
            ->get();

        return view('unit-pelayanan.forensik.index', compact('unit'));
    }

    public function unitPelayanan($kd_unit, Request $request)
    {
        $unit = Unit::with(['bagian'])
            ->where('kd_unit', $kd_unit)
            ->first();

        $nama_unit = '';
        if ($unit->kd_unit == 228) $nama_unit = 'Klinik';
        if ($unit->kd_unit == 76) $nama_unit = 'Patologi';


        if ($request->ajax()) {
            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->where('kd_unit', $kd_unit);

            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($searchValue = $request->get('search')['value']) {
                        $query->where(function ($q) use ($searchValue) {
                            if (is_numeric($searchValue) && strlen($searchValue) == 4) {
                                $q->whereRaw("YEAR(kunjungan.tgl_masuk) = ?", [$searchValue]);
                            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $searchValue)) {
                                $q->whereRaw("CONVERT(varchar, kunjungan.tgl_masuk, 23) like ?", ["%{$searchValue}%"]);
                            } elseif (preg_match('/^\d{2}:\d{2}$/', $searchValue)) {
                                $q->whereRaw("FORMAT(kunjungan.jam_masuk, 'HH:mm') like ?", ["%{$searchValue}%"]);
                            } else {
                                $q->where('kunjungan.kd_pasien', 'like', "%{$searchValue}%")
                                    ->orWhereHas('pasien', function ($q) use ($searchValue) {
                                        $q->where('nama', 'like', "%{$searchValue}%")
                                            ->orWhere('alamat', 'like', "%{$searchValue}%");
                                    })
                                    ->orWhereHas('customer', function ($q) use ($searchValue) {
                                        $q->where('customer', 'like', "%{$searchValue}%");
                                    });
                            }
                        });
                    }
                })

                ->order(function ($query) {
                    $query->orderBy('tgl_masuk', 'desc')
                        ->orderBy('jam_masuk', 'desc');
                })
                ->editColumn('tgl_masuk', fn($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
                ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
                ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
                ->addColumn('jaminan', fn($row) =>  $row->customer->customer ?: '-')
                ->addColumn('status_pelayanan', fn($row) => '' ?: '-')
                ->addColumn('keterangan', fn($row) => '' ?: '-')
                ->addColumn('tindak_lanjut', fn($row) => '' ?: '-')
                ->addColumn('no_antrian', fn($row) => '' ?: '-')
                // Hitung umur dari tabel pasien
                ->addColumn('umur', function ($row) {
                    return $row->pasien && $row->pasien->tgl_lahir
                        ? Carbon::parse($row->pasien->tgl_lahir)->age . ''
                        : 'Tidak diketahui';
                })
                ->addColumn('profile', fn($row) => $row)
                ->addColumn('action', fn($row) => $row->kd_pasien)
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }

        return view('unit-pelayanan.forensik.unit-pelayanan', compact('unit', 'nama_unit'));
    }

    public function pelayanan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
        ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($kd_unit == '228') {
            return view('unit-pelayanan.forensik.pelayanan.index-klinik', compact(
                'dataMedis',
                'kd_unit',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk'
            ));
        } else if ($kd_unit == '76') {
            return view('unit-pelayanan.forensik.pelayanan.index-patologi', compact(
                'dataMedis',
                'kd_unit',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk'
            ));
        }
    }
}

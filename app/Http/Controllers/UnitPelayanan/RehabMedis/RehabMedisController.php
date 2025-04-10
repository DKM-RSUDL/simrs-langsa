<?php

namespace App\Http\Controllers\UnitPelayanan\RehabMedis;

use App\Http\Controllers\Controller;
use App\Models\DokterKlinik;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RehabMedisController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->kdUnitDef_ = 74;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $dokterFilter = $request->get('dokter');

            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('t.kd_unit', $this->kdUnitDef_)
                ->whereNull('kunjungan.tgl_keluar')
                ->whereNull('kunjungan.jam_keluar');

            // Filte dokter
            if (!empty($dokterFilter)) $data->where('kd_dokter', $dokterFilter);

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
                                    ->orWhereHas('dokter', function ($q) use ($searchValue) {
                                        $q->where('nama_lengkap', 'like', "%{$searchValue}%");
                                    })
                                    ->orWhereHas('customer', function ($q) use ($searchValue) {
                                        $q->where('customer', 'like', "%{$searchValue}%");
                                    });
                            }
                        });
                    }
                })

                ->order(function ($query) {
                    $query->orderBy('kunjungan.tgl_masuk', 'desc')
                        ->orderBy('kunjungan.antrian', 'desc')
                        ->orderBy('t.urut_masuk', 'desc');
                })
                ->editColumn('tgl_masuk', fn($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
                ->addColumn('triase', fn($row) => $row->kd_triase ?: '-')
                ->addColumn('bed', fn($row) => '' ?: '-')
                ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
                ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
                ->addColumn('jaminan', fn($row) =>  $row->customer->customer ?: '-')
                ->addColumn('instruksi', fn($row) => '' ?: '-')
                ->addColumn('kd_dokter', fn($row) => $row->dokter->nama ?: '-')
                ->addColumn('waktu_masuk', function ($row) {

                    $tglMasuk = Carbon::parse($row->tgl_masuk)->format('d M Y');
                    $jamMasuk = date('H:i', strtotime($row->jam_masuk));
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

        $dokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 214)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.rehab-medis.index', compact('dokter'));
    }

    public function pelayanan($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->where('kd_unit', $this->kdUnitDef_)
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
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

        return view('unit-pelayanan.rehab-medis.pelayanan.index', compact('dataMedis'));
    }
}
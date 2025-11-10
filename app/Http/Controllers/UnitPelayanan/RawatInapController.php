<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\PasienInap;
use App\Models\RmeSerahTerima;
use App\Models\Unit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\BaseService;
use Illuminate\Support\Facades\Cache;

class RawatInapController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
    }

    public function index()
    {
        $unit = Unit::with(['bagian'])
            ->where('kd_bagian', 1)
            ->where('aktif', 1)
            ->get();


        // Ambil semua kd_unit yang akan ditampilkan
        $unitIds = $unit->pluck('kd_unit')->toArray();

        // Hitung semua pasien aktif untuk semua unit sekaligus
        $patientCounts = $this->getActivePatientCounts($unitIds);

        return view('unit-pelayanan.rawat-inap.index', compact('unit', 'patientCounts'));
    }

    private function getActivePatientCounts(array $unitIds)
    {
        $cacheKey = "count_active_ranap_multiple_" . md5(implode(',', $unitIds));

        return Cache::remember($cacheKey, 300, function () use ($unitIds) {
            $counts = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->join('nginap', function ($q) {
                    $q->on('kunjungan.kd_pasien', '=', 'nginap.kd_pasien');
                    $q->on('kunjungan.kd_unit', '=', 'nginap.kd_unit');
                    $q->on('kunjungan.tgl_masuk', '=', 'nginap.tgl_masuk');
                    $q->on('kunjungan.urut_masuk', '=', 'nginap.urut_masuk');
                })
                ->join('pasien_inap as pi', function ($q) {
                    $q->on('t.kd_kasir', '=', 'pi.kd_kasir');
                    $q->on('t.no_transaksi', '=', 'pi.no_transaksi');
                })
                ->whereIn('nginap.kd_unit_kamar', $unitIds)
                ->where('nginap.akhir', 1)
                ->where(function ($q) {
                    $q->whereNull('kunjungan.status_inap');
                    $q->orWhere('kunjungan.status_inap', 1);
                })
                ->whereNull('kunjungan.tgl_pulang')
                ->whereNull('kunjungan.jam_pulang')
                ->whereYear('kunjungan.tgl_masuk', '>=', 2025)
                ->select('nginap.kd_unit_kamar', DB::raw('COUNT(*) as total'))
                ->groupBy('nginap.kd_unit_kamar')
                ->pluck('total', 'kd_unit_kamar');

            // Pastikan semua unit punya value, defaultkan 0 jika tidak ada data
            return collect($unitIds)->mapWithKeys(function ($unitId) use ($counts) {
                return [$unitId => $counts->get($unitId, 0)];
            });
        });
    }

    public function unitPelayanan($kd_unit, Request $request)
    {
        $unit = Unit::with(['bagian'])
            ->where('kd_unit', $kd_unit)
            ->first();

        if ($request->ajax()) {
            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->join('nginap', function ($q) {
                    $q->on('kunjungan.kd_pasien', 'nginap.kd_pasien');
                    $q->on('kunjungan.kd_unit', 'nginap.kd_unit');
                    $q->on('kunjungan.tgl_masuk', 'nginap.tgl_masuk');
                    $q->on('kunjungan.urut_masuk', 'nginap.urut_masuk');
                })
                ->join('transaksi as t', function ($q) {
                    $q->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $q->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $q->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $q->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('rme_ket_status_kunjungan as sk', function ($q) {
                    $q->on('t.kd_kasir', '=', 'sk.kd_kasir');
                    $q->on('t.no_transaksi', '=', 'sk.no_transaksi');
                })
                ->where('nginap.kd_unit_kamar', $kd_unit)
                ->where('nginap.akhir', 1)
                ->where(function ($q) {
                    $q->whereNull('kunjungan.status_inap');
                    $q->orWhere('kunjungan.status_inap', 1);
                })
                ->whereNull('kunjungan.tgl_pulang')
                ->whereNull('kunjungan.jam_pulang')
                ->whereYear('kunjungan.tgl_masuk', '>=', 2025);

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
                    $query->orderBy('kunjungan.tgl_masuk', 'desc')
                        ->orderBy('kunjungan.jam_masuk', 'desc');
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

        return view('unit-pelayanan.rawat-inap.unit-pelayanan', compact('unit'));
    }

    public function selesai($kd_unit, Request $request)
    {
        $unit = Unit::with(['bagian'])
            ->where('kd_unit', $kd_unit)
            ->first();

        if ($request->ajax()) {
            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->join('nginap', function ($q) {
                    $q->on('kunjungan.kd_pasien', 'nginap.kd_pasien');
                    $q->on('kunjungan.kd_unit', 'nginap.kd_unit');
                    $q->on('kunjungan.tgl_masuk', 'nginap.tgl_masuk');
                    $q->on('kunjungan.urut_masuk', 'nginap.urut_masuk');
                })
                ->join('transaksi as t', function ($q) {
                    $q->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $q->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $q->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $q->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('rme_ket_status_kunjungan as sk', function ($q) {
                    $q->on('t.kd_kasir', '=', 'sk.kd_kasir');
                    $q->on('t.no_transaksi', '=', 'sk.no_transaksi');
                })
                ->where('nginap.kd_unit_kamar', $kd_unit)
                ->where('nginap.akhir', 1)
                ->where(function ($q) {
                    $q->whereNull('kunjungan.status_inap');
                    $q->orWhere('kunjungan.status_inap', 1);
                })
                ->whereNotNull('kunjungan.tgl_pulang')
                ->whereNotNull('kunjungan.jam_pulang')
                ->whereYear('kunjungan.tgl_masuk', '>=', 2025);

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
                    $query->orderBy('kunjungan.tgl_masuk', 'desc')
                        ->orderBy('kunjungan.jam_masuk', 'desc');
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

        return view('unit-pelayanan.rawat-inap.unit-pelayanan-selesai', compact('unit'));
    }

    public function pelayanan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Use BaseService to include transaksi join so kd_kasir and no_transaksi are available
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.index', compact('dataMedis'));
    }

    public function pending($kd_unit, Request $request)
    {
        $unit = Unit::with(['bagian'])
            ->where('kd_unit', $kd_unit)
            ->first();

        if ($request->ajax()) {
            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->join('nginap', function ($q) {
                    $q->on('kunjungan.kd_pasien', 'nginap.kd_pasien');
                    $q->on('kunjungan.kd_unit', 'nginap.kd_unit');
                    $q->on('kunjungan.tgl_masuk', 'nginap.tgl_masuk');
                    $q->on('kunjungan.urut_masuk', 'nginap.urut_masuk');
                })
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->join('rme_serah_terima as st', function ($q) {
                    $q->on('kunjungan.kd_pasien', '=', 'st.kd_pasien');
                    $q->on('kunjungan.tgl_masuk', '=', 'st.tgl_masuk');
                    $q->on('kunjungan.urut_masuk', '=', 'st.urut_masuk_tujuan');
                    $q->on('nginap.kd_unit_kamar', '=', 'st.kd_unit_tujuan');
                })
                ->whereRaw('nginap.kd_unit = t.kd_unit')
                ->where('nginap.kd_unit_kamar', $kd_unit)
                ->where('nginap.akhir', 1)
                ->where('st.status', 1)
                ->select(['kunjungan.*', 't.*']);
            // ->where('kunjungan.status_inap', 0);

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
                    $query->orderBy('kunjungan.tgl_masuk', 'desc')
                        ->orderBy('kunjungan.jam_masuk', 'desc');
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

        return view('unit-pelayanan.rawat-inap.unit-pelayanan-pending', compact('unit'));
    }

    public function serahTerimaPasien($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Get Pasien Inap Data
        $pasienInap = PasienInap::where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->first();

        $serahTerimaData = RmeSerahTerima::with(['unitAsal', 'unitTujuan', 'petugasAsal', 'petugasTerima'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit_tujuan', $pasienInap->kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk_tujuan', $urut_masuk)
            ->first();

        if (empty($serahTerimaData)) abort(404, 'Data serah terima tidak ditemukan !');

        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_bagian', 1)->where('aktif', 1)->get();

        $petugas = HrdKaryawan::with(['ruangan'])
            ->where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->whereRelation('ruangan', 'kd_unit', $kd_unit)
            ->where('status_peg',  1)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.serah-terima.index', compact('dataMedis', 'serahTerimaData', 'unit', 'unitTujuan', 'petugas'));
    }

    public function serahTerimaPasienCreate($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (empty($dataMedis)) return back()->with('error', 'Data kunjungan pasien tidak ditemukan !');

            // validasi
            $request->validate([
                'petugas_terima'   => 'required',
                'tanggal_terima'   => 'required|date_format:Y-m-d',
                'jam_terima'       => 'required|date_format:H:i',
            ]);


            // update serah terima data
            $data = [
                'petugas_terima'   => $request->petugas_terima,
                'tanggal_terima'   => $request->tanggal_terima,
                'jam_terima'       => $request->jam_terima,
                'status'            => 2
            ];

            $id = decrypt($idEncrypt);
            $serahTerima = RmeSerahTerima::find($id);
            RmeSerahTerima::where('id', $id)->update($data);

            // update status inap kunjungan jadi aktif
            Kunjungan::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->update(['status_inap' => 1]);


            // update keterangan status kunjungan ranap
            $this->baseService->updateKetKunjungan($dataMedis->kd_kasir, $dataMedis->no_transaksi, 'Aktif', 1);

            // update keterangan status kunjungan IGD
            $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)
                ->where('no_transaksi', $dataMedis->no_transaksi)
                ->first();

            if (empty($asalIGD)) throw new Exception('Data Asal IGD tidak ditemukan !');
            $this->baseService->updateKetKunjungan($asalIGD->kd_kasir_asal, $asalIGD->no_transaksi_asal, 'Ranap', 0);

            DB::commit();
            return to_route('rawat-inap.unit.pending', [$serahTerima->kd_unit_tujuan])->with('success', 'Pasien berhasil di terima !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}

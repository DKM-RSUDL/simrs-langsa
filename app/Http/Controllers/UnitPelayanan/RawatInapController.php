<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\KamarInduk;
use App\Models\Kunjungan;
use App\Models\Nginap;
use App\Models\PasienInap;
use App\Models\RmeSerahTerima;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\Unit;
use App\Models\UnitAsal;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
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
                                $normalized = str_replace('-', '', $searchValue);
                                $q->whereRaw("REPLACE(kunjungan.kd_pasien, '-', '') like ?", ["%{$normalized}%"])
                                    ->orWhereHas('pasien', function ($q) use ($searchValue, $normalized) {
                                        $q->whereRaw("REPLACE(kd_pasien, '-', '') like ?", ["%{$normalized}%"])
                                            ->orWhere('nama', 'like', "%{$searchValue}%")
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
                                $normalized = str_replace('-', '', $searchValue);
                                $q->whereRaw("REPLACE(kunjungan.kd_pasien, '-', '') like ?", ["%{$normalized}%"])
                                    ->orWhereHas('pasien', function ($q) use ($searchValue, $normalized) {
                                        $q->whereRaw("REPLACE(kd_pasien, '-', '') like ?", ["%{$normalized}%"])
                                            ->orWhere('nama', 'like', "%{$searchValue}%")
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

    // public function pending($kd_unit, Request $request)
    // {
    //     $unit = Unit::with(['bagian'])
    //         ->where('kd_unit', $kd_unit)
    //         ->first();

    //     if ($request->ajax()) {
    //         $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
    //             ->join('nginap', function ($q) {
    //                 $q->on('kunjungan.kd_pasien', 'nginap.kd_pasien');
    //                 $q->on('kunjungan.kd_unit', 'nginap.kd_unit');
    //                 $q->on('kunjungan.tgl_masuk', 'nginap.tgl_masuk');
    //                 $q->on('kunjungan.urut_masuk', 'nginap.urut_masuk');
    //             })
    //             ->join('transaksi as t', function ($join) {
    //                 $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
    //                 $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
    //                 $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
    //                 $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
    //             })
    //             ->join('rme_serah_terima as st', function ($q) {
    //                 $q->on('kunjungan.kd_pasien', '=', 'st.kd_pasien');
    //                 $q->on('kunjungan.tgl_masuk', '=', 'st.tgl_masuk');
    //                 $q->on('kunjungan.urut_masuk', '=', 'st.urut_masuk_tujuan');
    //                 $q->on('nginap.kd_unit_kamar', '=', 'st.kd_unit_tujuan');
    //             })
    //             ->whereRaw('nginap.kd_unit = t.kd_unit')
    //             ->where('nginap.kd_unit_kamar', $kd_unit)
    //             ->where('nginap.akhir', 1)
    //             ->where('st.status', 1)
    //             ->select(['kunjungan.*', 't.*']);
    //         // ->where('kunjungan.status_inap', 0);

    //         return DataTables::of($data)
    //             ->filter(function ($query) use ($request) {
    //                 if ($searchValue = $request->get('search')['value']) {
    //                     $query->where(function ($q) use ($searchValue) {
    //                         if (is_numeric($searchValue) && strlen($searchValue) == 4) {
    //                             $q->whereRaw("YEAR(kunjungan.tgl_masuk) = ?", [$searchValue]);
    //                         } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $searchValue)) {
    //                             $q->whereRaw("CONVERT(varchar, kunjungan.tgl_masuk, 23) like ?", ["%{$searchValue}%"]);
    //                         } elseif (preg_match('/^\d{2}:\d{2}$/', $searchValue)) {
    //                             $q->whereRaw("FORMAT(kunjungan.jam_masuk, 'HH:mm') like ?", ["%{$searchValue}%"]);
    //                         } else {
    //                             $q->where('kunjungan.kd_pasien', 'like', "%{$searchValue}%")
    //                                 ->orWhereHas('pasien', function ($q) use ($searchValue) {
    //                                     $q->where('nama', 'like', "%{$searchValue}%")
    //                                         ->orWhere('alamat', 'like', "%{$searchValue}%");
    //                                 })
    //                                 ->orWhereHas('customer', function ($q) use ($searchValue) {
    //                                     $q->where('customer', 'like', "%{$searchValue}%");
    //                                 });
    //                         }
    //                     });
    //                 }
    //             })
    //             ->order(function ($query) {
    //                 $query->orderBy('kunjungan.tgl_masuk', 'desc')
    //                     ->orderBy('kunjungan.jam_masuk', 'desc');
    //             })
    //             ->editColumn('tgl_masuk', fn($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
    //             ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
    //             ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
    //             ->addColumn('jaminan', fn($row) =>  $row->customer->customer ?: '-')
    //             ->addColumn('status_pelayanan', fn($row) => '' ?: '-')
    //             ->addColumn('keterangan', fn($row) => '' ?: '-')
    //             ->addColumn('tindak_lanjut', fn($row) => '' ?: '-')
    //             ->addColumn('no_antrian', fn($row) => '' ?: '-')
    //             // Hitung umur dari tabel pasien
    //             ->addColumn('umur', function ($row) {
    //                 return $row->pasien && $row->pasien->tgl_lahir
    //                     ? Carbon::parse($row->pasien->tgl_lahir)->age . ''
    //                     : 'Tidak diketahui';
    //             })
    //             ->addColumn('profile', fn($row) => $row)
    //             ->addColumn('action', fn($row) => $row->kd_pasien)
    //             ->rawColumns(['action', 'profile'])
    //             ->make(true);
    //     }

    //     return view('unit-pelayanan.rawat-inap.unit-pelayanan-pending', compact('unit'));
    // }


    public function pending($kd_unit, Request $request)
    {
        $unit = Unit::with(['bagian'])
            ->where('kd_unit', $kd_unit)
            ->first();

        if ($request->ajax()) {
            $data = RmeSerahTerima::with(['unitAsal', 'pasien', 'petugasAsal', 'transfer', 'kamar', 'dokter'])
                ->where('kd_unit_tujuan', $kd_unit)
                ->where('status', 1);

            return DataTables::of($data)
                ->filter(function ($query) use ($request, $kd_unit) {
                    $query->whereNot('kd_unit_asal', $kd_unit);

                    if ($searchValue = $request->get('search')['value']) {
                        $normalized = str_replace('-', '', $searchValue);

                        // Bungkus semua kondisi pencarian agar tetap memenuhi kondisi whereNot di atas
                        $query->where(function ($q) use ($searchValue, $normalized) {
                            $q->where(function ($qq) use ($searchValue) {
                                $qq->where('tgl_masuk', 'like', "%{$searchValue}%")
                                    ->orWhere('tanggal_menyerahkan', 'like', "%{$searchValue}%")
                                    ->orWhere('jam_menyerahkan', 'like', "%{$searchValue}%");
                            })
                                ->orWhereHas('pasien', function ($qq) use ($searchValue, $normalized) {
                                    $qq->whereRaw("REPLACE(kd_pasien, '-', '') like ?", ["%{$normalized}%"])
                                        ->orWhere('nama', 'like', "%{$searchValue}%")
                                        ->orWhere('alamat', 'like', "%{$searchValue}%");
                                });
                        });
                    }
                })
                // ->order(function ($query) {
                //     $query->orderBy('kunjungan.tgl_masuk', 'desc')
                //         ->orderBy('kunjungan.jam_masuk', 'desc');
                // })
                ->editColumn('waktu_menyerahkan', function ($row) {
                    $waktu = '';
                    if ($row->tanggal_menyerahkan) $waktu .= date('Y-m-d', strtotime($row->tanggal_menyerahkan));
                    if ($row->jam_menyerahkan) $waktu .= ' ' . date('H:i', strtotime($row->jam_menyerahkan));

                    return $waktu ?: '-';
                })
                ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
                ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
                ->addColumn('status_pelayanan', fn($row) => '' ?: '-')
                ->addColumn('keterangan', fn($row) => '' ?: '-')
                ->addColumn('tindak_lanjut', fn($row) => '' ?: '-')
                ->addColumn('no_antrian', fn($row) => '' ?: '-')
                // Hitung umur dari tabel pasien
                ->addColumn('umur', function ($row) {
                    return hitungUmur($row->pasien->tgl_lahir);
                })
                ->addColumn('profile', fn($row) => $row)
                ->addColumn('action', fn($row) => $row->kd_pasien)
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }

        return view('unit-pelayanan.rawat-inap.unit-pelayanan-pending', compact('unit'));
    }

    private function decodeJsonFields($transfer)
    {
        $jsonFields = ['alasan', 'metode', 'info_medis', 'peralatan', 'gangguan', 'inkontinensia', 'terapi_data', 'alergis'];

        foreach ($jsonFields as $field) {
            if (isset($transfer->$field)) {
                $decoded = json_decode($transfer->$field, true);
                $transfer->$field = $decoded ?? [];
            }
        }

        return $transfer;
    }

    public function serahTerimaPasien($kd_unit, $idSerahTerima)
    {
        $serahTerima = RmeSerahTerima::with(['unitAsal', 'unitTujuan', 'petugasAsal', 'petugasTerima', 'transfer'])
            ->where('id', $idSerahTerima)
            ->first();

        if (empty($serahTerima)) abort(404, 'Data serah terima tidak ditemukan !');

        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_bagian', 1)->where('aktif', 1)->get();

        $petugas = HrdKaryawan::with(['ruangan'])
            ->where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->whereRelation('ruangan', 'kd_unit', $kd_unit)
            ->where('status_peg',  1)
            ->get();

        $dokter = Dokter::where('status', 1)->orderBy('nama', 'asc')->get();
        $transfer = $serahTerima->transfer;
        $transfer = $this->decodeJsonFields($transfer);


        return view('unit-pelayanan.rawat-inap.pelayanan.serah-terima.index', compact('serahTerima', 'unit', 'unitTujuan', 'petugas', 'transfer', 'dokter'));
    }

    // add kunjungan baru ranap
    private function storeKunjunganBaru($serahTerima)
    {
        $dataMedisAsal = $this->baseService->getDataMedisbyTransaksi($serahTerima->kd_kasir_asal, $serahTerima->no_transaksi_asal);
        if (empty($dataMedisAsal)) throw new Exception('Data Medis Asal tidak ditemukan !');

        $kdSpesial = $serahTerima->kd_spesial ?? null;
        $kdDokter = $serahTerima->kd_dokter ?? null;
        $kdKelas = $serahTerima->kd_kelas ?? null;
        $kdUnit = $serahTerima->kd_unit_tujuan ?? null;
        $noKamar = $serahTerima->no_kamar ?? null;

        $sisaBed = KamarInduk::select(DB::raw('(jumlah_bed - digunakan - booking) as sisa'))
            ->where('no_kamar', $noKamar)
            ->first()
            ->sisa ?? 0;

        if ($sisaBed < 1) throw new Exception('Kamar penuh, tidak dapat melakukan serah terima pasien !');


        // get antrian terakhir
        $getLastAntrianToday = Kunjungan::select('antrian')
            ->whereDate('tgl_masuk', $dataMedisAsal->tgl_masuk)
            ->where('kd_unit', $kdUnit)
            ->orderBy('antrian', 'desc')
            ->first();

        $no_antrian = !empty($getLastAntrianToday) ? $getLastAntrianToday->antrian + 1 : 1;

        // pasien not null get last urut masuk
        $getLastUrutMasukPatientToday = Kunjungan::select('urut_masuk')
            ->where('kd_pasien', $dataMedisAsal->kd_pasien)
            ->whereDate('tgl_masuk', $dataMedisAsal->tgl_masuk)
            ->orderBy('urut_masuk', 'desc')
            ->first();

        $newUrutMasuk = !empty($getLastUrutMasukPatientToday) ? $getLastUrutMasukPatientToday->urut_masuk + 1 : 1;

        // get tarif rawatan per unit
        $tarifRawatan = Tarif::where('kd_tarif', 'TU')
            ->where('kd_produk', 17)
            ->where('kd_unit', $kdUnit)
            ->whereNull('tgl_berakhir')
            ->orderBy('tgl_berlaku', 'DESC')
            ->first();

        if (empty($tarifRawatan)) return back()->with('error', 'Tarif rawatan tidak ditemukan !');


        // insert ke tabel kunjungan
        $dataKunjungan = [
            'kd_pasien'         => $dataMedisAsal->kd_pasien,
            'kd_unit'           => $kdUnit,
            'tgl_masuk'         => $dataMedisAsal->tgl_masuk,
            'urut_masuk'        => $newUrutMasuk,
            'jam_masuk'         => date('H:i:s'),
            'asal_pasien'       => 0,
            'cara_penerimaan'   => 99,
            'kd_rujukan'        => $dataMedisAsal->kd_rujukan,
            'no_surat'          => '',
            'kd_dokter'         => $kdDokter,
            'baru'              => 1,
            'kd_customer'       => $dataMedisAsal->kd_customer,
            'shift'             => 0,
            'kontrol'           => 0,
            'antrian'           => $no_antrian,
            'tgl_surat'         => $dataMedisAsal->tgl_masuk,
            'jasa_raharja'      => 0,
            'catatan'           => '',
            'kd_triase'         => $dataMedisAsal->kd_triase,
            'status_inap'       => 1,
            'user_create'       => Auth::id()
        ];

        Kunjungan::create($dataKunjungan);

        // delete rujukan_kunjungan
        RujukanKunjungan::where('kd_pasien', $dataMedisAsal->kd_pasien)
            ->where('kd_unit', $kdUnit)
            ->whereDate('tgl_masuk', $dataMedisAsal->tgl_masuk)
            ->where('urut_masuk', $newUrutMasuk)
            ->delete();


        // insert transaksi
        $lastTransaction = Transaksi::select('no_transaksi')
            ->where('kd_kasir', '02')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastTransactionNumber = (int) $lastTransaction->no_transaksi;
            $newTransactionNumber = $lastTransactionNumber + 1;
        } else {
            $newTransactionNumber = 1;
        }

        // formatted new transaction number with 7 digits length
        $formattedTransactionNumber = str_pad($newTransactionNumber, 7, '0', STR_PAD_LEFT);

        $dataTransaksi = [
            'kd_kasir'      => '02',
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_pasien'     => $dataMedisAsal->kd_pasien,
            'kd_unit'       => $kdUnit,
            'tgl_transaksi' => $dataMedisAsal->tgl_masuk,
            'app'           => 0,
            'ispay'         => 0,
            'co_status'     => 0,
            'urut_masuk'    => $newUrutMasuk,
            'kd_user'       => Auth::id(),
            'lunas'         => 0,
        ];

        Transaksi::create($dataTransaksi);


        // insert detail_transaksi
        $dataDetailTransaksi = [
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_kasir'      => '02',
            'tgl_transaksi' => $dataMedisAsal->tgl_masuk,
            'urut'          => 1,
            'kd_tarif'      => 'TU',
            'kd_produk'     => 17,
            'kd_unit'       => $kdUnit,
            'kd_unit_tr'    => $kdUnit,
            'tgl_berlaku'   => $tarifRawatan->tgl_berlaku,
            'kd_user'       => Auth::id(),
            'shift'         => 0,
            'harga'         => $tarifRawatan->tarif,
            'qty'           => 1,
            'flag'          => 0,
            'jns_trans'     => 0,
        ];

        DetailTransaksi::create($dataDetailTransaksi);


        // insert detail_prsh
        $dataDetailPrsh = [
            'kd_kasir'      => '02',
            'no_transaksi'  => $formattedTransactionNumber,
            'urut'          => 1,
            'tgl_transaksi' => $dataMedisAsal->tgl_masuk,
            'hak'           => $tarifRawatan->tarif,
            'selisih'       => 0,
            'disc'          => 0
        ];

        DetailPrsh::create($dataDetailPrsh);


        // delete detail_component
        DetailComponent::where('kd_kasir', '02')
            ->where('no_transaksi', $formattedTransactionNumber)
            ->where('urut', 1)
            ->delete();


        // insert detail_component
        $dataDetailComponent = [
            'kd_kasir'      => '02',
            'no_transaksi'  => $formattedTransactionNumber,
            'tgl_transaksi' => $dataMedisAsal->tgl_masuk,
            'urut'          => 1,
            'kd_component'  => '30',
            'tarif'         => $tarifRawatan->tarif,
            'disc'          => 0
        ];

        DetailComponent::create($dataDetailComponent);

        // insert sjp_kunjungan
        $sjpKunjunganData = [
            'kd_pasien'     => $dataMedisAsal->kd_pasien,
            'kd_unit'       => $kdUnit,
            'tgl_masuk'     => $dataMedisAsal->tgl_masuk,
            'urut_masuk'    => $newUrutMasuk,
            'no_sjp'        => '',
            'penjamin_laka' => 0,
            'katarak'       => 0,
            'dpjp'          => $kdDokter,
            'cob'           => 0
        ];

        SjpKunjungan::create($sjpKunjunganData);

        // insert tabel pasien inap
        $pasienInapData = [
            'kd_kasir'      => '02',
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_unit'       => $kdUnit,
            'no_kamar'      => $noKamar,
            'kd_spesial'    => $kdSpesial,
            'co_status'     => 1
        ];

        PasienInap::create($pasienInapData);

        // insert tabel nginap
        $getLastUrutNginap = Nginap::select('urut_nginap')
            ->where('kd_pasien', $dataMedisAsal->kd_pasien)
            ->where('kd_unit', $kdUnit)
            ->whereDate('tgl_masuk', $dataMedisAsal->tgl_masuk)
            ->where('urut_masuk', $newUrutMasuk)
            ->orderBy('urut_nginap', 'desc')
            ->first();

        $urutNginap = !empty($getLastUrutNginap) ? $getLastUrutNginap->urut_nginap + 1 : 1;


        $nginapData = [
            'kd_unit_kamar'     => $kdUnit,
            'no_kamar'          => $noKamar,
            'kd_pasien'         => $dataMedisAsal->kd_pasien,
            'kd_unit'           => $kdUnit,
            'tgl_masuk'         => $dataMedisAsal->tgl_masuk,
            'urut_masuk'        => $newUrutMasuk,
            'tgl_inap'          => $dataMedisAsal->tgl_masuk,
            'jam_inap'          => date('H:i:s'),
            'kd_spesial'        => $kdSpesial,
            'akhir'             => 1,
            'urut_nginap'       => $urutNginap
        ];

        Nginap::create($nginapData);


        // update kamar induk
        $subquery = KamarInduk::query()
            ->join('pasien_inap as pi', 'kamar_induk.NO_KAMAR', '=', 'pi.NO_KAMAR')
            ->join('transaksi as t', function ($join) {
                $join->on('t.NO_TRANSAKSI', '=', 'pi.NO_TRANSAKSI')
                    ->on('t.KD_KASIR', '=', 'pi.KD_KASIR');
            })
            ->join('nginap as ng', function ($join) {
                $join->on('ng.KD_PASIEN', '=', 't.KD_PASIEN')
                    ->on('ng.TGL_MASUK', '=', 't.TGL_TRANSAKSI')
                    ->on('ng.URUT_MASUK', '=', 't.URUT_MASUK')
                    ->on('ng.KD_UNIT', '=', 't.KD_UNIT');
            })
            ->join('pasien as p', 'p.KD_PASIEN', '=', 't.KD_PASIEN')
            ->whereNull('ng.TGL_KELUAR')
            ->whereNull('t.tgl_dok')
            ->where('kamar_induk.aktif', 1)
            ->where('ng.akhir', 1)
            ->select('ng.NO_KAMAR')
            ->selectRaw('COUNT(*) as digunakan')
            ->groupBy('ng.NO_KAMAR');

        // Update
        KamarInduk::query()
            ->joinSub($subquery, 'x', function ($join) {
                $join->on('kamar_induk.NO_KAMAR', '=', 'x.NO_KAMAR');
            })
            ->update(['kamar_induk.digunakan' => DB::raw('x.digunakan')]);


        // update keterangan status kunjungan ranap
        $this->baseService->updateKetKunjungan('02', $formattedTransactionNumber, 'Aktif', 1);
        // update keterangan status kunjungan IGD
        $this->baseService->updateKetKunjungan($dataMedisAsal->kd_kasir, $dataMedisAsal->no_transaksi, 'Ranap', 0);
    }

    // proses antar ranap
    private function storeProsesAntarRanap($serahTerima)
    {
        $dataMedisAsal = $this->baseService->getDataMedisbyTransaksi($serahTerima->kd_kasir_asal, $serahTerima->no_transaksi_asal);
        if (empty($dataMedisAsal)) throw new Exception('Data Medis Asal tidak ditemukan !');

        // update status inap kunjungan jadi aktif
        Kunjungan::where('kd_pasien', $dataMedisAsal->kd_pasien)
            ->where('kd_unit', $dataMedisAsal->kd_unit)
            ->where('urut_masuk', $dataMedisAsal->urut_masuk)
            ->whereDate('tgl_masuk', $dataMedisAsal->tgl_masuk)
            ->update(['status_inap' => 1]);


        // update keterangan status kunjungan ranap
        $this->baseService->updateKetKunjungan($dataMedisAsal->kd_kasir, $dataMedisAsal->no_transaksi, 'Aktif', 1);
    }

    private function storeProsesFromPenunjang($serahTerima)
    {

        // get asal rawat inap
        $unitAsal = UnitAsal::where('kd_kasir', $serahTerima->kd_kasir_asal)
            ->where('no_transaksi', $serahTerima->no_transaksi_asal)
            ->first();

        if (empty($unitAsal)) throw new Exception('Data unit asal rawat inap tidak ditemukan !');

        // get kunjungan rawat inap
        $dataMedisAsal = $this->baseService->getDataMedisbyTransaksi($unitAsal->kd_kasir_asal, $unitAsal->no_transaksi_asal);
        if (empty($dataMedisAsal)) throw new Exception('Data kunjungan rawat inap tidak ditemukan !');

        // update keterangan status kunjungan ranap
        $this->baseService->updateKetKunjungan($dataMedisAsal->kd_kasir, $dataMedisAsal->no_transaksi, 'Aktif', 1);
    }

    public function serahTerimaPasienCreate($kd_unit, $idHash, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idHash);

            $serahTerima = RmeSerahTerima::with(['unitAsal', 'unitTujuan', 'petugasAsal', 'petugasTerima', 'transfer'])
                ->where('id', $id)
                ->first();

            if (empty($serahTerima)) throw new Exception('Data serah terima tidak ditemukan !');

            // validasi
            $request->validate([
                'petugas_terima'   => 'required',
                'tanggal_terima'   => 'required|date_format:Y-m-d',
                'jam_terima'       => 'required|date_format:H:i',
            ]);


            // arahkan ke function yg sesuai
            $transferFormReady =
                !empty($serahTerima->kd_spesial) &&
                !empty($serahTerima->kd_dokter) &&
                !empty($serahTerima->kd_kelas) &&
                !empty($serahTerima->no_kamar);

            if ($transferFormReady) {
                $this->storeKunjunganBaru($serahTerima);
            } else if (!$transferFormReady && !empty($serahTerima->transfer)) {

                if (!$serahTerima->transfer->to_penunjang) {
                    $this->storeProsesAntarRanap($serahTerima);
                } else {
                    $this->storeProsesFromPenunjang($serahTerima);
                }
            } else {
                throw new Exception('Maaf, transfer belum dapat diproses saat ini. Silakan hubungi bagian IT untuk penanganan lebih lanjut.');
            }

            // update serah terima data
            $data = [
                'petugas_terima'   => $request->petugas_terima,
                'tanggal_terima'   => $request->tanggal_terima,
                'jam_terima'       => $request->jam_terima,
                'status'            => 2
            ];

            RmeSerahTerima::where('id', $serahTerima->id)->update($data);

            DB::commit();
            return to_route('rawat-inap.unit.pending', [$serahTerima->kd_unit_tujuan])->with('success', 'Pasien berhasil di terima !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan;

use App\Http\Controllers\Controller;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\ListTindakanPasien;
use App\Models\Produk;
use App\Models\RmeRehabMedikProgram;
use App\Models\RmeRehabMedikProgramDetail;
use App\Models\RmeRehabMedikTindakan;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TindakanController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rehab-medis');
        $this->kdUnitDef_ = 74;
    }

    public function index(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $tindakan = RmeRehabMedikTindakan::with(['karyawan'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        return view('unit-pelayanan.rehab-medis.pelayanan.tindakan.index', compact(
            'dataMedis',
            'tindakan'
        ));
    }


    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $programs = RmeRehabMedikProgramDetail::with(['program', 'produk'])
            ->whereRelation('program', function ($q) use ($kd_pasien, $tgl_masuk, $urut_masuk) {
                $q->where('kd_pasien', $kd_pasien);
                $q->where('kd_unit', $this->kdUnitDef_);
                $q->whereDate('tgl_masuk', $tgl_masuk);
                $q->where('urut_masuk', $urut_masuk);
            })->get();


        $petugas = HrdKaryawan::whereIn('kd_ruangan', [1, 107])
            ->where('status_peg', 1)
            ->orderBy('kd_karyawan')
            ->get();

        return view('unit-pelayanan.rehab-medis.pelayanan.tindakan.create', compact('dataMedis', 'programs', 'petugas'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        // validate data
        $request->validate([
            'ppa'           => 'required',
            'tgl_tindakan'  => 'required|date_format:Y-m-d',
            'jam_tindakan'  => 'required|date_format:H:i',
            'hasil'         => 'required',
            'kesimpulan'    => 'required',
            'rekomendasi'   => 'required',
        ]);

        DB::beginTransaction();

        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_unit', $this->kdUnitDef_)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }


            // Menghitung umur berdasarkan tgl_lahir jika ada
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // store tindakan
            $tindakanData = [
                'kd_pasien'     => $kd_pasien,
                'kd_unit'       => $this->kdUnitDef_,
                'tgl_masuk'     => $tgl_masuk,
                'urut_masuk'    => $urut_masuk,
                'tgl_tindakan'  => $request->tgl_tindakan,
                'jam_tindakan'  => $request->jam_tindakan,
                'ppa'           => $request->ppa,
                'hasil'         => $request->hasil,
                'kesimpulan'    => $request->kesimpulan,
                'rekomendasi'   => $request->rekomendasi,
            ];

            RmeRehabMedikTindakan::create($tindakanData);


            // STORE DETAIL TRANSAKSI
            $programs = RmeRehabMedikProgramDetail::with(['program'])
                ->whereRelation('program', function ($q) use ($kd_pasien, $tgl_masuk, $urut_masuk) {
                    $q->where('kd_pasien', $kd_pasien);
                    $q->where('kd_unit', $this->kdUnitDef_);
                    $q->whereDate('tgl_masuk', $tgl_masuk);
                    $q->where('urut_masuk', $urut_masuk);
                })->get();

            $lastDetailTransaksiUrut = DetailTransaksi::select(['urut'])
                ->where('no_transaksi', $dataMedis->no_transaksi)
                ->orderBy('urut', 'desc')
                ->first();

            $urut = !empty($lastDetailTransaksiUrut) ? $lastDetailTransaksiUrut->urut + 1 : 1;

            foreach ($programs as $program) {
                $dataDetailTransaksi = [
                    'no_transaksi'  => $dataMedis->no_transaksi,
                    'kd_kasir'      => $dataMedis->kd_kasir,
                    'tgl_transaksi' => $tgl_masuk,
                    'urut'          => $urut,
                    'kd_tarif'      => 'TU',
                    'kd_produk'     => $program->kd_produk,
                    'kd_unit'       => 74,
                    'kd_unit_tr'    => $this->kdUnitDef_,
                    'tgl_berlaku'   => $program->tgl_berlaku,
                    'shift'         => 0,
                    'harga'         => $program->tarif,
                    'qty'           => 1,
                    'flag'          => 0,
                    'jns_trans'     => 0,
                ];

                DetailTransaksi::create($dataDetailTransaksi);

                $urut++;
            }

            DB::commit();
            return to_route('rehab-medis.pelayanan.tindakan.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Tindakan berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $programs = RmeRehabMedikProgramDetail::with(['program', 'produk'])
            ->whereRelation('program', function ($q) use ($kd_pasien, $tgl_masuk, $urut_masuk) {
                $q->where('kd_pasien', $kd_pasien);
                $q->where('kd_unit', $this->kdUnitDef_);
                $q->whereDate('tgl_masuk', $tgl_masuk);
                $q->where('urut_masuk', $urut_masuk);
            })->get();


        $petugas = HrdKaryawan::whereIn('kd_ruangan', [1, 107])
            ->where('status_peg', 1)
            ->orderBy('kd_karyawan')
            ->get();

        $tindakan = RmeRehabMedikTindakan::find($id);

        return view('unit-pelayanan.rehab-medis.pelayanan.tindakan.edit', compact('dataMedis', 'programs', 'petugas', 'tindakan'));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        // validate data
        $request->validate([
            'ppa'           => 'required',
            'tgl_tindakan'  => 'required|date_format:Y-m-d',
            'jam_tindakan'  => 'required|date_format:H:i',
            'hasil'         => 'required',
            'kesimpulan'    => 'required',
            'rekomendasi'   => 'required',
        ]);

        DB::beginTransaction();

        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_unit', $this->kdUnitDef_)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }


            // Menghitung umur berdasarkan tgl_lahir jika ada
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // update tindakan
            $tindakanData = [
                'tgl_tindakan'  => $request->tgl_tindakan,
                'jam_tindakan'  => $request->jam_tindakan,
                'ppa'           => $request->ppa,
                'hasil'         => $request->hasil,
                'kesimpulan'    => $request->kesimpulan,
                'rekomendasi'   => $request->rekomendasi,
            ];

            $id = decrypt($idEncrypt);
            RmeRehabMedikTindakan::where('id', $id)->update($tindakanData);

            DB::commit();
            return to_route('rehab-medis.pelayanan.tindakan.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Tindakan berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $programs = RmeRehabMedikProgramDetail::with(['program', 'produk'])
            ->whereRelation('program', function ($q) use ($kd_pasien, $tgl_masuk, $urut_masuk) {
                $q->where('kd_pasien', $kd_pasien);
                $q->where('kd_unit', $this->kdUnitDef_);
                $q->whereDate('tgl_masuk', $tgl_masuk);
                $q->where('urut_masuk', $urut_masuk);
            })->get();


        $petugas = HrdKaryawan::whereIn('kd_ruangan', [1, 107])
            ->where('status_peg', 1)
            ->orderBy('kd_karyawan')
            ->get();

        $tindakan = RmeRehabMedikTindakan::find($id);

        return view('unit-pelayanan.rehab-medis.pelayanan.tindakan.show', compact('dataMedis', 'programs', 'petugas', 'tindakan'));
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_unit', $this->kdUnitDef_)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (empty($dataMedis)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Kunjungan pasien tidak ditemukan !',
                    'data'      => []
                ]);
            }

            $id = decrypt($request->tindakan);
            $tindakan = RmeRehabMedikTindakan::find($id);

            if (empty($tindakan)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan !',
                    'data'      => []
                ]);
            }


            // delete tindakan
            RmeRehabMedikTindakan::where('id', $id)->delete();


            // delete detail transaksi
            $programs = RmeRehabMedikProgramDetail::with(['program'])
                ->whereRelation('program', function ($q) use ($kd_pasien, $tgl_masuk, $urut_masuk) {
                    $q->where('kd_pasien', $kd_pasien);
                    $q->where('kd_unit', $this->kdUnitDef_);
                    $q->whereDate('tgl_masuk', $tgl_masuk);
                    $q->where('urut_masuk', $urut_masuk);
                })->get();

            foreach ($programs as $program) {
                DetailTransaksi::where('no_transaksi', $dataMedis->no_transaksi)
                    ->where('kd_kasir', $dataMedis->kd_kasir)
                    ->where('kd_unit', 74)
                    ->where('kd_produk', $program->kd_produk)
                    ->whereDate('tgl_transaksi', $tgl_masuk)
                    ->delete();
            }

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'OK !',
                'data'      => []
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
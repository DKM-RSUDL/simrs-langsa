<?php

namespace App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Produk;
use App\Models\RmeRehabMedikLayanan;
use App\Models\RmeRehabMedikProgram;
use App\Models\RmeRehabMedikProgramDetail;
use App\Models\RmeRehabMedikTindakan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    public function index(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 214)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        $layanan = RmeRehabMedikLayanan::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 214)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        $programs = RmeRehabMedikProgram::with(['detail'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 214)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        $tindakan = RmeRehabMedikTindakan::with(['karyawan'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 214)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        return view('unit-pelayanan.rehab-medis.pelayanan.layanan.index', compact('dataMedis', 'layanan', 'programs', 'tindakan'));
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
            ->where('kunjungan.kd_unit', 214)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        return view('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.create', compact('dataMedis'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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
                ->where('kunjungan.kd_unit', 214)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            // store
            $layanan = new RmeRehabMedikLayanan();
            $layanan->kd_pasien             = $kd_pasien;
            $layanan->kd_unit               = 214;
            $layanan->tgl_masuk             = $tgl_masuk;
            $layanan->urut_masuk            = $urut_masuk;
            $layanan->tgl_pelayanan         = $request->tgl_pelayanan;
            $layanan->jam_pelayanan         = $request->jam_pelayanan;
            $layanan->anamnesa              = $request->anamnesa;
            $layanan->pemeriksaan_fisik     = $request->pemeriksaan_fisik;
            $layanan->diagnosis_medis       = $request->diagnosis_medis;
            $layanan->diagnosis_fungsi      = $request->diagnosis_fungsi;
            $layanan->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;
            $layanan->tatalaksana           = $request->tatalaksana;
            $layanan->suspek_penyakit       = $request->suspek_penyakit;
            $layanan->suspek_penyakit_ket   = $request->suspek_penyakit_ket;
            $layanan->diagnosa              = $request->diagnosa;
            $layanan->permintaan_terapi     = $request->permintaan_terapi;
            $layanan->user_create           = Auth::id();
            $layanan->save();


            DB::commit();
            return to_route('rehab-medis.pelayanan.layanan', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Layanan berhasil ditambah !');
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
            ->where('kunjungan.kd_unit', 214)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        $layanan = RmeRehabMedikLayanan::find($id);

        if (empty($layanan)) abort(404, 'Data layanan tidak ditemukan !');

        return view('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.edit', compact('dataMedis', 'layanan'));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
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
                ->where('kunjungan.kd_unit', 214)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            // store
            $id = decrypt($idEncrypt);

            $layanan = RmeRehabMedikLayanan::find($id);
            $layanan->tgl_pelayanan         = $request->tgl_pelayanan;
            $layanan->jam_pelayanan         = $request->jam_pelayanan;
            $layanan->anamnesa              = $request->anamnesa;
            $layanan->pemeriksaan_fisik     = $request->pemeriksaan_fisik;
            $layanan->diagnosis_medis       = $request->diagnosis_medis;
            $layanan->diagnosis_fungsi      = $request->diagnosis_fungsi;
            $layanan->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;
            $layanan->tatalaksana           = $request->tatalaksana;
            $layanan->suspek_penyakit       = $request->suspek_penyakit;
            $layanan->suspek_penyakit_ket   = $request->suspek_penyakit_ket;
            $layanan->diagnosa              = $request->diagnosa;
            $layanan->permintaan_terapi     = $request->permintaan_terapi;
            $layanan->user_edit             = Auth::id();
            $layanan->save();


            DB::commit();
            return to_route('rehab-medis.pelayanan.layanan', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Layanan berhasil diubah !');
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
            ->where('kunjungan.kd_unit', 214)
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



        $layanan = RmeRehabMedikLayanan::find($id);
        if (empty($layanan)) abort(404, 'Data layanan tidak ditemukan !');

        return view('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.show', compact('dataMedis', 'layanan'));
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
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.kd_unit', 214)
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

            $id = decrypt($request->pelayanan);

            $pelayanan = RmeRehabMedikLayanan::find($id);

            if (empty($pelayanan)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan !',
                    'data'      => []
                ]);
            }

            RmeRehabMedikLayanan::where('id', $pelayanan->id)->delete();

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


    /*================================
                PROGRAM
    ================================*/

    public function createProgram($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 214)
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

        $produk = Produk::select([
            'klas_produk.kd_klas',
            'produk.kd_produk',
            'produk.kp_produk',
            'produk.deskripsi',
            'tarif.kd_tarif',
            'tarif.tarif',
            'tarif.kd_unit',
            'tarif.tgl_berlaku'
        ])
            ->join('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
            ->join('tarif_cust', 'tarif.kd_tarif', '=', 'tarif_cust.kd_tarif')
            ->join('klas_produk', 'klas_produk.kd_klas', '=', 'produk.kd_klas')
            ->whereIn('tarif.kd_unit', [74])
            // ->where('klas_produk.kd_klas', '63')
            ->where('tarif.kd_tarif', 'TU')
            ->where(function ($query) {
                $query->whereNull('tarif.Tgl_Berakhir')
                    ->orWhere('tarif.Tgl_Berakhir', '>=', Carbon::now()->toDateString());
            })
            ->where('tarif.tgl_berlaku', '<=', Carbon::now()->toDateString())
            ->whereIn('tarif.tgl_berlaku', function ($query) {
                $query->select('tgl_berlaku')
                    ->from('tarif as t')
                    ->whereColumn('t.KD_PRODUK', 'tarif.kd_produk')
                    ->whereColumn('t.KD_TARIF', 'tarif.kd_tarif')
                    ->whereColumn('t.KD_UNIT', 'tarif.kd_unit')
                    ->where(function ($q) {
                        $q->whereNull('t.Tgl_Berakhir')
                            ->orWhere('t.Tgl_Berakhir', '>=', Carbon::now()->toDateString());
                    })
                    ->orderBy('t.tgl_berlaku', 'asc')
                    ->limit(1);
            })
            ->whereRaw('LEFT(produk.kd_klas, 2) = ?', ['74'])
            ->orderBy('tarif.TGL_BERLAKU', 'desc')
            ->distinct()
            ->get();

        return view('unit-pelayanan.rehab-medis.pelayanan.layanan.program.create', compact('dataMedis', 'produk'));
    }

    public function storeProgram($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'program'       => 'required'
            ]);

            if ($validator->fails()) return back()->with('error', 'Program harus di pilih minimal 1 !');

            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_unit', 214)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (empty($dataMedis)) return back()->with('error', 'Data kunjungan pasien tidak ditemukan !');

            // convert program to array
            $programReq = $request->program;
            $programs = [];

            foreach ($programReq as $pro) {
                $programs[] = json_decode($pro, true);
            }


            // store program
            $program = new RmeRehabMedikProgram();
            $program->kd_pasien     = $kd_pasien;
            $program->kd_unit       = 214;
            $program->tgl_masuk     = $tgl_masuk;
            $program->urut_masuk    = $urut_masuk;
            $program->tgl_pelayanan = $request->tgl_pelayanan;
            $program->jam_pelayanan = $request->jam_pelayanan;
            $program->user_create   = Auth::id();
            $program->save();


            // store program detail

            foreach ($programs as $pr) {
                $programDetailData = [
                    'id_program'    => $program->id,
                    'kd_produk'     => $pr['kd_produk'],
                    'tarif'         => intval($pr['tarif']),
                    'tgl_berlaku'   => $pr['tgl_berlaku']
                ];
                RmeRehabMedikProgramDetail::create($programDetailData);
            }


            DB::commit();
            return to_route('rehab-medis.pelayanan.layanan', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Program berhasil ditambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function editProgram($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 214)
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

        $produk = Produk::select([
            'klas_produk.kd_klas',
            'produk.kd_produk',
            'produk.kp_produk',
            'produk.deskripsi',
            'tarif.kd_tarif',
            'tarif.tarif',
            'tarif.kd_unit',
            'tarif.tgl_berlaku'
        ])
            ->join('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
            ->join('tarif_cust', 'tarif.kd_tarif', '=', 'tarif_cust.kd_tarif')
            ->join('klas_produk', 'klas_produk.kd_klas', '=', 'produk.kd_klas')
            ->whereIn('tarif.kd_unit', [74])
            // ->where('klas_produk.kd_klas', '63')
            ->where('tarif.kd_tarif', 'TU')
            ->where(function ($query) {
                $query->whereNull('tarif.Tgl_Berakhir')
                    ->orWhere('tarif.Tgl_Berakhir', '>=', Carbon::now()->toDateString());
            })
            ->where('tarif.tgl_berlaku', '<=', Carbon::now()->toDateString())
            ->whereIn('tarif.tgl_berlaku', function ($query) {
                $query->select('tgl_berlaku')
                    ->from('tarif as t')
                    ->whereColumn('t.KD_PRODUK', 'tarif.kd_produk')
                    ->whereColumn('t.KD_TARIF', 'tarif.kd_tarif')
                    ->whereColumn('t.KD_UNIT', 'tarif.kd_unit')
                    ->where(function ($q) {
                        $q->whereNull('t.Tgl_Berakhir')
                            ->orWhere('t.Tgl_Berakhir', '>=', Carbon::now()->toDateString());
                    })
                    ->orderBy('t.tgl_berlaku', 'asc')
                    ->limit(1);
            })
            ->whereRaw('LEFT(produk.kd_klas, 2) = ?', ['74'])
            ->orderBy('tarif.TGL_BERLAKU', 'desc')
            ->distinct()
            ->get();

        $program = RmeRehabMedikProgram::find($id);

        return view('unit-pelayanan.rehab-medis.pelayanan.layanan.program.edit', compact('dataMedis', 'produk', 'program'));
    }

    public function updateProgram($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'program'       => 'required'
            ]);

            if ($validator->fails()) return back()->with('error', 'Program harus di pilih minimal 1 !');

            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_unit', 214)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (empty($dataMedis)) return back()->with('error', 'Data kunjungan pasien tidak ditemukan !');

            // convert program to array
            $programReq = $request->program;
            $programs = [];

            foreach ($programReq as $pro) {
                $programs[] = json_decode($pro, true);
            }


            // update program
            $id = decrypt($idEncrypt);

            $program = RmeRehabMedikProgram::find($id);
            $program->tgl_pelayanan = $request->tgl_pelayanan;
            $program->jam_pelayanan = $request->jam_pelayanan;
            $program->user_edit   = Auth::id();
            $program->save();


            // update program detail
            RmeRehabMedikProgramDetail::where('id_program', $id)->delete();

            foreach ($programs as $pr) {
                $programDetailData = [
                    'id_program'    => $id,
                    'kd_produk'     => $pr['kd_produk'],
                    'tarif'         => intval($pr['tarif']),
                    'tgl_berlaku'   => $pr['tgl_berlaku']
                ];
                RmeRehabMedikProgramDetail::create($programDetailData);
            }


            DB::commit();
            return to_route('rehab-medis.pelayanan.layanan', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Program berhasil diubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroyProgram($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.kd_unit', 214)
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

            $id = decrypt($request->program);

            $program = RmeRehabMedikProgram::find($id);

            if (empty($program)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan !',
                    'data'      => []
                ]);
            }

            RmeRehabMedikProgram::where('id', $program->id)->delete();
            RmeRehabMedikProgramDetail::where('id_program', $program->id)->delete();

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

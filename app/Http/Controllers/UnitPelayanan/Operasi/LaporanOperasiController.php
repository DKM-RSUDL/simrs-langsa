<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\OkAsesmen;
use App\Models\OkPraOperasiMedis;
use App\Models\OkJenisAnastesi;
use App\Models\DokterAnastesi;
use App\Models\OkLaporanOperasi;
use App\Models\Perawat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanOperasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
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

        $reportOperations = OkLaporanOperasi::with(['userCreate'])
            ->where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->get();

        return view('unit-pelayanan.operasi.pelayanan.laporan-operatif.index', compact('dataMedis', 'reportOperations'));
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
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

        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::with(['dokter'])->where('aktif', 1)->get();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        return view('unit-pelayanan.operasi.pelayanan.laporan-operatif.create', compact('dataMedis', 'jenisAnastesi', 'dokterAnastesi', 'dokter', 'perawat'));
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
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.kd_unit', 71)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            // store
            $data = [
                'kd_kasir'              => $dataMedis->kd_kasir,
                'no_transaksi'          => $dataMedis->no_transaksi,
                'nama_tindakan_operasi' => $request->nama_tindakan_operasi,
                'kd_jenis_anastesi' => $request->kd_jenis_anastesi,
                'pa' => $request->pa,
                'kultur' => $request->kultur,
                'kd_dokter_bedah' => $request->kd_dokter_bedah,
                'kd_dokter_anastesi' => $request->kd_dokter_anastesi,
                'pendarahan' => $request->pendarahan,
                'diagnosa_pra_operasi' => $request->diagnosa_pra_operasi,
                'diagnosa_pasca_operasi' => $request->diagnosa_pasca_operasi,
                'laporan_prosedur_operasi' => $request->laporan_prosedur_operasi,
                'kompleksitas' => $request->kompleksitas,
                'urgensi' => $request->urgensi,
                'kebersihan' => $request->kebersihan,
                'komplikasi' => $request->komplikasi,
                'kd_perawat_bedah' => $request->kd_perawat_bedah,
                'kd_penata_anastesi' => $request->kd_penata_anastesi,
                'wb' => $request->wb,
                'prc' => $request->prc,
                'cryo' => $request->cryo,
                'tgl_mulai' => $request->tgl_mulai,
                'jam_mulai' => $request->jam_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'jam_selesai' => $request->jam_selesai,
                'lama_operasi' => $request->lama_operasi,
                'user_create'   => Auth::id()
            ];

            OkLaporanOperasi::create($data);

            DB::commit();
            return to_route('operasi.pelayanan.laporan-operasi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Laporan berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
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

        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::with(['dokter'])->where('aktif', 1)->get();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        $laporan = OkLaporanOperasi::where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->first();

        return view('unit-pelayanan.operasi.pelayanan.laporan-operatif.edit', compact('dataMedis', 'jenisAnastesi', 'dokterAnastesi', 'dokter', 'perawat', 'laporan'));
    }


    public function update($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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
                ->where('kunjungan.kd_unit', 71)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            // store
            $data = [
                'nama_tindakan_operasi' => $request->nama_tindakan_operasi,
                'kd_jenis_anastesi' => $request->kd_jenis_anastesi,
                'pa' => $request->pa,
                'kultur' => $request->kultur,
                'kd_dokter_bedah' => $request->kd_dokter_bedah,
                'kd_dokter_anastesi' => $request->kd_dokter_anastesi,
                'pendarahan' => $request->pendarahan,
                'diagnosa_pra_operasi' => $request->diagnosa_pra_operasi,
                'diagnosa_pasca_operasi' => $request->diagnosa_pasca_operasi,
                'laporan_prosedur_operasi' => $request->laporan_prosedur_operasi,
                'kompleksitas' => $request->kompleksitas,
                'urgensi' => $request->urgensi,
                'kebersihan' => $request->kebersihan,
                'komplikasi' => $request->komplikasi,
                'kd_perawat_bedah' => $request->kd_perawat_bedah,
                'kd_penata_anastesi' => $request->kd_penata_anastesi,
                'wb' => $request->wb,
                'prc' => $request->prc,
                'cryo' => $request->cryo,
                'tgl_mulai' => $request->tgl_mulai,
                'jam_mulai' => $request->jam_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'jam_selesai' => $request->jam_selesai,
                'lama_operasi' => $request->lama_operasi,
                'user_edit'   => Auth::id()
            ];

            OkLaporanOperasi::where('kd_kasir', $dataMedis->kd_kasir)
                ->where('no_transaksi', $dataMedis->no_transaksi)
                ->update($data);

            DB::commit();
            return to_route('operasi.pelayanan.laporan-operasi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Laporan berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function show($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
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

        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::with(['dokter'])->where('aktif', 1)->get();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        $laporan = OkLaporanOperasi::where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->first();

        return view('unit-pelayanan.operasi.pelayanan.laporan-operatif.show', compact('dataMedis', 'jenisAnastesi', 'dokterAnastesi', 'dokter', 'perawat', 'laporan'));
    }
}

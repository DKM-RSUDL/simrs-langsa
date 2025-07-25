<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\OkAsesmen;
use App\Models\OkPraInduksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsesmenController extends Controller
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

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $asesmen = OkAsesmen::with(['praOperatifMedis', 'userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 71)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        $okPraInduksi = OkPraInduksi::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 71)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->latest('id')
            ->paginate(10);

        return view('unit-pelayanan.operasi.pelayanan.asesmen.index', compact('dataMedis', 'asesmen', 'okPraInduksi'));
    }
}
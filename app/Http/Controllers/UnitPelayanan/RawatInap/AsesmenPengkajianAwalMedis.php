<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\SatsetPrognosis;

class AsesmenPengkajianAwalMedis extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();


        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.create', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'dataMedis' => $dataMedis,
            'rmeMasterDiagnosis' => $rmeMasterDiagnosis,
            'rmeMasterImplementasi' => $rmeMasterImplementasi,
            'alergiPasien' => $alergiPasien,
            'satsetPrognosis' => $satsetPrognosis
        ]);
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RajalHivArtAkhirFollowUpController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // start fungsi Tabs
        $activeTab = $request->query('tab', 'ikhtisar');

        $allowedTabs = ['ikhtisar', 'followUp'];
        if (!in_array($activeTab, $allowedTabs)) {
            $activeTab = 'ikhtisar';
        }

        if ($activeTab == 'ikhtisar') {
            return $this->ikhtisarTab($dataMedis, $activeTab);
        } else {
            return $this->followUpTab($dataMedis, $activeTab);
        }
        // end code

        // $prmrjs = RmePrmrj::where('kd_pasien', $kd_pasien)
        // ->where('kd_unit', $kd_unit)
        // ->where('tgl_masuk', $tgl_masuk)
        // ->where('urut_masuk', $urut_masuk)
        // ->orderBy('tanggal', 'desc')
        // ->paginate(10);
    }

    private function ikhtisarTab($dataMedis, $activeTab)
    {
        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.index', compact(
        'dataMedis',
            'activeTab'
        ));
    }

    private function followUpTab($dataMedis, $activeTab)
    {
        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art_akhiri_follow_up.index', compact(
        'dataMedis',
            'activeTab'
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art_akhiri_follow_up.create', compact(
            'dataMedis',
        ));
    }
}

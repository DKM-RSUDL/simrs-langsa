<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap\ResikoJatuh;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkalaMorseController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    /**
     * Helper method untuk mendapatkan data medis
     */
    private function getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
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

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else if ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return $dataMedis;
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        // start fungsi Tabs
        $activeTab = $request->query('tab', 'skalaMorse');

        $allowedTabs = ['skalaMorse', 'skalaMorse1', 'skalaMorse2'];
        if (!in_array($activeTab, $allowedTabs)) {
            $activeTab = 'skalaMorse';
        }

        if ($activeTab == 'skalaMorse') {
            return $this->skalaMorseTab($dataMedis, $activeTab);
        } elseif ($activeTab == 'skalaMorse') {
            return $this->skalaMorse1Tab($dataMedis, $activeTab);
        } else {
            return $this->skalaMorse2Tab($dataMedis, $activeTab);
        }
        // end code Tabs
    }

    private function skalaMorseTab($dataMedis, $activeTab)
    {
        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.index', compact(
            'dataMedis',
            'activeTab'
        ));
    }

    private function skalaMorse1Tab($dataMedis, $activeTab)
    {
        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.index', compact(
            'dataMedis',
            'activeTab',
        ));
    }

    private function skalaMorse2Tab($dataMedis, $activeTab)
    {

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.index', compact(
            'dataMedis',
            'activeTab',
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        DB::beginTransaction();
        try {
    
            DB::commit();

            return to_route('rawat-inap.ews-pasien-dewasa.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])
                ->with('success', 'Data EWS Pasien Dewasa berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

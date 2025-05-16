<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokterInap;
use App\Models\Kunjungan;
use App\Models\PermintaanSecondOpinion;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EWSPasienDewasaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
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
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        $dataDokter = DokterInap::with(['dokter', 'unit'])
            ->where('kd_unit', '1001')
            ->whereRelation('dokter', 'status', 1)
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // start fungsi Tabs        
        $activeTab = $request->query('tab', 'dewasa');

        $allowedTabs = ['dewasa', 'anak', 'obstetri'];
        if (!in_array($activeTab, $allowedTabs)) {
            $activeTab = 'dewasa';
        }

        if ($activeTab == 'dewasa') {
            return $this->dewasaTab($dataMedis, $activeTab);
        } elseif ($activeTab == 'anak') {
            return $this->anakTab($dataMedis, $activeTab);
        } else {
            return $this->obstetriTab($dataMedis, $activeTab);
        }
        // end code              
    }

    private function dewasaTab($dataMedis, $activeTab)
    {
        $dataDokter = DokterInap::with(['dokter', 'unit'])
            ->where('kd_unit', '1001')
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.index', compact(
            'dataMedis',
            'dataDokter',            
            'activeTab'
        ));
    }

    private function anakTab($dataMedis, $activeTab)
    {
        // Data khusus untuk tab anak jika diperlukan        

        // return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-anak.index', compact(
        //     'dataMedis',
        //     'dataDokter',        
        //     'activeTab',
        //     'dataAnak'
        // ));
    }

    private function obstetriTab($dataMedis, $activeTab)
    {
        // Data khusus untuk tab obstetri jika diperlukan

        // return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-obstetri.index', compact(
        //     'dataMedis',
        //     'dataDokter',        
        //     'activeTab',
        //     'dataObstetri'
        // ));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
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


        return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.create', compact(
            'dataMedis',            
        ));
    }
}

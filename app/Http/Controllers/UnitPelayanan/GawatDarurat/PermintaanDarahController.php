<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\BdrsPermintaanDarah;
use App\Models\DokterKlinik;
use App\Models\GolonganDarah;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanDarahController extends Controller
{
    public function index($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // start fungsi Tabs
        $tabs = $request->query('tab');

        if ($tabs == 'monitoring') {
            return $this->monitoringTab($dataMedis, $request);
        } else {
            return $this->orderTab($dataMedis, $request);
        }
        // end code
    }

    private function orderTab($dataMedis, $request)
    {
        $permintaanDarah = BdrsPermintaanDarah::orderBy('TGL_PENGIRIMAN', 'desc')->paginate(10);
        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-darah.index', compact(
            'dataMedis',
            'permintaanDarah'
        ));
    }

    private function monitoringTab($dataMedis, $request)
    {
        //
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
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = DokterKlinik::with(['unit', 'dokter'])
            ->whereRelation('dokter', 'status', 1)
            ->where('kd_unit', 3)
            ->get();

        $gologanDarah = GolonganDarah::all();


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-darah.create', compact(
            'dataMedis',
            'dokter',
            'gologanDarah'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {

            $permintaanDarah = new BdrsPermintaanDarah();            
            $permintaanDarah->KD_PASIEN = $kd_pasien;
            $permintaanDarah->KD_UNIT = 3;
            $permintaanDarah->TGL_MASUK = $tgl_masuk;
            $permintaanDarah->URUT_MASUK = $urut_masuk;
            $permintaanDarah->STATUS = 0;
            $permintaanDarah->USER_CREATE = Auth::id();                      
            
            // filed all db
            $permintaanDarah->TIPE = $request->TIPE;          
            $permintaanDarah->KD_DOKTER = $request->KD_DOKTER;          
            $permintaanDarah->TGL_PENGIRIMAN = $request->TGL_PENGIRIMAN;          
            $permintaanDarah->TGL_DIPERLUKAN = $request->TGL_DIPERLUKAN;          
            $permintaanDarah->DIAGNOSA_KIMIA = $request->DIAGNOSA_KIMIA;          
            $permintaanDarah->ALASAN_TRANSFUSI = $request->ALASAN_TRANSFUSI;          
            $permintaanDarah->KODE_GOLDA = $request->KODE_GOLDA;          
            $permintaanDarah->HB = $request->HB;          
            $permintaanDarah->NAMA_SUAMI_ISTRI = $request->NAMA_SUAMI_ISTRI;          
            $permintaanDarah->TRANFUSI_SEBELUMNYA = $request->TRANFUSI_SEBELUMNYA;          
            $permintaanDarah->REAKSI_TRANFUSI = $request->REAKSI_TRANFUSI;          
            $permintaanDarah->SEROLOGI_DIMANA = $request->SEROLOGI_DIMANA;          
            $permintaanDarah->SEROLOGI_KAPAN = $request->SEROLOGI_KAPAN;          
            $permintaanDarah->SEROLOGI_HASIL = $request->SEROLOGI_HASIL;          
            $permintaanDarah->PERNAH_HAMIL = $request->PERNAH_HAMIL;          
            $permintaanDarah->ABORTUS_HDN = $request->ABORTUS_HDN;
            $permintaanDarah->WB = $request->WB;            
            $permintaanDarah->PRC = $request->PRC;            
            $permintaanDarah->PRC_PEDIACTRIC = $request->PRC_PEDIACTRIC;            
            $permintaanDarah->PRC_LEUKODEPLETED = $request->PRC_LEUKODEPLETED;            
            $permintaanDarah->WASHED_ERYTHROYTE = $request->WASHED_ERYTHROYTE;            
            $permintaanDarah->LAINNYA = $request->LAINNYA;            
            $permintaanDarah->TC_BIASA = $request->TC_BIASA;            
            $permintaanDarah->TC_APHERESIS = $request->TC_APHERESIS;            
            $permintaanDarah->TC_POOLED = $request->TC_POOLED;            
            $permintaanDarah->PLASMA_CAIR = $request->PLASMA_CAIR;            
            $permintaanDarah->PLASMA_SEGAR_BEKU = $request->PLASMA_SEGAR_BEKU;            
            $permintaanDarah->CIYOPRECIPITATE = $request->CIYOPRECIPITATE;                        
            $permintaanDarah->WAKTU_PENGAMBILAN_SAMPEL = $request->TGL_PENGAMBILAN_SAMPEL . ' ' . $request->WAKTU_PENGAMBILAN_SAMPEL;
            $permintaanDarah->PETUGAS_PENGAMBILAN_SAMPEL = $request->PETUGAS_PENGAMBILAN_SAMPEL;                        
            $permintaanDarah->save();

            DB::commit();

            return to_route('permintaan-darah.index', [
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])->with(['success' => 'Berhasil menambah Edukasi !']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}

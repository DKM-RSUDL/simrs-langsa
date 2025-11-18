<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\HrdKaryawan;
use App\Models\OrderHD;
use App\Models\RmeSerahTerima;
use App\Models\Unit;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderHemodialisaController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->baseService = new BaseService();
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $unit = Unit::where('kd_bagian', 1)->where('aktif', 1)->get();

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->where('kd_karyawan', '!=', Auth::user()->kd_karyawan)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.hd.index', compact('dataMedis', 'nginap', 'unit', 'petugas'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan');

            // cek order aktif
            $orderAktif = OrderHD::where('kd_kasir_asal', $dataMedis->kd_kasir)
                ->where('no_transaksi_asal', $dataMedis->no_transaksi)
                ->whereIn('status', [0, 1])
                ->count();

            if ($orderAktif > 0) throw new Exception('Terdapat order hemodialisa aktif pada pasien ini !');

            // store rme_serah_terima
            // $serahTerima = new RmeSerahTerima();
            // $serahTerima->kd_pasien = $kd_pasien;
            // $serahTerima->tgl_masuk = $tgl_masuk;
            // $serahTerima->urut_masuk = $urut_masuk;
            // $serahTerima->kd_unit_asal = $kd_unit;
            // $serahTerima->kd_unit_tujuan = 72;
            // $serahTerima->subjective = $request->subjective;
            // $serahTerima->background = $request->background;
            // $serahTerima->assessment = $request->assessment;
            // $serahTerima->recomendation = $request->recomendation;
            // $serahTerima->tanggal_menyerahkan = $request->tanggal_menyerahkan;
            // $serahTerima->jam_menyerahkan = $request->jam_menyerahkan;
            // $serahTerima->petugas_menyerahkan = $request->petugas_menyerahkan;
            // $serahTerima->status = 1;
            // $serahTerima->save();

            // store order_hd
            $orderData = [
                'kd_kasir_asal' => $dataMedis->kd_kasir,
                'no_transaksi_asal' => $dataMedis->no_transaksi,
                'kd_unit_order' => $nginap->kd_unit_kamar,
                'tgl_order' => $request->tanggal_menyerahkan,
                'jam_order' => $request->jam_menyerahkan,
                'status'    => 0,
                // 'id_serah_terima' => $serahTerima->id,
            ];

            OrderHD::create($orderData);

            DB::commit();
            return to_route('rawat-inap.unit', [$nginap->kd_unit_kamar])->with('success', 'Order Hemodialisa berhasil dibuat');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}

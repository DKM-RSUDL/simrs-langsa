<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\InformedConsent;
use App\Models\Kunjungan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformedConsentController extends Controller
{
    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                            ->join('transaksi as t', function($join) {
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

        $informedConsent = InformedConsent::where('kd_pasien', $kd_pasien)
                                        ->where('kd_unit', $kd_unit)
                                        ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
                                        ->where('urut_masuk', $urut_masuk)
                                        ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.informed-consent.index', compact('dataMedis', 'informedConsent'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $data = $request->except(['_token']);
            $data['kd_pasien'] = $kd_pasien;
            $data['kd_unit'] = $kd_unit;
            $data['tgl_masuk'] = $tgl_masuk;
            $data['urut_masuk'] = $urut_masuk;
            $data['id_user'] = Auth::id();


            $formatTglMasuk = date('Y-m-d', strtotime($tgl_masuk));

            // store ttd petugas
            if($request->hasFile('ttd_pj')) {
                $path = $request->file('ttd_pj')->store("uploads/rawat-inap/informed-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_pj'] = $path;
            }

            // store ttd pj
            if($request->hasFile('ttd_saksi_1')) {
                $path = $request->file('ttd_saksi_1')->store("uploads/rawat-inap/informed-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_saksi_1'] = $path;
            }

            // store ttd saksi
            if($request->hasFile('ttd_saksi_2')) {
                $path = $request->file('ttd_saksi_2')->store("uploads/rawat-inap/informed-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_saksi_2'] = $path;
            }

            // store data
            InformedConsent::create($data);
            return back()->with('success', 'Informed Consent berhasil ditambah!');

        } catch (Exception $e) {
            return back()->with('error', 'Internal Server Error!');
        }
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idInformedConsent)
    {
        try {
            InformedConsent::where('id', $idInformedConsent)->delete();
            return back()->with('success', 'Informed Consent berhasil dihapus!');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $informedConsent = InformedConsent::find($request->dataic);

            if(empty($informedConsent)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan !',
                    'data'      => []
                ]);
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $informedConsent
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Internal Server Error !',
                'data'      => []
            ]);
        }
    }
}

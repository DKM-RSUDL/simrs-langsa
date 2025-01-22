<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\GeneralConsent;
use App\Models\Kunjungan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralConsentController extends Controller
{
    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                            ->join('transaksi as t', function($join) {
                                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                            })
                            ->where('kunjungan.kd_pasien', $kd_pasien)
                            ->where('kunjungan.kd_unit', 3)
                            ->where('kunjungan.urut_masuk', $urut_masuk)
                            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                            ->first();

        $generalConsent = GeneralConsent::where('kd_pasien', $kd_pasien)
                                        ->where('kd_unit', 3)
                                        ->whereDate('tgl_masuk', $tgl_masuk)
                                        ->where('urut_masuk', $urut_masuk)
                                        ->get();


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.general-consent.index', compact('dataMedis', 'generalConsent'));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $data = [
                'kd_pasien'     => $kd_pasien,
                'kd_unit'     => 3,
                'tgl_masuk'     => date('Y-m-d', strtotime($tgl_masuk)),
                'urut_masuk'     => $urut_masuk,
                'tanggal'       => $request->tanggal,
                'jam'       => $request->jam,
                'pj_nama'       => $request->pj_nama,
                'pj_tgl_lahir'       => $request->pj_tgl_lahir,
                'pj_nohp'       => $request->pj_nohp,
                'pj_alamat'       => $request->pj_alamat,
                'pj_hubungan_pasien'       => $request->pj_hubungan_pasien,
                'saksi_nama'       => $request->saksi_nama,
                'saksi_tgl_lahir'       => $request->saksi_tgl_lahir,
                'saksi_nohp'       => $request->saksi_nohp,
                'saksi_alamat'       => $request->saksi_alamat,
                'saksi_hubungan_pasien'       => $request->saksi_hubungan_pasien,
                'setuju_perawatan'       => $request->setuju_perawatan,
                'setuju_barang'       => $request->setuju_barang,
                'info_nama_1'       => $request->info_nama_1,
                'info_hubungan_pasien_1'       => $request->info_hubungan_pasien_1,
                'info_nama_2'       => $request->info_nama_2,
                'info_hubungan_pasien_2'       => $request->info_hubungan_pasien_2,
                'info_nama_3'       => $request->info_nama_3,
                'info_hubungan_pasien_3'       => $request->info_hubungan_pasien_3,
                'setuju_hak'       => $request->setuju_hak,
                'setuju_akses_privasi'       => $request->setuju_akses_privasi,
                'akses_privasi_keterangan'       => $request->akses_privasi_keterangan,
                'setuju_privasi_khusus'       => $request->setuju_privasi_khusus,
                'privasi_khusus_keterangan'       => $request->privasi_khusus_keterangan,
                'rawat_inap_keterangan'       => $request->rawat_inap_keterangan,
                'biaya_status'       => $request->biaya_status,
                'biaya_setuju'       => $request->biaya_setuju,
                'id_user'           => Auth::id()
            ];
            // dd($data);

            $formatTglMasuk = date('Y-m-d', strtotime($tgl_masuk));

            // store ttd petugas
            if($request->hasFile('ttd_petugas')) {
                $path = $request->file('ttd_petugas')->store("uploads/gawat-darurat/general-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_petugas'] = $path;
            }

            // store ttd pj
            if($request->hasFile('ttd_pj')) {
                $path = $request->file('ttd_pj')->store("uploads/gawat-darurat/general-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_pj'] = $path;
            }

            // store ttd saksi
            if($request->hasFile('ttd_saksi')) {
                $path = $request->file('ttd_saksi')->store("uploads/gawat-darurat/general-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_saksi'] = $path;
            }

            // store data
            GeneralConsent::create($data);
            return back()->with('success', 'General Consent berhasil ditambah!');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function delete($kd_pasien, $tgl_masuk, $urut_masuk, $idGeneralConsent)
    {
        try {
            GeneralConsent::where('id', $idGeneralConsent)->delete();
            return back()->with('success', 'General Consent berhasil dihapus!');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $generalConsent = GeneralConsent::find($request->datagc);

            if(empty($generalConsent)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan !',
                    'data'      => []
                ]);
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $generalConsent
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

<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\KamarInduk;
use App\Models\Kunjungan;
use App\Models\Nginap;
use App\Models\PasienInap;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\SpcKelas;
use App\Models\Spesialisasi;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferPasienController extends Controller
{
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
                                ->where('kunjungan.kd_unit', 3)
                                ->where('kunjungan.urut_masuk', $urut_masuk)
                                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                                ->first();

        $spesialisasi = Spesialisasi::orderBy('spesialisasi')->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.transfer-pasien.index', compact('dataMedis', 'spesialisasi'));
    }

    public function getDokterBySpesial(Request $request)
    {
        try {
            $dokter = Dokter::select(['dokter.kd_dokter', 'nama'])
                            ->join('dokter_spesial as ds', 'dokter.kd_dokter', '=', 'ds.kd_dokter')
                            ->where('ds.kd_spesial', $request->kd_spesial)
                            ->where('dokter.status', 1)
                            ->distinct()
                            ->get();

            $kelas = SpcKelas::select(['k.kd_kelas', 'k.kelas'])
                            ->join('kelas as k', 'spc_kelas.kd_kelas', '=', 'k.kd_kelas')
                            ->where('spc_kelas.kd_spesial', $request->kd_spesial)
                            ->orderBy('k.kelas')
                            ->get();

            
            $dokHtml = "<option value=''>--Pilih Dokter--</option>";
            $klsHtml = "<option value=''>--Pilih Kelas--</option>";

            foreach($dokter as $dok) {
                $dokHtml .= "<option value='$dok->kd_dokter'>$dok->nama</option>";
            }

            foreach($kelas as $kls) {
                $klsHtml .= "<option value='$kls->kd_kelas'>$kls->kelas</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => [
                    'dokterOption'  => $dokHtml,
                    'kelasOption'   => $klsHtml
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    public function getRuanganByKelas(Request $request)
    {
        try {
            $ruangan = Unit::select(['unit.kd_unit', 'unit.nama_unit'])
                            ->join('kelas as k', 'unit.kd_kelas', '=', 'k.kd_kelas')
                            ->where('k.kd_kelas', $request->kd_kelas)
                            ->where('unit.aktif', 1)
                            ->orderBy('unit.kd_unit')
                            ->get();

            
            $ruangHtml = "<option value=''>--Pilih Ruang--</option>";

            foreach($ruangan as $ruang) {
                $ruangHtml .= "<option value='$ruang->kd_unit'>$ruang->nama_unit</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $ruangHtml
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    public function getKamarByRuang(Request $request)
    {
        try {
            $kamar = KamarInduk::select(['kamar_induk.no_kamar', 'kamar_induk.nama_kamar'])
                                ->join('kamar as k', 'kamar_induk.no_kamar', '=', 'k.no_kamar')
                                ->where(DB::raw('kamar_induk.jumlah_bed - kamar_induk.digunakan - kamar_induk.booking'), '>', 0)
                                ->where('kamar_induk.aktif', 1)
                                ->where('k.kd_unit', $request->kd_unit)
                                ->get();

            
            $kamarHtml = "<option value=''>--Pilih Kamar--</option>";

            foreach($kamar as $kmr) {
                $kamarHtml .= "<option value='$kmr->no_kamar'>$kmr->nama_kamar</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $kamarHtml
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    public function getSisaBedByKamar(Request $request)
    {
        try {
            $sisaBed = KamarInduk::select(DB::raw('(jumlah_bed - digunakan - booking) as sisa'))
                                ->where('no_kamar', $request->no_kamar)
                                ->first()
                                ->sisa;

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $sisaBed
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    public function storeTransferInap(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $messageErr = [
            'kd_spesial.required'   => 'Spesialisasi harus dipilih!',
            'kd_dokter.required'    => 'Dokter harus dipilih!',
            'kd_kelas.required'     => 'Kelas harus dipilih!',
            'kd_unit.required'      => 'Ruangan harus dipilih!',
            'no_kamar.required'     => 'Kamar harus dipilih!',
            'sisa_bed.required'     => 'Sisa bed tidak boleh kosong!',
        ];

        $request->validate([
            'kd_spesial'    => 'required',
            'kd_dokter'     => 'required',
            'kd_kelas'      => 'required',
            'kd_unit'       => 'required',
            'no_kamar'      => 'required',
            'sisa_bed'      => 'required',
        ], $messageErr);


        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                                ->join('transaksi as t', function ($join) {
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

        if($dataMedis->status_kunjungan == 1) return back()->with('error', 'Pasien sudah pernah di transfer !');

        $kdSpesial = $request->kd_spesial;
        $kdDokter = $request->kd_dokter;
        $kdKelas = $request->kd_kelas;
        $kdUnit = $request->kd_unit;
        $noKamar = $request->no_kamar;
        $sisaBed = $request->sisa_bed;

        // get antrian terakhir
        $getLastAntrianToday = Kunjungan::select('antrian')
                                    ->whereDate('tgl_masuk', $tgl_masuk)
                                    ->where('kd_unit', $kdUnit)
                                    ->orderBy('antrian', 'desc')
                                    ->first();

        $no_antrian = !empty($getLastAntrianToday) ? $getLastAntrianToday->antrian + 1 : 1;

        // pasien not null get last urut masuk
        $getLastUrutMasukPatientToday = Kunjungan::select('urut_masuk')
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->orderBy('urut_masuk', 'desc')
            ->first();

        $newUrutMasuk = !empty($getLastUrutMasukPatientToday) ? $getLastUrutMasukPatientToday->urut_masuk + 1 : 1;

        // get tarif rawatan per unit
        $tarifRawatan = Tarif::where('kd_tarif', 'TU')
                    ->where('kd_produk', 17)
                    ->where('kd_unit', $kdUnit)
                    ->whereNull('tgl_berakhir')
                    ->orderBy('tgl_berlaku', 'DESC')
                    ->first();

        if(empty($tarifRawatan)) return back()->with('error', 'Tarif rawatan tidak ditemukan !');


        // insert ke tabel kunjungan
        $dataKunjungan = [
            'kd_pasien'         => $kd_pasien,
            'kd_unit'           => $kdUnit,
            'tgl_masuk'         => $tgl_masuk,
            'urut_masuk'        => $newUrutMasuk,
            'jam_masuk'         => date('H:i:s'),
            'asal_pasien'       => 0,
            'cara_penerimaan'   => 99,
            'kd_rujukan'        => $dataMedis->kd_rujukan,
            'no_surat'          => '',
            'kd_dokter'         => $kdDokter,
            'baru'              => 1,
            'kd_customer'       => $dataMedis->kd_customer,
            'shift'             => 0,
            'kontrol'           => 0,
            'antrian'           => $no_antrian,
            'tgl_surat'         => $tgl_masuk,
            'jasa_raharja'      => 0,
            'catatan'           => '',
            'kd_triase'         => $dataMedis->kd_triase,
            'status_inap'       => 0,
        ];

        Kunjungan::create($dataKunjungan);

        // delete rujukan_kunjungan
        RujukanKunjungan::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kdUnit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $newUrutMasuk)
            ->delete();


        // insert transaksi
        $lastTransaction = Transaksi::select('no_transaksi')
            ->where('kd_kasir', '02')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastTransactionNumber = (int) $lastTransaction->no_transaksi;
            $newTransactionNumber = $lastTransactionNumber + 1;
        } else {
            $newTransactionNumber = 1;
        }

        // formatted new transaction number with 7 digits length
        $formattedTransactionNumber = str_pad($newTransactionNumber, 7, '0', STR_PAD_LEFT);

        $dataTransaksi = [
            'kd_kasir'      => '02',
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_pasien'     => $kd_pasien,
            'kd_unit'       => $kdUnit,
            'tgl_transaksi' => $tgl_masuk,
            'app'           => 0,
            'ispay'         => 0,
            'co_status'     => 0,
            'urut_masuk'    => $newUrutMasuk,
            'kd_user'       => Auth::id(),
            'lunas'         => 0,
        ];

        Transaksi::create($dataTransaksi);


        // insert detail_transaksi
        $dataDetailTransaksi = [
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_kasir'      => '02',
            'tgl_transaksi' => $tgl_masuk,
            'urut'          => 1,
            'kd_tarif'      => 'TU',
            'kd_produk'     => 17,
            'kd_unit'       => $kdUnit,
            'kd_unit_tr'    => $kdUnit,
            'tgl_berlaku'   => $tarifRawatan->tgl_berlaku,
            'kd_user'       => Auth::id(),
            'shift'         => 0,
            'harga'         => $tarifRawatan->tarif,
            'qty'           => 1,
            'flag'          => 0,
            'jns_trans'     => 0,
        ];

        DetailTransaksi::create($dataDetailTransaksi);


        // insert detail_prsh
        $dataDetailPrsh = [
            'kd_kasir'      => '02',
            'no_transaksi'  => $formattedTransactionNumber,
            'urut'          => 1,
            'tgl_transaksi' => $tgl_masuk,
            'hak'           => $tarifRawatan->tarif,
            'selisih'       => 0,
            'disc'          => 0
        ];

        DetailPrsh::create($dataDetailPrsh);


        // delete detail_component
        DetailComponent::where('kd_kasir', '02')
            ->where('no_transaksi', $formattedTransactionNumber)
            ->where('urut', 1)
            ->delete();


        // insert detail_component
        $dataDetailComponent = [
            'kd_kasir'      => '02',
            'no_transaksi'  => $formattedTransactionNumber,
            'tgl_transaksi' => $tgl_masuk,
            'urut'          => 1,
            'kd_component'  => '30',
            'tarif'         => $tarifRawatan->tarif,
            'disc'          => 0
        ];

        DetailComponent::create($dataDetailComponent);

        // insert sjp_kunjungan
        $sjpKunjunganData = [
            'kd_pasien'     => $kd_pasien,
            'kd_unit'       => $kdUnit,
            'tgl_masuk'     => $tgl_masuk,
            'urut_masuk'    => $newUrutMasuk,
            'no_sjp'        => '',
            'penjamin_laka' => 0,
            'katarak'       => 0,
            'dpjp'          => $kdDokter,
            'cob'           => 0
        ];

        SjpKunjungan::create($sjpKunjunganData);

        // insert tabel pasien inap
        $pasienInapData = [
            'kd_kasir'      => '02',
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_unit'       => $kdUnit,
            'no_kamar'      => $noKamar,
            'kd_spesial'    => $kdSpesial,
            'co_status'     => 1
        ];

        PasienInap::create($pasienInapData);

        // insert tabel nginap
        $getLastUrutNginap = Nginap::select('urut_nginap')
                                    ->whereDate('tgl_masuk', $tgl_masuk)
                                    ->orderBy('urut_nginap', 'desc')
                                    ->first();

        $urutNginap = !empty($getLastUrutNginap) ? $getLastUrutNginap->urut_nginap + 1 : 1;


        $nginapData = [
            'kd_unit_kamar'     => $kdUnit,
            'no_kamar'          => $noKamar,
            'kd_pasien'         => $kd_pasien,
            'kd_unit'           => $kdUnit,
            'tgl_masuk'         => $tgl_masuk,
            'urut_masuk'        => $newUrutMasuk,
            'tgl_inap'          => $tgl_masuk,
            'jam_inap'          => date('H:i:s'),
            'kd_spesial'        => $kdSpesial,
            'akhir'             => 1,
            'urut_nginap'       => $urutNginap
        ];

        Nginap::create($nginapData);


        // update kamar induk
        $subquery = KamarInduk::query()
                            ->join('pasien_inap as pi', 'kamar_induk.NO_KAMAR', '=', 'pi.NO_KAMAR')
                            ->join('transaksi as t', function($join) {
                                $join->on('t.NO_TRANSAKSI', '=', 'pi.NO_TRANSAKSI')
                                    ->on('t.KD_KASIR', '=', 'pi.KD_KASIR');
                            })
                            ->join('nginap as ng', function($join) {
                                $join->on('ng.KD_PASIEN', '=', 't.KD_PASIEN')
                                    ->on('ng.TGL_MASUK', '=', 't.TGL_TRANSAKSI')
                                    ->on('ng.URUT_MASUK', '=', 't.URUT_MASUK')
                                    ->on('ng.KD_UNIT', '=', 't.KD_UNIT');
                            })
                            ->join('pasien as p', 'p.KD_PASIEN', '=', 't.KD_PASIEN')
                            ->whereNull('ng.TGL_KELUAR')
                            ->whereNull('t.tgl_dok')
                            ->where('kamar_induk.aktif', 1)
                            ->where('ng.akhir', 1)
                            ->select('ng.NO_KAMAR')
                            ->selectRaw('COUNT(*) as digunakan')
                            ->groupBy('ng.NO_KAMAR');

        // Update
        KamarInduk::query()
                ->joinSub($subquery, 'x', function($join) {
                    $join->on('kamar_induk.NO_KAMAR', '=', 'x.NO_KAMAR');
                })
                ->update(['kamar_induk.digunakan' => DB::raw('x.digunakan')]);

        // update kunjungan pasien telah di transfer
        Kunjungan::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 3)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->update(['status_kunjungan' => 1]);

        return to_route('gawat-darurat.index')->with('success', 'Pasien berhasil di transfer !');
    }
}

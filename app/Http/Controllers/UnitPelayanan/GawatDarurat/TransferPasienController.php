<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\KamarInduk;
use App\Models\Kunjungan;
use App\Models\Nginap;
use App\Models\PasienInap;
use App\Models\RmeKetStatusKunjungan;
use App\Models\RmeSerahTerima;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\SpcKelas;
use App\Models\Spesialisasi;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\Unit;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransferPasienController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
        $this->baseService = new BaseService();
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis(3, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (empty($dataMedis)) return to_route('gawat-darurat.index')->with('error', 'Data medis pasien tidak ditemukan !');

        $spesialisasi = Spesialisasi::orderBy('spesialisasi')->get();

        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_bagian', 1)->where('aktif', 1)->get();

        $petugasIGD = HrdKaryawan::where('kd_ruangan', 36)
            ->where('status_peg',  1)
            ->get();

        $serahTerima = RmeSerahTerima::where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit_asal', 3)
            ->first();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.transfer-pasien.index', compact('dataMedis', 'spesialisasi', 'unit', 'unitTujuan', 'petugasIGD', 'serahTerima'));
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

            foreach ($dokter as $dok) {
                $dokHtml .= "<option value='$dok->kd_dokter'>$dok->nama</option>";
            }

            foreach ($kelas as $kls) {
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

            foreach ($ruangan as $ruang) {
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

            foreach ($kamar as $kmr) {
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

            // HANDOVER
            'subjective'            => 'required',
            'background'            => 'required',
            'assessment'            => 'required',
            'recomendation'         => 'required',
            'petugas_menyerahkan'   => 'required',
            'tanggal_menyerahkan'   => 'required|date_format:Y-m-d',
            'jam_menyerahkan'       => 'required|date_format:H:i',
        ], $messageErr);

        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis(3, $kd_pasien, $tgl_masuk, $urut_masuk);
            if ($dataMedis->status_kunjungan == 1) return back()->with('error', 'Pasien sudah pernah di transfer !');

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

            if (empty($tarifRawatan)) return back()->with('error', 'Tarif rawatan tidak ditemukan !');


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
                'user_create'       => Auth::id()
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
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kdUnit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $newUrutMasuk)
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
                ->join('transaksi as t', function ($join) {
                    $join->on('t.NO_TRANSAKSI', '=', 'pi.NO_TRANSAKSI')
                        ->on('t.KD_KASIR', '=', 'pi.KD_KASIR');
                })
                ->join('nginap as ng', function ($join) {
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
                ->joinSub($subquery, 'x', function ($join) {
                    $join->on('kamar_induk.NO_KAMAR', '=', 'x.NO_KAMAR');
                })
                ->update(['kamar_induk.digunakan' => DB::raw('x.digunakan')]);


            // CREATE DATA SERAH TERIMA
            $handOverData = [
                'urut_masuk_tujuan'     => $newUrutMasuk,
                'kd_unit_tujuan'        => $kdUnit,
                'subjective'            => $request->subjective,
                'background'            => $request->background,
                'assessment'            => $request->assessment,
                'recomendation'         => $request->recomendation,
                'petugas_menyerahkan'   => $request->petugas_menyerahkan,
                'tanggal_menyerahkan'   => $request->tanggal_menyerahkan,
                'jam_menyerahkan'       => $request->jam_menyerahkan,
                'status'                => 1
            ];

            RmeSerahTerima::updateOrCreate([
                'kd_pasien'             => $kd_pasien,
                'tgl_masuk'             => $tgl_masuk,
                'urut_masuk'            => $urut_masuk,
                'kd_unit_asal'          => 3,
            ], $handOverData);

            // update kunjungan pasien telah di transfer
            Kunjungan::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 3)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->update(['status_kunjungan' => 1]);


            // CREATE ASAL_IGD
            $asalIGDData = [
                'kd_kasir'          => '02',
                'no_transaksi'      => $formattedTransactionNumber,
                'kd_kasir_asal'     => $dataMedis->kd_kasir,
                'no_transaksi_asal' => $dataMedis->no_transaksi
            ];

            AsalIGD::create($asalIGDData);

            // update keterangan status kunjungan IGD
            $this->baseService->updateKetKunjungan($dataMedis->kd_kasir, $dataMedis->no_transaksi, 'Handover Ranap', 0);

            DB::commit();
            return to_route('gawat-darurat.index')->with('success', 'Pasien berhasil di transfer !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function storeDataTemp(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {

            // $validator = Validator::make($request->all(), [
            //     // HANDOVER
            //     'subjective'            => 'required',
            //     'background'            => 'required',
            //     'assessment'            => 'required',
            //     'recomendation'         => 'required',
            // ]);

            // if ($validator->fails()) throw new Exception('SBAR harus diisi semua!');

            $dataMedis = $this->baseService->getDataMedis(3, $kd_pasien, $tgl_masuk, $urut_masuk);
            if ($dataMedis->status_kunjungan == 1) return back()->with('error', 'Pasien sudah di transfer, tidak dapat mengubah data !');

            // CREATE DATA SERAH TERIMA
            $handOverData = [
                'petugas_menyerahkan'   => $request->petugas_menyerahkan,
                'tanggal_menyerahkan'   => $request->tanggal_menyerahkan,
                'jam_menyerahkan'       => $request->jam_menyerahkan,
                'subjective'            => $request->subjective,
                'background'            => $request->background,
                'assessment'            => $request->assessment,
                'recomendation'         => $request->recomendation,
                'kd_spesial'            => $request->kd_spesial,
                'kd_dokter'             => $request->kd_dokter,
                'kd_kelas'              => $request->kd_kelas,
                'no_kamar'              => $request->no_kamar,
                'kd_unit_tujuan'        => $request->kd_unit
            ];

            RmeSerahTerima::updateOrCreate([
                'kd_pasien'             => $kd_pasien,
                'tgl_masuk'             => $tgl_masuk,
                'urut_masuk'            => $urut_masuk,
                'kd_unit_asal'          => 3,
            ], $handOverData);

            DB::commit();
            return to_route('index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))])->with('success', 'Data transfer pasien berhasil disimpan sementara!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\DokterAnastesi;
use App\Models\DokterKlinik;
use App\Models\DokterPenunjang;
use App\Models\Kamar;
use App\Models\KlasProduk;
use App\Models\Kunjungan;
use App\Models\Operasi\OkJadwal;
use App\Models\Operasi\OkJadwalDr;
use App\Models\Operasi\OkJadwalPs;
use App\Models\OrderOK;
use App\Models\Produk;
use App\Models\Spesialisasi;
use App\Models\Transaksi;
use App\Models\UnitAsal;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class OperasiController extends Controller
{
    private $baseService;
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
        $this->baseService = new BaseService();
        $this->kdUnitDef_ = 71;
    }

    /**
     * 🔥 HELPER METHOD - Get Products dengan Filter Tarif Aktif
     */
    private function getProducts()
    {
        return Cache::remember("products:unit:10013:klas:61:" . date('Y-m-d'), 60, function () {
            $today = date('Y-m-d');

            return DB::select("
                SELECT
                    p.kd_produk,
                    p.deskripsi
                FROM produk p
                INNER JOIN tarif t ON p.kd_produk = t.kd_produk
                INNER JOIN KLAS_PRODUK kp ON p.kd_klas = kp.kd_klas
                WHERE t.kd_unit = '10013'
                AND t.kd_tarif = 'TU'
                AND LEFT(p.kd_klas, 2) = '61'
                AND t.tgl_berlaku = (
                    SELECT MAX(x.tgl_berlaku)
                    FROM tarif x
                    WHERE x.kd_unit = '10013'
                    AND x.kd_tarif = 'TU'
                    AND x.tgl_berlaku <= ?
                    AND x.kd_produk = t.kd_produk
                )
                AND (t.tgl_berakhir >= ? OR t.tgl_berakhir IS NULL)
                AND p.aktif = 1
                GROUP BY p.kd_produk, p.deskripsi
                ORDER BY p.deskripsi
            ", [$today, $today]);
        });
    }

    /**
     * 🔥 HELPER METHOD - Get Kamar Operasi
     */
    private function getKamarOperasi()
    {
        return Kamar::where('kd_unit', 71)
            ->where('AKTIF', 1)
            ->orderBy('nama_kamar')
            ->get(['no_kamar', 'nama_kamar']);
    }

    /**
     * 🔥 HELPER METHOD - Get Dokter
     */
    private function getDokters()
    {
        return DB::table('Dokter_Inap as di')
            ->join('Dokter as d', 'di.kd_dokter', '=', 'd.kd_dokter')
            ->select('d.kd_dokter', 'd.nama')
            ->where('di.Kd_Unit', 71)
            ->where('di.Dokter_luar', 0)
            ->where('d.STATUS', 1)
            ->orderBy('d.nama')
            ->get();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->where('kd_unit', 71);

            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($searchValue = $request->get('search')['value']) {
                        $query->where(function ($q) use ($searchValue) {
                            if (is_numeric($searchValue) && strlen($searchValue) == 4) {
                                $q->whereRaw("YEAR(kunjungan.tgl_masuk) = ?", [$searchValue]);
                            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $searchValue)) {
                                $q->whereRaw("CONVERT(varchar, kunjungan.tgl_masuk, 23) like ?", ["%{$searchValue}%"]);
                            } elseif (preg_match('/^\d{2}:\d{2}$/', $searchValue)) {
                                $q->whereRaw("FORMAT(kunjungan.jam_masuk, 'HH:mm') like ?", ["%{$searchValue}%"]);
                            } else {
                                $q->where('kunjungan.kd_pasien', 'like', "%{$searchValue}%")
                                    ->orWhereHas('pasien', function ($q) use ($searchValue) {
                                        $q->where('nama', 'like', "%{$searchValue}%")
                                            ->orWhere('alamat', 'like', "%{$searchValue}%");
                                    })
                                    ->orWhereHas('customer', function ($q) use ($searchValue) {
                                        $q->where('customer', 'like', "%{$searchValue}%");
                                    });
                            }
                        });
                    }
                })

                ->order(function ($query) {
                    $query->orderBy('tgl_masuk', 'desc')
                        ->orderBy('jam_masuk', 'desc');
                })
                ->editColumn('tgl_masuk', fn($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
                ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
                ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
                ->addColumn('jaminan', fn($row) =>  $row->customer->customer ?: '-')
                ->addColumn('status_pelayanan', fn($row) => '' ?: '-')
                ->addColumn('keterangan', fn($row) => '' ?: '-')
                ->addColumn('tindak_lanjut', fn($row) => '' ?: '-')
                ->addColumn('no_antrian', fn($row) => '' ?: '-')
                // Hitung umur dari tabel pasien
                ->addColumn('umur', function ($row) {
                    return $row->pasien && $row->pasien->tgl_lahir
                        ? Carbon::parse($row->pasien->tgl_lahir)->age . ''
                        : 'Tidak diketahui';
                })
                ->addColumn('profile', fn($row) => $row)
                ->addColumn('action', fn($row) => $row->kd_pasien)
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }

        $dokter = DokterPenunjang::with(['dokter', 'unit'])
            ->where('kd_unit', 71)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.operasi.index', compact('dokter'));
    }

    public function pendingOrder(Request $request)
    {
        if ($request->ajax()) {
            $data = OrderOK::with(['produk', 'kamar', 'dokter', 'jenisOperasi', 'spesialisasi', 'subSpesialisasi'])
                ->select([
                    'order_ok.*',
                    'p.nama as nama_pasien',
                    'p.tgl_lahir',
                    'p.jenis_kelamin',
                    'p.alamat',
                    'c.customer as jaminan',
                    'k.kd_pasien',
                    'u.nama_unit as unit_order'
                ])
                ->join('transaksi as t', function ($q) {
                    $q->on('order_ok.kd_kasir', '=', 't.kd_kasir');
                    $q->on('order_ok.no_transaksi', '=', 't.no_transaksi');
                })
                ->join('kunjungan as k', function ($q) {
                    $q->on('t.kd_pasien', '=', 'k.kd_pasien');
                    $q->on('t.kd_unit', '=', 'k.kd_unit');
                    $q->on('t.tgl_transaksi', '=', 'k.tgl_masuk');
                    $q->on('t.urut_masuk', '=', 'k.urut_masuk');
                })
                ->join('customer as c', 'order_ok.penjamin', '=', 'c.kd_customer')
                ->join('pasien as p', 't.kd_pasien', '=', 'p.kd_pasien')
                ->join('unit as u', 'order_ok.kd_kamar_order', '=', 'u.kd_unit')
                ->where('status', 0)
                ->where('batal', 0);

            return DataTables::of($data)
                ->order(function ($query) {
                    $query->orderBy('order_ok.tgl_jadwal', 'desc')
                        ->orderBy('order_ok.jam_op', 'desc');
                })
                ->addColumn('waktu_order', function ($row) {
                    $tglOrder = Carbon::parse($row->tgl_jadwal)->format('d M Y');
                    $jamOrder = date('H:i', strtotime($row->jam_op));
                    return "$tglOrder $jamOrder";
                })
                ->addColumn('umur', function ($row) {
                    return hitungUmur($row->tgl_lahir);
                })
                ->make(true);
        }

        return view('unit-pelayanan.operasi.pending-order');
    }

    public function terimaOrder(Request $request, $kd_kasir, $no_transaksi,  $tanggal_op, $jam_op)
    {
        $dataMedis = $this->baseService->getDataMedisbyTransaksi($kd_kasir, $no_transaksi);
        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan.');
        }

        $products = $this->getProducts();
        $kamarOperasi = $this->getKamarOperasi();
        $dokters = $this->getDokters();
        $dokterAnastesi = DokterAnastesi::with(['dokter:kd_dokter,nama_lengkap'])->where('aktif', 1)->get();

        $operasi = OrderOK::where('kd_kasir', $kd_kasir)->where('no_transaksi', $no_transaksi)
            ->whereDate('tgl_jadwal', $tanggal_op)
            ->where('jam_op', $jam_op)
            ->where('status', 0)
            ->first();

        return view('unit-pelayanan.operasi.pelayanan.order.terima.edit', compact('operasi', 'dataMedis', 'products', 'kamarOperasi', 'dokters', 'dokterAnastesi'));
    }

    private function mappingDataByKdKasir($kd_kasir)
    {
        $kd_kasir_ok = null;
        $asal_pasien = null;

        switch ($kd_kasir) {
            case '01':
                $kd_kasir_ok = '13';
                $asal_pasien = 1; // Rawat Jalan
                break;
            case '02':
                $kd_kasir_ok = '15';
                $asal_pasien = 2; // Rawat Inap
                break;
            case '06':
                $kd_kasir_ok = '14';
                $asal_pasien = 3; // IGD
                break;
        }

        return [
            'kd_kasir' => $kd_kasir_ok,
            'asal_pasien' => $asal_pasien
        ];
    }

    private function mappingDataUnitAsal($kd_kasir)
    {
        $asal_pasien = null;

        switch ($kd_kasir) {
            case '01':
                $asal_pasien = 0; // Rawat Jalan
                break;
            case '02':
                $asal_pasien = 2; // Rawat Inap
                break;
            case '06':
                $asal_pasien = 1; // IGD
                break;
        }

        return $asal_pasien;
    }

    private function getProductDetail($kd_produk)
    {
        $today = date('Y-m-d');

        return DB::select("
                SELECT
                    p.kd_produk,
                    p.deskripsi,
                    t.tarif,
                    t.tgl_berlaku
                FROM produk p
                INNER JOIN tarif t ON p.kd_produk = t.kd_produk
                INNER JOIN KLAS_PRODUK kp ON p.kd_klas = kp.kd_klas
                WHERE t.kd_unit = '10013'
                AND p.kd_produk = ?
                AND t.kd_tarif = 'TU'
                AND LEFT(p.kd_klas, 2) = '61'
                AND t.tgl_berlaku = (
                    SELECT MAX(x.tgl_berlaku)
                    FROM tarif x
                    WHERE x.kd_unit = '10013'
                    AND x.kd_tarif = 'TU'
                    AND x.tgl_berlaku <= ?
                    AND x.kd_produk = t.kd_produk
                )
                AND (t.tgl_berakhir >= ? OR t.tgl_berakhir IS NULL)
                AND p.aktif = 1
                ORDER BY p.deskripsi
            ", [$kd_produk, $today, $today]);
    }

    public function storeTerimaOrder(Request $request, $kd_kasir, $no_transaksi,  $tanggal_op, $jam_op)
    {

        DB::beginTransaction();
        try {

            $request->validate([
                'tanggal_registrasi' => 'required|date',
                'tanggal_jadwal' => 'required|date',
                'jam_operasi' => 'required',
                'jenis_tindakan' => 'required|string',
                'spesialisasi' => 'required|string',
                'kamar_operasi' => 'required|string',
                'dokter' => 'required|string',
                'dokter_anastesi' => 'required|string',
                'durasi' => 'required|numeric',
                'cito' => 'required|in:0,1',
                'diagnosa_medis' => 'required|string|max:500',
                'catatan' => 'nullable|string|max:1000',
            ]);


            $dataMedis = $this->baseService->getDataMedisbyTransaksi($kd_kasir, $no_transaksi);
            if (!$dataMedis) throw new Exception('Data medis tidak ditemukan.');

            $order = OrderOK::where('kd_kasir', $kd_kasir)->where('no_transaksi', $no_transaksi)
                ->whereDate('tgl_jadwal', $tanggal_op)
                ->where('jam_op', $jam_op)
                ->first();

            if ($order->status) throw new Exception('Order sudah diproses sebelumnya.');
            if (!$order) throw new Exception('Order tidak ditemukan.');

            // mapping data kd kasir
            $mappingData = $this->mappingDataByKdKasir($kd_kasir);
            $produkDetail = $this->getProductDetail($request->jenis_tindakan);

            if (empty($produkDetail)) throw new Exception('Detail produk tidak ditemukan.');

            // Get Produk
            $product = Produk::with(['klas:kd_klas,klasifikasi,parent'])
                ->where('kd_produk', $request->input('jenis_tindakan'))
                ->first(['kd_produk', 'deskripsi', 'kd_klas']);

            if (!$product) {
                throw new \Exception('Produk tidak ditemukan atau tidak valid!');
            }

            // Validasi produk punya klas
            if (!$product->klas) {
                throw new \Exception('Klasifikasi produk tidak ditemukan!');
            }

            // CEK PASIEN AKTIF ATAU TIDAK
            $inap = DB::table('pasien_inap as i')
                ->join('transaksi as t', function ($join) {
                    $join->on('i.kd_kasir', '=', 't.kd_kasir')
                        ->on('i.no_transaksi', '=', 't.no_transaksi');
                })
                ->join('kunjungan as k', function ($join) {
                    $join->on('t.kd_pasien', '=', 'k.kd_pasien')
                        ->on('t.tgl_transaksi', '=', 'k.tgl_masuk')
                        ->on('t.kd_unit', '=', 'k.kd_unit')
                        ->on('t.urut_masuk', '=', 'k.urut_masuk');
                })
                ->join('customer as c', 'k.kd_customer', '=', 'c.kd_customer')
                ->join('pasien as p', 't.kd_pasien', '=', 'p.kd_pasien')
                ->join('unit as un', 'i.kd_unit', '=', 'un.kd_unit')
                ->join('kamar as km', function ($join) {
                    $join->on('i.no_kamar', '=', 'km.no_kamar')
                        ->on('i.kd_unit', '=', 'km.kd_unit');
                })
                ->join('spesialisasi as sp', 'i.kd_spesial', '=', 'sp.kd_spesial')
                ->where('t.kd_kasir', $kd_kasir)
                ->where('t.no_transaksi', $no_transaksi)
                ->where('un.kd_bagian', 1)
                ->whereNull('t.tgl_co')
                ->whereNull('k.tgl_keluar')
                ->first();

            if (empty($inap)) throw new Exception('Pasien tidak aktif di rawat inap atau tidak memenuhi syarat untuk menerima order.');


            // CREATE OK_JADWAL
            // GENERATE NO URUT OK_JADWAL (delegated to model)
            $noUrutData = OkJadwal::generateNoUrut();

            OkJadwal::create([
                'tgl_op'     => Carbon::parse($request->tanggal_registrasi)->format('Y-m-d'),
                'jam_op'     => Carbon::parse($request->jam_operasi)->format('H:i:s'),
                'kd_unit'    => '71',
                'no_kamar'   => $request->kamar_operasi,
                'kd_sub_spc' => $request->sub_spesialisasi,
                'kd_spc'     => $request->spesialisasi,
                'kd_jenis_op' => $request->jenis_operasi,
                'kd_tindakan' => $request->jenis_tindakan,
                'durasi'     => $request->durasi,
                'tgl_jadwal' => Carbon::parse($request->tanggal_jadwal)->format('Y-m-d'),
                'status'     => 0,
                'kd_produk'  => $request->jenis_tindakan,
                'no_urut'    => $noUrutData,
                'cyto'       => $request->cito ?? 0,
            ]);

            // CREATE OK_JADWAL_PS
            OkJadwalPs::create([
                'tgl_op'     => Carbon::parse($request->tanggal_registrasi)->format('Y-m-d'),
                'jam_op'     => Carbon::parse($request->jam_operasi)->format('H:i:s'),
                'kd_pasien' => $dataMedis->kd_pasien,
                'kd_unit' => 71,
                'no_kamar'   => $request->kamar_operasi,
                'kd_asal_pasien' => 2,
                'status_pasien' => 0
            ]);

            // CREATE OK_JADWAL_PS
            OkJadwalDr::create([
                'tgl_op'     => Carbon::parse($request->tanggal_registrasi)->format('Y-m-d'),
                'jam_op'     => Carbon::parse($request->jam_operasi)->format('H:i:s'),
                'kd_dokter' => $request->dokter,
                'kd_unit' => 71,
                'kd_dok_anas' => $request->dokter_anastesi,
                'no_kamar'   => $request->kamar_operasi,
            ]);

            // Jaga-jaga
            // UPDATE Ordr_Mng_OK
            // SET tgl_op = '2025-10-06',
            // Jam_op = '1900-01-01 07:00',
            // kd_tindakan = '2846',
            // kd_jenis_op = '6105',
            // Kd_spesial = '4',
            // Kd_sub_Spc = '610504',
            // No_Kamar = '013',
            // Dilayani = '1'
            // WHERE
            // 	kd_pasien = '0-75-43-42'
            // 	AND dilayani = '0'

            // Update Order OK
            OrderOK::where('tgl_op', $tanggal_op)
                ->where('jam_op', $jam_op)
                ->where('kd_kasir', $order->kd_kasir)
                ->where('no_transaksi', $order->no_transaksi)
                ->update([
                    'tgl_op' => $request->input('tanggal_registrasi'),
                    'jam_op' => $request->input('jam_operasi'),
                    'kd_tindakan' => $request->input('jenis_tindakan'),
                    'kd_jenis_op' => $product->klas->parent, // ✅ Dari database
                    'durasi'     => $request->durasi,
                    'kd_sub_spc' => $product->kd_klas, // ✅ Dari database
                    'no_kamar' => $request->input('kamar_operasi'),
                    'status' => 1,
                ]);


            // Ambil urut masuk terakhir untuk pasien yang sudah ada
            $getLastUrutMasukPatientToday = Kunjungan::select('urut_masuk')
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->whereDate('tgl_masuk', $request->tanggal_registrasi)
                ->orderBy('urut_masuk', 'desc')
                ->first();

            $urut_masuk = !empty($getLastUrutMasukPatientToday) ? $getLastUrutMasukPatientToday->urut_masuk + 1 : 0;

            // Simpan ke tabel kunjungan
            $dataKunjungan = [
                'kd_pasien' => $dataMedis->kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_masuk' => $request->tanggal_registrasi,
                'urut_masuk' => $urut_masuk,
                'kd_dokter' => $request->dokter,
                'kd_rujukan' => 1,
                'kd_customer' => $dataMedis->kd_customer,
                'jam_masuk' => $jam_op,
                'keadaan_masuk' => 1,
                'keadaan_pasien' => 1,
                'cara_penerimaan' => 1,
                'asal_pasien' => 2,
                'cara_keluar' => 0,
                'baru' => 1,
                'shift' => 1,
                'karyawan' => 0,
                'kontrol' => 0,
            ];

            Kunjungan::create($dataKunjungan);


            // Simpan transaksi
            $lastTransaction = Transaksi::select('no_transaksi')
                ->where('kd_unit', $this->kdUnitDef_)
                ->where('kd_kasir', $mappingData['kd_kasir'])
                ->orderBy('no_transaksi', 'desc')
                ->first();

            if ($lastTransaction) {
                $lastTransactionNumber = (int) $lastTransaction->no_transaksi;
                $newTransactionNumber = $lastTransactionNumber + 1;
            } else {
                $newTransactionNumber = 1;
            }

            $formattedTransactionNumber = str_pad($newTransactionNumber, 7, '0', STR_PAD_LEFT);

            $dataTransaksi = [
                'kd_kasir' => $mappingData['kd_kasir'],
                'no_transaksi' => $formattedTransactionNumber,
                'kd_pasien' => $dataMedis->kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_transaksi' => $request->tanggal_registrasi,
                'urut_masuk' => $urut_masuk,
                'co_status' => 0,
                'ispay' => 0,
                'app' => 0,
                'lunas' => 0,
                'acc_dr' => 0,
                'jumlah_lama' => 0,
                'dilayani' => 0,
                'ordermng' => 0,
                'verified' => 0,
                'closeshift' => 0,
                'paid' => 0,
                'stats_dok' => 0
            ];

            Transaksi::create($dataTransaksi);

            // Simpan detail_transaksi
            $dataDetailTransaksi = [
                'kd_kasir' => $mappingData['kd_kasir'],
                'no_transaksi' => $formattedTransactionNumber,
                'urut' => 1,
                'tgl_transaksi' => $request->tanggal_registrasi,
                'kd_tarif' => 'TU',
                'kd_produk' => $produkDetail['kd_produk'],
                'kd_unit' => '10013',
                'tgl_berlaku' => $produkDetail['tgl_berlaku'],
                // 'charge' => 0,
                // 'adjust' => 0,
                // 'folio' => 'A',
                'qty' => 1,
                'harga' => $produkDetail['tarif'],
                'shift' => 1,
                'kd_unit_tr' => $this->kdUnitDef_,
                'cito' => $request->cito ?? 0,
                // 'js' => 0,
                // 'jp' => 0,
                'flag' => 0,
                // 'tag' => 0,
                // 'hrg_asli' => 0,
                // 'close_shift_status' => 0
            ];

            DetailTransaksi::create($dataDetailTransaksi);


            // SIMPAN DATA UNIT_ASAL
            $mappingUnitAsal = $this->mappingDataUnitAsal($kd_kasir);

            $dataUnitAsal = [
                'kd_kasir'      => $mappingData['kd_kasir'],
                'no_transaksi'  => $formattedTransactionNumber,
                'no_transaksi_asal' => $no_transaksi,
                'kd_kasir_asal'   => $kd_kasir,
                'id_asal'        => $mappingUnitAsal,
            ];

            UnitAsal::create($dataUnitAsal);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('unit-pelayanan.operasi.pending-order')->with('success', 'Order berhasil diterima.');
    }

    public function pelayanan($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->where('kd_unit', 71)
            ->where('kd_pasien', $kd_pasien)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.operasi.pelayanan.index', compact('dataMedis'));
    }

    public function productDetails(Request $request)
    {
        try {
            $kd_produk = $request->query('kd_produk');

            if (!$kd_produk) {
                return response()->json(['error' => 'kd_produk required'], 400);
            }

            // 1. Ambil produk dengan relasi klas
            $product = Produk::with(['klas:kd_klas,klasifikasi,parent'])
                ->where('kd_produk', $kd_produk)
                ->first(['kd_produk', 'deskripsi', 'kd_klas']);

            if (!$product) {
                return response()->json(['error' => 'Produk tidak ditemukan'], 404);
            }

            // 2. Jenis Operasi (dari parent) - AUTO SELECT ✅
            $jenisOperasi = [];
            $selectedJenisOperasi = null;

            if ($product->klas && $product->klas->parent) {
                $jenisOperasi = KlasProduk::where('kd_klas', $product->klas->parent)
                    ->get(['kd_klas', 'klasifikasi']);

                $selectedJenisOperasi = $product->klas->parent;
            }

            // 3. Sub Spesialisasi (dari kd_klas produk) - AUTO SELECT ✅
            $selectedSubSpesialisasi = $product->kd_klas;

            // Ambil SEMUA sub spesialisasi dari KLAS_PRODUK
            $subSpesialisasiList = KlasProduk::where('parent', $selectedJenisOperasi)
                ->orderBy('klasifikasi')
                ->get(['kd_klas', 'klasifikasi', 'parent']);

            // 4. Spesialisasi - TIDAK AUTO SELECT ❌
            $spesialisasiList = Spesialisasi::whereIn('kd_spesial', [1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 22, 23, 29])
                ->orderBy('spesialisasi')
                ->get(['kd_spesial', 'spesialisasi']);

            return response()->json([
                'product' => [
                    'kd_produk' => $product->kd_produk,
                    'deskripsi' => $product->deskripsi,
                    'kd_klas' => $product->kd_klas,
                    'parent' => $product->klas->parent,
                    'klas_nama' => $product->klas->klasifikasi,
                ],
                'jenisOperasi' => $jenisOperasi,
                'spesialisasi' => $spesialisasiList,
                'subSpesialisasi' => $subSpesialisasiList,
                'selected' => [
                    'jenis_operasi' => $selectedJenisOperasi,
                    'spesialisasi' => null,
                    'sub_spesialisasi' => $selectedSubSpesialisasi,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('productDetails error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

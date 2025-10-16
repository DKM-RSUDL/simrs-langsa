<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\DokterKlinik;
use App\Models\DokterPenunjang;
use App\Models\Kamar;
use App\Models\KlasProduk;
use App\Models\Kunjungan;
use App\Models\OrderOK;
use App\Models\Produk;
use App\Models\Spesialisasi;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class OperasiController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
        $this->baseService = new BaseService();
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
                ->where('status', 0);



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

        $operasi = OrderOK::where('kd_kasir', $kd_kasir)->where('no_transaksi', $no_transaksi)
            ->whereDate('tgl_jadwal', $tanggal_op)
            ->where('jam_op', $jam_op)
            ->first();

        return view('unit-pelayanan.operasi.pelayanan.order.terima.edit', compact('operasi', 'dataMedis', 'products', 'kamarOperasi', 'dokters'));
    }

    public function storeTerimaOrder(Request $request, $kd_kasir, $no_transaksi,  $tanggal_op, $jam_op)
    {
        dd($request->all());
        $order = OrderOK::where('kd_kasir', $kd_kasir)->where('no_transaksi', $no_transaksi)
            ->whereDate('tgl_jadwal', $tanggal_op)
            ->where('jam_op', $jam_op)
            ->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan.');
        }
        $order->status = 1; // Terima order
        $order->catatan = $request->catatan;
        $order->save();
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
                    'parent' => $product->klas->parent ?? null,
                    'klas_nama' => $product->klas->klasifikasi ?? null,
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

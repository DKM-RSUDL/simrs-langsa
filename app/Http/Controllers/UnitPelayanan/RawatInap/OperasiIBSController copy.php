<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Produk;
use App\Models\KlasProduk;
use App\Models\Spesialisasi;
use App\Models\RawatInap\OperasiIBS;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OperasiIBSController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
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

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $operasiIbs = OperasiIBS::with([
            'produk:kd_produk,deskripsi',
            'kamar:no_kamar,nama_kamar',
            'dokter:kd_dokter,nama',
            'jenisOperasi:kd_klas,klasifikasi',
            'spesialisasi:kd_spesial,spesialisasi',
            'subSpesialisasi:kd_klas,klasifikasi',
            'pasien:kd_pasien,nama'
        ])
            ->where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi-ibs.index', compact('dataMedis', 'operasiIbs'));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $products = $this->getProducts();
        $kamarOperasi = $this->getKamarOperasi();
        $dokters = $this->getDokters();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi-ibs.create', compact(
            'dataMedis',
            'kamarOperasi',
            'dokters',
            'products'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            $request->validate([
                'tanggal_registrasi' => 'required|date',
                'tanggal_jadwal' => 'required|date',
                'jam_operasi' => 'required',
                'jenis_tindakan' => 'required|string',
                'spesialisasi' => 'required|string',
                'kamar_operasi' => 'required|string',
                'dokter' => 'required|string',
                'diagnosa_medis' => 'required|string|max:500',
                'catatan' => 'nullable|string|max:1000',
            ]);

            // 🔥 AMBIL DATA DARI DATABASE - BUKAN DARI REQUEST!
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

            OperasiIBS::create([
                'tgl_op' => $request->input('tanggal_registrasi'),
                'jam_op' => $request->input('jam_operasi'),
                'tgl_jadwal' => $request->input('tanggal_jadwal'),
                'kd_unit' => $kd_unit,
                'no_kamar' => $request->input('kamar_operasi'),
                'kd_unit_kamar' => $nginap ? $nginap->kd_unit_kamar : null,
                'kd_kamar_order' => $nginap ? $nginap->kd_unit_kamar : null,
                'kd_sub_spc' => $product->kd_klas,
                'kd_spc' => $request->input('spesialisasi'),
                'kd_jenis_op' => $product->klas->parent,
                'status' => 0,
                'kd_tindakan' => '',
                'kd_produk' => $product->kd_produk, // ✅ Dari database
                'no_transaksi' => $dataMedis->no_transaksi,
                'kd_kasir' => $dataMedis->kd_kasir,
                'kd_pasien' => $kd_pasien,
                'kd_dokter' => $request->input('dokter'),
                'penjamin' => $dataMedis->customer,
                'batal' => 0,
                'user_create' => Auth::id(),
                'diagnosis' => $request->input('diagnosa_medis'),
                'catatan' => $request->input('catatan'),
            ]);

            DB::commit();

            return redirect()->route('rawat-inap.operasi-ibs.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Operasi (IBS) berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $operasi = OperasiIBS::where('tgl_op', $tgl_op)
            ->where('jam_op', $jam_op)
            ->where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->with([
                'produk:kd_produk,deskripsi',
                'kamar:no_kamar,nama_kamar',
                'dokter:kd_dokter,nama',
                'jenisOperasi:kd_klas,klasifikasi',
                'spesialisasi:kd_spesial,spesialisasi',
                'subSpesialisasi:kd_klas,klasifikasi',
                'pasien:kd_pasien,nama'
            ])
            ->firstOrFail();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi-ibs.show', compact('dataMedis', 'operasi'));
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $operasi = OperasiIBS::where('tgl_op', $tgl_op)
            ->where('jam_op', $jam_op)
            ->where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->with([
                'produk:kd_produk,deskripsi,kd_klas',
                'jenisOperasi:kd_klas,klasifikasi',
                'spesialisasi:kd_spesial,spesialisasi',
                'subSpesialisasi:kd_klas,klasifikasi'
            ])
            ->firstOrFail();

        $products = $this->getProducts();
        $kamarOperasi = $this->getKamarOperasi();
        $dokters = $this->getDokters();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi-ibs.edit', compact(
            'dataMedis',
            'kamarOperasi',
            'dokters',
            'products',
            'operasi'
        ));
    }


    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            $request->validate([
                'tanggal_registrasi' => 'required|date',
                'tanggal_jadwal' => 'required|date',
                'jam_operasi' => 'required',
                'jenis_tindakan' => 'required|string',
                'spesialisasi' => 'required|string',
                'kamar_operasi' => 'required|string',
                'dokter' => 'required|string',
                'diagnosa_medis' => 'required|string|max:500',
                'catatan' => 'nullable|string|max:1000',
            ]);

            // 🔥 AMBIL DATA DARI DATABASE - BUKAN DARI REQUEST!
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

            $updated = OperasiIBS::where('tgl_op', $tgl_op)
                ->where('jam_op', $jam_op)
                ->where('kd_kasir', $dataMedis->kd_kasir)
                ->where('no_transaksi', $dataMedis->no_transaksi)
                ->update([
                    'tgl_op' => $request->input('tanggal_registrasi'),
                    'jam_op' => $request->input('jam_operasi'),
                    'tgl_jadwal' => $request->input('tanggal_jadwal'),
                    'kd_unit' => $kd_unit,
                    'no_kamar' => $request->input('kamar_operasi'),
                    'kd_unit_kamar' => $request->input('kamar_operasi'),
                    'kd_sub_spc' => $product->kd_klas, // ✅ Dari database
                    'kd_spc' => $request->input('spesialisasi'), // User pilih manual
                    'kd_jenis_op' => $product->klas->parent, // ✅ Dari database
                    'kd_produk' => $product->kd_produk, // ✅ Dari database
                    'kd_pasien' => $kd_pasien,
                    'kd_dokter' => $request->input('dokter'),
                    'diagnosis' => $request->input('diagnosa_medis'),
                    'catatan' => $request->input('catatan'),
                    'user_edit' => Auth::id(),
                ]);

            if (!$updated) {
                throw new \Exception('Data Operasi (IBS) gagal diubah!');
            }

            DB::commit();

            return redirect()->route('rawat-inap.operasi-ibs.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Operasi (IBS) berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            OperasiIBS::where('tgl_op', $tgl_op)
                ->where('jam_op', $jam_op)
                ->where('kd_kasir', $dataMedis->kd_kasir)
                ->where('no_transaksi', $dataMedis->no_transaksi)
                ->delete();

            DB::commit();

            return back()->with('success', 'Data Operasi IBS berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * 🔥 PRODUCT DETAILS - ELOQUENT ONLY
     * Auto-select: Jenis Operasi ✅ & Sub Spesialisasi ✅
     * Manual select: Spesialisasi ❌
     */
    public function productDetails($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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

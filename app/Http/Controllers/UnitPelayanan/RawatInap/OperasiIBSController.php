<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\RawatInap\OperasiIBS;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class OperasiIBSController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $operasiIbs = OperasiIBS::with(['produk:kd_produk,deskripsi', 'kamar:no_kamar,nama_kamar', 'dokter:kd_dokter,nama', 'jenisOperasi', 'spesialisasi:kd_spesial,spesialisasi', 'subSpesialisasi:kd_sub_spc,sub_spesialisasi', 'pasien:kd_pasien,nama'])
            ->where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.operasi-ibs.index', compact('dataMedis', 'operasiIbs'));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        // HANYA ambil data yang TIDAK ditangani AJAX
        $kamarOperasi = DB::table('kamar')
            ->where('kd_unit', 71)
            ->where('AKTIF', 1)
            ->orderBy('nama_kamar')
            ->get();

        $dokters = DB::table('Dokter_Inap as di')
            ->join('Dokter as d', 'di.kd_dokter', '=', 'd.kd_dokter')
            ->select('d.kd_dokter', 'd.nama')
            ->where('di.Kd_Unit', 71)
            ->where('di.Dokter_luar', 0)
            ->where('d.STATUS', 1)
            ->orderBy('d.nama')
            ->get();

        $products = Cache::remember("products:unit:{$kd_unit}:klas:61", 60, function () use ($kd_unit) {
            return DB::table('produk')
                ->join('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
                ->where('tarif.kd_unit', $kd_unit)
                ->whereRaw('LEFT(produk.kd_klas, 2) = ?', ['61'])
                ->select('produk.kd_produk', 'produk.deskripsi')
                ->groupBy('produk.kd_produk', 'produk.deskripsi')
                ->orderBy('produk.deskripsi')
                ->get();
        });

        return view('unit-pelayanan.rawat-inap.pelayanan.operasi-ibs.create', compact(
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

            // dd($dataMedis);

            $request->validate([
                'tanggal_registrasi' => 'required|date',
                'tanggal_jadwal' => 'required|date',
                'jam_operasi' => 'required',
                'jenis_tindakan' => 'required|string',
                'jenis_operasi' => 'required|string',
                'spesialisasi' => 'required|string',
                'sub_spesialisasi' => 'required|string',
                'kamar_operasi' => 'required|string',
                'dokter' => 'required|string',
                'diagnosa_medis' => 'required|string|max:500',
                'catatan' => 'nullable|string|max:1000',
            ]);

            OperasiIBS::create([
                'tgl_op' => $request->input('tanggal_registrasi'),
                'jam_op' => $request->input('jam_operasi'),
                'tgl_jadwal' => $request->input('tanggal_jadwal'),
                'kd_unit' => $kd_unit,
                'no_kamar' => $request->input('kamar_operasi'),
                'kd_unit_kamar' => $request->input('kamar_operasi'),
                'kd_sub_spc' => $request->input('sub_spesialisasi'),
                'kd_spc' => $request->input('spesialisasi'),
                'kd_jenis_op' => $request->input('jenis_operasi'),
                'status' => 0,
                'kd_tindakan' => '',
                'kd_produk' => $request->input('jenis_tindakan'),
                'no_transaksi' => $dataMedis->no_transaksi,
                'kd_kasir' => $dataMedis->kd_kasir,
                'kd_pasien' => $kd_pasien,
                'kd_unit_kamar' => $request->input('kamar_operasi'),
                'kd_dokter' => $request->input('dokter'),
                'batal' => 0,
                'user_create' => Auth::id(),
                'diagnosis' => $request->input('diagnosa_medis'),
                'catatan' => $request->input('catatan'),
            ]);

            DB::commit();

            return redirect()->route('rawat-inap.operasi-ibs.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Operasi IBS berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function productDetails($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            // Ambil kd_produk dari query string
            $kd_produk = $request->query('kd_produk');

            if (!$kd_produk) {
                return response()->json(['error' => 'kd_produk required'], 400);
            }

            // 1. Ambil produk dengan kd_klas
            $product = DB::selectOne("SELECT kd_produk, deskripsi, kd_klas FROM produk WHERE kd_produk = ?", [$kd_produk]);

            if (!$product) {
                return response()->json(['error' => 'Produk tidak ditemukan'], 404);
            }

            $kd_klas = $product->kd_klas;

            // 2. Ambil klasifikasi dari klas_produk
            $klasProduk = DB::selectOne("SELECT klasifikasi, kd_klas, parent FROM klas_produk WHERE kd_klas = ?", [$kd_klas]);

            // 3. Ambil SEMUA jenis operasi
            $jenisOperasi = DB::select("SELECT kd_jenis_op, jenis_op FROM OK_JENIS_OP ORDER BY jenis_op");
            $selectedJenisOperasi = count($jenisOperasi) > 0 ? $jenisOperasi[0]->kd_jenis_op : null;

            // 4. Cari spesialisasi berdasarkan nama klasifikasi
            $selectedSpesialisasi = null;
            $subSpesialisasi = [];
            $selectedSubSpesialisasi = null;

            if ($klasProduk) {
                $klasifikasi = trim($klasProduk->klasifikasi);

                // Cari sub_spesialisasi yang namanya SAMA dengan klasifikasi
                $subSpc = DB::selectOne("
                SELECT kd_sub_spc, kd_spesial, sub_spesialisasi
                FROM SUB_SPESIALISASI
                WHERE sub_spesialisasi = ?
            ", [$klasifikasi]);

                if ($subSpc) {
                    // Dapat! Sekarang ambil spesialisasi-nya
                    $selectedSpesialisasi = $subSpc->kd_spesial;
                    $selectedSubSpesialisasi = $subSpc->kd_sub_spc;

                    // Ambil semua sub spesialisasi untuk spesialisasi ini
                    $subSpesialisasi = DB::select("
                    SELECT kd_sub_spc, kd_spesial, sub_spesialisasi
                    FROM SUB_SPESIALISASI
                    WHERE kd_spesial = ?
                    ORDER BY sub_spesialisasi
                ", [$selectedSpesialisasi]);
                }
            }

            // 5. Ambil SEMUA spesialisasi
            $spesialisasi = DB::select("
            SELECT kd_spesial, spesialisasi
            FROM Spesialisasi
            WHERE Kd_Spesial IN (1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,22,23,29)
            ORDER BY spesialisasi
        ");

            // 6. Kamar & Dokter
            $kamarOperasi = DB::select("SELECT * FROM kamar WHERE kd_unit = ? AND AKTIF = 1 ORDER BY nama_kamar", [$kd_unit]);
            $dokters = DB::select("
            SELECT d.kd_dokter, d.nama
            FROM Dokter_Inap di
            INNER JOIN Dokter d ON di.kd_dokter = d.kd_dokter
            WHERE di.Dokter_luar = 0 AND di.kd_unit = ? AND d.STATUS = 1
            ORDER BY d.nama
        ", [$kd_unit]);

            return response()->json([
                'product' => $product,
                'klasProduk' => $klasProduk,
                'jenisOperasi' => $jenisOperasi,
                'spesialisasi' => $spesialisasi,
                'subSpesialisasi' => $subSpesialisasi,
                'dokters' => $dokters,
                'kamarOperasi' => $kamarOperasi,
                'selected' => [
                    'jenis_operasi' => $selectedJenisOperasi,
                    'spesialisasi' => $selectedSpesialisasi,
                    'sub_spesialisasi' => $selectedSubSpesialisasi,
                    'dokter' => null,
                    'kamar' => null,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('productDetails error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSubSpesialisasi($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            $kd_spesial = $request->query('kd_spesial');

            if (!$kd_spesial) {
                return response()->json([]);
            }

            $subSpesialisasi = DB::select("
            SELECT KD_SUB_SPC, KD_SPESIAL, SUB_SPESIALISASI
            FROM SUB_SPESIALISASI
            WHERE KD_SPESIAL = ?
            ORDER BY SUB_SPESIALISASI
        ", [$kd_spesial]);

            return response()->json($subSpesialisasi);
        } catch (\Exception $e) {
            \Log::error('getSubSpesialisasi error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
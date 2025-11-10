<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\Kunjungan;
use App\Models\MrResep;
use App\Models\MrResepDtl;
use App\Models\RmeRekonsiliasiObat;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FarmasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    public function index($kd_pasien, $tgl_masuk)
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
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $riwayatObat = $this->getRiwayatObat($kd_pasien);
        $riwayatObatHariIni = $this->getRiwayatObatHariIni($kd_pasien);

        $riwayatObatHariIniPulang = DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->leftJoin('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->where('MR_RESEP.RESEP_PULANG', 1)
            ->select(
                'MR_RESEP.TGL_ORDER',
                'DOKTER.NAMA as NAMA_DOKTER',
                'MR_RESEP.ID_MRRESEP',
                'MR_RESEP.STATUS',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH',
                'MR_RESEPDTL.KET',
                'MR_RESEPDTL.JUMLAH_TAKARAN',
                'MR_RESEPDTL.SATUAN_TAKARAN',
                'APT_OBAT.NAMA_OBAT'
            )
            ->distinct()
            ->orderBy('MR_RESEP.TGL_ORDER', 'desc')
            ->get();

        // Ambil data rekonsiliasi obat
        $rekonsiliasiObat = $this->getRekonsiliasi($kd_pasien, $tgl_masuk, $dataMedis->urut_masuk);

        $dokters = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.index',
            compact('dataMedis', 'riwayatObat', 'riwayatObatHariIni', 'riwayatObatHariIniPulang', 'kd_pasien', 'tgl_masuk', 'dokters', 'rekonsiliasiObat')
        );
    }

    public function store($kd_pasien, $tgl_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi input
            $validatedData = $request->validate([
                'kd_dokter' => 'required',
                'tgl_order' => 'required|date_format:Y-m-d',
                'jam_order' => 'required',
                'cat_racikan' => 'nullable|string',
                'obat' => 'required|array|min:1',
                'obat.*.id' => 'required',
                'obat.*.frekuensi' => 'required',
                'obat.*.jumlah' => 'required|numeric|min:1',
                'obat.*.dosis' => 'required',
                'obat.*.sebelumSesudahMakan' => 'required',
                'obat.*.aturanTambahan' => 'nullable|string',
                'obat.*.satuan' => 'nullable',
            ]);

            $kunjungan = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_unit', 3)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();

            // Generate ID_MRRESEP
            $tglMasuk = Carbon::parse($kunjungan->tgl_masuk);
            $prefix = $tglMasuk->format('Ymd');
            $lastResep = MrResep::where('ID_MRRESEP', 'like', $prefix . '%')
                ->orderBy('ID_MRRESEP', 'desc')
                ->first();

            if ($lastResep) {
                $lastNumber = intval(substr($lastResep->ID_MRRESEP, -4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $ID_MRRESEP = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // Periksa apakah ID sudah ada (untuk keamanan tambahan)
            while (MrResep::where('ID_MRRESEP', $ID_MRRESEP)->exists()) {
                $newNumber++;
                $ID_MRRESEP = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            }

            // Simpan ke MR_RESEP
            $mrResep = new MrResep();
            $mrResep->KD_PASIEN = $kunjungan->kd_pasien;
            $mrResep->KD_UNIT = $kunjungan->kd_unit;
            $mrResep->TGL_MASUK = $kunjungan->tgl_masuk;
            $mrResep->URUT_MASUK = $kunjungan->urut_masuk;
            $mrResep->KD_DOKTER = $validatedData['kd_dokter'];
            $mrResep->ID_MRRESEP = $ID_MRRESEP;
            $mrResep->CAT_RACIKAN = $validatedData['cat_racikan'] ?? '';
            $mrResep->TGL_ORDER = $validatedData['tgl_order'];
            $mrResep->JAM_ORDER = $validatedData['jam_order'];
            $mrResep->STATUS = 0;
            $mrResep->DILAYANI = 0;
            $mrResep->STTS_TERIMA = 0;
            $mrResep->KRONIS = 0;
            $mrResep->PRB = 0;
            $mrResep->save();

            // Simpan detail resep ke MR_RESEPDTL
            foreach ($validatedData['obat'] as $index => $obat) {
                $mrResepDtl = new MrResepDtl();
                $mrResepDtl->ID_MRRESEP = $ID_MRRESEP;
                $mrResepDtl->URUT = $index + 1;
                $mrResepDtl->KD_PRD = $obat['id'];
                $mrResepDtl->CARA_PAKAI = $obat['frekuensi'] . ' , '  . $obat['sebelumSesudahMakan'];
                $mrResepDtl->JUMLAH = $obat['jumlah'];
                $mrResepDtl->JUMLAH_TAKARAN = $obat['dosis'];
                $mrResepDtl->SATUAN_TAKARAN = $obat['satuan'];
                $mrResepDtl->KD_DOKTER = $validatedData['kd_dokter'];
                $mrResepDtl->KET = $obat['aturanTambahan'] ?? '';
                $mrResepDtl->RACIKAN = 0;
                $mrResepDtl->VERIFIED = 1;
                $mrResepDtl->STATUS = 0;
                $mrResepDtl->save();
            }

            DB::commit();
            return response()->json(['message' => 'Resep berhasil disimpan', 'id_mrresep' => $ID_MRRESEP], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Terjadi kesalahan internal server', 'error' => $e->getMessage()], 500);
        }
    }

    public function storeEResepPulang($kd_pasien, $tgl_masuk, Request $request)
    {
        DB::beginTransaction();
        try {
            // Validasi input sesuai struktur tabel
            $validatedData = $request->validate([
                'kd_dokter' => 'required|max:3', // varchar(3)
                'tgl_order' => 'required|date', // datetime-local
                'cat_racikan' => 'nullable|string', // varchar(max)
                'obat' => 'required|array|min:1',
                'obat.*.id' => 'required|max:12', // Sesuaikan dengan MR_RESEPDTL
                'obat.*.frekuensi' => 'required|max:50',
                'obat.*.jumlah' => 'required|numeric|min:1',
                'obat.*.dosis' => 'required|max:50',
                'obat.*.sebelumSesudahMakan' => 'required|max:50',
                'obat.*.aturanTambahan' => 'nullable|string|max:255',
                'obat.*.satuan' => 'nullable|max:50',
            ]);

            // Konversi tgl_order ke format datetime
            $tglOrder = Carbon::parse($validatedData['tgl_order'])->format('Y-m-d H:i:s');
            // JAM_ORDER harus datetime penuh, gunakan TGL_ORDER untuk jam
            $jamOrder = $tglOrder;

            // Cari kunjungan
            $kunjungan = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien')
                    ->on('kunjungan.kd_unit', '=', 't.kd_unit')
                    ->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi')
                    ->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();

            if (!$kunjungan) {
                throw new \Exception('Data kunjungan tidak ditemukan.');
            }

            // Generate ID_MRRESEP (sebagai string)
            $tglMasuk = Carbon::parse($kunjungan->tgl_masuk);
            $prefix = $tglMasuk->format('Ymd');
            $lastResep = MrResep::where('ID_MRRESEP', 'like', $prefix . '%')
                ->orderBy('ID_MRRESEP', 'desc')
                ->first();

            $newNumber = $lastResep ? intval(substr($lastResep->ID_MRRESEP, -4)) + 1 : 1;
            $ID_MRRESEP = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // Periksa apakah ID sudah ada
            while (MrResep::where('ID_MRRESEP', $ID_MRRESEP)->exists()) {
                $newNumber++;
                $ID_MRRESEP = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            }

            // Simpan ke MR_RESEP
            $mrResep = MrResep::create([
                'KD_PASIEN' => $kunjungan->kd_pasien,
                'KD_UNIT' => $kunjungan->kd_unit,
                'TGL_MASUK' => $kunjungan->tgl_masuk,
                'URUT_MASUK' => $kunjungan->urut_masuk,
                'KD_DOKTER' => $validatedData['kd_dokter'],
                'ID_MRRESEP' => $ID_MRRESEP,
                'CAT_RACIKAN' => $validatedData['cat_racikan'] ?? null,
                'TGL_ORDER' => $tglOrder,
                'JAM_ORDER' => $jamOrder,
                'STATUS' => '0', // varchar(50)
                'DILAYANI' => 0, // tinyint
                'STTS_TERIMA' => '0', // varchar(50)
                'KRONIS' => '0', // varchar(2)
                'PRB' => '0', // varchar(2)
                'RESEP_PULANG' => 1,
            ]);

            // Simpan detail resep ke MR_RESEPDTL
            foreach ($validatedData['obat'] as $index => $obat) {
                $resepDtlData = [
                    'ID_MRRESEP' => $ID_MRRESEP,
                    'URUT' => $index + 1,
                    'KD_PRD' => $obat['id'],
                    'CARA_PAKAI' => $obat['frekuensi'] . ', ' . $obat['sebelumSesudahMakan'],
                    'JUMLAH' => $obat['jumlah'],
                    'JUMLAH_TAKARAN' => $obat['dosis'],
                    'SATUAN_TAKARAN' => $obat['satuan'],
                    'KD_DOKTER' => $validatedData['kd_dokter'],
                    'KET' => $obat['aturanTambahan'],
                    'STATUS' => '0',
                ];

                $mrResepDtl = new MrResepDtl();
                $mrResepDtl->ID_MRRESEP = $ID_MRRESEP;
                $mrResepDtl->URUT = $index + 1;
                $mrResepDtl->KD_PRD = $obat['id'];
                $mrResepDtl->CARA_PAKAI = $obat['frekuensi'] . ', ' . $obat['sebelumSesudahMakan'];
                $mrResepDtl->JUMLAH = $obat['jumlah'];
                $mrResepDtl->JUMLAH_TAKARAN = $obat['dosis'];
                $mrResepDtl->SATUAN_TAKARAN = $obat['satuan'];
                $mrResepDtl->KD_DOKTER = $validatedData['kd_dokter'];
                $mrResepDtl->KET = $obat['aturanTambahan'];
                $mrResepDtl->RACIKAN = 0;
                $mrResepDtl->VERIFIED = 1;
                $mrResepDtl->STATUS = 0;
                $mrResepDtl->save();
            }

            DB::commit();

            return to_route('gawat-darurat.farmasi.index', [
                $kd_pasien,
                date('Y-m-d', strtotime($tgl_masuk)),
            ])->with('success', 'Order Obat Pulang Berhasil disimpan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }


    // === E-Resep Pulang ===
    public function orderObatEResepPulang($kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $riwayatObat = $this->getRiwayatObat($kd_pasien);

        $dokters = Dokter::where('status', 1)->get();

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.tab-eresep-pulang.order-obat',
            compact('dataMedis', 'riwayatObat', 'kd_pasien', 'tgl_masuk', 'dokters')
        );
    }

    public function searchObat(Request $request)
    {
        $kdMilik  = 1;
        $limit    = 10;
        $term     = trim((string) $request->get('term', ''));
        $depo     = $request->get('depo', 'DP3'); // default DP3 for gawat darurat

        // Hindari query berat saat term kosong/terlalu pendek
        if ($term === '' || mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $cacheKey = 'gd_obat_search_' . md5(json_encode([$term, $depo, $kdMilik, $limit]));

        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }

        // Subquery: latest price per KD_PRD (mengambil HRG_BELI_OBT dari TGL_MASUK terbaru)
        $latestPriceSub = DB::table('DATA_BATCH as db')
            ->select('db.KD_PRD', 'db.HRG_BELI_OBT')
            ->whereRaw('db.TGL_MASUK = (SELECT MAX(TGL_MASUK) FROM DATA_BATCH WHERE KD_PRD = db.KD_PRD)');

        // Subquery: stok per KD_PRD pada depo tertentu (DP1/DPF/DP3), di-SUM agar 1 baris per produk
        $stokDepoSub = DB::table('APT_STOK_UNIT as su')
            ->select('su.KD_PRD', DB::raw('SUM(su.JML_STOK_APT) as total_stok'))
            ->where('su.KD_UNIT_FAR', $depo)
            ->groupBy('su.KD_PRD');

        // Query utama: hasil siap pakai
        $rows = DB::table('APT_OBAT')
            ->join('APT_PRODUK', 'APT_OBAT.KD_PRD', '=', 'APT_PRODUK.KD_PRD')
            ->join('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->leftJoinSub($latestPriceSub, 'latest_price', function ($join) {
                $join->on('APT_OBAT.KD_PRD', '=', 'latest_price.KD_PRD');
            })
            ->leftJoinSub($stokDepoSub, 'stok_depo', function ($join) {
                $join->on('APT_OBAT.KD_PRD', '=', 'stok_depo.KD_PRD');
            })
            ->where('APT_PRODUK.KD_MILIK', $kdMilik)
            ->where('APT_PRODUK.TAG_BERLAKU', 1)
            ->where(function ($q) use ($term) {
                $q->where('APT_OBAT.NAMA_OBAT', 'like', $term . '%')
                    ->orWhere('APT_OBAT.NAMA_OBAT', 'like', '% ' . $term . '%');
            })
            ->orderBy(DB::raw('COALESCE(stok_depo.total_stok, 0)'), 'desc')
            ->limit($limit)
            ->get([
                'APT_OBAT.KD_PRD as id',
                'APT_OBAT.NAMA_OBAT as text',
                'APT_SATUAN.SATUAN as satuan',
                DB::raw('COALESCE(latest_price.HRG_BELI_OBT, 0) as harga'),
                DB::raw('COALESCE(stok_depo.total_stok, 0) as stok'),
            ]);

        // Cache 5 menit
        Cache::put($cacheKey, $rows, now()->addMinutes(5));

        return response()->json($rows);
    }

    private function getRiwayatObat($kd_pasien)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->leftJoin('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->leftJoin(DB::raw('(SELECT KD_PRD, HRG_BELI_OBT
                           FROM DATA_BATCH AS db
                           WHERE TGL_MASUK = (
                               SELECT MAX(TGL_MASUK)
                               FROM DATA_BATCH
                               WHERE KD_PRD = db.KD_PRD
                           )) AS latest_price'), 'APT_OBAT.KD_PRD', '=', 'latest_price.KD_PRD')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->select(
                DB::raw('DISTINCT MR_RESEP.TGL_MASUK'),
                'MR_RESEP.KD_DOKTER',
                'DOKTER.NAMA as NAMA_DOKTER',
                'MR_RESEP.ID_MRRESEP as ID_MRRESEP',
                'MR_RESEP.CAT_RACIKAN',
                'MR_RESEP.TGL_ORDER',
                'MR_RESEP.STATUS',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH',
                'MR_RESEPDTL.KET',
                'MR_RESEPDTL.JUMLAH_TAKARAN',
                'MR_RESEPDTL.SATUAN_TAKARAN',
                'MR_RESEPDTL.KD_PRD',
                'APT_OBAT.NAMA_OBAT',
                'APT_SATUAN.SATUAN',
                'latest_price.HRG_BELI_OBT as HARGA'
            )
            ->orderBy('MR_RESEP.TGL_MASUK', 'desc')
            ->get();
    }

    private function getRiwayatObatHariIni($kd_pasien)
    {
        $today = Carbon::today()->toDateString();

        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->leftJoin('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->whereDate('MR_RESEP.TGL_ORDER', $today)
            ->select(
                'MR_RESEP.TGL_ORDER',
                'DOKTER.NAMA as NAMA_DOKTER',
                'MR_RESEP.ID_MRRESEP',
                'MR_RESEP.STATUS',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH',
                'MR_RESEPDTL.KET',
                'MR_RESEPDTL.JUMLAH_TAKARAN',
                'MR_RESEPDTL.SATUAN_TAKARAN',
                'APT_OBAT.NAMA_OBAT'
            )
            ->distinct()
            ->orderBy('MR_RESEP.TGL_ORDER', 'desc')
            ->get();
    }

    public function rekonsiliasiObat($kd_pasien, $tgl_masuk, Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'frekuensi' => 'required|string|max:255',
            'keterangan' => 'required|string|in:Sebelum Makan,Sesudah Makan,Saat Makan',
            'dosis' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|in:Lanjut aturan pakai sama,Lanjut aturan pakai berubah,Stop',
            'dibawa' => 'required|in:0,1',
            'perubahanpakai' => 'nullable|string|max:255',
            'kd_petugas' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Konversi tindak_lanjut_dpjp ke nilai numerik
            $tindakLanjutMap = [
                'Lanjut aturan pakai sama' => 1,
                'Lanjut aturan pakai berubah' => 2,
                'Stop' => 3,
            ];
            $tindakLanjutValue = $tindakLanjutMap[$request->tindak_lanjut];

            // Ambil kd_unit dan urut_masuk dari model Kunjungan
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
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data Kunjungan Tidak Ditemukan');
            }


            // Simpan data ke tabel RmeRekonsiliasiObat
            $rekonsiliasi = RmeRekonsiliasiObat::create([
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => date('Y-m-d H:i:s', strtotime($tgl_masuk)),
                'kd_unit' => 3,
                'urut_masuk' => $dataMedis->urut_masuk,
                'nama_obat' => $request->nama_obat,
                'frekuensi_obat' => $request->frekuensi,
                'keterangan_obat' => $request->keterangan,
                'dosis_obat' => $request->dosis,
                'cara_pemberian' => $request->cara_pemberian,
                'tindak_lanjut_dpjp' => $tindakLanjutValue,
                'obat_dibawa_pulang' => $request->dibawa,
                'perubahan_aturan_pakai' => $request->perubahanpakai,
                'user_created' => $request->kd_petugas,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rekonsiliasi obat berhasil disimpan',
                'id' => $rekonsiliasi->id,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan rekonsiliasi obat: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function rekonsiliasiObatDelete($kd_pasien, $tgl_masuk, Request $request)
    {

        try {
            $rekonsiliasi = RmeRekonsiliasiObat::where('id', $request->id)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->firstOrFail();

            $rekonsiliasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rekonsiliasi obat berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus rekonsiliasi obat: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function getRekonsiliasi($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return RmeRekonsiliasiObat::where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', 3)
            ->where('urut_masuk', $urut_masuk)
            ->get();
    }
}

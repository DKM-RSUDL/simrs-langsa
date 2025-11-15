<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\AptObat;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrResep;
use App\Models\MrResepDtl;
use App\Models\RmeRekonsiliasiObat;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class FarmasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
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

        if (! $dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $riwayatObat = $this->getRiwayatObat($kd_pasien);
        $riwayatObatHariIni = $this->getRiwayatObatHariIni($kd_pasien);
        $rekonsiliasiObat = $this->getRekonsiliasi($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $dokters = Dokter::all();

        return view(
            'unit-pelayanan.rawat-jalan.pelayanan.farmasi.index',
            compact('dataMedis', 'riwayatObat', 'riwayatObatHariIni', 'kd_pasien', 'tgl_masuk', 'dokters', 'rekonsiliasiObat', 'kd_unit')
        );
    }

    public function orderObat($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
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

        if (! $dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $riwayatObat = $this->getRiwayatObat($kd_pasien);

        $dokters = Dokter::all();

        return view(
            'unit-pelayanan.rawat-jalan.pelayanan.farmasi.order-obat',
            compact('dataMedis', 'riwayatObat', 'kd_pasien', 'tgl_masuk', 'dokters', 'kd_unit')
        );
    }


    function generateNoOrder($tglOrder)
    {
        // Pastikan $tglOrder berupa Carbon atau tanggal yang valid
        $tanggal = Carbon::parse($tglOrder)->format('Y-m-d');

        // Ambil data terakhir berdasarkan tanggal masuk
        $lastOrder = MrResep::whereDate('tgl_order', $tanggal)
            ->orderByDesc('id_mrresep')
            ->first();

        // Format dasar tanggal: yyyyMMdd
        $prefix = Carbon::parse($tglOrder)->format('Ymd');

        if (!$lastOrder) {
            // Jika belum ada data untuk tanggal tersebut
            $noOrder = $prefix . '0001';
        } else {
            // Ambil KD_ORDER terakhir
            $lastKdOrder = $lastOrder->id_mrresep;

            // Jika prefix berbeda dengan tanggal saat ini, reset ke 0001
            if (substr($lastKdOrder, 0, 8) !== $prefix) {
                $noOrder = $prefix . '0001';
            } else {
                // Tambah 1 dari KD_ORDER terakhir
                $noOrder = str_pad($lastKdOrder + 1, 12, '0', STR_PAD_LEFT);
            }
        }

        return $noOrder;
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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
            $tglOrder = Carbon::parse($validatedData['tgl_order'])->format('Y-m-d');
            // JAM_ORDER harus datetime penuh, gunakan TGL_ORDER untuk jam
            $jamOrder = Carbon::parse($validatedData['tgl_order'])->format('H:i:s');

            // Cari kunjungan
            $kunjungan = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien')
                    ->on('kunjungan.kd_unit', '=', 't.kd_unit')
                    ->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi')
                    ->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();

            if (! $kunjungan) {
                throw new \Exception('Data kunjungan tidak ditemukan.');
            }

            // Generate ID_MRRESEP (sebagai string)
            $ID_MRRESEP = $this->generateNoOrder($tglOrder);

            // Log data sebelum insert
            $resepData = [
                'KD_PASIEN' => $kunjungan->kd_pasien,
                'KD_UNIT' => $kunjungan->kd_unit,
                'TGL_MASUK' => $kunjungan->tgl_masuk,
                'URUT_MASUK' => $kunjungan->urut_masuk,
                'KD_DOKTER' => $validatedData['kd_dokter'],
                'ID_MRRESEP' => $ID_MRRESEP,
                'CAT_RACIKAN' => $validatedData['cat_racikan'] ?? '',
                'TGL_ORDER' => $tglOrder,
                'JAM_ORDER' => $jamOrder,
                'STATUS' => '0', // varchar(50)
                'DILAYANI' => 0, // tinyint
                'STTS_TERIMA' => '0', // varchar(50)
                'KRONIS' => '0', // varchar(2)
                'PRB' => '0', // varchar(2)
            ];
            Log::info('Data untuk insert MR_RESEP', $resepData);

            // Simpan ke MR_RESEP
            $mrResep = new MrResep;
            $mrResep->KD_PASIEN = $kunjungan->kd_pasien; // varchar(12)
            $mrResep->KD_UNIT = $kunjungan->kd_unit; // varchar(5)
            $mrResep->TGL_MASUK = $kunjungan->tgl_masuk; // datetime
            $mrResep->URUT_MASUK = $kunjungan->urut_masuk; // smallint
            $mrResep->KD_DOKTER = $validatedData['kd_dokter']; // varchar(3)
            $mrResep->ID_MRRESEP = $ID_MRRESEP; // Simpan sebagai string
            $mrResep->CAT_RACIKAN = $validatedData['cat_racikan'] ?? ''; // varchar(max)
            $mrResep->TGL_ORDER = $tglOrder; // datetime
            $mrResep->JAM_ORDER = $jamOrder; // datetime
            $mrResep->STATUS = '0'; // varchar(50)
            $mrResep->DILAYANI = 0; // tinyint
            $mrResep->STTS_TERIMA = '0'; // varchar(50)
            $mrResep->KRONIS = '0'; // varchar(2)
            $mrResep->PRB = '0'; // varchar(2)
            $mrResep->save();

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
                Log::info('Data untuk insert MR_RESEPDTL', $resepDtlData);

                $mrResepDtl = new MrResepDtl;
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

            // Panggil fungsi resume (sesuaikan jika ada)
            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            Log::info('Resep berhasil disimpan', ['id_mrresep' => $ID_MRRESEP]);

            DB::commit();

            return redirect()->route('rawat-jalan.farmasi.index', [
                $kd_unit,
                $kd_pasien,
                date('Y-m-d', strtotime($tgl_masuk)),
                $urut_masuk,
            ])->with('success', 'Resep berhasil disimpan dengan ID: ' . $ID_MRRESEP);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function searchObat(Request $request)
    {
        $kdMilik  = 1;
        $limit    = 10;
        $term     = trim((string) $request->get('term', ''));
        $depo     = $request->get('depo', 'DP1'); // default DP1 for rawat jalan

        // Hindari query berat saat term kosong/terlalu pendek
        if ($term === '' || mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $cacheKey = 'obat_search_' . md5(json_encode([$term, $depo, $kdMilik, $limit]));

        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }

        // Subquery: latest price per KD_PRD (mengambil HRG_BELI_OBT dari TGL_MASUK terbaru)
        $latestPriceSub = DB::table('DATA_BATCH as db')
            ->select('db.KD_PRD', 'db.HRG_BELI_OBT')
            ->whereRaw('db.TGL_MASUK = (SELECT MAX(TGL_MASUK) FROM DATA_BATCH WHERE KD_PRD = db.KD_PRD)');

        // Subquery: stok per KD_PRD pada depo tertentu (DP1/DPF/DP3), di-SUM agar 1 baris per produk
        $stokDepoSub = DB::table('APT_OBAT as a')
            ->join('APT_PRODUK as b', 'a.KD_PRD', '=', 'b.KD_PRD')
            ->join('APT_STOK_UNIT as c', function ($join) {
                $join->on('b.KD_PRD', '=', 'c.KD_PRD')
                    ->on('b.KD_MILIK', '=', 'c.KD_MILIK');
            })
            ->where('b.KD_MILIK', $kdMilik)
            ->where('b.TAG_BERLAKU', 1)
            ->where('c.KD_UNIT_FAR', $depo)
            ->where(function ($q) use ($term) {
                $q->where('a.NAMA_OBAT', 'like', $term . '%')
                    ->orWhere('a.NAMA_OBAT', 'like', '% ' . $term . '%');
            })
            ->groupBy('a.KD_PRD')
            ->select([
                'a.KD_PRD',
                DB::raw('SUM(c.JML_STOK_APT) as total_stok'),
            ]);

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

    public function createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (empty($resume)) {
            $resumeData = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'status' => 0,
            ];

            $newResume = RMEResume::create($resumeData);
            $newResume->refresh();

            // create resume detail
            $resumeDtlData = [
                'id_resume' => $newResume->id,
            ];

            RmeResumeDtl::create($resumeDtlData);
        } else {
            // get resume dtl
            $resumeDtl = RmeResumeDtl::where('id_resume', $resume->id)->first();
            $resumeDtlData = [
                'id_resume' => $resume->id,
            ];

            if (empty($resumeDtl)) {
                RmeResumeDtl::create($resumeDtlData);
            }
        }
    }

    private function getRekonsiliasi($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        return RmeRekonsiliasiObat::where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->get();
    }

    public function rekonsiliasiObat($kd_pasien, $kd_unit, $tgl_masuk, Request $request)
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
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();

            if (! $dataMedis) {
                abort(404, 'Data Kunjungan Tidak Ditemukan');
            }

            // Simpan data ke tabel RmeRekonsiliasiObat
            $rekonsiliasi = RmeRekonsiliasiObat::create([
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => date('Y-m-d H:i:s', strtotime($tgl_masuk)),
                'kd_unit' => $kd_unit,
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

    public function deleteRekonsiliasiObat($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk, Request $request)
    {
        $id = $request->input('id');
        $rekonsiliasi = RmeRekonsiliasiObat::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (! $rekonsiliasi) {
            return response()->json([
                'success' => false,
                'message' => 'Rekonsiliasi obat tidak ditemukan',
            ], 404);
        }

        $rekonsiliasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rekonsiliasi obat berhasil dihapus',
        ], 200);
    }
}

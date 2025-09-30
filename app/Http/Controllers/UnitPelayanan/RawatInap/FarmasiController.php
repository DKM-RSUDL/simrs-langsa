<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\AptObat;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrResep;
use App\Models\MrResepDtl;
use App\Models\RmeCatatanPemberianObat;
use App\Models\RmeRekonsiliasiObat;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FarmasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $riwayatObat = $this->getRiwayatObat($kd_pasien);
        $riwayatObatHariIni = $this->getRiwayatObatHariIni($kd_pasien);
        $riwayatCatatanObat = $this->getRiwayatCatatanPemberianObat($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $rekonsiliasiObat = $this->getRekonsiliasi($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        // dd($riwayatObatHariIni);

        $dokters = Dokter::where('status', 1)->get();

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.farmasi.index',
            compact('dataMedis', 'riwayatObat', 'riwayatObatHariIni', 'riwayatCatatanObat', 'kd_pasien', 'tgl_masuk', 'dokters', 'rekonsiliasiObat')
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

        if (!$dataMedis) {
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
            'unit-pelayanan.rawat-inap.pelayanan.farmasi.order-obat',
            compact('dataMedis', 'riwayatObat', 'kd_pasien', 'tgl_masuk', 'dokters', 'kd_unit')
        );
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
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.urut_masuk', $urut_masuk)
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

            // Log data sebelum insert
            $resepData = [
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
            ];

            // Simpan ke MR_RESEP
            $mrResep = new MrResep();
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

            // Panggil fungsi resume (sesuaikan jika ada)
            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            Log::info('Resep berhasil disimpan', ['id_mrresep' => $ID_MRRESEP]);

            DB::commit();

            return redirect()->route('rawat-inap.farmasi.index', [
                $kd_unit,
                $kd_pasien,
                date('Y-m-d', strtotime($tgl_masuk)),
                $urut_masuk
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
        $search = $request->get('term');
        $cacheKey = 'obat_search_' . md5($search);

        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }

        $obats = AptObat::join('APT_PRODUK', 'APT_OBAT.KD_PRD', '=', 'APT_PRODUK.KD_PRD')
            ->join('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->leftJoin(DB::raw('(SELECT KD_PRD, HRG_BELI_OBT
                           FROM DATA_BATCH AS db
                           WHERE TGL_MASUK = (
                               SELECT MAX(TGL_MASUK)
                               FROM DATA_BATCH
                               WHERE KD_PRD = db.KD_PRD
                           )) AS latest_price'), 'APT_OBAT.KD_PRD', '=', 'latest_price.KD_PRD')
            ->where(function ($query) use ($search) {
                // Optimize search conditions
                $query->where('APT_OBAT.nama_obat', 'LIKE', $search . '%')
                    ->orWhere('APT_OBAT.nama_obat', 'LIKE', '% ' . $search . '%');
            })
            ->select(
                'APT_OBAT.KD_PRD as id',
                'APT_OBAT.nama_obat as text',
                'latest_price.HRG_BELI_OBT as harga',
                'APT_SATUAN.SATUAN as satuan'
            )
            ->groupBy('APT_OBAT.KD_PRD', 'APT_OBAT.nama_obat', 'latest_price.HRG_BELI_OBT', 'APT_SATUAN.SATUAN')
            ->limit(10)
            ->get();

        // Simpan ke cache selama 5 menit
        Cache::put($cacheKey, $obats, now()->addMinutes(5));

        return response()->json($obats);
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
                'kd_pasien'     => $kd_pasien,
                'kd_unit'       => $kd_unit,
                'tgl_masuk'     => $tgl_masuk,
                'urut_masuk'    => $urut_masuk,
                'status'        => 0
            ];

            $newResume = RMEResume::create($resumeData);
            $newResume->refresh();

            // create resume detail
            $resumeDtlData = [
                'id_resume'     => $newResume->id
            ];

            RmeResumeDtl::create($resumeDtlData);
        } else {
            // get resume dtl
            $resumeDtl = RmeResumeDtl::where('id_resume', $resume->id)->first();
            $resumeDtlData = [
                'id_resume'     => $resume->id
            ];

            if (empty($resumeDtl)) RmeResumeDtl::create($resumeDtlData);
        }
    }

    public function catatanObat(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Validasi data
            $validatedData = $request->validate([
                'nama_obat' => 'required',
                'frekuensi' => 'required',
                'keterangan' => 'required',
                'dosis' => 'required',
                'satuan' => 'required',
                'tanggal' => 'required|date',
                'jam' => 'required',
                'catatan' => 'nullable',
                'is_validasi'   => 'required|in:0,1'
            ]);

            // Simpan ke tabel RmeCatatanPemberianObat
            $catatan = new RmeCatatanPemberianObat();
            $catatan->kd_pasien = $kd_pasien;
            $catatan->kd_unit = $kd_unit;
            $catatan->tgl_masuk = $tgl_masuk;
            $catatan->urut_masuk = $urut_masuk;
            $catatan->kd_petugas = Auth::user()->karyawan->kd_karyawan;
            $catatan->nama_obat = $validatedData['nama_obat'];
            $catatan->frekuensi = $validatedData['frekuensi'];
            $catatan->keterangan = $validatedData['keterangan'];
            $catatan->dosis = $validatedData['dosis'];
            $catatan->satuan = $validatedData['satuan'];
            $catatan->tanggal = $validatedData['tanggal'] . ' ' . $validatedData['jam'];
            $catatan->catatan = $validatedData['catatan'];
            $catatan->is_validasi = $validatedData['is_validasi'];
            $catatan->save();

            DB::commit();
            return back()->with('success', 'Catatan pemberian obat berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    private function getRiwayatCatatanPemberianObat($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        return RmeCatatanPemberianObat::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->with(['petugas', 'petugasValidasi'])
            ->select(
                'id',
                'kd_petugas',
                'nama_obat',
                'frekuensi',
                'dosis',
                'satuan',
                'keterangan',
                'freak',
                'tanggal',
                'catatan',
                'is_validasi',
                'petugas_validasi'
            )
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function hapusCatatanObat($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari record berdasarkan ID
            $catatan = RmeCatatanPemberianObat::find($id);

            if (!$catatan) {
                return response()->json([
                    'message' => 'Gagal menghapus catatan',
                    'error' => 'Catatan dengan ID ' . $id . ' tidak ditemukan'
                ], 404);
            }

            $catatan->delete();

            DB::commit();
            return response()->json(['message' => 'Catatan pemberian obat berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menghapus catatan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function validasiCatatanObat($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'catatan'   => 'required',
            ]);

            if ($validator->fails()) throw new Exception('Payload tidak valid !');

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

            if (empty($dataMedis)) throw new Exception('Kunjungan pasien tidak ditemukan !');

            $id = decrypt($request->catatan);
            $catatan = RmeCatatanPemberianObat::find($id);

            if (empty($catatan)) throw new Exception('CPO tidak ditemukan !');

            // update validasi
            $catatan->petugas_validasi = Auth::user()->karyawan->kd_karyawan;
            $catatan->save();

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'     => []
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'     => []
            ]);
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

            if (!$dataMedis) {
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

        if (!$rekonsiliasi) {
            return response()->json([
                'success' => false,
                'message' => 'Rekonsiliasi obat tidak ditemukan'
            ], 404);
        }

        $rekonsiliasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rekonsiliasi obat berhasil dihapus'
        ], 200);
    }
}

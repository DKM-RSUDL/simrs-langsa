<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\AptObat;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrResep;
use App\Models\MrResepDtl;
use App\Models\RmeCatatanPemberianObat;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FarmasiController extends Controller
{
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
        // dd($riwayatObatHariIni);

        $dokters = Dokter::all();

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.farmasi.index',
            compact('dataMedis', 'riwayatObat', 'riwayatObatHariIni', 'riwayatCatatanObat', 'kd_pasien', 'tgl_masuk', 'dokters')
        );
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.urut_masuk', $urut_masuk)
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
                $mrResepDtl->KET = $obat['aturanTambahan'];
                $mrResepDtl->RACIKAN = 0;
                $mrResepDtl->VERIFIED = 1;
                $mrResep->STATUS = 0;
                $mrResepDtl->save();
            }

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            DB::commit();
            return response()->json(['message' => 'Resep berhasil disimpan', 'id_mrresep' => $ID_MRRESEP], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Terjadi kesalahan internal server', 'error' => $e->getMessage()], 500);
        }
    }

    public function searchObat(Request $request)
    {
        $search = $request->get('term');
        $obats = AptObat::join('APT_PRODUK', 'APT_OBAT.KD_PRD', '=', 'APT_PRODUK.KD_PRD')
            ->join('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->leftJoin(DB::raw('(SELECT KD_PRD, HRG_BELI_OBT
                               FROM DATA_BATCH AS db
                               WHERE TGL_MASUK = (
                                   SELECT MAX(TGL_MASUK)
                                   FROM DATA_BATCH
                                   WHERE KD_PRD = db.KD_PRD
                               )) AS latest_price'), 'APT_OBAT.KD_PRD', '=', 'latest_price.KD_PRD')
            ->where('APT_OBAT.nama_obat', 'LIKE', '%' . $search . '%')
            ->select(
                'APT_OBAT.KD_PRD as id',
                'APT_OBAT.nama_obat as text',
                'latest_price.HRG_BELI_OBT as harga',
                'APT_SATUAN.SATUAN as satuan'
            )
            ->groupBy('APT_OBAT.KD_PRD', 'APT_OBAT.nama_obat', 'latest_price.HRG_BELI_OBT', 'APT_SATUAN.SATUAN')
            ->take(10)
            ->get();

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
        try {
            // Validasi data
            $validatedData = $request->validate([
                'kd_petugas' => 'required',
                'nama_obat' => 'required',
                'frekuensi' => 'required',
                'keterangan' => 'required',
                'dosis' => 'required',
                'satuan' => 'required',
                'tanggal' => 'required|date',
                'freak' => 'required',
                'jam' => 'required',
                'catatan' => 'nullable',
            ]);

            // Simpan ke tabel RmeCatatanPemberianObat
            $catatan = new RmeCatatanPemberianObat();
            $catatan->kd_pasien = $kd_pasien;
            $catatan->kd_unit = $kd_unit;
            $catatan->tgl_masuk = $tgl_masuk;
            $catatan->urut_masuk = $urut_masuk;
            $catatan->kd_petugas = $validatedData['kd_petugas'];
            $catatan->nama_obat = $validatedData['nama_obat'];
            $catatan->frekuensi = $validatedData['frekuensi'];
            $catatan->keterangan = $validatedData['keterangan'];
            $catatan->dosis = $validatedData['dosis'];
            $catatan->satuan = $validatedData['satuan'];
            $catatan->freak = $validatedData['freak'];
            $catatan->tanggal = $validatedData['tanggal'] . ' ' . $validatedData['jam'];
            $catatan->catatan = $validatedData['catatan'];
            $catatan->save();

            return response()->json(['message' => 'Catatan pemberian obat berhasil disimpan', 'id' => $catatan->id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan catatan', 'error' => $e->getMessage()], 500);
        }
    }

    private function getRiwayatCatatanPemberianObat($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        return RmeCatatanPemberianObat::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->with('petugas')
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
                'catatan'
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
}

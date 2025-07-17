<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat\StatusNyeri;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeEfekNyeri;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeSkalaFlacc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkalaFlaccController extends Controller
{

    private $kdUnit;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
        $this->kdUnit = 3; // Gawat Darurat
    }

    public function index(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnit)
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

        // Query data skala Flacc
        $query = RmeSkalaFlacc::with(['userCreated'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lokasi_nyeri', 'like', "%{$search}%");
            });
        }

        // Filter tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        $dataSkalaFlacc = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-flacc.index', compact(
            'dataMedis',
            'dataSkalaFlacc'
        ));
    }


    public function create(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $jenisnyeri = RmeJenisNyeri::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnit)
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


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-flacc.create', compact(
            'dataMedis',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'jenisnyeri',
            'frekuensinyeri',
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Simpan data assessment
            $dataFlacc = new RmeSkalaFlacc();
            $dataFlacc->kd_pasien = $kd_pasien;
            $dataFlacc->tgl_masuk = $tgl_masuk;
            $dataFlacc->kd_unit = $this->kdUnit;
            $dataFlacc->urut_masuk = $urut_masuk;

            // Data dasar
            $dataFlacc->tanggal_implementasi = $request->tanggal_implementasi;
            $dataFlacc->jam_implementasi = $request->jam_implementasi;
            $dataFlacc->pain_value = $request->pain_value;

            // Data FLACC Assessment
            $dataFlacc->face = $request->face;
            $dataFlacc->legs = $request->legs;
            $dataFlacc->activity = $request->activity;
            $dataFlacc->cry = $request->cry;
            $dataFlacc->consolability = $request->consolability;

            // Detail nyeri
            $dataFlacc->lokasi_nyeri = $request->lokasi_nyeri;
            $dataFlacc->durasi_nyeri = $request->durasi_nyeri;
            $dataFlacc->menjalar = $request->menjalar;
            $dataFlacc->menjalar_keterangan = $request->menjalar_keterangan;
            $dataFlacc->kualitas_nyeri = $request->kualitas_nyeri;
            $dataFlacc->faktor_pemberat = $request->faktor_pemberat;
            $dataFlacc->faktor_peringan = $request->faktor_peringan;
            $dataFlacc->efek_nyeri = $request->efek_nyeri;
            $dataFlacc->jenis_nyeri = $request->jenis_nyeri;
            $dataFlacc->frekuensi_nyeri = $request->frekuensi_nyeri;

            // Protokol Intervensi Nyeri Ringan (Skor 1-3)
            $dataFlacc->nr_kaji_ulang_8jam = $request->has('nr_kaji_ulang_8jam') ? 1 : 0;
            $dataFlacc->nr_edukasi_pasien = $request->has('nr_edukasi_pasien') ? 1 : 0;
            $dataFlacc->nr_teknik_relaksasi = $request->has('nr_teknik_relaksasi') ? 1 : 0;
            $dataFlacc->nr_posisi_nyaman = $request->has('nr_posisi_nyaman') ? 1 : 0;
            $dataFlacc->nr_nsaid = $request->has('nr_nsaid') ? 1 : 0;

            // Protokol Intervensi Nyeri Sedang (Skor 4-7)
            $dataFlacc->ns_beritahu_tim_nyeri = $request->has('ns_beritahu_tim_nyeri') ? 1 : 0;
            $dataFlacc->ns_rujuk_tim_nyeri = $request->has('ns_rujuk_tim_nyeri') ? 1 : 0;
            $dataFlacc->ns_kolaborasi_obat = $request->has('ns_kolaborasi_obat') ? 1 : 0;
            $dataFlacc->ns_teknik_relaksasi = $request->has('ns_teknik_relaksasi') ? 1 : 0;
            $dataFlacc->ns_posisi_nyaman = $request->has('ns_posisi_nyaman') ? 1 : 0;
            $dataFlacc->ns_edukasi_pasien = $request->has('ns_edukasi_pasien') ? 1 : 0;
            $dataFlacc->ns_kaji_ulang_2jam = $request->has('ns_kaji_ulang_2jam') ? 1 : 0;
            $dataFlacc->ns_konsultasi_tim = $request->has('ns_konsultasi_tim') ? 1 : 0;

            // Protokol Intervensi Nyeri Berat (Skor 8-10)
            $dataFlacc->nt_semua_langkah_sedang = $request->has('nt_semua_langkah_sedang') ? 1 : 0;
            $dataFlacc->nt_kaji_ulang_1jam = $request->has('nt_kaji_ulang_1jam') ? 1 : 0;

            $dataFlacc->user_created = Auth::id();

            $dataFlacc->save();

            DB::commit();

            return redirect()->route('status-nyeri.skala-flacc.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data Skala FLACC berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnit)
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

        // Ambil data skala CRIES untuk diedit
        $skalaFlacc = RmeSkalaFlacc::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->findOrFail($id);

        // Ambil data master untuk dropdown
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $jenisnyeri = RmeJenisNyeri::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-flacc.edit', compact(
            'dataMedis',
            'skalaFlacc',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'jenisnyeri',
            'frekuensinyeri'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Ambil data yang akan diupdate
            $dataFlacc = RmeSkalaFlacc::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->findOrFail($id);

            // Update data dasar
            $dataFlacc->tanggal_implementasi = $request->tanggal_implementasi;
            $dataFlacc->jam_implementasi = $request->jam_implementasi;
            $dataFlacc->pain_value = $request->pain_value;

            // Update data FLACC Assessment
            $dataFlacc->face = $request->face;
            $dataFlacc->legs = $request->legs;
            $dataFlacc->activity = $request->activity;
            $dataFlacc->cry = $request->cry;
            $dataFlacc->consolability = $request->consolability;

            // Update detail nyeri
            $dataFlacc->lokasi_nyeri = $request->lokasi_nyeri;
            $dataFlacc->durasi_nyeri = $request->durasi_nyeri;
            $dataFlacc->menjalar = $request->menjalar;
            $dataFlacc->menjalar_keterangan = $request->menjalar_keterangan;
            $dataFlacc->kualitas_nyeri = $request->kualitas_nyeri;
            $dataFlacc->faktor_pemberat = $request->faktor_pemberat;
            $dataFlacc->faktor_peringan = $request->faktor_peringan;
            $dataFlacc->efek_nyeri = $request->efek_nyeri;
            $dataFlacc->jenis_nyeri = $request->jenis_nyeri;
            $dataFlacc->frekuensi_nyeri = $request->frekuensi_nyeri;

            // Update Protokol Intervensi Nyeri Ringan (Skor 1-3)
            $dataFlacc->nr_kaji_ulang_8jam = $request->has('nr_kaji_ulang_8jam') ? 1 : 0;
            $dataFlacc->nr_edukasi_pasien = $request->has('nr_edukasi_pasien') ? 1 : 0;
            $dataFlacc->nr_teknik_relaksasi = $request->has('nr_teknik_relaksasi') ? 1 : 0;
            $dataFlacc->nr_posisi_nyaman = $request->has('nr_posisi_nyaman') ? 1 : 0;
            $dataFlacc->nr_nsaid = $request->has('nr_nsaid') ? 1 : 0;

            // Update Protokol Intervensi Nyeri Sedang (Skor 4-7)
            $dataFlacc->ns_beritahu_tim_nyeri = $request->has('ns_beritahu_tim_nyeri') ? 1 : 0;
            $dataFlacc->ns_rujuk_tim_nyeri = $request->has('ns_rujuk_tim_nyeri') ? 1 : 0;
            $dataFlacc->ns_kolaborasi_obat = $request->has('ns_kolaborasi_obat') ? 1 : 0;
            $dataFlacc->ns_teknik_relaksasi = $request->has('ns_teknik_relaksasi') ? 1 : 0;
            $dataFlacc->ns_posisi_nyaman = $request->has('ns_posisi_nyaman') ? 1 : 0;
            $dataFlacc->ns_edukasi_pasien = $request->has('ns_edukasi_pasien') ? 1 : 0;
            $dataFlacc->ns_kaji_ulang_2jam = $request->has('ns_kaji_ulang_2jam') ? 1 : 0;
            $dataFlacc->ns_konsultasi_tim = $request->has('ns_konsultasi_tim') ? 1 : 0;

            // Update Protokol Intervensi Nyeri Berat (Skor 8-10)
            $dataFlacc->nt_semua_langkah_sedang = $request->has('nt_semua_langkah_sedang') ? 1 : 0;
            $dataFlacc->nt_kaji_ulang_1jam = $request->has('nt_kaji_ulang_1jam') ? 1 : 0;

            $dataFlacc->user_updated = Auth::id();

            $dataFlacc->save();

            DB::commit();

            return redirect()->route('status-nyeri.skala-flacc.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data Skala FLACC berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnit)
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

        // Ambil data skala FLACC dengan relasi
        $skalaFlacc = RmeSkalaFlacc::with([
            'userCreated',
            'kualitasNyeri',
            'faktorPemberat',
            'faktorPeringan',
            'efekNyeri',
            'jenisNyeri',
            'frekuensiNyeri'
        ])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-flacc.show', compact(
            'dataMedis',
            'skalaFlacc'
        ));
    }

    public function destroy(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data yang akan dihapus
            $skalaFlacc = RmeSkalaFlacc::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->findOrFail($id);

            // Simpan informasi untuk response
            $tanggalImplementasi = \Carbon\Carbon::parse($skalaFlacc->tanggal_implementasi)->format('d-m-Y');
            $jamImplementasi = $skalaFlacc->jam_implementasi;

            // Hapus data
            $skalaFlacc->delete();

            DB::commit();

            return redirect()->route('status-nyeri.skala-flacc.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', "Data Skala FLACC tanggal {$tanggalImplementasi} jam {$jamImplementasi} berhasil dihapus!");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}

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
use App\Models\RmeSkalaCries;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkalaCriesController extends Controller
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

        // Query data skala CRIES
        $query = RmeSkalaCries::with(['userCreated'])
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

        $dataSkalaCries = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-cries.index', compact(
            'dataMedis',
            'dataSkalaCries'
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


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-cries.create', compact(
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
            $dataCries = new RmeSkalaCries();
            $dataCries->kd_pasien = $kd_pasien;
            $dataCries->tgl_masuk = $tgl_masuk;
            $dataCries->kd_unit = $this->kdUnit;
            $dataCries->urut_masuk = $urut_masuk;

            // Data dasar
            $dataCries->tanggal_implementasi = $request->tanggal_implementasi;
            $dataCries->jam_implementasi = $request->jam_implementasi;
            $dataCries->pain_value = $request->pain_value;

            // Data CRIES Assessment
            $dataCries->crying = $request->crying;
            $dataCries->requires = $request->requires;
            $dataCries->increased = $request->increased;
            $dataCries->expression = $request->expression;
            $dataCries->sleepless = $request->sleepless;

            // Detail nyeri
            $dataCries->lokasi_nyeri = $request->lokasi_nyeri;
            $dataCries->durasi_nyeri = $request->durasi_nyeri;
            $dataCries->menjalar = $request->menjalar;
            $dataCries->menjalar_keterangan = $request->menjalar_keterangan;
            $dataCries->kualitas_nyeri = $request->kualitas_nyeri;
            $dataCries->faktor_pemberat = $request->faktor_pemberat;
            $dataCries->faktor_peringan = $request->faktor_peringan;
            $dataCries->efek_nyeri = $request->efek_nyeri;
            $dataCries->jenis_nyeri = $request->jenis_nyeri;
            $dataCries->frekuensi_nyeri = $request->frekuensi_nyeri;

            // Protokol Intervensi Nyeri Ringan (Skor 1-3)
            $dataCries->nr_kaji_ulang_8jam = $request->has('nr_kaji_ulang_8jam') ? 1 : 0;
            $dataCries->nr_edukasi_pasien = $request->has('nr_edukasi_pasien') ? 1 : 0;
            $dataCries->nr_teknik_relaksasi = $request->has('nr_teknik_relaksasi') ? 1 : 0;
            $dataCries->nr_posisi_nyaman = $request->has('nr_posisi_nyaman') ? 1 : 0;
            $dataCries->nr_nsaid = $request->has('nr_nsaid') ? 1 : 0;

            // Protokol Intervensi Nyeri Sedang (Skor 4-7)
            $dataCries->ns_beritahu_tim_nyeri = $request->has('ns_beritahu_tim_nyeri') ? 1 : 0;
            $dataCries->ns_rujuk_tim_nyeri = $request->has('ns_rujuk_tim_nyeri') ? 1 : 0;
            $dataCries->ns_kolaborasi_obat = $request->has('ns_kolaborasi_obat') ? 1 : 0;
            $dataCries->ns_teknik_relaksasi = $request->has('ns_teknik_relaksasi') ? 1 : 0;
            $dataCries->ns_posisi_nyaman = $request->has('ns_posisi_nyaman') ? 1 : 0;
            $dataCries->ns_edukasi_pasien = $request->has('ns_edukasi_pasien') ? 1 : 0;
            $dataCries->ns_kaji_ulang_2jam = $request->has('ns_kaji_ulang_2jam') ? 1 : 0;
            $dataCries->ns_konsultasi_tim = $request->has('ns_konsultasi_tim') ? 1 : 0;

            // Protokol Intervensi Nyeri Berat (Skor 8-10)
            $dataCries->nt_semua_langkah_sedang = $request->has('nt_semua_langkah_sedang') ? 1 : 0;
            $dataCries->nt_kaji_ulang_1jam = $request->has('nt_kaji_ulang_1jam') ? 1 : 0;

            $dataCries->user_created = Auth::id();

            $dataCries->save();

            DB::commit();

            return redirect()->route('status-nyeri.skala-cries.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data Skala CRIES berhasil disimpan!');
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
        $skalaCries = RmeSkalaCries::where('kd_pasien', $kd_pasien)
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

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-cries.edit', compact(
            'dataMedis',
            'skalaCries',
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
            $dataCries = RmeSkalaCries::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->findOrFail($id);

            // Update data dasar
            $dataCries->tanggal_implementasi = $request->tanggal_implementasi;
            $dataCries->jam_implementasi = $request->jam_implementasi;
            $dataCries->pain_value = $request->pain_value;

            // Update data CRIES Assessment
            $dataCries->crying = $request->crying;
            $dataCries->requires = $request->requires;
            $dataCries->increased = $request->increased;
            $dataCries->expression = $request->expression;
            $dataCries->sleepless = $request->sleepless;

            // Update detail nyeri
            $dataCries->lokasi_nyeri = $request->lokasi_nyeri;
            $dataCries->durasi_nyeri = $request->durasi_nyeri;
            $dataCries->menjalar = $request->menjalar;
            $dataCries->menjalar_keterangan = $request->menjalar_keterangan;
            $dataCries->kualitas_nyeri = $request->kualitas_nyeri;
            $dataCries->faktor_pemberat = $request->faktor_pemberat;
            $dataCries->faktor_peringan = $request->faktor_peringan;
            $dataCries->efek_nyeri = $request->efek_nyeri;
            $dataCries->jenis_nyeri = $request->jenis_nyeri;
            $dataCries->frekuensi_nyeri = $request->frekuensi_nyeri;

            // Update Protokol Intervensi Nyeri Ringan (Skor 1-3)
            $dataCries->nr_kaji_ulang_8jam = $request->has('nr_kaji_ulang_8jam') ? 1 : 0;
            $dataCries->nr_edukasi_pasien = $request->has('nr_edukasi_pasien') ? 1 : 0;
            $dataCries->nr_teknik_relaksasi = $request->has('nr_teknik_relaksasi') ? 1 : 0;
            $dataCries->nr_posisi_nyaman = $request->has('nr_posisi_nyaman') ? 1 : 0;
            $dataCries->nr_nsaid = $request->has('nr_nsaid') ? 1 : 0;

            // Update Protokol Intervensi Nyeri Sedang (Skor 4-7)
            $dataCries->ns_beritahu_tim_nyeri = $request->has('ns_beritahu_tim_nyeri') ? 1 : 0;
            $dataCries->ns_rujuk_tim_nyeri = $request->has('ns_rujuk_tim_nyeri') ? 1 : 0;
            $dataCries->ns_kolaborasi_obat = $request->has('ns_kolaborasi_obat') ? 1 : 0;
            $dataCries->ns_teknik_relaksasi = $request->has('ns_teknik_relaksasi') ? 1 : 0;
            $dataCries->ns_posisi_nyaman = $request->has('ns_posisi_nyaman') ? 1 : 0;
            $dataCries->ns_edukasi_pasien = $request->has('ns_edukasi_pasien') ? 1 : 0;
            $dataCries->ns_kaji_ulang_2jam = $request->has('ns_kaji_ulang_2jam') ? 1 : 0;
            $dataCries->ns_konsultasi_tim = $request->has('ns_konsultasi_tim') ? 1 : 0;

            // Update Protokol Intervensi Nyeri Berat (Skor 8-10)
            $dataCries->nt_semua_langkah_sedang = $request->has('nt_semua_langkah_sedang') ? 1 : 0;
            $dataCries->nt_kaji_ulang_1jam = $request->has('nt_kaji_ulang_1jam') ? 1 : 0;

            $dataCries->user_updated = Auth::id();

            $dataCries->save();

            DB::commit();

            return redirect()->route('status-nyeri.skala-cries.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data Skala CRIES berhasil diupdate!');
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

        // Ambil data skala CRIES dengan relasi
        $skalaCries = RmeSkalaCries::with([
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

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-cries.show', compact(
            'dataMedis',
            'skalaCries'
        ));
    }

    public function destroy(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data yang akan dihapus
            $skalaCries = RmeSkalaCries::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->findOrFail($id);

            // Simpan informasi untuk response
            $tanggalImplementasi = \Carbon\Carbon::parse($skalaCries->tanggal_implementasi)->format('d-m-Y');
            $jamImplementasi = $skalaCries->jam_implementasi;

            // Hapus data
            $skalaCries->delete();

            DB::commit();

            return redirect()->route('status-nyeri.skala-cries.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', "Data Skala CRIES tanggal {$tanggalImplementasi} jam {$jamImplementasi} berhasil dihapus!");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}

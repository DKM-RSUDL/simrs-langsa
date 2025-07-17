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
use App\Models\RmeSkalaNumerik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkalaNumerikController extends Controller
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

        // Query data skala numerik
        $query = RmeSkalaNumerik::with(['userCreated'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lokasi_nyeri', 'like', "%{$search}%")
                    ->orWhere('pain_scale_type', 'like', "%{$search}%");
            });
        }

        // Filter tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        $dataSkalaNumerik = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-numerik.index', compact(
            'dataMedis',
            'dataSkalaNumerik'
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


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-numerik.create', compact(
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
            $dataNumerik = new RmeSkalaNumerik();
            $dataNumerik->kd_pasien = $kd_pasien;
            $dataNumerik->tgl_masuk = $tgl_masuk;
            $dataNumerik->kd_unit = $this->kdUnit;
            $dataNumerik->urut_masuk = $urut_masuk;

            // Data dasar
            $dataNumerik->tanggal_implementasi = $request->tanggal_implementasi;
            $dataNumerik->jam_implementasi = $request->jam_implementasi;
            $dataNumerik->pain_scale_type = $request->pain_scale_type;
            $dataNumerik->pain_value = $request->pain_value;

            // Detail nyeri
            $dataNumerik->lokasi_nyeri = $request->lokasi_nyeri;
            $dataNumerik->durasi_nyeri = $request->durasi_nyeri;
            $dataNumerik->menjalar = $request->menjalar;
            $dataNumerik->menjalar_keterangan = $request->menjalar_keterangan;
            $dataNumerik->kualitas_nyeri = $request->kualitas_nyeri;
            $dataNumerik->faktor_pemberat = $request->faktor_pemberat;
            $dataNumerik->faktor_peringan = $request->faktor_peringan;
            $dataNumerik->efek_nyeri = $request->efek_nyeri;
            $dataNumerik->jenis_nyeri = $request->jenis_nyeri;
            $dataNumerik->frekuensi_nyeri = $request->frekuensi_nyeri;

            // Protokol Intervensi Nyeri Ringan (Skor 1-3)
            $dataNumerik->nr_kaji_ulang_8jam = $request->has('nr_kaji_ulang_8jam') ? 1 : 0;
            $dataNumerik->nr_edukasi_pasien = $request->has('nr_edukasi_pasien') ? 1 : 0;
            $dataNumerik->nr_teknik_relaksasi = $request->has('nr_teknik_relaksasi') ? 1 : 0;
            $dataNumerik->nr_posisi_nyaman = $request->has('nr_posisi_nyaman') ? 1 : 0;
            $dataNumerik->nr_nsaid = $request->has('nr_nsaid') ? 1 : 0;

            // Protokol Intervensi Nyeri Sedang (Skor 4-6)
            $dataNumerik->ns_beritahu_tim_nyeri = $request->has('ns_beritahu_tim_nyeri') ? 1 : 0;
            $dataNumerik->ns_rujuk_tim_nyeri = $request->has('ns_rujuk_tim_nyeri') ? 1 : 0;
            $dataNumerik->ns_kolaborasi_obat = $request->has('ns_kolaborasi_obat') ? 1 : 0;
            $dataNumerik->ns_teknik_relaksasi = $request->has('ns_teknik_relaksasi') ? 1 : 0;
            $dataNumerik->ns_posisi_nyaman = $request->has('ns_posisi_nyaman') ? 1 : 0;
            $dataNumerik->ns_edukasi_pasien = $request->has('ns_edukasi_pasien') ? 1 : 0;
            $dataNumerik->ns_kaji_ulang_2jam = $request->has('ns_kaji_ulang_2jam') ? 1 : 0;
            $dataNumerik->ns_konsultasi_tim = $request->has('ns_konsultasi_tim') ? 1 : 0;

            // Protokol Intervensi Nyeri Tinggi (Skor 7-10)
            $dataNumerik->nt_semua_langkah_sedang = $request->has('nt_semua_langkah_sedang') ? 1 : 0;
            $dataNumerik->nt_kaji_ulang_1jam = $request->has('nt_kaji_ulang_1jam') ? 1 : 0;

            $dataNumerik->user_created = Auth::id();

            $dataNumerik->save();


            DB::commit();

            return redirect()->route('status-nyeri.skala-numerik.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data Skala Geriatri berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
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

        // Ambil data skala numerik dengan relasi
        $skalaNumerik = RmeSkalaNumerik::with([
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

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-numerik.show', compact(
            'dataMedis',
            'skalaNumerik'
        ));
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

        // Ambil data skala numerik untuk diedit
        $skalaNumerik = RmeSkalaNumerik::where('kd_pasien', $kd_pasien)
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

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.status-nyeri.skala-numerik.edit', compact(
            'dataMedis',
            'skalaNumerik',
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
            $dataNumerik = RmeSkalaNumerik::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->findOrFail($id);

            // Update data dasar
            $dataNumerik->tanggal_implementasi = $request->tanggal_implementasi;
            $dataNumerik->jam_implementasi = $request->jam_implementasi;
            $dataNumerik->pain_scale_type = $request->pain_scale_type;
            $dataNumerik->pain_value = $request->pain_value;

            // Update detail nyeri
            $dataNumerik->lokasi_nyeri = $request->lokasi_nyeri;
            $dataNumerik->durasi_nyeri = $request->durasi_nyeri;
            $dataNumerik->menjalar = $request->menjalar;
            $dataNumerik->menjalar_keterangan = $request->menjalar_keterangan;
            $dataNumerik->kualitas_nyeri = $request->kualitas_nyeri;
            $dataNumerik->faktor_pemberat = $request->faktor_pemberat;
            $dataNumerik->faktor_peringan = $request->faktor_peringan;
            $dataNumerik->efek_nyeri = $request->efek_nyeri;
            $dataNumerik->jenis_nyeri = $request->jenis_nyeri;
            $dataNumerik->frekuensi_nyeri = $request->frekuensi_nyeri;

            // Update Protokol Intervensi Nyeri Ringan (Skor 1-3)
            $dataNumerik->nr_kaji_ulang_8jam = $request->has('nr_kaji_ulang_8jam') ? 1 : 0;
            $dataNumerik->nr_edukasi_pasien = $request->has('nr_edukasi_pasien') ? 1 : 0;
            $dataNumerik->nr_teknik_relaksasi = $request->has('nr_teknik_relaksasi') ? 1 : 0;
            $dataNumerik->nr_posisi_nyaman = $request->has('nr_posisi_nyaman') ? 1 : 0;
            $dataNumerik->nr_nsaid = $request->has('nr_nsaid') ? 1 : 0;

            // Update Protokol Intervensi Nyeri Sedang (Skor 4-6)
            $dataNumerik->ns_beritahu_tim_nyeri = $request->has('ns_beritahu_tim_nyeri') ? 1 : 0;
            $dataNumerik->ns_rujuk_tim_nyeri = $request->has('ns_rujuk_tim_nyeri') ? 1 : 0;
            $dataNumerik->ns_kolaborasi_obat = $request->has('ns_kolaborasi_obat') ? 1 : 0;
            $dataNumerik->ns_teknik_relaksasi = $request->has('ns_teknik_relaksasi') ? 1 : 0;
            $dataNumerik->ns_posisi_nyaman = $request->has('ns_posisi_nyaman') ? 1 : 0;
            $dataNumerik->ns_edukasi_pasien = $request->has('ns_edukasi_pasien') ? 1 : 0;
            $dataNumerik->ns_kaji_ulang_2jam = $request->has('ns_kaji_ulang_2jam') ? 1 : 0;
            $dataNumerik->ns_konsultasi_tim = $request->has('ns_konsultasi_tim') ? 1 : 0;

            // Update Protokol Intervensi Nyeri Tinggi (Skor 7-10)
            $dataNumerik->nt_semua_langkah_sedang = $request->has('nt_semua_langkah_sedang') ? 1 : 0;
            $dataNumerik->nt_kaji_ulang_1jam = $request->has('nt_kaji_ulang_1jam') ? 1 : 0;

            $dataNumerik->user_updated = Auth::id();

            $dataNumerik->save();

            DB::commit();

            return redirect()->route('status-nyeri.skala-numerik.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data Skala Numerik berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data yang akan dihapus
            $skalaNumerik = RmeSkalaNumerik::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->findOrFail($id);

            // Simpan informasi untuk response
            $tanggalImplementasi = \Carbon\Carbon::parse($skalaNumerik->tanggal_implementasi)->format('d-m-Y');
            $jamImplementasi = $skalaNumerik->jam_implementasi;

            // Hapus data
            $skalaNumerik->delete();

            DB::commit();

            return redirect()->route('status-nyeri.skala-numerik.index', [
                'kd_unit' => $this->kdUnit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', "Data Skala Numerik tanggal {$tanggalImplementasi} jam {$jamImplementasi} berhasil dihapus!");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}

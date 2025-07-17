<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeResikoDecubitus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResikoDecubitusController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function checkDuplicate(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $exists = RmeResikoDecubitus::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('tanggal_implementasi', $request->tanggal_implementasi)
            ->where('shift', $request->shift)
            ->where('hari_ke', $request->hari_ke)
            ->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Data dengan tanggal, shift, dan hari ke ini sudah ada!' : 'Data dapat disimpan'
        ]);
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Query data Resiko Decubitus dengan filter
        $query = RmeResikoDecubitus::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('shift', 'like', '%' . $search . '%')
                    ->orWhere('kategori_risiko', 'like', '%' . $search . '%')
                    ->orWhere('norton_total_score', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        // Ambil data dengan pagination dan relasi user
        $dataDecubitus = $query->with(['userCreated', 'userUpdated'])
            ->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10);

        // Append query parameters untuk pagination
        $dataDecubitus->appends($request->query());

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-decubitus.index', compact(
            'dataMedis',
            'dataDecubitus'
        ));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-decubitus.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Validasi duplikasi berdasarkan tanggal, shift, dan hari ke
            $existingData = RmeResikoDecubitus::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal_implementasi', $request->tanggal_implementasi)
                ->where('shift', $request->shift)
                ->where('hari_ke', $request->hari_ke)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ', shift ' . ucfirst($request->shift) . ', dan hari ke-' . $request->hari_ke . ' sudah ada!')
                    ->withInput();
            }

            // Simpan data assessment
            $dataDecubitus = new RmeResikoDecubitus();
            $dataDecubitus->kd_pasien = $kd_pasien;
            $dataDecubitus->tgl_masuk = $tgl_masuk;
            $dataDecubitus->kd_unit = $kd_unit;
            $dataDecubitus->urut_masuk = $urut_masuk;

            // Data dasar
            $dataDecubitus->tanggal_implementasi = $request->tanggal_implementasi;
            $dataDecubitus->jam_implementasi = $request->jam_implementasi;
            $dataDecubitus->hari_ke = $request->hari_ke;
            $dataDecubitus->shift = $request->shift;

            // Data Norton Assessment
            $dataDecubitus->kondisi_fisik = $request->kondisi_fisik;
            $dataDecubitus->status_mental = $request->status_mental;
            $dataDecubitus->aktivitas = $request->aktivitas;
            $dataDecubitus->mobilitas = $request->mobilitas;
            $dataDecubitus->inkontinensia = $request->inkontinensia;
            $dataDecubitus->norton_total_score = $request->norton_total_score;

            if ($request->norton_total_score >= 16 && $request->norton_total_score <= 20) {
                $dataDecubitus->kategori_risiko = 'Risiko Rendah';
            } elseif ($request->norton_total_score >= 12 && $request->norton_total_score <= 15) {
                $dataDecubitus->kategori_risiko = 'Risiko Sedang';
            } elseif ($request->norton_total_score < 12) {
                $dataDecubitus->kategori_risiko = 'Risiko Tinggi';
            }

            // Protokol Intervensi Risiko Rendah (Skor 16-20)
            $dataDecubitus->rr_kaji_ulang = $request->has('rr_kaji_ulang') ? 1 : 0;
            $dataDecubitus->rr_cek_control = $request->has('rr_cek_control') ? 1 : 0;
            $dataDecubitus->rr_kebersihan = $request->has('rr_kebersihan') ? 1 : 0;
            $dataDecubitus->rr_beritahu_pasien = $request->has('rr_beritahu_pasien') ? 1 : 0;
            $dataDecubitus->rr_monitor_nutrisi = $request->has('rr_monitor_nutrisi') ? 1 : 0;
            $dataDecubitus->rr_edukasi = $request->has('rr_edukasi') ? 1 : 0;

            // Protokol Intervensi Risiko Sedang (Skor 12-15)
            $dataDecubitus->rs_kaji_ulang = $request->has('rs_kaji_ulang') ? 1 : 0;
            $dataDecubitus->rs_ubah_posisi = $request->has('rs_ubah_posisi') ? 1 : 0;
            $dataDecubitus->rs_motivasi = $request->has('rs_motivasi') ? 1 : 0;
            $dataDecubitus->rs_lotion = $request->has('rs_lotion') ? 1 : 0;
            $dataDecubitus->rs_lindungi_area = $request->has('rs_lindungi_area') ? 1 : 0;
            $dataDecubitus->rs_alat_penyangga = $request->has('rs_alat_penyangga') ? 1 : 0;
            $dataDecubitus->rs_cegah_gesekan = $request->has('rs_cegah_gesekan') ? 1 : 0;
            $dataDecubitus->rs_nutrisi = $request->has('rs_nutrisi') ? 1 : 0;
            $dataDecubitus->rs_keringkan = $request->has('rs_keringkan') ? 1 : 0;
            $dataDecubitus->rs_edukasi = $request->has('rs_edukasi') ? 1 : 0;
            $dataDecubitus->rs_libatkan_keluarga = $request->has('rs_libatkan_keluarga') ? 1 : 0;

            // Protokol Intervensi Risiko Tinggi (Skor < 12)
            $dataDecubitus->rt_kaji_ulang = $request->has('rt_kaji_ulang') ? 1 : 0;
            $dataDecubitus->rt_ubah_posisi = $request->has('rt_ubah_posisi') ? 1 : 0;
            $dataDecubitus->rt_motivasi = $request->has('rt_motivasi') ? 1 : 0;
            $dataDecubitus->rt_lotion = $request->has('rt_lotion') ? 1 : 0;
            $dataDecubitus->rt_lindungi_area = $request->has('rt_lindungi_area') ? 1 : 0;
            $dataDecubitus->rt_alat_penyangga = $request->has('rt_alat_penyangga') ? 1 : 0;
            $dataDecubitus->rt_cegah_gesekan = $request->has('rt_cegah_gesekan') ? 1 : 0;
            $dataDecubitus->rt_nutrisi = $request->has('rt_nutrisi') ? 1 : 0;
            $dataDecubitus->rt_keringkan = $request->has('rt_keringkan') ? 1 : 0;
            $dataDecubitus->rt_posisi_miring = $request->has('rt_posisi_miring') ? 1 : 0;
            $dataDecubitus->rt_matras_khusus = $request->has('rt_matras_khusus') ? 1 : 0;
            $dataDecubitus->rt_edukasi = $request->has('rt_edukasi') ? 1 : 0;
            $dataDecubitus->rt_libatkan_keluarga = $request->has('rt_libatkan_keluarga') ? 1 : 0;

            $dataDecubitus->user_created = Auth::id();
            $dataDecubitus->save();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-decubitus.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Pengkajian Resiko Decubitus berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Ambil data Resiko Decubitus berdasarkan ID
        $dataDecubitus = RmeResikoDecubitus::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$dataDecubitus) {
            abort(404, 'Data Resiko Decubitus tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-decubitus.edit', compact(
            'dataMedis',
            'dataDecubitus'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Ambil data yang akan diupdate
            $dataDecubitus = RmeResikoDecubitus::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataDecubitus) {
                return back()->with('error', 'Data tidak ditemukan!')
                    ->withInput();
            }

            // Validasi duplikasi tanggal, shift, dan hari ke (kecuali data sendiri)
            $existingData = RmeResikoDecubitus::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal_implementasi', $request->tanggal_implementasi)
                ->where('shift', $request->shift)
                ->where('hari_ke', $request->hari_ke)
                ->where('id', '!=', $id)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ', shift ' . ucfirst($request->shift) . ', dan hari ke-' . $request->hari_ke . ' sudah ada!')
                    ->withInput();
            }

            // Update data dasar
            $dataDecubitus->tanggal_implementasi = $request->tanggal_implementasi;
            $dataDecubitus->jam_implementasi = $request->jam_implementasi;
            $dataDecubitus->hari_ke = $request->hari_ke;
            $dataDecubitus->shift = $request->shift;

            // Update Data Norton Assessment
            $dataDecubitus->kondisi_fisik = $request->kondisi_fisik;
            $dataDecubitus->status_mental = $request->status_mental;
            $dataDecubitus->aktivitas = $request->aktivitas;
            $dataDecubitus->mobilitas = $request->mobilitas;
            $dataDecubitus->inkontinensia = $request->inkontinensia;
            $dataDecubitus->norton_total_score = $request->norton_total_score;

            if ($request->norton_total_score >= 16 && $request->norton_total_score <= 20) {
                $dataDecubitus->kategori_risiko = 'Risiko Rendah';
            } elseif ($request->norton_total_score >= 12 && $request->norton_total_score <= 15) {
                $dataDecubitus->kategori_risiko = 'Risiko Sedang';
            } elseif ($request->norton_total_score < 12) {
                $dataDecubitus->kategori_risiko = 'Risiko Tinggi';
            }

            // Reset semua intervensi ke 0 terlebih dahulu
            $dataDecubitus->rr_kaji_ulang = 0;
            $dataDecubitus->rr_cek_control = 0;
            $dataDecubitus->rr_kebersihan = 0;
            $dataDecubitus->rr_beritahu_pasien = 0;
            $dataDecubitus->rr_monitor_nutrisi = 0;
            $dataDecubitus->rr_edukasi = 0;
            $dataDecubitus->rs_kaji_ulang = 0;
            $dataDecubitus->rs_ubah_posisi = 0;
            $dataDecubitus->rs_motivasi = 0;
            $dataDecubitus->rs_lotion = 0;
            $dataDecubitus->rs_lindungi_area = 0;
            $dataDecubitus->rs_alat_penyangga = 0;
            $dataDecubitus->rs_cegah_gesekan = 0;
            $dataDecubitus->rs_nutrisi = 0;
            $dataDecubitus->rs_keringkan = 0;
            $dataDecubitus->rs_edukasi = 0;
            $dataDecubitus->rs_libatkan_keluarga = 0;
            $dataDecubitus->rt_kaji_ulang = 0;
            $dataDecubitus->rt_ubah_posisi = 0;
            $dataDecubitus->rt_motivasi = 0;
            $dataDecubitus->rt_lotion = 0;
            $dataDecubitus->rt_lindungi_area = 0;
            $dataDecubitus->rt_alat_penyangga = 0;
            $dataDecubitus->rt_cegah_gesekan = 0;
            $dataDecubitus->rt_nutrisi = 0;
            $dataDecubitus->rt_keringkan = 0;
            $dataDecubitus->rt_posisi_miring = 0;
            $dataDecubitus->rt_matras_khusus = 0;
            $dataDecubitus->rt_edukasi = 0;
            $dataDecubitus->rt_libatkan_keluarga = 0;

            // Update Protokol Intervensi berdasarkan kategori risiko
            if ($dataDecubitus->kategori_risiko == 'Risiko Rendah') {
                $dataDecubitus->rr_kaji_ulang = $request->has('rr_kaji_ulang') ? 1 : 0;
                $dataDecubitus->rr_cek_control = $request->has('rr_cek_control') ? 1 : 0;
                $dataDecubitus->rr_kebersihan = $request->has('rr_kebersihan') ? 1 : 0;
                $dataDecubitus->rr_beritahu_pasien = $request->has('rr_beritahu_pasien') ? 1 : 0;
                $dataDecubitus->rr_monitor_nutrisi = $request->has('rr_monitor_nutrisi') ? 1 : 0;
                $dataDecubitus->rr_edukasi = $request->has('rr_edukasi') ? 1 : 0;
            } elseif ($dataDecubitus->kategori_risiko == 'Risiko Sedang') {
                $dataDecubitus->rs_kaji_ulang = $request->has('rs_kaji_ulang') ? 1 : 0;
                $dataDecubitus->rs_ubah_posisi = $request->has('rs_ubah_posisi') ? 1 : 0;
                $dataDecubitus->rs_motivasi = $request->has('rs_motivasi') ? 1 : 0;
                $dataDecubitus->rs_lotion = $request->has('rs_lotion') ? 1 : 0;
                $dataDecubitus->rs_lindungi_area = $request->has('rs_lindungi_area') ? 1 : 0;
                $dataDecubitus->rs_alat_penyangga = $request->has('rs_alat_penyangga') ? 1 : 0;
                $dataDecubitus->rs_cegah_gesekan = $request->has('rs_cegah_gesekan') ? 1 : 0;
                $dataDecubitus->rs_nutrisi = $request->has('rs_nutrisi') ? 1 : 0;
                $dataDecubitus->rs_keringkan = $request->has('rs_keringkan') ? 1 : 0;
                $dataDecubitus->rs_edukasi = $request->has('rs_edukasi') ? 1 : 0;
                $dataDecubitus->rs_libatkan_keluarga = $request->has('rs_libatkan_keluarga') ? 1 : 0;
            } elseif ($dataDecubitus->kategori_risiko == 'Risiko Tinggi') {
                $dataDecubitus->rt_kaji_ulang = $request->has('rt_kaji_ulang') ? 1 : 0;
                $dataDecubitus->rt_ubah_posisi = $request->has('rt_ubah_posisi') ? 1 : 0;
                $dataDecubitus->rt_motivasi = $request->has('rt_motivasi') ? 1 : 0;
                $dataDecubitus->rt_lotion = $request->has('rt_lotion') ? 1 : 0;
                $dataDecubitus->rt_lindungi_area = $request->has('rt_lindungi_area') ? 1 : 0;
                $dataDecubitus->rt_alat_penyangga = $request->has('rt_alat_penyangga') ? 1 : 0;
                $dataDecubitus->rt_cegah_gesekan = $request->has('rt_cegah_gesekan') ? 1 : 0;
                $dataDecubitus->rt_nutrisi = $request->has('rt_nutrisi') ? 1 : 0;
                $dataDecubitus->rt_keringkan = $request->has('rt_keringkan') ? 1 : 0;
                $dataDecubitus->rt_posisi_miring = $request->has('rt_posisi_miring') ? 1 : 0;
                $dataDecubitus->rt_matras_khusus = $request->has('rt_matras_khusus') ? 1 : 0;
                $dataDecubitus->rt_edukasi = $request->has('rt_edukasi') ? 1 : 0;
                $dataDecubitus->rt_libatkan_keluarga = $request->has('rt_libatkan_keluarga') ? 1 : 0;
            }

            // Update user yang mengupdate dan timestamp
            $dataDecubitus->user_updated = Auth::id();

            $dataDecubitus->save();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-decubitus.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Pengkajian Resiko Decubitus berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data decubitus berdasarkan ID
        $dataDecubitus = RmeResikoDecubitus::with('userCreated')
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$dataDecubitus) {
            abort(404, 'Data Resiko Decubitus tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-decubitus.show', compact(
            'dataMedis',
            'dataDecubitus'
        ));
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id) 
    {
        DB::beginTransaction();

        try {
            // Cari data yang akan dihapus
            $dataDecubitus = RmeResikoDecubitus::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataDecubitus) {
                return back()->with('error', 'Data tidak ditemukan!');
            }

            // Hapus data
            $dataDecubitus->delete();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-decubitus.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Resiko Decubitus berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}

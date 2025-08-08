<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmePneumoniaPsi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PneumoniaPsiController extends Controller
{
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

        // Get PSI data with filters
        $query = RmePneumoniaPsi::with(['userCreated'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('rekomendasi_perawatan', 'like', '%' . $search . '%')
                    ->orWhere('kriteria_tambahan', 'like', '%' . $search . '%')
                    ->orWhere('total_skor', 'like', '%' . $search . '%')
                    ->orWhereHas('userCreated', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Apply date range filter
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        $dataPsi = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.pneumonia-psi.index', compact(
            'dataMedis',
            'dataPsi'
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        return view('unit-pelayanan.rawat-inap.pelayanan.pneumonia-psi.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $dataPsi = new RmePneumoniaPsi();
            $dataPsi->kd_pasien = $kd_pasien;
            $dataPsi->tgl_masuk = $tgl_masuk;
            $dataPsi->kd_unit = $kd_unit;
            $dataPsi->urut_masuk = $urut_masuk;

            // Basic information
            $dataPsi->tanggal_implementasi = $request->tanggal_implementasi;
            $dataPsi->jam_implementasi = $request->jam_implementasi;

            // Demographic factors
            $dataPsi->gender_age = $request->gender_age;
            $dataPsi->umur_laki = $request->gender_age == 'male' ? $request->umur_laki : null;
            $dataPsi->umur_perempuan = $request->gender_age == 'female' ? $request->umur_perempuan : null;
            $dataPsi->panti_werdha = $request->has('panti_werdha') ? 1 : 0;

            // Comorbid conditions
            $dataPsi->keganasan = $request->has('keganasan') ? 1 : 0;
            $dataPsi->penyakit_hati = $request->has('penyakit_hati') ? 1 : 0;
            $dataPsi->jantung_kongestif = $request->has('jantung_kongestif') ? 1 : 0;
            $dataPsi->serebrovaskular = $request->has('serebrovaskular') ? 1 : 0;
            $dataPsi->penyakit_ginjal = $request->has('penyakit_ginjal') ? 1 : 0;

            // Physical examination
            $dataPsi->gangguan_kesadaran = $request->has('gangguan_kesadaran') ? 1 : 0;
            $dataPsi->frekuensi_nafas = $request->has('frekuensi_nafas') ? 1 : 0;
            $dataPsi->tekanan_sistolik = $request->has('tekanan_sistolik') ? 1 : 0;
            $dataPsi->suhu_tubuh = $request->has('suhu_tubuh') ? 1 : 0;
            $dataPsi->frekuensi_nadi = $request->has('frekuensi_nadi') ? 1 : 0;

            // Laboratory results
            $dataPsi->ph_rendah = $request->has('ph_rendah') ? 1 : 0;
            $dataPsi->ureum_tinggi = $request->has('ureum_tinggi') ? 1 : 0;
            $dataPsi->natrium_rendah = $request->has('natrium_rendah') ? 1 : 0;
            $dataPsi->glukosa_tinggi = $request->has('glukosa_tinggi') ? 1 : 0;
            $dataPsi->hematokrit_rendah = $request->has('hematokrit_rendah') ? 1 : 0;
            $dataPsi->o2_rendah = $request->has('o2_rendah') ? 1 : 0;
            $dataPsi->efusi_pleura = $request->has('efusi_pleura') ? 1 : 0;

            // Total score and interpretation
            $dataPsi->total_skor = $request->total_skor;
            $dataPsi->rekomendasi_perawatan = $request->rekomendasi_perawatan;
            $dataPsi->kriteria_tambahan = $request->kriteria_tambahan;

            $dataPsi->user_created = Auth::id();
            $dataPsi->save();

            DB::commit();

            return redirect()->route('rawat-inap.pneumonia.psi.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data PSI berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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
            abort(404, 'Data medis not found');
        }

        // Get specific PSI data
        $dataPsi = RmePneumoniaPsi::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataPsi) {
            abort(404, 'Data PSI not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.pneumonia-psi.show', compact(
            'dataMedis',
            'dataPsi'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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
            abort(404, 'Data medis not found');
        }

        // Get specific PSI data for editing
        $dataPsi = RmePneumoniaPsi::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataPsi) {
            abort(404, 'Data PSI not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.pneumonia-psi.edit', compact(
            'dataMedis',
            'dataPsi'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Find existing PSI data
            $dataPsi = RmePneumoniaPsi::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->first();

            if (!$dataPsi) {
                return back()->with('error', 'Data PSI tidak ditemukan!')->withInput();
            }

            // Basic information
            $dataPsi->tanggal_implementasi = $request->tanggal_implementasi;
            $dataPsi->jam_implementasi = $request->jam_implementasi;

            // Demographic factors
            $dataPsi->gender_age = $request->gender_age;
            $dataPsi->umur_laki = $request->gender_age == 'male' ? $request->umur_laki : null;
            $dataPsi->umur_perempuan = $request->gender_age == 'female' ? $request->umur_perempuan : null;
            $dataPsi->panti_werdha = $request->has('panti_werdha') ? 1 : 0;

            // Comorbid conditions
            $dataPsi->keganasan = $request->has('keganasan') ? 1 : 0;
            $dataPsi->penyakit_hati = $request->has('penyakit_hati') ? 1 : 0;
            $dataPsi->jantung_kongestif = $request->has('jantung_kongestif') ? 1 : 0;
            $dataPsi->serebrovaskular = $request->has('serebrovaskular') ? 1 : 0;
            $dataPsi->penyakit_ginjal = $request->has('penyakit_ginjal') ? 1 : 0;

            // Physical examination
            $dataPsi->gangguan_kesadaran = $request->has('gangguan_kesadaran') ? 1 : 0;
            $dataPsi->frekuensi_nafas = $request->has('frekuensi_nafas') ? 1 : 0;
            $dataPsi->tekanan_sistolik = $request->has('tekanan_sistolik') ? 1 : 0;
            $dataPsi->suhu_tubuh = $request->has('suhu_tubuh') ? 1 : 0;
            $dataPsi->frekuensi_nadi = $request->has('frekuensi_nadi') ? 1 : 0;

            // Laboratory results
            $dataPsi->ph_rendah = $request->has('ph_rendah') ? 1 : 0;
            $dataPsi->ureum_tinggi = $request->has('ureum_tinggi') ? 1 : 0;
            $dataPsi->natrium_rendah = $request->has('natrium_rendah') ? 1 : 0;
            $dataPsi->glukosa_tinggi = $request->has('glukosa_tinggi') ? 1 : 0;
            $dataPsi->hematokrit_rendah = $request->has('hematokrit_rendah') ? 1 : 0;
            $dataPsi->o2_rendah = $request->has('o2_rendah') ? 1 : 0;
            $dataPsi->efusi_pleura = $request->has('efusi_pleura') ? 1 : 0;

            // Total score and interpretation
            $dataPsi->total_skor = $request->total_skor;
            $dataPsi->rekomendasi_perawatan = $request->rekomendasi_perawatan;
            $dataPsi->kriteria_tambahan = $request->kriteria_tambahan;

            $dataPsi->user_updated = Auth::id();
            $dataPsi->save();

            DB::commit();

            return redirect()->route('rawat-inap.pneumonia.psi.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data PSI berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Find and delete PSI data
            $dataPsi = RmePneumoniaPsi::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->first();

            if (!$dataPsi) {
                return back()->with('error', 'Data PSI tidak ditemukan!');
            }

            $dataPsi->delete();

            DB::commit();

            return redirect()->route('rawat-inap.pneumonia.psi.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data PSI berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}

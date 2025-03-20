<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeRujukKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RujukJalanController extends Controller
{
    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Format tanggal jika mengandung timestamp
        if (strpos($tgl_masuk, ' ') !== false) {
            $tgl_masuk = date('Y-m-d', strtotime($tgl_masuk));
        }

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

        if ($dataMedis && $dataMedis->tgl_masuk) {
            $dataMedis->tgl_masuk = date('Y-m-d', strtotime($dataMedis->tgl_masuk));
        }
        // Get existing rujukan data for this patient
        $rujukan = RmeRujukKeluar::where('kd_pasien', $kd_pasien)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-jalan.pelayanan.rujuk-antar-rs.index', compact('dataMedis', 'rujukan'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {

            $rujukan = new RmeRujukKeluar();
            $rujukan->kd_pasien = $kd_pasien;
            $rujukan->kd_unit = $kd_unit;
            $rujukan->tgl_masuk = $tgl_masuk;
            $rujukan->urut_masuk = $urut_masuk;
            $rujukan->tanggal = $request->tanggal;
            $rujukan->jam = $request->jam;
            $rujukan->transportasi = $request->transportasi;
            $rujukan->detail_kendaraan = $request->detail_kendaraan;
            $rujukan->nomor_polisi = $request->nomor_polisi;

            // Handle pendamping checkboxes
            $rujukan->pendamping_dokter = $request->has('pendamping_dokter') ? '1' : '0';
            $rujukan->pendamping_perawat = $request->has('pendamping_perawat') ? '1' : '0';
            $rujukan->pendamping_keluarga = $request->has('pendamping_keluarga') ? '1' : '0';
            $rujukan->detail_keluarga = $request->has('pendamping_keluarga') && $request->detail_keluarga ? $request->detail_keluarga : null;
            $rujukan->pendamping_tidak_ada = $request->has('pendamping_tidak_ada') ? '1' : '0';

            // Tanda vital
            $rujukan->suhu = $request->suhu;
            $rujukan->sistole = $request->sistole;
            $rujukan->diastole = $request->diastole;
            $rujukan->nadi = $request->nadi;
            $rujukan->respirasi = $request->respirasi;
            $rujukan->status_nyeri = $request->status_nyeri;

            // Handle alasan pindah checkboxes
            $rujukan->alasan_tempat_penuh = $request->has('alasan_tempat_penuh') ? '1' : '0';
            $rujukan->alasan_permintaan_keluarga = $request->has('alasan_permintaan_keluarga') ? '1' : '0';
            $rujukan->alasan_perawatan_khusus = $request->has('alasan_perawatan_khusus') ? '1' : '0';
            $rujukan->alasan_lainnya = $request->has('alasan_lainnya') ? '1' : '0';
            $rujukan->detail_alasan_lainnya = $request->has('alasan_lainnya') && $request->detail_alasan_lainnya ? $request->detail_alasan_lainnya : null;

            $rujukan->detail_alasan_lainnya = $request->detail_alasan_lainnya;
            $rujukan->alergi = $request->alergi;
            $rujukan->alasan_masuk_dirujuk = $request->alasan_masuk_dirujuk;
            $rujukan->hasil_pemeriksaan_penunjang = $request->hasil_pemeriksaan_penunjang;
            $rujukan->terapi = $request->terapi;
            $rujukan->diagnosis = $request->diagnosis;
            $rujukan->tindakan = $request->tindakan;
            $rujukan->edukasi_pasien = $request->edukasi_pasien;

            $rujukan->save();

            DB::commit();

            return redirect()->route('rawat-jalan.rujuk-antar-rs.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Data rujukan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $rujukan = RmeRujukKeluar::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('id', $id)
                ->firstOrFail();

            return response()->json($rujukan);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $rujukan = RmeRujukKeluar::findOrFail($id);
        return response()->json($rujukan);
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {

            $rujukan = RmeRujukKeluar::findOrFail($id);
            $rujukan->kd_pasien = $request->kd_pasien;
            $rujukan->kd_unit = $request->kd_unit;
            $rujukan->tgl_masuk = $request->tgl_masuk;
            $rujukan->urut_masuk = $request->urut_masuk;
            $rujukan->tanggal = $request->tanggal;
            $rujukan->jam = $request->jam;
            $rujukan->transportasi = $request->transportasi;
            $rujukan->detail_kendaraan = $request->detail_kendaraan;
            $rujukan->nomor_polisi = $request->nomor_polisi;

            // Handle pendamping checkboxes
            $rujukan->pendamping_dokter = $request->pendamping_dokter;
            $rujukan->pendamping_perawat = $request->pendamping_perawat;
            $rujukan->pendamping_keluarga = $request->pendamping_keluarga;
            $rujukan->detail_keluarga = $request->detail_keluarga;
            $rujukan->pendamping_tidak_ada = $request->detail_keluarga;

            // Tanda vital
            $rujukan->suhu = $request->suhu;
            $rujukan->sistole = $request->sistole;
            $rujukan->diastole = $request->diastole;
            $rujukan->nadi = $request->nadi;
            $rujukan->respirasi = $request->respirasi;
            $rujukan->status_nyeri = $request->status_nyeri;

            // Handle alasan pindah checkboxes
            $rujukan->alasan_tempat_penuh = $request->alasan_tempat_penuh;
            $rujukan->alasan_permintaan_keluarga = $request->alasan_permintaan_keluarga;
            $rujukan->alasan_perawatan_khusus = $request->alasan_perawatan_khusus;
            $rujukan->alasan_lainnya = $request->alasan_lainnya;
            $rujukan->detail_alasan_lainnya = $request->detail_alasan_lainnya;

            $rujukan->detail_alasan_lainnya = $request->detail_alasan_lainnya;
            $rujukan->alergi = $request->alergi;
            $rujukan->alasan_masuk_dirujuk = $request->alasan_masuk_dirujuk;
            $rujukan->hasil_pemeriksaan_penunjang = $request->hasil_pemeriksaan_penunjang;
            $rujukan->terapi = $request->terapi;
            $rujukan->diagnosis = $request->diagnosis;
            $rujukan->tindakan = $request->tindakan;
            $rujukan->edukasi_pasien = $request->edukasi_pasien;

            $rujukan->save();

            DB::commit();

            return redirect()->route('rawat-jalan.rujuk-antar-rs.index', [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data rujukan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $rujukan = RmeRujukKeluar::findOrFail($id);
            $rujukan->delete();

            return redirect()->route('rawat-jalan.rujuk-antar-rs.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data rujukan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

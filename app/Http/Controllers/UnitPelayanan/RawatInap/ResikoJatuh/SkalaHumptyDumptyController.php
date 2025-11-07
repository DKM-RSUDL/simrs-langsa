<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap\ResikoJatuh;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeSkalaHumptyDumpty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkalaHumptyDumptyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
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

        // Query data Humpty Dumpty dengan filter
        $query = RmeSkalaHumptyDumpty::with('userCreated')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('shift', 'like', "%{$search}%")
                    ->orWhere('kategori_risiko', 'like', "%{$search}%")
                    ->orWhere('total_skor', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        // Urutkan berdasarkan tanggal terbaru
        $dataHumptyDumpty = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-humpty-dumpty.index', compact(
            'dataMedis',
            'dataHumptyDumpty'
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

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-humpty-dumpty.create', compact(
            'dataMedis',
        ));
    }

    public function checkDuplicate(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $exists = RmeSkalaHumptyDumpty::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('tanggal_implementasi', $request->tanggal_implementasi)
            ->where('shift', $request->shift)
            ->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Data dengan tanggal dan shift ini sudah ada!' : 'Data dapat disimpan'
        ]);
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Validasi duplikasi tanggal dan shift
            $existingData = RmeSkalaHumptyDumpty::where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal_implementasi', $request->tanggal_implementasi)
                ->where('shift', $request->shift)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ' dan shift ' . ucfirst($request->shift) . ' sudah ada!')
                    ->withInput();
            }
            // Hitung total skor
            $totalSkor = (int)$request->usia +
                (int)$request->jenis_kelamin +
                (int)$request->diagnosis +
                (int)$request->gangguan_kognitif +
                (int)$request->faktor_lingkungan +
                (int)$request->pembedahan_sedasi +
                (int)$request->penggunaan_medikamentosa;

            // Tentukan kategori risiko
            if ($totalSkor >= 6 && $totalSkor <= 11) {
                $kategoriRisiko = 'Risiko Rendah';
            } elseif ($totalSkor >= 12) {
                $kategoriRisiko = 'Risiko Tinggi';
            } else {
                $kategoriRisiko = 'Skor Tidak Valid';
            }

            // Simpan data assessment
            $dataHumptyDumpty = new RmeSkalaHumptyDumpty();
            $dataHumptyDumpty->kd_pasien = $kd_pasien;
            $dataHumptyDumpty->tgl_masuk = $tgl_masuk;
            $dataHumptyDumpty->kd_unit = $kd_unit;
            $dataHumptyDumpty->urut_masuk = $urut_masuk;

            // Data dasar
            $dataHumptyDumpty->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHumptyDumpty->jam_implementasi = $request->jam_implementasi;
            $dataHumptyDumpty->shift = $request->shift;

            // Data assessment (simpan nilai angka)
            $dataHumptyDumpty->usia = (int)$request->usia;
            $dataHumptyDumpty->jenis_kelamin = (int)$request->jenis_kelamin;
            $dataHumptyDumpty->diagnosis = (int)$request->diagnosis;
            $dataHumptyDumpty->gangguan_kognitif = (int)$request->gangguan_kognitif;
            $dataHumptyDumpty->faktor_lingkungan = (int)$request->faktor_lingkungan;
            $dataHumptyDumpty->pembedahan_sedasi = (int)$request->pembedahan_sedasi;
            $dataHumptyDumpty->penggunaan_medikamentosa = (int)$request->penggunaan_medikamentosa;

            // Hasil assessment
            $dataHumptyDumpty->total_skor = $totalSkor;
            $dataHumptyDumpty->kategori_risiko = $kategoriRisiko;

            // Data intervensi untuk risiko rendah
            if ($kategoriRisiko == 'Risiko Rendah') {
                $dataHumptyDumpty->observasi_ambulasi = $request->has('observasi_ambulasi') ? 1 : 0;
                $dataHumptyDumpty->orientasi_kamar_mandi = $request->has('orientasi_kamar_mandi') ? 1 : 0;
                $dataHumptyDumpty->orientasi_bertahap = $request->has('orientasi_bertahap') ? 1 : 0;
                $dataHumptyDumpty->tempatkan_bel = $request->has('tempatkan_bel') ? 1 : 0;
                $dataHumptyDumpty->instruksi_bantuan = $request->has('instruksi_bantuan') ? 1 : 0;
                $dataHumptyDumpty->pagar_pengaman = $request->has('pagar_pengaman') ? 1 : 0;
                $dataHumptyDumpty->tempat_tidur_rendah = $request->has('tempat_tidur_rendah') ? 1 : 0;
                $dataHumptyDumpty->edukasi_perilaku = $request->has('edukasi_perilaku') ? 1 : 0;
                $dataHumptyDumpty->monitor_berkala = $request->has('monitor_berkala') ? 1 : 0;
                $dataHumptyDumpty->anjuran_kaus_kaki = $request->has('anjuran_kaus_kaki') ? 1 : 0;
                $dataHumptyDumpty->lantai_antislip = $request->has('lantai_antislip') ? 1 : 0;
            }

            // Data intervensi untuk risiko tinggi
            if ($kategoriRisiko == 'Risiko Tinggi') {
                $dataHumptyDumpty->semua_intervensi_rendah = $request->has('semua_intervensi_rendah') ? 1 : 0;
                $dataHumptyDumpty->gelang_kuning = $request->has('gelang_kuning') ? 1 : 0;
                $dataHumptyDumpty->pasang_gambar = $request->has('pasang_gambar') ? 1 : 0;
                $dataHumptyDumpty->tanda_daftar_nama = $request->has('tanda_daftar_nama') ? 1 : 0;
                $dataHumptyDumpty->pertimbangkan_obat = $request->has('pertimbangkan_obat') ? 1 : 0;
                $dataHumptyDumpty->alat_bantu_jalan = $request->has('alat_bantu_jalan') ? 1 : 0;
                $dataHumptyDumpty->pintu_terbuka = $request->has('pintu_terbuka') ? 1 : 0;
                $dataHumptyDumpty->jangan_tinggalkan = $request->has('jangan_tinggalkan') ? 1 : 0;
                $dataHumptyDumpty->dekat_nurse_station = $request->has('dekat_nurse_station') ? 1 : 0;
                $dataHumptyDumpty->bed_posisi_rendah = $request->has('bed_posisi_rendah') ? 1 : 0;
                $dataHumptyDumpty->edukasi_keluarga = $request->has('edukasi_keluarga') ? 1 : 0;
            }

            // User audit
            $dataHumptyDumpty->user_created = Auth::id();

            $dataHumptyDumpty->save();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Humpty Dumpty berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
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

        // Ambil data Humpty Dumpty berdasarkan ID
        $dataHumptyDumpty = RmeSkalaHumptyDumpty::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$dataHumptyDumpty) {
            abort(404, 'Data Humpty Dumpty tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-humpty-dumpty.edit', compact(
            'dataMedis',
            'dataHumptyDumpty'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Ambil data yang akan diupdate
            $dataHumptyDumpty = RmeSkalaHumptyDumpty::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataHumptyDumpty) {
                abort(404, 'Data Humpty Dumpty tidak ditemukan');
            }

            // Validasi duplikasi tanggal dan shift (kecuali data yang sedang diedit)
            $existingData = RmeSkalaHumptyDumpty::where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal_implementasi', $request->tanggal_implementasi)
                ->where('shift', $request->shift)
                ->where('id', '!=', $id)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ' dan shift ' . ucfirst($request->shift) . ' sudah ada!')
                    ->withInput();
            }

            // Hitung total skor
            $totalSkor = (int)$request->usia +
                (int)$request->jenis_kelamin +
                (int)$request->diagnosis +
                (int)$request->gangguan_kognitif +
                (int)$request->faktor_lingkungan +
                (int)$request->pembedahan_sedasi +
                (int)$request->penggunaan_medikamentosa;

            // Tentukan kategori risiko
            if ($totalSkor >= 6 && $totalSkor <= 11) {
                $kategoriRisiko = 'Risiko Rendah';
            } elseif ($totalSkor >= 12) {
                $kategoriRisiko = 'Risiko Tinggi';
            } else {
                $kategoriRisiko = 'Skor Tidak Valid';
            }

            // Update data dasar
            $dataHumptyDumpty->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHumptyDumpty->jam_implementasi = $request->jam_implementasi;
            $dataHumptyDumpty->shift = $request->shift;

            // Update data assessment
            $dataHumptyDumpty->usia = (int)$request->usia;
            $dataHumptyDumpty->jenis_kelamin = (int)$request->jenis_kelamin;
            $dataHumptyDumpty->diagnosis = (int)$request->diagnosis;
            $dataHumptyDumpty->gangguan_kognitif = (int)$request->gangguan_kognitif;
            $dataHumptyDumpty->faktor_lingkungan = (int)$request->faktor_lingkungan;
            $dataHumptyDumpty->pembedahan_sedasi = (int)$request->pembedahan_sedasi;
            $dataHumptyDumpty->penggunaan_medikamentosa = (int)$request->penggunaan_medikamentosa;

            // Update hasil assessment
            $dataHumptyDumpty->total_skor = $totalSkor;
            $dataHumptyDumpty->kategori_risiko = $kategoriRisiko;

            // Reset semua intervensi terlebih dahulu
            $dataHumptyDumpty->observasi_ambulasi = 0;
            $dataHumptyDumpty->orientasi_kamar_mandi = 0;
            $dataHumptyDumpty->orientasi_bertahap = 0;
            $dataHumptyDumpty->tempatkan_bel = 0;
            $dataHumptyDumpty->instruksi_bantuan = 0;
            $dataHumptyDumpty->pagar_pengaman = 0;
            $dataHumptyDumpty->tempat_tidur_rendah = 0;
            $dataHumptyDumpty->edukasi_perilaku = 0;
            $dataHumptyDumpty->monitor_berkala = 0;
            $dataHumptyDumpty->anjuran_kaus_kaki = 0;
            $dataHumptyDumpty->lantai_antislip = 0;
            $dataHumptyDumpty->semua_intervensi_rendah = 0;
            $dataHumptyDumpty->gelang_kuning = 0;
            $dataHumptyDumpty->pasang_gambar = 0;
            $dataHumptyDumpty->tanda_daftar_nama = 0;
            $dataHumptyDumpty->pertimbangkan_obat = 0;
            $dataHumptyDumpty->alat_bantu_jalan = 0;
            $dataHumptyDumpty->pintu_terbuka = 0;
            $dataHumptyDumpty->jangan_tinggalkan = 0;
            $dataHumptyDumpty->dekat_nurse_station = 0;
            $dataHumptyDumpty->bed_posisi_rendah = 0;
            $dataHumptyDumpty->edukasi_keluarga = 0;

            // Update intervensi untuk risiko rendah
            if ($kategoriRisiko == 'Risiko Rendah') {
                $dataHumptyDumpty->observasi_ambulasi = $request->has('observasi_ambulasi') ? 1 : 0;
                $dataHumptyDumpty->orientasi_kamar_mandi = $request->has('orientasi_kamar_mandi') ? 1 : 0;
                $dataHumptyDumpty->orientasi_bertahap = $request->has('orientasi_bertahap') ? 1 : 0;
                $dataHumptyDumpty->tempatkan_bel = $request->has('tempatkan_bel') ? 1 : 0;
                $dataHumptyDumpty->instruksi_bantuan = $request->has('instruksi_bantuan') ? 1 : 0;
                $dataHumptyDumpty->pagar_pengaman = $request->has('pagar_pengaman') ? 1 : 0;
                $dataHumptyDumpty->tempat_tidur_rendah = $request->has('tempat_tidur_rendah') ? 1 : 0;
                $dataHumptyDumpty->edukasi_perilaku = $request->has('edukasi_perilaku') ? 1 : 0;
                $dataHumptyDumpty->monitor_berkala = $request->has('monitor_berkala') ? 1 : 0;
                $dataHumptyDumpty->anjuran_kaus_kaki = $request->has('anjuran_kaus_kaki') ? 1 : 0;
                $dataHumptyDumpty->lantai_antislip = $request->has('lantai_antislip') ? 1 : 0;
            }

            // Update intervensi untuk risiko tinggi
            if ($kategoriRisiko == 'Risiko Tinggi') {
                $dataHumptyDumpty->semua_intervensi_rendah = $request->has('semua_intervensi_rendah') ? 1 : 0;
                $dataHumptyDumpty->gelang_kuning = $request->has('gelang_kuning') ? 1 : 0;
                $dataHumptyDumpty->pasang_gambar = $request->has('pasang_gambar') ? 1 : 0;
                $dataHumptyDumpty->tanda_daftar_nama = $request->has('tanda_daftar_nama') ? 1 : 0;
                $dataHumptyDumpty->pertimbangkan_obat = $request->has('pertimbangkan_obat') ? 1 : 0;
                $dataHumptyDumpty->alat_bantu_jalan = $request->has('alat_bantu_jalan') ? 1 : 0;
                $dataHumptyDumpty->pintu_terbuka = $request->has('pintu_terbuka') ? 1 : 0;
                $dataHumptyDumpty->jangan_tinggalkan = $request->has('jangan_tinggalkan') ? 1 : 0;
                $dataHumptyDumpty->dekat_nurse_station = $request->has('dekat_nurse_station') ? 1 : 0;
                $dataHumptyDumpty->bed_posisi_rendah = $request->has('bed_posisi_rendah') ? 1 : 0;
                $dataHumptyDumpty->edukasi_keluarga = $request->has('edukasi_keluarga') ? 1 : 0;
            }

            $dataHumptyDumpty->user_updated = auth()->user()->id;
            $dataHumptyDumpty->save();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Humpty Dumpty berhasil diupdate!');
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

        // Ambil data Humpty Dumpty berdasarkan ID
        $dataHumptyDumpty = RmeSkalaHumptyDumpty::with('userCreated')
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$dataHumptyDumpty) {
            abort(404, 'Data Humpty Dumpty tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-humpty-dumpty.show', compact(
            'dataMedis',
            'dataHumptyDumpty'
        ));
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data yang akan dihapus
            $dataHumptyDumpty = RmeSkalaHumptyDumpty::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataHumptyDumpty) {
                return back()->with('error', 'Data Humpty Dumpty tidak ditemukan!');
            }

            $dataHumptyDumpty->delete();

            return redirect()->route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Humpty Dumpty berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}

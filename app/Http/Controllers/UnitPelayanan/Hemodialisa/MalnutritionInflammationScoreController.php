<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeHdMalnutrisiSkor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MalnutritionInflammationScoreController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Mengambil data kunjungan
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Mengambil data skor malnutrisi
        $skorMalnutrisi = RmeHdMalnutrisiSkor::where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tgl_rawat', 'desc')
            ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.malnutrition-inflammation-score.index', compact(
            'dataMedis',
            'skorMalnutrisi'
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.malnutrition-inflammation-score.create', compact(
            'dataMedis',
            'dokter',
            'alergiPasien'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {

            // Hitung total skor
            $totalSkor = 0;
            $totalSkor += (int) $request->perubahan_bb_kering ?? 0;
            $totalSkor += (int) $request->asupan_diet ?? 0;
            $totalSkor += (int) $request->gejala_gastrointestinal ?? 0;
            $totalSkor += (int) $request->kapasitas_fungsional ?? 0;
            $totalSkor += (int) $request->komorbiditas ?? 0;
            $totalSkor += (int) $request->berkurang_cadangan_lemak ?? 0;
            $totalSkor += (int) $request->kehilangan_masa_oto ?? 0;
            $totalSkor += (int) $request->indeks_masa_tubuh ?? 0;
            $totalSkor += (int) $request->albumin_serum ?? 0;
            $totalSkor += (int) $request->tibc ?? 0;

            // Tentukan interpretasi
            $interpretasi = '';
            if ($totalSkor < 6) {
                $interpretasi = 'Normal - Tanpa malnutrisi';
            } elseif ($totalSkor == 6) {
                $interpretasi = 'Borderline - Lihat klinis pasien';
            } else {
                $interpretasi = 'Malnutrisi terdeteksi';
            }

            // Data yang akan disimpan
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tgl_rawat' => $request->tgl_rawat,
                'jam_rawat' => $request->jam_rawat,
                'diagnosis_medis' => $request->diagnosis_medis,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'imt_result' => $request->imt_result,

                'perubahan_bb_kering' => $request->perubahan_bb_kering,
                'asupan_diet' => $request->asupan_diet,
                'gejala_gastrointestinal' => $request->gejala_gastrointestinal,
                'kapasitas_fungsional' => $request->kapasitas_fungsional,
                'komorbiditas' => $request->komorbiditas,
                'berkurang_cadangan_lemak' => $request->berkurang_cadangan_lemak,
                'kehilangan_masa_oto' => $request->kehilangan_masa_oto,
                'indeks_masa_tubuh' => $request->indeks_masa_tubuh,
                'albumin_serum' => $request->albumin_serum,
                'tibc' => $request->tibc,
                'total_skor' => $totalSkor,
                'interpretasi' => $interpretasi,
                'user_created' => auth()->user()->id ?? null,
            ];

            // Simpan ke database menggunakan model RmeSkorMalnutrisi
            RmeHdMalnutrisiSkor::create($data);

            return redirect()
                ->route('hemodialisa.pelayanan.malnutrition-inflammation-score.index', [
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('success', 'Data Malnutrition Inflammation Score berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypted)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data skor malnutrisi yang akan diedit
        $id = decrypt($idEncrypted);
        if (!is_numeric($id)) {
            abort(404, 'ID tidak valid');
        }
        $skorMalnutrisi = RmeHdMalnutrisiSkor::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$skorMalnutrisi) {
            abort(404, 'Data Malnutrition Inflammation Score tidak ditemukan');
        }

        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.malnutrition-inflammation-score.edit', compact(
            'dataMedis',
            'dokter',
            'alergiPasien',
            'skorMalnutrisi'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Cari data yang akan diupdate
            $skorMalnutrisi = RmeHdMalnutrisiSkor::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$skorMalnutrisi) {
                return redirect()
                    ->back()
                    ->with('error', 'Data Malnutrition Inflammation Score tidak ditemukan');
            }

            // Hitung total skor
            $totalSkor = 0;
            $totalSkor += (int) $request->perubahan_bb_kering ?? 0;
            $totalSkor += (int) $request->asupan_diet ?? 0;
            $totalSkor += (int) $request->gejala_gastrointestinal ?? 0;
            $totalSkor += (int) $request->kapasitas_fungsional ?? 0;
            $totalSkor += (int) $request->komorbiditas ?? 0;
            $totalSkor += (int) $request->berkurang_cadangan_lemak ?? 0;
            $totalSkor += (int) $request->kehilangan_masa_oto ?? 0;
            $totalSkor += (int) $request->indeks_masa_tubuh ?? 0;
            $totalSkor += (int) $request->albumin_serum ?? 0;
            $totalSkor += (int) $request->tibc ?? 0;

            // Tentukan interpretasi
            $interpretasi = '';
            if ($totalSkor < 6) {
                $interpretasi = 'Normal - Tanpa malnutrisi';
            } elseif ($totalSkor == 6) {
                $interpretasi = 'Borderline - Lihat klinis pasien';
            } else {
                $interpretasi = 'Malnutrisi terdeteksi';
            }

            // Data yang akan diupdate
            $data = [
                'tgl_rawat' => $request->tgl_rawat,
                'jam_rawat' => $request->jam_rawat,
                'diagnosis_medis' => $request->diagnosis_medis,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'imt_result' => $request->imt_result,

                'perubahan_bb_kering' => $request->perubahan_bb_kering,
                'asupan_diet' => $request->asupan_diet,
                'gejala_gastrointestinal' => $request->gejala_gastrointestinal,
                'kapasitas_fungsional' => $request->kapasitas_fungsional,
                'komorbiditas' => $request->komorbiditas,
                'berkurang_cadangan_lemak' => $request->berkurang_cadangan_lemak,
                'kehilangan_masa_oto' => $request->kehilangan_masa_oto,
                'indeks_masa_tubuh' => $request->indeks_masa_tubuh,
                'albumin_serum' => $request->albumin_serum,
                'tibc' => $request->tibc,
                'total_skor' => $totalSkor,
                'interpretasi' => $interpretasi,
                'user_updated' => auth()->user()->id ?? null,
                'updated_at' => now(),
            ];

            // Update data
            $skorMalnutrisi->update($data);

            return redirect()
                ->route('hemodialisa.pelayanan.malnutrition-inflammation-score.index', [
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('success', 'Data Malnutrition Inflammation Score berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypted)
    {
        try {
            // Decrypt ID
            $id = decrypt($idEncrypted);
            if (!is_numeric($id)) {
                return redirect()
                    ->back()
                    ->with('error', 'ID tidak valid');
            }

            // Cari data yang akan dihapus
            $skorMalnutrisi = RmeHdMalnutrisiSkor::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$skorMalnutrisi) {
                return redirect()
                    ->back()
                    ->with('error', 'Data Malnutrition Inflammation Score tidak ditemukan');
            }

            // Hapus data
            $skorMalnutrisi->delete();

            return redirect()
                ->route('hemodialisa.pelayanan.malnutrition-inflammation-score.index', [
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('success', 'Data Malnutrition Inflammation Score berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function print($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypted)
    {
        // Decrypt ID
        $id = decrypt($idEncrypted);
        if (!is_numeric($id)) {
            abort(404, 'ID tidak valid');
        }

        // Ambil data kunjungan
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data skor malnutrisi
        $skorMalnutrisi = RmeHdMalnutrisiSkor::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', $this->kdUnitDef_)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$skorMalnutrisi) {
            abort(404, 'Data Malnutrition Inflammation Score tidak ditemukan');
        }

        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');

        // Generate PDF menggunakan DomPDF
        $pdf = Pdf::loadView('unit-pelayanan.hemodialisa.pelayanan.malnutrition-inflammation-score.print', compact(
            'dataMedis',
            'skorMalnutrisi',
            'logoPath'
        ));

        // Set paper dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Generate filename
        $filename = 'MIS_' . $dataMedis->pasien->nama . '_' . Carbon::parse($skorMalnutrisi->tgl_rawat)->format('dmY') . '.pdf';

        // Clean filename untuk keamanan
        $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);

        // Stream PDF ke browser
        return $pdf->stream($filename);
    }

}

<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeSuratKematian;
use App\Models\RmeSuratKematianDtl;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuratKematianController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    // SuratKematianController.php - method index
    public function index($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        // Ambil data pasien/medis
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
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

        // Filter data berdasarkan tanggal jika ada
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        // Query untuk data surat kematian
        $query = RmeSuratKematian::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->with(['detailType1', 'dokter']);

        // Tambahkan filter tanggal jika ada
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_kematian', [$startDate, $endDate]);
        } else if ($startDate) {
            $query->where('tanggal_kematian', '>=', $startDate);
        } else if ($endDate) {
            $query->where('tanggal_kematian', '<=', $endDate);
        }

        // Filter berdasarkan nomor surat jika ada pencarian
        if ($search) {
            $query->where('nomor_surat', 'like', "%{$search}%");
        }

        // Ambil data dan urutkan berdasarkan tanggal terbaru
        $dataSuratKematian = $query->orderBy('tanggal_kematian', 'desc')->get();

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.surat.kematian.index',
            compact('dataMedis', 'dataSuratKematian')
        );
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
            ->where('kunjungan.kd_unit', 3)
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

        // Fetch active doctors (status = 1)
        $dataDokter = Dokter::where('status', 1)->get();

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.surat.kematian.create',
            compact('dataMedis', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'dataDokter')
        );
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            // Start transaction
            DB::beginTransaction();

            // Create new RmeSuratKematian record
            $suratKematian = new RmeSuratKematian();
            $suratKematian->kd_pasien = $kd_pasien;
            $suratKematian->kd_unit = 3;
            $suratKematian->tgl_masuk = $tgl_masuk;
            $suratKematian->urut_masuk = $urut_masuk;
            $suratKematian->tanggal_kematian = $request->tanggal_kematian;
            $suratKematian->jam_kematian = $request->jam_kematian;
            $suratKematian->kd_dokter = $request->dokter;
            $suratKematian->nomor_surat = $request->nomor_surat;
            $suratKematian->tempat_kematian = $request->tempat_kematian;
            $suratKematian->kabupaten_kota = $request->kab_kota;
            $suratKematian->umur = $request->umur_tahun ?: '0';
            $suratKematian->bulan = $request->umur_bulan ?: '0';
            $suratKematian->hari = $request->umur_hari ?: '0';
            $suratKematian->jam = $request->umur_jam ?: '0';
            $suratKematian->user_create = auth()->id() ?: 0;
            $suratKematian->user_edit = auth()->id() ?: 0;
            $suratKematian->tanggal_surat = now();
            $suratKematian->save();

            // Process Section I: Penyakit atau keadaan yang langsung mengakibatkan kematian
            $count = 1;
            while ($request->has("diagnosa_{$count}")) {
                if (!empty($request->input("diagnosa_{$count}"))) {
                    $suratKematianDtl = new RmeSuratKematianDtl();
                    $suratKematianDtl->id_surat = $suratKematian->id;
                    $suratKematianDtl->keterangan = $request->input("diagnosa_{$count}");
                    $suratKematianDtl->konsekuensi = $request->input("akibat_{$count}") ?: null;
                    $suratKematianDtl->estimasi = $request->input("lama_diagnosa_{$count}") ?: null;
                    $suratKematianDtl->type = 1; // Type 1 for Section I
                    $suratKematianDtl->save();
                }
                $count++;
            }

            // Process Section II: Penyakit-penyakit lain
            $count = 2; // Starting from 2 as per your form
            while ($request->has("penyakit_lain_{$count}")) {
                if (!empty($request->input("penyakit_lain_{$count}"))) {
                    $suratKematianDtl = new RmeSuratKematianDtl();
                    $suratKematianDtl->id_surat = $suratKematian->id;
                    $suratKematianDtl->keterangan = $request->input("penyakit_lain_{$count}");
                    $suratKematianDtl->estimasi = $request->input("lama_penyakit_lain_{$count}") ?: null;
                    $suratKematianDtl->konsekuensi = null; // No konsekuensi field for Section II
                    $suratKematianDtl->type = 2; // Type 2 for Section II
                    $suratKematianDtl->save();
                }
                $count++;
            }

            // Commit transaction
            DB::commit();

            return redirect()
                ->route('surat-kematian.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Surat kematian berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            // Log the error
            Log::error('Error saving death certificate: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Get Patient data
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
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

        // Get Surat Kematian data
        $suratKematian = RmeSuratKematian::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$suratKematian) {
            abort(404, 'Surat kematian tidak ditemukan');
        }

        // Get details for section I (type 1)
        $detailType1 = RmeSuratKematianDtl::where('id_surat', $id)
            ->where('type', 1)
            ->orderBy('id', 'asc')
            ->get();

        // Get details for section II (type 2)
        $detailType2 = RmeSuratKematianDtl::where('id_surat', $id)
            ->where('type', 2)
            ->orderBy('id', 'asc')
            ->get();

        // Fetch active doctors (status = 1)
        $dataDokter = Dokter::where('status', 1)->get();

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.surat.kematian.edit',
            compact(
                'dataMedis',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk',
                'dataDokter',
                'suratKematian',
                'detailType1',
                'detailType2'
            )
        );
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        try {
            // Start transaction
            DB::beginTransaction();

            // Find existing surat kematian
            $suratKematian = RmeSuratKematian::findOrFail($id);

            // Update main details
            $suratKematian->tanggal_kematian = $request->tanggal_kematian;
            $suratKematian->jam_kematian = $request->jam_kematian;
            $suratKematian->kd_dokter = $request->dokter;
            $suratKematian->nomor_surat = $request->nomor_surat;
            $suratKematian->tempat_kematian = $request->tempat_kematian;
            $suratKematian->kabupaten_kota = $request->kab_kota;
            $suratKematian->umur = $request->umur_tahun ?: '0';
            $suratKematian->bulan = $request->umur_bulan ?: '0';
            $suratKematian->hari = $request->umur_hari ?: '0';
            $suratKematian->jam = $request->umur_jam ?: '0';
            $suratKematian->user_edit = auth()->id() ?: 0;
            $suratKematian->save();

            // Delete all existing details for this surat
            RmeSuratKematianDtl::where('id_surat', $id)->delete();

            // Re-process Section I: Penyakit atau keadaan yang langsung mengakibatkan kematian
            $count = 1;
            while ($request->has("diagnosa_{$count}")) {
                if (!empty($request->input("diagnosa_{$count}"))) {
                    $suratKematianDtl = new RmeSuratKematianDtl();
                    $suratKematianDtl->id_surat = $suratKematian->id;
                    $suratKematianDtl->keterangan = $request->input("diagnosa_{$count}");
                    $suratKematianDtl->konsekuensi = $request->input("akibat_{$count}") ?: null;
                    $suratKematianDtl->estimasi = $request->input("lama_diagnosa_{$count}") ?: null;
                    $suratKematianDtl->type = 1; // Type 1 for Section I
                    $suratKematianDtl->save();
                }
                $count++;
            }

            // Re-process Section II: Penyakit-penyakit lain
            $count = 2; // Starting from 2 as per your form
            while ($request->has("penyakit_lain_{$count}")) {
                if (!empty($request->input("penyakit_lain_{$count}"))) {
                    $suratKematianDtl = new RmeSuratKematianDtl();
                    $suratKematianDtl->id_surat = $suratKematian->id;
                    $suratKematianDtl->keterangan = $request->input("penyakit_lain_{$count}");
                    $suratKematianDtl->estimasi = $request->input("lama_penyakit_lain_{$count}") ?: null;
                    $suratKematianDtl->konsekuensi = null; // No konsekuensi field for Section II
                    $suratKematianDtl->type = 2; // Type 2 for Section II
                    $suratKematianDtl->save();
                }
                $count++;
            }

            // Commit transaction
            DB::commit();

            return redirect()
                ->route('surat-kematian.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Surat kematian berhasil diperbarui.');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            // Log the error
            Log::error('Error updating death certificate: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Get Patient data
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Get Surat Kematian data with relations
        $suratKematian = RmeSuratKematian::with(['dokter', 'detailType1', 'detailType2'])
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->first();

        if (!$suratKematian) {
            abort(404, 'Surat kematian tidak ditemukan');
        }

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.surat.kematian.show',
            compact('dataMedis', 'suratKematian')
        );
    }

    public function print($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Get Patient data
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Calculate age - make sure this is done
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Get Surat Kematian data with properly eager loaded relations
        $suratKematian = RmeSuratKematian::with([
            'dokter',
            'detailType1' => function ($query) {
                $query->where('type', 1)->orderBy('id', 'asc');
            },
            'detailType2' => function ($query) {
                $query->where('type', 2)->orderBy('id', 'asc');
            }
        ])
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->first();

        if (!$suratKematian) {
            abort(404, 'Surat kematian tidak ditemukan');
        }

        // Make sure the relationships are properly loaded
        if ($suratKematian->detailType1->isEmpty()) {
            // Fallback in case relationship doesn't work
            $suratKematian->detailType1 = RmeSuratKematianDtl::where('id_surat', $id)
                ->where('type', 1)
                ->orderBy('id', 'asc')
                ->get();
        }

        if ($suratKematian->detailType2->isEmpty()) {
            // Fallback in case relationship doesn't work
            $suratKematian->detailType2 = RmeSuratKematianDtl::where('id_surat', $id)
                ->where('type', 2)
                ->orderBy('id', 'asc')
                ->get();
        }

        // Persiapkan data untuk PDF
        $data = [
            'dataMedis' => $dataMedis,
            'suratKematian' => $suratKematian
        ];

        // Generate PDF dengan DomPDF
        $pdf = PDF::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.surat.kematian.print', $data);

        // Atur PDF properties
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'Arial',
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => true,
            'debugCss' => false,
        ]);

        // Nama file PDF
        $filename = 'Surat_Kematian_' . str_replace(' ', '_', $dataMedis->pasien->nama ?? 'Pasien') . '_' . date('Y-m-d') . '.pdf';

        // Download file PDF
        return $pdf->stream($filename);
    }

}

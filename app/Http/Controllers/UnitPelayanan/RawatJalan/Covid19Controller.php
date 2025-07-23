<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeCovid19;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class Covid19Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    /**
     * Helper method untuk mendapatkan data medis
     */
    private function getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
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
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else if ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return $dataMedis;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        // Query dengan filter
        $query = RmeCovid19::with(['userCreate', 'userEdit'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('gejala', 'LIKE', "%{$search}%")
                    ->orWhere('faktor_risiko', 'LIKE', "%{$search}%")
                    ->orWhere('komorbid', 'LIKE', "%{$search}%")
                    ->orWhere('kesimpulan', 'LIKE', "%{$search}%")
                    ->orWhereHas('userCreate', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $covidData = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('unit-pelayanan.rawat-jalan.pelayanan.covid-19.index', compact(
            'dataMedis',
            'covidData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        return view('unit-pelayanan.rawat-jalan.pelayanan.covid-19.create', compact(
            'dataMedis',
            'dokter'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        // Validasi data
        $validatedData = $request->validate([
            'gejala' => 'nullable|array',
            'tgl_gejala' => 'nullable|date',
            'faktor_risiko' => 'nullable|array',
            'lokasi_perjalanan' => 'nullable|string|max:255',
            'komorbid' => 'nullable|array',
            'persetujuan_untuk' => 'required|in:diri_sendiri,keluarga',
            'cara_penilaian' => 'nullable|string|max:255',
            'kesimpulan' => 'required|string|max:255',
            'persetujuan' => 'required|string|max:255',

            // Data keluarga (required jika persetujuan_untuk = keluarga)
            'nama_keluarga' => 'nullable:persetujuan_untuk,keluarga|string|max:255',
            'tgl_lahir_keluarga' => 'nullable|date',
            'alamat_keluarga' => 'nullable|string|max:255',
            'jk_keluarga' => 'nullable|in:0,1',
            'no_telp_keluarga' => 'nullable|string|max:255',
            'no_ktp_keluarga' => 'nullable|string|max:255',
            'hubungan_keluarga' => 'nullable:persetujuan_untuk,keluarga|string|max:255',

            // Data saksi 1
            'nama_saksi1' => 'nullable|string|max:255',
            'tgl_lahir_saksi1' => 'nullable|date',
            'alamat_saksi1' => 'nullable|string|max:255',
            'jk_saksi1' => 'nullable|in:0,1',
            'no_telp_saksi1' => 'nullable|string|max:255',
            'no_ktp_saksi1' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Prepare data untuk disimpan
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => Auth::id(),
                'tanggal' => now()->format('Y-m-d'),
                'jam' => now()->format('H:i:s'),

                // Convert arrays to JSON
                'gejala' => $request->gejala ? json_encode($request->gejala) : null,
                'tgl_gejala' => $request->tgl_gejala,
                'faktor_risiko' => $request->faktor_risiko ? json_encode($request->faktor_risiko) : null,
                'lokasi_perjalanan' => $request->lokasi_perjalanan,
                'komorbid' => $request->komorbid ? json_encode($request->komorbid) : null,

                'persetujuan_untuk' => $request->persetujuan_untuk,
                'nama_keluarga' => $request->nama_keluarga,
                'tgl_lahir_keluarga' => $request->tgl_lahir_keluarga,
                'alamat_keluarga' => $request->alamat_keluarga,
                'jk_keluarga' => $request->jk_keluarga,
                'no_telp_keluarga' => $request->no_telp_keluarga,
                'no_ktp_keluarga' => $request->no_ktp_keluarga,
                'hubungan_keluarga' => $request->hubungan_keluarga,

                'nama_saksi1' => $request->nama_saksi1,
                'tgl_lahir_saksi1' => $request->tgl_lahir_saksi1,
                'alamat_saksi1' => $request->alamat_saksi1,
                'jk_saksi1' => $request->jk_saksi1,
                'no_telp_saksi1' => $request->no_telp_saksi1,
                'no_ktp_saksi1' => $request->no_ktp_saksi1,

                'cara_penilaian' => $request->cara_penilaian,
                'kesimpulan' => $request->kesimpulan,
                'persetujuan' => $request->persetujuan,
            ];

            RmeCovid19::create($data);

            DB::commit();

            return redirect()
                ->route('rawat-jalan.covid-19.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data COVID-19 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $covidData = RmeCovid19::with(['userCreate', 'userEdit'])
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Decode JSON fields
        $covidData->gejala_decoded = $covidData->gejala ? json_decode($covidData->gejala, true) : [];
        $covidData->faktor_risiko_decoded = $covidData->faktor_risiko ? json_decode($covidData->faktor_risiko, true) : [];
        $covidData->komorbid_decoded = $covidData->komorbid ? json_decode($covidData->komorbid, true) : [];

        return view('unit-pelayanan.rawat-jalan.pelayanan.covid-19.show', compact(
            'dataMedis',
            'covidData'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $covidData = RmeCovid19::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Decode JSON fields untuk form
        $covidData->gejala_decoded = $covidData->gejala ? json_decode($covidData->gejala, true) : [];
        $covidData->faktor_risiko_decoded = $covidData->faktor_risiko ? json_decode($covidData->faktor_risiko, true) : [];
        $covidData->komorbid_decoded = $covidData->komorbid ? json_decode($covidData->komorbid, true) : [];

        return view('unit-pelayanan.rawat-jalan.pelayanan.covid-19.edit', compact(
            'dataMedis',
            'covidData'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $covidData = RmeCovid19::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Validasi data
        $validatedData = $request->validate([
            'gejala' => 'nullable|array',
            'tgl_gejala' => 'nullable|date',
            'faktor_risiko' => 'nullable|array',
            'lokasi_perjalanan' => 'nullable|string|max:255',
            'komorbid' => 'nullable|array',
            'persetujuan_untuk' => 'required|in:diri_sendiri,keluarga',
            'cara_penilaian' => 'nullable|string|max:255',
            'kesimpulan' => 'required|string|max:255',
            'persetujuan' => 'required|string|max:255',

            // Data keluarga (required jika persetujuan_untuk = keluarga)
            'nama_keluarga' => 'nullable:persetujuan_untuk,keluarga|string|max:255',
            'tgl_lahir_keluarga' => 'nullable|date',
            'alamat_keluarga' => 'nullable|string|max:255',
            'jk_keluarga' => 'nullable|in:0,1',
            'no_telp_keluarga' => 'nullable|string|max:255',
            'no_ktp_keluarga' => 'nullable|string|max:255',
            'hubungan_keluarga' => 'nullable:persetujuan_untuk,keluarga|string|max:255',

            // Data saksi 1
            'nama_saksi1' => 'nullable|string|max:255',
            'tgl_lahir_saksi1' => 'nullable|date',
            'alamat_saksi1' => 'nullable|string|max:255',
            'jk_saksi1' => 'nullable|in:0,1',
            'no_telp_saksi1' => 'nullable|string|max:255',
            'no_ktp_saksi1' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Update data
            $updateData = [
                'user_edit' => Auth::id(),

                // Convert arrays to JSON
                'gejala' => $request->gejala ? json_encode($request->gejala) : null,
                'tgl_gejala' => $request->tgl_gejala,
                'faktor_risiko' => $request->faktor_risiko ? json_encode($request->faktor_risiko) : null,
                'lokasi_perjalanan' => $request->lokasi_perjalanan,
                'komorbid' => $request->komorbid ? json_encode($request->komorbid) : null,

                'persetujuan_untuk' => $request->persetujuan_untuk,
                'nama_keluarga' => $request->nama_keluarga,
                'tgl_lahir_keluarga' => $request->tgl_lahir_keluarga,
                'alamat_keluarga' => $request->alamat_keluarga,
                'jk_keluarga' => $request->jk_keluarga,
                'no_telp_keluarga' => $request->no_telp_keluarga,
                'no_ktp_keluarga' => $request->no_ktp_keluarga,
                'hubungan_keluarga' => $request->hubungan_keluarga,

                'nama_saksi1' => $request->nama_saksi1,
                'tgl_lahir_saksi1' => $request->tgl_lahir_saksi1,
                'alamat_saksi1' => $request->alamat_saksi1,
                'jk_saksi1' => $request->jk_saksi1,
                'no_telp_saksi1' => $request->no_telp_saksi1,
                'no_ktp_saksi1' => $request->no_ktp_saksi1,

                'cara_penilaian' => $request->cara_penilaian,
                'kesimpulan' => $request->kesimpulan,
                'persetujuan' => $request->persetujuan,
            ];

            $covidData->update($updateData);

            DB::commit();

            return redirect()
                ->route('rawat-jalan.covid-19.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data COVID-19 berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $covidData = RmeCovid19::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $covidData->delete();

            return redirect()
                ->route('rawat-jalan.covid-19.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data COVID-19 berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data. Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF document
     */
    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data medis pasien
            $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Ambil data persetujuan transfusi darah
            $covidData = RmeCovid19::with([
                'userCreate',
                'userEdit'
            ])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->findOrFail($id);

            // Ambil semua data dokter seperti di index (sesuaikan dengan model dokter Anda)
            $dokter = \App\Models\Dokter::all(); // atau bisa menggunakan \App\Models\MsDokter::all()

            // Jika ingin lebih efisien, hanya ambil dokter yang dibutuhkan:
            // $dokter = \App\Models\Dokter::where('kd_dokter', $persetujuan->dokter)->get();

            // Load view untuk PDF
            $pdf = PDF::loadView('unit-pelayanan.rawat-jalan.pelayanan.covid-19.print', compact(
                'dataMedis',
                'covidData',
                'dokter'
            ));

            // Konfigurasi PDF
            $pdf->setPaper('a4', 'portrait');

            // Set options untuk DomPDF
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial',
                'fontSubsetting' => false,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false,
                'debugLayoutLines' => false,
                'debugLayoutBlocks' => false,
                'debugLayoutInline' => false,
                'debugLayoutPaddingBox' => false,
                'pdfBackend' => 'CPDF',
                'defaultPaperSize' => 'a4',
                'defaultPaperOrientation' => 'portrait',
            ]);

            // Generate nama file yang informatif
            $pasienNama = $dataMedis->pasien->nama ?? 'unknown';
            $tanggal = $covidData->tanggal ? $covidData->tanggal->format('d-m-Y') : date('d-m-Y');
            $filename = 'Covid_19' .
                    str_replace([' ', '.', ','], '_', $pasienNama) . '_' .
                    $kd_pasien . '_' .
                    $tanggal . '.pdf';

            // Return PDF sebagai response stream
            return $pdf->stream($filename);

        } catch (\Exception $e) {

            // Return error response yang user-friendly
            return back()->withErrors(['error' => 'Gagal generate PDF: ' . $e->getMessage()]);
        }
    }

    // Method untuk print (alias untuk generatePDF)
    public function printPDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        return $this->generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id);
    }
}

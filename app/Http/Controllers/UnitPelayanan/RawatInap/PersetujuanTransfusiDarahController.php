<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmePersetujuanTransfusiDarah;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PersetujuanTransfusiDarahController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
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
        $query = RmePersetujuanTransfusiDarah::with(['userCreate', 'dokter'])
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
                $q->where('diagnosa', 'LIKE', "%{$search}%")
                    ->orWhereHas('userCreate', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('dokter', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'LIKE', "%{$search}%");
                    });
            });
        }

        $persetujuanData = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.persetujuan-transfusi-darah.index', compact(
            'dataMedis',
            'persetujuanData',
            'dokter'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.persetujuan-transfusi-darah.create', compact(
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

        // Validasi
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'diagnosa' => 'required|string|max:255',
            'persetujuan_untuk' => 'required|in:diri_sendiri,keluarga',
            'dokter' => 'required|exists:dokter,kd_dokter',
            'persetujuan' => 'required|in:setuju,tidak_setuju',
            'yang_menyatakan' => 'required|string|max:255',

            // Validasi untuk keluarga jika dipilih
            'nama_keluarga' => 'nullable|string|max:255',
            'tgl_lahir_keluarga' => 'nullable|date',
            'alamat_keluarga' => 'nullable|string',
            'jk_keluarga' => 'nullable|in:0,1',
            'no_telp_keluarga' => 'nullable|string|max:20',
            'no_ktp_keluarga' => 'nullable|string|max:20',
            'hubungan_keluarga' => 'nullable|string|max:100',

            // Validasi untuk saksi
            'nama_saksi1' => 'nullable|string|max:255',
            'tgl_lahir_saksi1' => 'nullable|date',
            'alamat_saksi1' => 'nullable|string',
            'jk_saksi1' => 'nullable|in:0,1,Laki-laki,Perempuan',
            'no_telp_saksi1' => 'nullable|string|max:20',
            'no_ktp_saksi1' => 'nullable|string|max:20',

            'nama_saksi2' => 'nullable|string|max:255',
            'tgl_lahir_saksi2' => 'nullable|date',
            'alamat_saksi2' => 'nullable|string',
            'jk_saksi2' => 'nullable|in:0,1,Laki-laki,Perempuan',
            'no_telp_saksi2' => 'nullable|string|max:20',
            'no_ktp_saksi2' => 'nullable|string|max:20',
        ]);

        // Normalize jenis kelamin
        $validated['jk_saksi1'] = $this->normalizeJenisKelamin($validated['jk_saksi1']);
        $validated['jk_saksi2'] = $this->normalizeJenisKelamin($validated['jk_saksi2']);

        if ($request->persetujuan_untuk === 'keluarga') {
            $validated['jk_keluarga'] = $this->normalizeJenisKelamin($validated['jk_keluarga']);
        }

        try {
            DB::beginTransaction();

            // Simpan data
            $data = array_merge($validated, [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => Auth::id(),
            ]);

            RmePersetujuanTransfusiDarah::create($data);

            DB::commit();

            return redirect()
                ->route('rawat-inap.persetujuan-transfusi-darah.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data persetujuan transfusi darah berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $persetujuan = RmePersetujuanTransfusiDarah::with(['userCreate', 'userEdit', 'dokter'])
        ->where('kd_pasien', $kd_pasien)
        ->where('kd_unit', $kd_unit)
        ->whereDate('tgl_masuk', $tgl_masuk)
        ->where('urut_masuk', $urut_masuk)
        ->findOrFail($id);;

        // dd($persetujuan);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.persetujuan-transfusi-darah.show', compact(
            'dataMedis',
            'persetujuan',
            'dokter'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $persetujuan = RmePersetujuanTransfusiDarah::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->findOrFail($id);

        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.persetujuan-transfusi-darah.edit', compact(
            'dataMedis',
            'persetujuan',
            'dokter'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $persetujuan = RmePersetujuanTransfusiDarah::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->findOrFail($id);

        // Validasi sama seperti store
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'diagnosa' => 'required|string|max:255',
            'persetujuan_untuk' => 'required|in:diri_sendiri,keluarga',
            'dokter' => 'required|exists:dokter,kd_dokter',
            'persetujuan' => 'required|in:setuju,tidak_setuju',
            'yang_menyatakan' => 'required|string|max:255',

            // Validasi untuk keluarga jika dipilih
            'nama_keluarga' => 'nullable|string|max:255',
            'tgl_lahir_keluarga' => 'nullable|date',
            'alamat_keluarga' => 'nullable|string',
            'jk_keluarga' => 'nullable|in:0,1',
            'no_telp_keluarga' => 'nullable|string|max:20',
            'no_ktp_keluarga' => 'nullable|string|max:20',
            'hubungan_keluarga' => 'nullable|string|max:100',

            // Validasi untuk saksi
            'nama_saksi1' => 'nullable|string|max:255',
            'tgl_lahir_saksi1' => 'nullable|date',
            'alamat_saksi1' => 'nullable|string',
            'jk_saksi1' => 'nullable|in:0,1,Laki-laki,Perempuan',
            'no_telp_saksi1' => 'nullable|string|max:20',
            'no_ktp_saksi1' => 'nullable|string|max:20',

            'nama_saksi2' => 'nullable|string|max:255',
            'tgl_lahir_saksi2' => 'nullable|date',
            'alamat_saksi2' => 'nullable|string',
            'jk_saksi2' => 'nullable|in:0,1,Laki-laki,Perempuan',
            'no_telp_saksi2' => 'nullable|string|max:20',
            'no_ktp_saksi2' => 'nullable|string|max:20',
        ]);

        // Normalize jenis kelamin
        $validated['jk_saksi1'] = $this->normalizeJenisKelamin($validated['jk_saksi1']);
        $validated['jk_saksi2'] = $this->normalizeJenisKelamin($validated['jk_saksi2']);

        if ($request->persetujuan_untuk === 'keluarga') {
            $validated['jk_keluarga'] = $this->normalizeJenisKelamin($validated['jk_keluarga']);
        }

        try {
            DB::beginTransaction();

            // Update data
            $validated['user_edit'] = Auth::id();
            $persetujuan->update($validated);

            DB::commit();

            return redirect()
                ->route('rawat-inap.persetujuan-transfusi-darah.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data persetujuan transfusi darah berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $persetujuan = RmePersetujuanTransfusiDarah::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->findOrFail($id);

        try {
            DB::beginTransaction();

            $persetujuan->delete();

            DB::commit();

            return redirect()
                ->route('rawat-inap.persetujuan-transfusi-darah.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data persetujuan transfusi darah berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Helper method untuk normalize jenis kelamin
     */
    private function normalizeJenisKelamin($jenisKelamin)
    {
        if ($jenisKelamin === 'Laki-laki' || $jenisKelamin == '1') {
            return 1;
        } elseif ($jenisKelamin === 'Perempuan' || $jenisKelamin == '0') {
            return 0;
        }
        return $jenisKelamin;
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
            $persetujuan = RmePersetujuanTransfusiDarah::with([
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
            $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.persetujuan-transfusi-darah.print', compact(
                'dataMedis',
                'persetujuan',
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
            $tanggal = $persetujuan->tanggal ? $persetujuan->tanggal->format('d-m-Y') : date('d-m-Y');
            $filename = 'Persetujuan_Transfusi_Darah_' .
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

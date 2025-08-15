<?php

namespace App\Http\Controllers\UnitPelayanan\Forensik;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Transaksi;
use App\Models\RmeVisumHidup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\Pdf;

class VisumHidupController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/forensik');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Ambil data transaksi untuk mendapatkan kd_kasir dan no_transaksi
        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$transaksi) {
            // Jika tidak ada transaksi, return empty pagination
            $visumHidupList = $this->createEmptyPagination(10);
            return view('unit-pelayanan.forensik.pelayanan.visum-hidup.index', compact('dataMedis', 'visumHidupList'));
        }

        // Query visum hidup berdasarkan transaksi
        $query = RmeVisumHidup::with(['dokter', 'userCreate'])
            ->where('no_transaksi', $transaksi->no_transaksi)
            ->where('kd_kasir', $transaksi->kd_kasir);

        // Filter berdasarkan tanggal
        if ($request->filled(['start_date', 'end_date'])) {
            $query->filterByDateRange($request->start_date, $request->end_date);
        }

        // Filter berdasarkan dokter
        if ($request->filled('search')) {
            $query->filterByDokter($request->search);
        }

        // Pagination
        $visumHidupList = $query->orderBy('tanggal', 'desc')
            ->where('kd_kasir', $transaksi->kd_kasir)
            ->where('no_transaksi', $transaksi->no_transaksi)
            ->where('registrasi', $kd_pasien)
            ->orderBy('jam', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('unit-pelayanan.forensik.pelayanan.visum-hidup.index', compact('dataMedis', 'visumHidupList'));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Generate nomor VeR otomatis
        $nomorVer = RmeVisumHidup::generateNomorVer();

        return view('unit-pelayanan.forensik.pelayanan.visum-hidup.create', compact('dataMedis', 'dokter', 'nomorVer'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nomor_ver' => 'required|string|max:255|unique:RME_VISUM_HIDUP,nomor_ver',
            'permintaan' => 'nullable|string|max:255',
            'nomor_surat' => 'nullable|string|max:255',
            'registrasi' => 'nullable|string|max:255',
            'menerangkan' => 'nullable|string|max:255',
            'hasil_pemeriksaan' => 'nullable|string',
            'hasil_kesimpulan' => 'nullable|string',
            'dokter_pemeriksa' => 'required|string|max:255|exists:dokter,kd_dokter'
        ], [
            'tanggal.required' => 'Tanggal pemeriksaan harus diisi',
            'jam.required' => 'Jam pemeriksaan harus diisi',
            'nomor_ver.required' => 'Nomor VeR harus diisi',
            'nomor_ver.unique' => 'Nomor VeR sudah digunakan',
            'dokter_pemeriksa.required' => 'Dokter pemeriksa harus dipilih',
            'dokter_pemeriksa.exists' => 'Dokter pemeriksa tidak valid'
        ]);

        // Cek data medis dan transaksi
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) {
            return back()->withErrors(['error' => 'Data medis tidak ditemukan'])->withInput();
        }

        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$transaksi) {
            return back()->withErrors(['error' => 'Data transaksi tidak ditemukan'])->withInput();
        }

        try {
            DB::beginTransaction();

            // Siapkan data untuk disimpan
            $data = $validated;
            $data['kd_kasir'] = $transaksi->kd_kasir;
            $data['no_transaksi'] = $transaksi->no_transaksi;
            $data['user_create'] = Auth::id();

            // Simpan data
            $visumHidup = RmeVisumHidup::create($data);

            DB::commit();

            return redirect()
                ->route('forensik.unit.pelayanan.visum-hidup.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Visum Hidup berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $visumHidup = RmeVisumHidup::with(['dokter', 'userCreate', 'userEdit'])->findOrFail($id);

        return view('unit-pelayanan.forensik.pelayanan.visum-hidup.show', compact('dataMedis', 'dokter', 'visumHidup'));
    }

    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $visumHidup = RmeVisumHidup::findOrFail($id);

        return view('unit-pelayanan.forensik.pelayanan.visum-hidup.edit', compact('dataMedis', 'dokter', 'visumHidup'));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $visumHidup = RmeVisumHidup::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nomor_ver' => 'required|string|max:255|unique:RME_VISUM_HIDUP,nomor_ver,' . $id,
            'permintaan' => 'nullable|string|max:255',
            'nomor_surat' => 'nullable|string|max:255',
            'registrasi' => 'nullable|string|max:255',
            'menerangkan' => 'nullable|string|max:255',
            'hasil_pemeriksaan' => 'nullable|string',
            'hasil_kesimpulan' => 'nullable|string',
            'dokter_pemeriksa' => 'required|string|max:255|exists:dokter,kd_dokter'
        ], [
            'tanggal.required' => 'Tanggal pemeriksaan harus diisi',
            'jam.required' => 'Jam pemeriksaan harus diisi',
            'nomor_ver.required' => 'Nomor VeR harus diisi',
            'nomor_ver.unique' => 'Nomor VeR sudah digunakan',
            'dokter_pemeriksa.required' => 'Dokter pemeriksa harus dipilih',
            'dokter_pemeriksa.exists' => 'Dokter pemeriksa tidak valid'
        ]);

        try {
            DB::beginTransaction();

            // Update data
            $validated['user_edit'] = Auth::id();
            $visumHidup->update($validated);

            DB::commit();

            return redirect()
                ->route('forensik.unit.pelayanan.visum-hidup.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Visum Hidup berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $visumHidup = RmeVisumHidup::findOrFail($id);

            DB::beginTransaction();

            $visumHidup->delete();

            DB::commit();

            return redirect()
                ->route('forensik.unit.pelayanan.visum-hidup.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Visum Hidup berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    // Method helper yang sudah ada
    private function getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } elseif ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return $dataMedis;
    }

    private function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return Transaksi::select('kd_kasir', 'no_transaksi')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_transaksi', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();
    }

    private function createEmptyPagination($perPage = 10)
    {
        return new LengthAwarePaginator(
            collect([]), // Empty collection
            0, // Total items
            $perPage, // Items per page
            1, // Current page
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Get medical data
            $dataMedis = Kunjungan::with(['pasien.suku', 'pasien.agama', 'pasien.pekerjaan', 'dokter', 'customer', 'unit'])
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
                abort(404, 'Data medis tidak ditemukan.');
            }

            // Calculate age
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Get transaction data
            $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksi) {
                abort(404, 'Data transaksi tidak ditemukan');
            }

            // Get VisumExit data
            $visumHidup = RmeVisumHidup::where('id', $id)
                ->where(function ($q) use ($transaksi) {
                    $q->where('no_transaksi', $transaksi->no_transaksi)
                        ->orWhere('kd_kasir', $transaksi->kd_kasir);
                })
                ->with(['dokter', 'userCreate', 'userEdit', 'transaksi'])
                ->firstOrFail();

            // Set locale for Indonesian date formatting
            Carbon::setLocale('id');

            // Load PDF view
            $pdf = PDF::loadView('unit-pelayanan.forensik.pelayanan.visum-hidup.print', compact(
                'dataMedis',
                'visumHidup'
            ));

            // Set paper to A4 portrait (as per original document)
            $pdf->setPaper('a4', 'portrait');

            // Set options for better rendering
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'serif',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'debugKeepTemp' => false,
            ]);

            // Generate safe filename - remove all problematic characters
            $safeNomorVer = $this->sanitizeFilename($visumHidup->nomor_ver);
            $safeDate = $visumHidup->tanggal ? Carbon::parse($visumHidup->tanggal)->format('d-m-Y') : date('d-m-Y');
            $safePasienName = $this->sanitizeFilename($dataMedis->pasien->nama ?? 'Unknown');

            $filename = "Visum-et-Repertum-{$safeNomorVer}-{$safePasienName}-{$safeDate}.pdf";

            return $pdf->stream($filename);
        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Sanitize filename by removing problematic characters
     */
    private function sanitizeFilename($filename)
    {
        // Remove or replace problematic characters
        $filename = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '-', $filename);

        // Remove multiple consecutive dashes
        $filename = preg_replace('/-+/', '-', $filename);

        // Remove leading and trailing dashes
        $filename = trim($filename, '-');

        // Ensure filename is not empty
        if (empty($filename)) {
            $filename = 'document';
        }

        return $filename;
    }
}

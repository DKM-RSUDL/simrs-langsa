<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokterInap;
use App\Models\Kunjungan;
use App\Models\OrientasiPasienBaru;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrientasiPasienBaruController extends Controller
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

        $dataDokter = DokterInap::with(['dokter', 'unit'])
            ->where('kd_unit', '1001')
            ->whereRelation('dokter', 'status', 1)
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $orientasiPasienBaru = OrientasiPasienBaru::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-inap.pelayanan.orientasi-pasien-baru.index', compact(
            'dataMedis',
            'dataDokter',
            'orientasiPasienBaru'
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.orientasi-pasien-baru.create',  compact('dataMedis'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {

            $validated = $request->validate([
                'tanggal' => 'required|date',
                'hubungan' => 'nullable|string|max:255',
                'tata_tertib' => 'nullable|array',
                'fasilitas' => 'nullable|array',
                'tenaga_medis' => 'nullable|array',
                'lokasi' => 'nullable|array',
                'administrasi' => 'nullable|array',
                'barang' => 'nullable|array',
                'informasi_lainnya' => 'nullable|array',
                'kegawatdaruratan' => 'nullable|array',
                'kegiatan' => 'nullable|array',
                'nama_penerima' => 'nullable|string|max:255',
                'nama_pemberi' => 'nullable|string|max:255',
                'fasilitas_lainnya_text' => 'nullable|string|max:255',
                'kegiatan_lainnya_text' => 'nullable|string|max:255',
                'lokasi_lainnya_text' => 'nullable|string|max:255',
                'administrasi_lainnya_text' => 'nullable|string|max:255',
                'barang_lainnya_1_text' => 'nullable|string|max:255',
                'barang_lainnya_2_text' => 'nullable|string|max:255',
                'barang_lainnya_3_text' => 'nullable|string|max:255',
            ]);

            // Ensure all array fields are converted to JSON strings
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tata_tertib' => !empty($validated['tata_tertib']) ? json_encode($validated['tata_tertib']) : json_encode([]),
                'fasilitas' => !empty($validated['fasilitas']) ? json_encode($validated['fasilitas']) : json_encode([]),
                'tenaga_medis' => !empty($validated['tenaga_medis']) ? json_encode($validated['tenaga_medis']) : json_encode([]),
                'lokasi' => !empty($validated['lokasi']) ? json_encode($validated['lokasi']) : json_encode([]),
                'administrasi' => !empty($validated['administrasi']) ? json_encode($validated['administrasi']) : json_encode([]),
                'barang' => !empty($validated['barang']) ? json_encode($validated['barang']) : json_encode([]),
                'informasi_lainnya' => !empty($validated['informasi_lainnya']) ? json_encode($validated['informasi_lainnya']) : json_encode([]),
                'kegawatdaruratan' => !empty($validated['kegawatdaruratan']) ? json_encode($validated['kegawatdaruratan']) : json_encode([]),
                'kegiatan' => !empty($validated['kegiatan']) ? json_encode($validated['kegiatan']) : json_encode([]),
                'nama_penerima' => $validated['nama_penerima'] ?? null,
                'nama_pemberi' => $validated['nama_pemberi'] ?? null,
                'tanggal' => $validated['tanggal'],
                'hubungan' => $validated['hubungan'] ?? null,
                'fasilitas_lainnya_text' => $validated['fasilitas_lainnya_text'] ?? null,
                'kegiatan_lainnya_text' => $validated['kegiatan_lainnya_text'] ?? null,
                'lokasi_lainnya_text' => $validated['lokasi_lainnya_text'] ?? null,
                'administrasi_lainnya_text' => $validated['administrasi_lainnya_text'] ?? null,
                'barang_lainnya_1_text' => $validated['barang_lainnya_2_text'] ?? null,
                'barang_lainnya_2_text' => $validated['barang_lainnya_2_text'] ?? null,
                'barang_lainnya_3_text' => $validated['barang_lainnya_3_text'] ?? null,
                'user_create' => auth()->user()->id,
            ];

            // Create the record
            OrientasiPasienBaru::create($data);
            DB::commit();

            return redirect()->route('rawat-inap.orientasi-pasien-baru.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $orientasiPasienBaru = OrientasiPasienBaru::findOrFail($id);

        // Decode JSON fields for display
        $orientasiPasienBaru->tata_tertib = $orientasiPasienBaru->tata_tertib ? json_decode($orientasiPasienBaru->tata_tertib, true) : null;
        $orientasiPasienBaru->fasilitas = $orientasiPasienBaru->fasilitas ? json_decode($orientasiPasienBaru->fasilitas, true) : null;
        $orientasiPasienBaru->tenaga_medis = $orientasiPasienBaru->tenaga_medis ? json_decode($orientasiPasienBaru->tenaga_medis, true) : null;
        $orientasiPasienBaru->lokasi = $orientasiPasienBaru->lokasi ? json_decode($orientasiPasienBaru->lokasi, true) : null;
        $orientasiPasienBaru->administrasi = $orientasiPasienBaru->administrasi ? json_decode($orientasiPasienBaru->administrasi, true) : null;
        $orientasiPasienBaru->barang = $orientasiPasienBaru->barang ? json_decode($orientasiPasienBaru->barang, true) : null;
        $orientasiPasienBaru->informasi_lainnya = $orientasiPasienBaru->informasi_lainnya ? json_decode($orientasiPasienBaru->informasi_lainnya, true) : null;
        $orientasiPasienBaru->kegawatdaruratan = $orientasiPasienBaru->kegawatdaruratan ? json_decode($orientasiPasienBaru->kegawatdaruratan, true) : null;
        $orientasiPasienBaru->kegiatan = $orientasiPasienBaru->kegiatan ? json_decode($orientasiPasienBaru->kegiatan, true) : null;

        return view('unit-pelayanan.rawat-inap.pelayanan.orientasi-pasien-baru.show', compact('dataMedis', 'orientasiPasienBaru'));
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $orientasiPasienBaru = OrientasiPasienBaru::findOrFail($id);

        // Decode JSON fields for the form
        $orientasiPasienBaru->tata_tertib = $orientasiPasienBaru->tata_tertib ? json_decode($orientasiPasienBaru->tata_tertib, true) : null;
        $orientasiPasienBaru->fasilitas = $orientasiPasienBaru->fasilitas ? json_decode($orientasiPasienBaru->fasilitas, true) : null;
        $orientasiPasienBaru->tenaga_medis = $orientasiPasienBaru->tenaga_medis ? json_decode($orientasiPasienBaru->tenaga_medis, true) : null;
        $orientasiPasienBaru->lokasi = $orientasiPasienBaru->lokasi ? json_decode($orientasiPasienBaru->lokasi, true) : null;
        $orientasiPasienBaru->administrasi = $orientasiPasienBaru->administrasi ? json_decode($orientasiPasienBaru->administrasi, true) : null;
        $orientasiPasienBaru->barang = $orientasiPasienBaru->barang ? json_decode($orientasiPasienBaru->barang, true) : null;
        $orientasiPasienBaru->informasi_lainnya = $orientasiPasienBaru->informasi_lainnya ? json_decode($orientasiPasienBaru->informasi_lainnya, true) : null;
        $orientasiPasienBaru->kegawatdaruratan = $orientasiPasienBaru->kegawatdaruratan ? json_decode($orientasiPasienBaru->kegawatdaruratan, true) : null;
        $orientasiPasienBaru->kegiatan = $orientasiPasienBaru->kegiatan ? json_decode($orientasiPasienBaru->kegiatan, true) : null;

        return view('unit-pelayanan.rawat-inap.pelayanan.orientasi-pasien-baru.edit', compact('dataMedis', 'orientasiPasienBaru'));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'hubungan' => 'nullable|string|max:255',
                'tata_tertib' => 'nullable|array',
                'fasilitas' => 'nullable|array',
                'tenaga_medis' => 'nullable|array',
                'lokasi' => 'nullable|array',
                'administrasi' => 'nullable|array',
                'barang' => 'nullable|array',
                'informasi_lainnya' => 'nullable|array',
                'kegawatdaruratan' => 'nullable|array',
                'kegiatan' => 'nullable|array',
                'nama_penerima' => 'nullable|string|max:255',
                'nama_pemberi' => 'nullable|string|max:255',
                'fasilitas_lainnya_text' => 'nullable|string|max:255',
                'kegiatan_lainnya_text' => 'nullable|string|max:255',
                'lokasi_lainnya_text' => 'nullable|string|max:255',
                'administrasi_lainnya_text' => 'nullable|string|max:255',
                'barang_lainnya_1_text' => 'nullable|string|max:255',
                'barang_lainnya_2_text' => 'nullable|string|max:255',
                'barang_lainnya_3_text' => 'nullable|string|max:255',
            ]);

            $orientasiPasienBaru = OrientasiPasienBaru::findOrFail($id);

            // Ensure all array fields are converted to JSON strings
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tata_tertib' => !empty($validated['tata_tertib']) ? json_encode($validated['tata_tertib']) : json_encode([]),
                'fasilitas' => !empty($validated['fasilitas']) ? json_encode($validated['fasilitas']) : json_encode([]),
                'tenaga_medis' => !empty($validated['tenaga_medis']) ? json_encode($validated['tenaga_medis']) : json_encode([]),
                'lokasi' => !empty($validated['lokasi']) ? json_encode($validated['lokasi']) : json_encode([]),
                'administrasi' => !empty($validated['administrasi']) ? json_encode($validated['administrasi']) : json_encode([]),
                'barang' => !empty($validated['barang']) ? json_encode($validated['barang']) : json_encode([]),
                'informasi_lainnya' => !empty($validated['informasi_lainnya']) ? json_encode($validated['informasi_lainnya']) : json_encode([]),
                'kegawatdaruratan' => !empty($validated['kegawatdaruratan']) ? json_encode($validated['kegawatdaruratan']) : json_encode([]),
                'kegiatan' => !empty($validated['kegiatan']) ? json_encode($validated['kegiatan']) : json_encode([]),
                'nama_penerima' => $validated['nama_penerima'] ?? null,
                'nama_pemberi' => $validated['nama_pemberi'] ?? null,
                'tanggal' => $validated['tanggal'],
                'hubungan' => $validated['hubungan'] ?? null,
                'fasilitas_lainnya_text' => $validated['fasilitas_lainnya_text'] ?? null,
                'kegiatan_lainnya_text' => $validated['kegiatan_lainnya_text'] ?? null,
                'lokasi_lainnya_text' => $validated['lokasi_lainnya_text'] ?? null,
                'administrasi_lainnya_text' => $validated['administrasi_lainnya_text'] ?? null,
                'barang_lainnya_1_text' => $validated['barang_lainnya_2_text'] ?? null,
                'barang_lainnya_2_text' => $validated['barang_lainnya_2_text'] ?? null,
                'barang_lainnya_3_text' => $validated['barang_lainnya_3_text'] ?? null,
                'user_create' => auth()->user()->id,
            ];

            $orientasiPasienBaru->update($data);
            DB::commit();

            return redirect()->route('rawat-inap.orientasi-pasien-baru.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $orientasiPasienBaru = OrientasiPasienBaru::findOrFail($id);
            $orientasiPasienBaru->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data orientasi pasien baru
            $orientasiPasienBaru = OrientasiPasienBaru::where('id', $id)->firstOrFail();

            // Ambil data medis (pasien, kunjungan, dll.)
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Hitung umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Generate tanggal dalam format Indonesia
            $tglSekarang = Carbon::now()->locale('id');
            $tglSekarang->settings(['formatFunction' => 'translatedFormat']);
            $tanggalLengkap = "RSUD Langsa, " . $tglSekarang->format('d F Y');

            // Parse data checkbox dari JSON ke array
            $checkboxFields = [
                'tata_tertib',
                'fasilitas',
                'tenaga_medis',
                'kegiatan',
                'lokasi',
                'administrasi',
                'barang',
                'informasi_lainnya',
                'kegawatdaruratan'
            ];

            // Penting: Pastikan semua data diproses dengan benar, bukan hanya diambil langsung
            foreach ($checkboxFields as $field) {
                if (is_string($orientasiPasienBaru->$field) && !empty($orientasiPasienBaru->$field)) {
                    // Jika masih berupa string JSON, decode
                    $orientasiPasienBaru->$field = json_decode($orientasiPasienBaru->$field, true);
                }

                // Pastikan hasilnya adalah array
                if (!is_array($orientasiPasienBaru->$field)) {
                    $orientasiPasienBaru->$field = [];
                }
            }

            // Data teks tambahan yang mungkin diperlukan
            $textFields = [
                'hubungan_lainnya',
                'fasilitas_lainnya_text',
                'kegiatan_lainnya_text',
                'lokasi_lainnya_text',
                'administrasi_lainnya_text',
                'barang_lainnya_1_text',
                'barang_lainnya_2_text',
                'barang_lainnya_3_text'
            ];

            foreach ($textFields as $field) {
                if (!isset($orientasiPasienBaru->$field)) {
                    $orientasiPasienBaru->$field = '';
                }
            }

            // Load view PDF
            $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.orientasi-pasien-baru.print', [
                'orientasiPasienBaru' => $orientasiPasienBaru,
                'dataMedis' => $dataMedis,
                'tanggalLengkap' => $tanggalLengkap
            ]);

            // Konfigurasi PDF
            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif',
                'chroot' => public_path()
            ]);

            // Generate dan download PDF
            return $pdf->stream("orientasi-pasien-baru-{$dataMedis->pasien->no_rm}-{$id}.pdf");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }
}
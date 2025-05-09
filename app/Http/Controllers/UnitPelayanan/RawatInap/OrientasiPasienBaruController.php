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

class OrientasiPasienBaruController extends Controller
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
        ]);

        $data = [
            'kd_pasien' => $kd_pasien,
            'kd_unit' => $kd_unit,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'tata_tertib' => $validated['tata_tertib'] ?? json_encode([]),
            'fasilitas' => $validated['fasilitas'] ?? json_encode([]),
            'tenaga_medis' => $validated['tenaga_medis'] ?? json_encode([]),
            'lokasi' => $validated['lokasi'] ?? json_encode([]),
            'administrasi' => $validated['administrasi'] ?? json_encode([]),
            'barang' => $validated['barang'] ?? json_encode([]),
            'informasi_lainnya' => $validated['informasi_lainnya'] ?? json_encode([]),
            'kegawatdaruratan' => $validated['kegawatdaruratan'] ?? json_encode([]),
            'kegiatan' => $validated['kegiatan'] ?? json_encode([]),
            'nama_penerima' => $validated['nama_penerima'] ?? null,
            'tanggal' => $validated['tanggal'],
            'hubungan' => $validated['hubungan'] ?? null,
            'user_create' => auth()->user()->id,
        ];

        OrientasiPasienBaru::create($data);

        return redirect()->route('rawat-inap.orientasi-pasien-baru.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data berhasil disimpan');
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
        ]);

        $orientasiPasienBaru = OrientasiPasienBaru::findOrFail($id);

        $data = [
            'kd_pasien' => $kd_pasien,
            'kd_unit' => $kd_unit,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'tata_tertib' => $validated['tata_tertib'] ?? json_encode([]),
            'fasilitas' => $validated['fasilitas'] ?? json_encode([]),
            'tenaga_medis' => $validated['tenaga_medis'] ?? json_encode([]),
            'lokasi' => $validated['lokasi'] ?? json_encode([]),
            'administrasi' => $validated['administrasi'] ?? json_encode([]),
            'barang' => $validated['barang'] ?? json_encode([]),
            'informasi_lainnya' => $validated['informasi_lainnya'] ?? json_encode([]),
            'kegawatdaruratan' => $validated['kegawatdaruratan'] ?? json_encode([]),
            'kegiatan' => $validated['kegiatan'] ?? json_encode([]),
            'nama_penerima' => $validated['nama_penerima'] ?? null,
            'tanggal' => $validated['tanggal'],
            'hubungan' => $validated['hubungan'] ?? null,
            'user_edit' => auth()->user()->id,
        ];

        $orientasiPasienBaru->update($data);

        return redirect()->route('rawat-inap.orientasi-pasien-baru.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data berhasil diperbarui');
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
}

<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat\ResikoJatuh;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeSkalaMorse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkalaMorseController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    /**
     * Helper method untuk mendapatkan data medis
     */
    private function getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
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

    public function index(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        // Query untuk mendapatkan data resiko jatuh
        $query = RmeSkalaMorse::with(['userCreate'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk);

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date)
                ->whereDate('tanggal', '<=', $request->end_date);
        }

        // Filter berdasarkan search nama petugas
        if ($request->filled('search')) {
            $query->whereHas('userCreate', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Urutkan berdasarkan tanggal terbaru
        $skalaMorseData = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.resiko-jatuh.skala-morse.index', compact(
            'dataMedis',
            'skalaMorseData'
        ));
    }

    public function create(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.resiko-jatuh.skala-morse.create', compact(
            'dataMedis',
        ));
    }

    public function checkDuplicate(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $query = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('tanggal', $request->tanggal)
            ->where('shift', $request->shift);

        // Jika ada parameter id (untuk edit), exclude record tersebut
        if ($request->has('id') && $request->id) {
            $query->where('id', '!=', $request->id);
        }

        $exists = $query->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Data dengan tanggal dan shift ini sudah ada!' : 'Data dapat disimpan'
        ]);
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'hari_ke' => 'required|integer|min:1',
            'shift' => 'required|in:PG,SI,ML',
            'riwayat_jatuh' => 'required|in:0,25',
            'diagnosa_sekunder' => 'required|in:0,15',
            'bantuan_ambulasi' => 'required|in:0,15,30',
            'terpasang_infus' => 'required|in:0,20',
            'gaya_berjalan' => 'required|in:0,10,20',
            'status_mental' => 'required|in:0,15',
            'skor_total' => 'required|integer|min:0',
            'kategori_resiko' => 'required|in:RR,RS,RT',
        ]);

        DB::beginTransaction();
        try {
            // Validasi duplikasi tanggal dan shift
            $existingData = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal', $request->tanggal)
                ->where('shift', $request->shift)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ' dan shift ' . ucfirst($request->shift) . ' sudah ada. Silakan pilih tanggal atau shift yang berbeda.')
                    ->withInput();
            }

            // Siapkan data untuk disimpan
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => 3,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => now()->format('H:i:s'),
                'hari_ke' => $request->hari_ke,
                'shift' => $request->shift,
                'riwayat_jatuh' => $request->riwayat_jatuh,
                'diagnosa_sekunder' => $request->diagnosa_sekunder,
                'bantuan_ambulasi' => $request->bantuan_ambulasi,
                'terpasang_infus' => $request->terpasang_infus,
                'gaya_berjalan' => $request->gaya_berjalan,
                'status_mental' => $request->status_mental,
                'skor_total' => $request->skor_total,
                'kategori_resiko' => $request->kategori_resiko,
            ];

            // Tambahkan intervensi berdasarkan kategori resiko
            // JANGAN gunakan json_encode karena model sudah ada cast 'array'
            if ($request->kategori_resiko == 'RR' && $request->has('intervensi_rr')) {
                $data['intervensi_rr'] = $request->intervensi_rr; // Langsung assign array
            }

            if ($request->kategori_resiko == 'RS' && $request->has('intervensi_rs')) {
                $data['intervensi_rs'] = $request->intervensi_rs; // Langsung assign array
            }

            if ($request->kategori_resiko == 'RT' && $request->has('intervensi_rt')) {
                $data['intervensi_rt'] = $request->intervensi_rt; // Langsung assign array
            }

            // Simpan data
            RmeSkalaMorse::create($data);

            DB::commit();

            return to_route('resiko-jatuh.morse.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])
                ->with('success', 'Data Pengkajian Resiko Jatuh Skala Morse berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        $skalaMorse = RmeSkalaMorse::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.resiko-jatuh.skala-morse.show', compact(
            'dataMedis',
            'skalaMorse'
        ));
    }

    public function edit(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        $skalaMorse = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.resiko-jatuh.skala-morse.edit', compact(
            'dataMedis',
            'skalaMorse'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'hari_ke' => 'required|integer|min:1',
            'shift' => 'required|in:PG,SI,ML',
            'riwayat_jatuh' => 'required|in:0,25',
            'diagnosa_sekunder' => 'required|in:0,15',
            'bantuan_ambulasi' => 'required|in:0,15,30',
            'terpasang_infus' => 'required|in:0,20',
            'gaya_berjalan' => 'required|in:0,10,20',
            'status_mental' => 'required|in:0,15',
            'skor_total' => 'required|integer|min:0',
            'kategori_resiko' => 'required|in:RR,RS,RT',
        ]);

        DB::beginTransaction();
        try {
            $skalaMorse = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 3)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->findOrFail($id);

            // Validasi duplikasi tanggal dan shift (EXCLUDE record yang sedang diedit)
            $existingData = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal', $request->tanggal)
                ->where('shift', $request->shift)
                ->where('id', '!=', $id) // TAMBAHKAN INI: exclude record yang sedang diedit
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal)) . ' dan shift ' . ucfirst($request->shift) . ' sudah ada. Silakan pilih tanggal atau shift yang berbeda.')
                    ->withInput();
            }

            // Siapkan data untuk diupdate
            $data = [
                'user_edit' => Auth::id(),
                'tanggal' => $request->tanggal,
                'hari_ke' => $request->hari_ke,
                'shift' => $request->shift,
                'riwayat_jatuh' => $request->riwayat_jatuh,
                'diagnosa_sekunder' => $request->diagnosa_sekunder,
                'bantuan_ambulasi' => $request->bantuan_ambulasi,
                'terpasang_infus' => $request->terpasang_infus,
                'gaya_berjalan' => $request->gaya_berjalan,
                'status_mental' => $request->status_mental,
                'skor_total' => $request->skor_total,
                'kategori_resiko' => $request->kategori_resiko,
            ];

            // Reset semua intervensi
            $data['intervensi_rr'] = null;
            $data['intervensi_rs'] = null;
            $data['intervensi_rt'] = null;

            // Tambahkan intervensi berdasarkan kategori resiko
            // JANGAN gunakan json_encode karena model sudah ada cast 'array'
            if ($request->kategori_resiko == 'RR' && $request->has('intervensi_rr')) {
                $data['intervensi_rr'] = $request->intervensi_rr; // Langsung assign array
            }

            if ($request->kategori_resiko == 'RS' && $request->has('intervensi_rs')) {
                $data['intervensi_rs'] = $request->intervensi_rs; // Langsung assign array
            }

            if ($request->kategori_resiko == 'RT' && $request->has('intervensi_rt')) {
                $data['intervensi_rt'] = $request->intervensi_rt; // Langsung assign array
            }

            // Update data
            $skalaMorse->update($data);

            DB::commit();

            return to_route('resiko-jatuh.morse.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])
                ->with('success', 'Data Pengkajian Resiko Jatuh Skala Morse berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $skalaMorse = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 3)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->findOrFail($id);

            $skalaMorse->delete();

            DB::commit();

            return to_route('resiko-jatuh.morse.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])
                ->with('success', 'Data Pengkajian Resiko Jatuh Skala Morse berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

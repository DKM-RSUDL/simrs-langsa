<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap\ResikoJatuh;

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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return $dataMedis;
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

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

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.index', compact(
            'dataMedis',
            'skalaMorseData'
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        // Ambil data penilaian terakhir yang valid untuk menentukan apakah penilaian perlu ditampilkan
        $lastAssessment = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.create', compact(
            'dataMedis',
            'lastAssessment'
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

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'shift' => 'required|in:PG,SI,ML'
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
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal)) . ' dan shift ' . $request->shift . ' sudah ada. Silakan pilih tanggal atau shift yang berbeda.')
                    ->withInput();
            }

            // Siapkan data untuk disimpan
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'hari_ke' => $request->hari_ke,
                'shift' => $request->shift,
            ];

            // Jika ada penilaian baru (checkbox dicentang atau use_existing_assessment = 0)
            if (($request->filled('skor_total') && $request->filled('kategori_resiko')) || $request->use_existing_assessment == '0') {
                $data['riwayat_jatuh'] = $request->riwayat_jatuh;
                $data['diagnosa_sekunder'] = $request->diagnosa_sekunder;
                $data['bantuan_ambulasi'] = $request->bantuan_ambulasi;
                $data['terpasang_infus'] = $request->terpasang_infus;
                $data['gaya_berjalan'] = $request->gaya_berjalan;
                $data['status_mental'] = $request->status_mental;
                $data['skor_total'] = $request->skor_total;
                $data['kategori_resiko'] = $request->kategori_resiko;
            } else {
                // Gunakan data existing atau data terakhir yang valid
                if ($request->has('existing_riwayat_jatuh')) {
                    // Gunakan data dari hidden input (existing)
                    $data['riwayat_jatuh'] = $request->existing_riwayat_jatuh;
                    $data['diagnosa_sekunder'] = $request->existing_diagnosa_sekunder;
                    $data['bantuan_ambulasi'] = $request->existing_bantuan_ambulasi;
                    $data['terpasang_infus'] = $request->existing_terpasang_infus;
                    $data['gaya_berjalan'] = $request->existing_gaya_berjalan;
                    $data['status_mental'] = $request->existing_status_mental;
                    $data['skor_total'] = $request->existing_skor_total;
                    $data['kategori_resiko'] = $request->existing_kategori_resiko;
                } else {
                    // Fallback: Gunakan data terakhir yang valid
                    $lastAssessment = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
                        ->where('kd_unit', $kd_unit)
                        ->whereDate('tgl_masuk', $tgl_masuk)
                        ->where('urut_masuk', $urut_masuk)
                        ->whereNotNull('riwayat_jatuh')
                        ->whereNotNull('diagnosa_sekunder')
                        ->whereNotNull('bantuan_ambulasi')
                        ->whereNotNull('terpasang_infus')
                        ->whereNotNull('gaya_berjalan')
                        ->whereNotNull('status_mental')
                        ->where('skor_total', '>', 0)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('jam', 'desc')
                        ->first();

                    if ($lastAssessment) {
                        $data['riwayat_jatuh'] = $lastAssessment->riwayat_jatuh;
                        $data['diagnosa_sekunder'] = $lastAssessment->diagnosa_sekunder;
                        $data['bantuan_ambulasi'] = $lastAssessment->bantuan_ambulasi;
                        $data['terpasang_infus'] = $lastAssessment->terpasang_infus;
                        $data['gaya_berjalan'] = $lastAssessment->gaya_berjalan;
                        $data['status_mental'] = $lastAssessment->status_mental;
                        $data['skor_total'] = $lastAssessment->skor_total;
                        $data['kategori_resiko'] = $lastAssessment->kategori_resiko;
                    }
                }
            }

            // Simpan semua intervensi yang dikirim (tampung rr/rs/rt apa adanya)
            $data['intervensi_rr'] = $request->input('intervensi_rr', null);
            $data['intervensi_rs'] = $request->input('intervensi_rs', null);
            $data['intervensi_rt'] = $request->input('intervensi_rt', null);

            // Simpan data
            RmeSkalaMorse::create($data);

            DB::commit();

            return to_route('rawat-inap.resiko-jatuh.morse.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])
                ->with('success', 'Data Pengkajian Resiko Jatuh Skala Morse berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $skalaMorse = RmeSkalaMorse::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->findOrFail($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.show', compact(
            'dataMedis',
            'skalaMorse'
        ));
    }

    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $skalaMorse = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->findOrFail($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.edit', compact(
            'dataMedis',
            'skalaMorse'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'shift' => 'required|in:PG,SI,ML',
        ]);

        DB::beginTransaction();
        try {
            $skalaMorse = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->findOrFail($id);

            // Validasi duplikasi tanggal dan shift
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
                'jam' => $request->jam,
                'shift' => $request->shift,
            ];

            // Cek apakah menggunakan assessment existing atau membuat baru
            if ($request->use_existing_assessment == '1') {
                // Gunakan data existing (tidak membuat penilaian baru)
                $data['riwayat_jatuh'] = $request->existing_riwayat_jatuh;
                $data['diagnosa_sekunder'] = $request->existing_diagnosa_sekunder;
                $data['bantuan_ambulasi'] = $request->existing_bantuan_ambulasi;
                $data['terpasang_infus'] = $request->existing_terpasang_infus;
                $data['gaya_berjalan'] = $request->existing_gaya_berjalan;
                $data['status_mental'] = $request->existing_status_mental;
                $data['skor_total'] = $request->existing_skor_total;
                $data['kategori_resiko'] = $request->existing_kategori_resiko;
            } else {
                // Gunakan data penilaian baru
                $data['riwayat_jatuh'] = $request->riwayat_jatuh;
                $data['diagnosa_sekunder'] = $request->diagnosa_sekunder;
                $data['bantuan_ambulasi'] = $request->bantuan_ambulasi;
                $data['terpasang_infus'] = $request->terpasang_infus;
                $data['gaya_berjalan'] = $request->gaya_berjalan;
                $data['status_mental'] = $request->status_mental;
                $data['skor_total'] = $request->skor_total;
                $data['kategori_resiko'] = $request->kategori_resiko;
            }

            // Tambahkan intervensi berdasarkan kategori resiko
            $data['kategori_resiko'];

            // Jika membuat penilaian baru (user menilai ulang), ambil semua intervensi dari request
            // Jika menggunakan existing assessment (use_existing_assessment == '1'), jangan ubah intervensi
            $data['intervensi_rr'] = $request->input('intervensi_rr', null);
            $data['intervensi_rs'] = $request->input('intervensi_rs', null);
            $data['intervensi_rt'] = $request->input('intervensi_rt', null);

            // Update data
            $skalaMorse->update($data);

            DB::commit();

            return to_route('rawat-inap.resiko-jatuh.morse.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])
                ->with('success', 'Data Pengkajian Resiko Jatuh Skala Morse berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $skalaMorse = RmeSkalaMorse::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->findOrFail($id);

            $skalaMorse->delete();

            DB::commit();

            return to_route('rawat-inap.resiko-jatuh.morse.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])
                ->with('success', 'Data Pengkajian Resiko Jatuh Skala Morse berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

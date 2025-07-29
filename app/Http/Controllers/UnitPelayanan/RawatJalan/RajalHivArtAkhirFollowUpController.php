<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RmeHivArtAkhiriFollowUp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RajalHivArtAkhirFollowUpController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Get existing HIV ART follow-up data
        $hivArtData = RmeHivArtAkhiriFollowUp::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        // start fungsi Tabs
        $activeTab = $request->query('tab', 'ikhtisar');
        $allowedTabs = ['ikhtisar', 'followUp'];

        if (!in_array($activeTab, $allowedTabs)) {
            $activeTab = 'ikhtisar';
        }

        if ($activeTab == 'ikhtisar') {
            return $this->ikhtisarTab($dataMedis, $activeTab, $hivArtData);
        } else {
            return $this->followUpTab($dataMedis, $activeTab, $hivArtData);
        }
    }

    private function getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
        } else if ($dataMedis) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return $dataMedis;
    }

    private function ikhtisarTab($dataMedis, $activeTab, $hivArtData)
    {
        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.index', compact(
            'dataMedis',
            'activeTab',
            'hivArtData'
        ));
    }

    private function followUpTab($dataMedis, $activeTab, $hivArtData)
    {
        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art_akhiri_follow_up.index', compact(
            'dataMedis',
            'activeTab',
            'hivArtData'
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Check if there's existing data for today
        $existingData = RmeHivArtAkhiriFollowUp::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art_akhiri_follow_up.create', compact(
            'dataMedis',
            'existingData'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi dasar dengan pesan error yang lebih jelas
        $validator = Validator::make($request->all(), [
            'catatan_umum' => 'nullable|string|max:1000',
        ]);

        // Validasi dinamis untuk field visits
        $visitFields = [];
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^(tanggal_kunjungan|bb|tb|cd4|status_fungsional|hamil|status_tb|adherence_art|akhir_followup)_(\d+)$/', $key, $matches)) {
                $fieldName = $matches[1];
                $visitNumber = $matches[2];

                switch ($fieldName) {
                    case 'tanggal_kunjungan':
                        $visitFields[$key] = 'nullable|date';
                        break;
                    case 'bb':
                        $visitFields[$key] = 'nullable|numeric|min:0|max:500';
                        break;
                    case 'tb':
                        $visitFields[$key] = 'nullable|numeric|min:0|max:300';
                        break;
                    case 'cd4':
                        $visitFields[$key] = 'nullable|integer|min:0';
                        break;
                    case 'status_fungsional':
                        $visitFields[$key] = 'nullable|in:1,2,3';
                        break;
                    case 'hamil':
                        $visitFields[$key] = 'nullable|in:1,2,3';
                        break;
                    case 'status_tb':
                        $visitFields[$key] = 'nullable|in:1,2,3,4';
                        break;
                    case 'adherence_art':
                        $visitFields[$key] = 'nullable|in:1,2,3';
                        break;
                    case 'akhir_followup':
                        $visitFields[$key] = 'nullable|in:aktif,m,lfu,rk';
                        break;
                }
            }
        }

        // Gabungkan validasi
        $allValidationRules = array_merge($validator->getRules(), $visitFields);
        $mainValidator = Validator::make($request->all(), $allValidationRules);

        try {
            DB::beginTransaction();

            // Format data visits dari form
            $visitsData = RmeHivArtAkhiriFollowUp::formatVisitData($request->all());

            // Validasi minimal harus ada 1 visit dengan data lengkap
            if (empty($visitsData)) {
                throw new \Exception('Minimal harus ada 1 kunjungan yang diisi.');
            }

            // Validasi setiap visit
            foreach ($visitsData as $visit) {
                if (!RmeHivArtAkhiriFollowUp::validateVisitData($visit)) {
                    throw new \Exception('Data kunjungan #' . ($visit['visit_number'] ?? 'tidak diketahui') . ' tidak lengkap. Pastikan tanggal kunjungan, berat badan, dan status fungsional sudah diisi.');
                }
            }

            // Tentukan status akhir dari visit terakhir
            $lastVisit = collect($visitsData)->sortByDesc('visit_number')->first();
            $statusAkhir = $lastVisit['akhir_followup'] ?? 'aktif';

            // Prepare data untuk disimpan
            $dataToSave = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
                'user_create' => Auth::id(),
                'visits_data' => $visitsData,
                'total_visits' => count($visitsData),
                'status_akhir' => $statusAkhir,
                'catatan_umum' => $request->input('catatan_umum'),
                'created_at' => now(),
                'updated_at' => now()
            ];


            // Buat record baru
            $hivArtRecord = RmeHivArtAkhiriFollowUp::create($dataToSave);


            DB::commit();

            return redirect()
                ->route('rawat-jalan.hiv_art_akhir_follow_up.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk,
                    'tab' => 'followUp'
                ])
                ->with('success', 'Data follow-up HIV ART berhasil disimpan dengan ' . count($visitsData) . ' kunjungan.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $hivArtData = RmeHivArtAkhiriFollowUp::findOrFail($id);

        // Pastikan data sesuai dengan pasien yang benar
        if ($hivArtData->kd_pasien !== $kd_pasien) {
            abort(404);
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art_akhiri_follow_up.show', compact(
            'dataMedis',
            'hivArtData'
        ));
    }

    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $hivArtData = RmeHivArtAkhiriFollowUp::findOrFail($id);

        // Pastikan data sesuai dengan pasien yang benar
        if ($hivArtData->kd_pasien !== $kd_pasien) {
            abort(404);
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art_akhiri_follow_up.edit', compact(
            'dataMedis',
            'hivArtData'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $hivArtData = RmeHivArtAkhiriFollowUp::findOrFail($id);

        // Pastikan data sesuai dengan pasien yang benar
        if ($hivArtData->kd_pasien !== $kd_pasien) {
            abort(404);
        }

        // Validasi sama seperti store
        $validator = Validator::make($request->all(), [
            'tanggal_kunjungan_*' => 'nullable|date',
            'bb_*' => 'nullable|numeric|min:0|max:500',
            'tb_*' => 'nullable|numeric|min:0|max:300',
            'cd4_*' => 'nullable|integer|min:0',
            'status_fungsional_*' => 'nullable|in:1,2,3',
            'hamil_*' => 'nullable|in:1,2,3',
            'status_tb_*' => 'nullable|in:1,2,3,4',
            'adherence_art_*' => 'nullable|in:1,2,3',
            'akhir_followup_*' => 'nullable|in:aktif,m,lfu,rk'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data tidak valid. Periksa kembali input Anda.');
        }

        try {
            DB::beginTransaction();

            // Format data visits dari form
            $visitsData = RmeHivArtAkhiriFollowUp::formatVisitData($request->all());

            if (empty($visitsData)) {
                throw new \Exception('Minimal harus ada 1 kunjungan yang diisi.');
            }

            // Validasi setiap visit
            foreach ($visitsData as $visit) {
                if (!RmeHivArtAkhiriFollowUp::validateVisitData($visit)) {
                    throw new \Exception('Data kunjungan #' . $visit['visit_number'] . ' tidak lengkap.');
                }
            }

            // Update record
            $hivArtData->update([
                'user_edit' => Auth::id(),
                'visits_data' => $visitsData,
                'catatan_umum' => $request->input('catatan_umum')
            ]);

            DB::commit();

            return redirect()
                ->route('rawat-jalan.hiv_art_akhir_follow_up.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk,
                    'tab' => 'followUp'
                ])
                ->with('success', 'Data follow-up HIV ART berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $hivArtData = RmeHivArtAkhiriFollowUp::findOrFail($id);

            // Pastikan data sesuai dengan pasien yang benar
            if ($hivArtData->kd_pasien !== $kd_pasien) {
                abort(404);
            }

            $hivArtData->delete();

            return redirect()
                ->route('rawat-jalan.hiv_art_akhir_follow_up.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk,
                    'tab' => 'followUp'
                ])
                ->with('success', 'Data follow-up HIV ART berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    // API endpoint untuk mendapatkan data dalam format JSON
    public function getVisitsData(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $hivArtData = RmeHivArtAkhiriFollowUp::findOrFail($id);

            if ($hivArtData->kd_pasien !== $kd_pasien) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'visits' => $hivArtData->getOrderedVisits(),
                    'total_visits' => $hivArtData->total_visits,
                    'status_akhir' => $hivArtData->status_akhir,
                    'last_visit' => $hivArtData->getLastVisit()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

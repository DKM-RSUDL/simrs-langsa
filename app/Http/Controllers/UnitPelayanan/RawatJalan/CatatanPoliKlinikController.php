<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeCatatanPoliklinik;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatatanPoliKlinikController extends Controller
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

        $query = RmeCatatanPoliklinik::where('kd_pasien', $kd_pasien);

        // Filter berdasarkan option
        if ($request->has('option') && $request->option != 'semua') {
            switch ($request->option) {
                case 'option1': // Episode Sekarang
                    $query->where('kd_unit', $kd_unit)
                        ->whereDate('tgl_masuk', $tgl_masuk)
                        ->where('urut_masuk', $urut_masuk);
                    break;
                case 'option2': // 1 Bulan
                    $query->where('tanggal', '>=', Carbon::now()->subMonth());
                    break;
                case 'option3': // 3 Bulan
                    $query->where('tanggal', '>=', Carbon::now()->subMonths(3));
                    break;
                case 'option4': // 6 Bulan
                    $query->where('tanggal', '>=', Carbon::now()->subMonths(6));
                    break;
                case 'option5': // 9 Bulan
                    $query->where('tanggal', '>=', Carbon::now()->subMonths(9));
                    break;
            }
        }

        // Filter berdasarkan tanggal
        if ($request->start_date) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        // Search berdasarkan assessment/diagnosis atau SOAP
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('assessment', 'like', '%' . $request->search . '%')
                    ->orWhere('subjective', 'like', '%' . $request->search . '%')
                    ->orWhere('objective', 'like', '%' . $request->search . '%')
                    ->orWhere('plan', 'like', '%' . $request->search . '%');
            });
        }

        $catatanPoliklinik = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-jalan.pelayanan.catatan-poliklinik.index', compact(
            'dataMedis',
            'catatanPoliklinik'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        return view('unit-pelayanan.rawat-jalan.pelayanan.catatan-poliklinik.create', compact(
            'dataMedis',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'subjective' => 'nullable|string|max:255',
            'objective' => 'nullable|string|max:255',
            'assessment' => 'nullable|string|max:255',
            'plan' => 'nullable|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'jam.required' => 'Jam harus diisi',
            'subjective.nullable' => 'Subjective (S) harus diisi',
            'objective.nullable' => 'Objective (O) harus diisi',
            'assessment.nullable' => 'Assessment (A) harus diisi',
            'plan.nullable' => 'Plan (P) harus diisi',
            'subjective.max' => 'Subjective maksimal 255 karakter',
            'objective.max' => 'Objective maksimal 255 karakter',
            'assessment.max' => 'Assessment maksimal 255 karakter',
            'plan.max' => 'Plan maksimal 255 karakter',
        ]);

        try {
            DB::beginTransaction();

            RmeCatatanPoliklinik::create([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'subjective' => $request->subjective,
                'objective' => $request->objective,
                'assessment' => $request->assessment,
                'plan' => $request->plan,
                'user_create' => Auth::id(),
            ]);

            DB::commit();

            return redirect()
                ->route('rawat-jalan.catatan-poliklinik.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('success', 'Catatan klinik berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan catatan klinik: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $catatanPoliklinik = RmeCatatanPoliklinik::findOrFail($id);

        return view('unit-pelayanan.rawat-jalan.pelayanan.catatan-poliklinik.show', compact(
            'dataMedis',
            'catatanPoliklinik'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $catatanPoliklinik = RmeCatatanPoliklinik::findOrFail($id);

        // Check if user can edit (same unit)
        if ($catatanPoliklinik->kd_unit != $kd_unit) {
            return redirect()
                ->route('rawat-jalan.catatan-poliklinik.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('error', 'Anda tidak memiliki akses untuk mengedit catatan ini');
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.catatan-poliklinik.edit', compact(
            'dataMedis',
            'catatanPoliklinik'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'subjective' => 'nullable|string|max:255',
            'objective' => 'nullable|string|max:255',
            'assessment' => 'nullable|string|max:255',
            'plan' => 'nullable|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'jam.required' => 'Jam harus diisi',
            'subjective.nullable' => 'Subjective (S) harus diisi',
            'objective.nullable' => 'Objective (O) harus diisi',
            'assessment.nullable' => 'Assessment (A) harus diisi',
            'plan.nullable' => 'Plan (P) harus diisi',
            'subjective.max' => 'Subjective maksimal 255 karakter',
            'objective.max' => 'Objective maksimal 255 karakter',
            'assessment.max' => 'Assessment maksimal 255 karakter',
            'plan.max' => 'Plan maksimal 255 karakter',
        ]);

        try {
            DB::beginTransaction();

            $catatanPoliklinik = RmeCatatanPoliklinik::findOrFail($id);

            // Check if user can edit (same unit)
            if ($catatanPoliklinik->kd_unit != $kd_unit) {
                return redirect()
                    ->route('rawat-jalan.catatan-poliklinik.index', [
                        $kd_unit,
                        $kd_pasien,
                        $tgl_masuk,
                        $urut_masuk
                    ])
                    ->with('error', 'Anda tidak memiliki akses untuk mengedit catatan ini');
            }

            $catatanPoliklinik->update([
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'subjective' => $request->subjective,
                'objective' => $request->objective,
                'assessment' => $request->assessment,
                'plan' => $request->plan,
                'user_edit' => Auth::id(),
            ]);

            DB::commit();

            return redirect()
                ->route('rawat-jalan.catatan-poliklinik.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('success', 'Catatan klinik berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui catatan klinik: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $catatanPoliklinik = RmeCatatanPoliklinik::findOrFail($id);

            // Check if user can delete (same unit)
            if ($catatanPoliklinik->kd_unit != $kd_unit) {
                return redirect()
                    ->route('rawat-jalan.catatan-poliklinik.index', [
                        $kd_unit,
                        $kd_pasien,
                        $tgl_masuk,
                        $urut_masuk
                    ])
                    ->with('error', 'Anda tidak memiliki akses untuk menghapus catatan ini');
            }

            $catatanPoliklinik->delete();

            DB::commit();

            return redirect()
                ->route('rawat-jalan.catatan-poliklinik.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('success', 'Catatan klinik berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus catatan klinik: ' . $e->getMessage());
        }
    }
}

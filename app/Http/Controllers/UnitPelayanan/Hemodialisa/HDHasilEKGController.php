<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\RmeHdEkg;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class HDHasilEKGController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        // Query data EKG dengan filter
        $query = RmeHdEkg::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_);

        // Filter berdasarkan pencarian diagnosis
        if ($request->filled('search')) {
            $query->where('diagnosis', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan option periode
        if ($request->filled('option')) {
            switch ($request->option) {
                case 'option1': // Episode Sekarang
                    $query->whereDate('tanggal', $tgl_masuk);
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
                default: // Semua Episode
                    break;
            }
        }

        $hdHasilEkg = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.hemodialisa.pelayanan.hasil-ekg.index', compact(
            'dataMedis',
            'hdHasilEkg'
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);
        $perawat = HrdKaryawan::where('status_peg', 1)->get();
        $dokter = Dokter::where('status', 1)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.hasil-ekg.create', compact(
            'dataMedis',
            'perawat',
            'dokter'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lead_i' => 'nullable|string|max:255',
            'lead_ii' => 'nullable|string|max:255',
            'lead_iii' => 'nullable|string|max:255',
            'lead_avr' => 'nullable|string|max:255',
            'lead_avl' => 'nullable|string|max:255',
            'lead_avf' => 'nullable|string|max:255',
            'lead_v1' => 'nullable|string|max:255',
            'lead_v2' => 'nullable|string|max:255',
            'lead_v3' => 'nullable|string|max:255',
            'lead_v4' => 'nullable|string|max:255',
            'lead_v5' => 'nullable|string|max:255',
            'lead_v6' => 'nullable|string|max:255',
            'diagnosis' => 'nullable|string|max:255',
            'kd_perawat' => 'nullable|string|max:255',
            'kd_dokter' => 'nullable|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'jam.required' => 'Jam harus diisi',
        ]);

        try {
            DB::beginTransaction();

            RmeHdEkg::create([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'lead_i' => $request->lead_i,
                'lead_ii' => $request->lead_ii,
                'lead_iii' => $request->lead_iii,
                'lead_avr' => $request->lead_avr,
                'lead_avl' => $request->lead_avl,
                'lead_avf' => $request->lead_avf,
                'lead_v1' => $request->lead_v1,
                'lead_v2' => $request->lead_v2,
                'lead_v3' => $request->lead_v3,
                'lead_v4' => $request->lead_v4,
                'lead_v5' => $request->lead_v5,
                'lead_v6' => $request->lead_v6,
                'diagnosis' => $request->diagnosis,
                'kd_perawat' => $request->kd_perawat,
                'kd_dokter' => $request->kd_dokter,
                'user_create' => Auth::id(),
            ]);

            DB::commit();

            return redirect()
                ->route('hemodialisa.pelayanan.hasil-ekg.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data hasil EKG berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        $hasilEkg = RmeHdEkg::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->findOrFail($id);

        $perawat = HrdKaryawan::where('status_peg', 1)->get();
        $dokter = Dokter::where('status', 1)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.hasil-ekg.show', compact(
            'dataMedis',
            'hasilEkg',
            'perawat',
            'dokter'
        ));
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        $hasilEkg = RmeHdEkg::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->findOrFail($id);

        $perawat = HrdKaryawan::where('status_peg', 1)->get();
        $dokter = Dokter::where('status', 1)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.hasil-ekg.edit', compact(
            'dataMedis',
            'hasilEkg',
            'perawat',
            'dokter'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $hasilEkg = RmeHdEkg::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lead_i' => 'nullable|string|max:255',
            'lead_ii' => 'nullable|string|max:255',
            'lead_iii' => 'nullable|string|max:255',
            'lead_avr' => 'nullable|string|max:255',
            'lead_avl' => 'nullable|string|max:255',
            'lead_avf' => 'nullable|string|max:255',
            'lead_v1' => 'nullable|string|max:255',
            'lead_v2' => 'nullable|string|max:255',
            'lead_v3' => 'nullable|string|max:255',
            'lead_v4' => 'nullable|string|max:255',
            'lead_v5' => 'nullable|string|max:255',
            'lead_v6' => 'nullable|string|max:255',
            'diagnosis' => 'nullable|string|max:255',
            'kd_perawat' => 'nullable|string|max:255',
            'kd_dokter' => 'nullable|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'jam.required' => 'Jam harus diisi',
        ]);

        try {
            DB::beginTransaction();

            $hasilEkg->update([
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'lead_i' => $request->lead_i,
                'lead_ii' => $request->lead_ii,
                'lead_iii' => $request->lead_iii,
                'lead_avr' => $request->lead_avr,
                'lead_avl' => $request->lead_avl,
                'lead_avf' => $request->lead_avf,
                'lead_v1' => $request->lead_v1,
                'lead_v2' => $request->lead_v2,
                'lead_v3' => $request->lead_v3,
                'lead_v4' => $request->lead_v4,
                'lead_v5' => $request->lead_v5,
                'lead_v6' => $request->lead_v6,
                'diagnosis' => $request->diagnosis,
                'kd_perawat' => $request->kd_perawat,
                'kd_dokter' => $request->kd_dokter,
                'user_edit' => Auth::id(),
            ]);

            DB::commit();

            return redirect()
                ->route('hemodialisa.pelayanan.hasil-ekg.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data hasil EKG berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $hasilEkg = RmeHdEkg::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnitDef_)
                ->findOrFail($id);

            $hasilEkg->delete();

            return redirect()
                ->route('hemodialisa.pelayanan.hasil-ekg.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data hasil EKG berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
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
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
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

        return $dataMedis;
    }


    // -----------------------------------------------------------------
    // --- FUNGSI BARU DIMULAI DARI SINI ---
    // -----------------------------------------------------------------

    /**
     * Tampilkan PDF Hasil EKG Pasien
     */
    public function printPDF($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // 1. Ambil Data Medis (helper)
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        // 2. Ambil Data EKG
        $hasilEkg = RmeHdEkg::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->findOrFail($id);

        // 3. Ambil data Perawat dan Dokter
        //    (Ini BEDA dari show, kita ambil data spesifik, bukan list)
        $perawat = HrdKaryawan::where('kd_karyawan', $hasilEkg->kd_perawat)->first();
        $dokter = Dokter::where('kd_dokter', $hasilEkg->kd_dokter)->first();

        // 4. Buat PDF
        $pdf = Pdf::loadView('unit-pelayanan.hemodialisa.pelayanan.hasil-ekg.print', compact(
            'dataMedis',
            'hasilEkg',
            'perawat',
            'dokter'
        ));

        // Atur ukuran kertas
        $pdf->setPaper('a4', 'portrait');

        // 5. Tampilkan PDF di browser
        return $pdf->stream('hasil-ekg-hd-' . $dataMedis->pasien->nama . '.pdf');
    }
}

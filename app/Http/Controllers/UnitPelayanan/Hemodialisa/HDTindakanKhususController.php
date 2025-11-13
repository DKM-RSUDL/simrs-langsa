<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeHdTindakanKhusus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class HDTindakanKhususController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $user = auth()->user();

        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        // Query untuk tindakan khusus
        $query = RmeHdTindakanKhusus::with('userCreate')
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk);

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter berdasarkan periode
        if ($request->has('option') && $request->option !== 'semua') {
            $now = Carbon::now();
            switch ($request->option) {
                case 'option1': // Episode Sekarang
                    $query->whereDate('tanggal', $dataMedis->tgl_masuk);
                    break;
                case 'option2': // 1 Bulan
                    $query->where('tanggal', '>=', $now->subMonth());
                    break;
                case 'option3': // 3 Bulan
                    $query->where('tanggal', '>=', $now->subMonths(3));
                    break;
                case 'option4': // 6 Bulan
                    $query->where('tanggal', '>=', $now->subMonths(6));
                    break;
                case 'option5': // 9 Bulan
                    $query->where('tanggal', '>=', $now->subMonths(9));
                    break;
            }
        }

        // Filter berdasarkan custom date range
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        $hdTindakanKhusus = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.hemodialisa.pelayanan.tindakan-khusus.index', compact(
            'dataMedis',
            'hdTindakanKhusus'
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        return view('unit-pelayanan.hemodialisa.pelayanan.tindakan-khusus.create', compact(
            'dataMedis'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'diagnosis' => 'nullable|string',
            'hasil_lab' => 'nullable|string',
            'obat_tindakan' => 'nullable|string',
            'follow_up' => 'nullable|string',
            'catatan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Gabungkan tanggal dan jam
            $jamDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->tanggal . ' ' . $request->jam); // Fixed: was jam_masuk, now jam

            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => auth()->id(),
                'tanggal' => $request->tanggal,
                'jam' => $jamDateTime,
                'diagnosis' => $request->diagnosis,
                'hasil_lab' => $request->hasil_lab,
                'obat_tindakan' => $request->obat_tindakan,
                'follow_up' => $request->follow_up,
                'catatan' => $request->catatan
            ];

            RmeHdTindakanKhusus::create($data);

            DB::commit();

            return redirect()
                ->route('hemodialisa.pelayanan.tindakan-khusus.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data tindakan khusus berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        $tindakanKhusus = RmeHdTindakanKhusus::with('userCreate')
            ->where('id', $id)
            ->byPasien($kd_pasien, $tgl_masuk, $urut_masuk)
            ->firstOrFail();

        return view('unit-pelayanan.hemodialisa.pelayanan.tindakan-khusus.show', compact(
            'dataMedis',
            'tindakanKhusus'
        ));
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        $tindakanKhusus = RmeHdTindakanKhusus::where('id', $id)
            ->byPasien($kd_pasien, $tgl_masuk, $urut_masuk)
            ->firstOrFail();

        return view('unit-pelayanan.hemodialisa.pelayanan.tindakan-khusus.edit', compact(
            'dataMedis',
            'tindakanKhusus'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'diagnosis' => 'nullable|string',
            'hasil_lab' => 'nullable|string',
            'obat_tindakan' => 'nullable|string',
            'follow_up' => 'nullable|string',
            'catatan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $tindakanKhusus = RmeHdTindakanKhusus::where('id', $id)
                ->byPasien($kd_pasien, $tgl_masuk, $urut_masuk)
                ->firstOrFail();

            // Gabungkan tanggal dan jam
            $jamDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->tanggal . ' ' . $request->jam);

            $tindakanKhusus->update([
                'user_edit' => auth()->id(),
                'tanggal' => $request->tanggal,
                'jam' => $jamDateTime,
                'diagnosis' => $request->diagnosis,
                'hasil_lab' => $request->hasil_lab,
                'obat_tindakan' => $request->obat_tindakan,
                'follow_up' => $request->follow_up,
                'catatan' => $request->catatan
            ]);

            DB::commit();

            return redirect()
                ->route('hemodialisa.pelayanan.tindakan-khusus.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data tindakan khusus berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $tindakanKhusus = RmeHdTindakanKhusus::where('id', $id)
                ->byPasien($kd_pasien, $tgl_masuk, $urut_masuk)
                ->firstOrFail();

            $tindakanKhusus->delete();

            DB::commit();

            return redirect()
                ->route('hemodialisa.pelayanan.tindakan-khusus.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data tindakan khusus berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
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
    /**
     * Tampilkan PDF Tindakan Khusus Pasien
     */
    public function printPDF($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // 1. Ambil Data Medis (helper)
        $dataMedis = $this->getDataMedis($kd_pasien, $tgl_masuk, $urut_masuk);

        // 2. Ambil Data Tindakan Khusus (dari fungsi show)
        //    Eager load 'userCreate' dan 'userCreate.karyawan' untuk TTD
        $tindakanKhusus = RmeHdTindakanKhusus::with('userCreate.karyawan')
            ->where('id', $id)
            // ->byPasien($kd_pasien, $tgl_masuk, $urut_masuk) // Anda bisa pakai scope jika ada
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // 3. Buat PDF
        $pdf = Pdf::loadView('unit-pelayanan.hemodialisa.pelayanan.tindakan-khusus.print', compact(
            'dataMedis',
            'tindakanKhusus'
        ));

        // Atur ukuran kertas
        $pdf->setPaper('a4', 'portrait');

        // 4. Tampilkan PDF di browser
        return $pdf->stream('tindakan-khusus-hd-' . $dataMedis->pasien->nama . '.pdf');
    }
}

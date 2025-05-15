<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\ICCU;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\PermintaanSecondOpinion;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;

class MasukKeluarIccuController extends Controller
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


        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // fungsi tab
        $tabs = $request->query('tab');

        if ($tabs == 'monitoring') {
            return $this->monitoringTab($dataMedis, $request);
        } else {
            return $this->iccuTab($dataMedis, $request);
        }
    }

    private function iccuTab($dataMedis, $request)
    {
        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        $dataIccu = ICCU::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.iccu.index', compact(
            'dataMedis',
            'dokter',
            'dataIccu'
        ));
    }

    private function monitoringTab($dataMedis, $request)
    {
        //
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

        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama_lengkap')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.iccu.create',  compact('dataMedis', 'dokter'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            // Validasi
            $request->validate([
                'iccu_tanggal' => 'required|date',
                'iccu_jam' => 'required',
                'kd_dokter' => 'required',
                'vita_kriteria_masuk' => 'nullable',
                'vita_keterangan_masuk' => 'nullable|string|max:255',
                'infark_kriteria_masuk' => 'nullable|string|max:255',
                'infark_keterangan_masuk' => 'nullable|string|max:255',
                'angina_kriteria_masuk' => 'nullable|string|max:255',
                'angina_keterangan_masuk' => 'nullable|string|max:255',
                'aritmia_kriteria_masuk' => 'nullable|string|max:255',
                'aritmia_keterangan_masuk' => 'nullable|string|max:255',
                'blokav_kriteria_masuk' => 'nullable|string|max:255',
                'blokav_keterangan_masuk' => 'nullable|string|max:255',
                'sinus_kriteria_masuk' => 'nullable|string|max:255',
                'sinus_keterangan_masuk' => 'nullable|string|max:255',
                'sick_kriteria_masuk' => 'nullable|string|max:255',
                'sick_keterangan_masuk' => 'nullable|string|max:255',
                'takikardia_kriteria_masuk' => 'nullable|string|max:255',
                'takikardia_keterangan_masuk' => 'nullable|string|max:255',
                'fibrilasi_kriteria_masuk' => 'nullable|string|max:255',
                'fibrilasi_keterangan_masuk' => 'nullable|string|max:255',
                'edema_kriteria_masuk' => 'nullable|string|max:255',
                'edema_keterangan_masuk' => 'nullable|string|max:255',
                'miokarditis_kriteria_masuk' => 'nullable|string|max:255',
                'miokarditis_keterangan_masuk' => 'nullable|string|max:255',
                'krisis_kriteria_masuk' => 'nullable|string|max:255',
                'krisis_keterangan_masuk' => 'nullable|string|max:255',
                'penyakit_kriteria_masuk' => 'nullable|string|max:255',
                'penyakit_keterangan_masuk' => 'nullable|string|max:255',
                //
                'dirawat_kriteria_keluar' => 'nullable|string|max:255',
                'dirawat_keterangan_keluar' => 'nullable|string|max:255',
                'kegawatan_kriteria_keluar' => 'nullable|string|max:255',
                'kegawatan_keterangan_keluar' => 'nullable|string|max:255',
                'penderita_kriteria_keluar' => 'nullable|string|max:255',
                'penderita_keterangan_keluar' => 'nullable|string|max:255',
                'iccu_kriteria_keluar' => 'nullable|string|max:255',
                'iccu_keterangan_keluar' => 'nullable|string|max:255',
                'rslain_kriteria_keluar' => 'nullable|string|max:255',
                'rslain_keterangan_keluar' => 'nullable|string|max:255',
                'rsud_kriteria_keluar' => 'nullable|string|max:255',
                'rsud_keterangan_keluar' => 'nullable|string|max:255',
            ]);

            // Prepare data
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => Carbon::parse($tgl_masuk)->toDateString(),
                'urut_masuk' => $urut_masuk,
                'tanggal' => Carbon::parse($request->iccu_tanggal . ' ' . $request->iccu_jam),
                'user_create' => Auth::user()->id,
                'iccu_tanggal' => $request->iccu_tanggal,
                'iccu_jam' => $request->iccu_jam,
                'kd_dokter' => $request->kd_dokter,
                'vita_kriteria_masuk' => $request->vita_kriteria_masuk ?? 0,
                'vita_keterangan_masuk' => $request->vita_keterangan_masuk,
                'infark_kriteria_masuk' => $request->infark_kriteria_masuk ?? 0,
                'infark_keterangan_masuk' => $request->infark_keterangan_masuk,
                'angina_kriteria_masuk' => $request->angina_kriteria_masuk ?? 0,
                'angina_keterangan_masuk' => $request->angina_keterangan_masuk,
                'aritmia_kriteria_masuk' => $request->aritmia_kriteria_masuk ?? 0,
                'aritmia_keterangan_masuk' => $request->aritmia_keterangan_masuk,
                'blokav_kriteria_masuk' => $request->blokav_kriteria_masuk ?? 0,
                'blokav_keterangan_masuk' => $request->blokav_keterangan_masuk,
                'sinus_kriteria_masuk' => $request->sinus_kriteria_masuk ?? 0,
                'sinus_keterangan_masuk' => $request->sinus_keterangan_masuk,
                'sick_kriteria_masuk' => $request->sick_kriteria_masuk ?? 0,
                'sick_keterangan_masuk' => $request->sick_keterangan_masuk,
                'takikardia_kriteria_masuk' => $request->takikardia_kriteria_masuk ?? 0,
                'takikardia_keterangan_masuk' => $request->takikardia_keterangan_masuk,
                'fibrilasi_kriteria_masuk' => $request->fibrilasi_kriteria_masuk ?? 0,
                'fibrilasi_keterangan_masuk' => $request->fibrilasi_keterangan_masuk,
                'edema_kriteria_masuk' => $request->edema_kriteria_masuk ?? 0,
                'edema_keterangan_masuk' => $request->edema_keterangan_masuk,
                'miokarditis_kriteria_masuk' => $request->miokarditis_kriteria_masuk ?? 0,
                'miokarditis_keterangan_masuk' => $request->miokarditis_keterangan_masuk,
                'krisis_kriteria_masuk' => $request->krisis_kriteria_masuk ?? 0,
                'krisis_keterangan_masuk' => $request->krisis_keterangan_masuk,
                'penyakit_kriteria_masuk' => $request->penyakit_kriteria_masuk ?? 0,
                'penyakit_keterangan_masuk' => $request->penyakit_keterangan_masuk,
                'dirawat_kriteria_keluar' => $request->dirawat_kriteria_keluar ?? 0,
                'dirawat_keterangan_keluar' => $request->dirawat_keterangan_keluar,
                'kegawatan_kriteria_keluar' => $request->kegawatan_kriteria_keluar ?? 0,
                'kegawatan_keterangan_keluar' => $request->kegawatan_keterangan_keluar,
                'penderita_kriteria_keluar' => $request->penderita_kriteria_keluar ?? 0,
                'penderita_keterangan_keluar' => $request->penderita_keterangan_keluar,
                'iccu_kriteria_keluar' => $request->iccu_kriteria_keluar ?? 0,
                'iccu_keterangan_keluar' => $request->iccu_keterangan_keluar,
                'rslain_kriteria_keluar' => $request->rslain_kriteria_keluar ?? 0,
                'rslain_keterangan_keluar' => $request->rslain_keterangan_keluar,
                'rsud_kriteria_keluar' => $request->rsud_kriteria_keluar ?? 0,
                'rsud_keterangan_keluar' => $request->rsud_keterangan_keluar,
            ];

            // Membuat data di ICCU
            ICCU::create($data);
            DB::commit();

            return redirect()->route('rawat-inap.kriteria-masuk-keluar.iccu.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
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

        $dataIccu = ICCU::findOrFail($id);
        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama_lengkap')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.iccu.show', compact(
            'dataMedis',
            'dataIccu',
            'dokter'
        ));
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

        $dataIccu = ICCU::findOrFail($id);
        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama_lengkap')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.iccu.edit', compact(
            'dataMedis',
            'dataIccu',
            'dokter'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            // Validasi
            $request->validate([
                'iccu_tanggal' => 'required|date',
                'iccu_jam' => 'required',
                'kd_dokter' => 'required',
                'vita_kriteria_masuk' => 'nullable',
                'vita_keterangan_masuk' => 'nullable|string|max:255',
                'infark_kriteria_masuk' => 'nullable|string|max:255',
                'infark_keterangan_masuk' => 'nullable|string|max:255',
                'angina_kriteria_masuk' => 'nullable|string|max:255',
                'angina_keterangan_masuk' => 'nullable|string|max:255',
                'aritmia_kriteria_masuk' => 'nullable|string|max:255',
                'aritmia_keterangan_masuk' => 'nullable|string|max:255',
                'blokav_kriteria_masuk' => 'nullable|string|max:255',
                'blokav_keterangan_masuk' => 'nullable|string|max:255',
                'sinus_kriteria_masuk' => 'nullable|string|max:255',
                'sinus_keterangan_masuk' => 'nullable|string|max:255',
                'sick_kriteria_masuk' => 'nullable|string|max:255',
                'sick_keterangan_masuk' => 'nullable|string|max:255',
                'takikardia_kriteria_masuk' => 'nullable|string|max:255',
                'takikardia_keterangan_masuk' => 'nullable|string|max:255',
                'fibrilasi_kriteria_masuk' => 'nullable|string|max:255',
                'fibrilasi_keterangan_masuk' => 'nullable|string|max:255',
                'edema_kriteria_masuk' => 'nullable|string|max:255',
                'edema_keterangan_masuk' => 'nullable|string|max:255',
                'miokarditis_kriteria_masuk' => 'nullable|string|max:255',
                'miokarditis_keterangan_masuk' => 'nullable|string|max:255',
                'krisis_kriteria_masuk' => 'nullable|string|max:255',
                'krisis_keterangan_masuk' => 'nullable|string|max:255',
                'penyakit_kriteria_masuk' => 'nullable|string|max:255',
                'penyakit_keterangan_masuk' => 'nullable|string|max:255',
                'dirawat_kriteria_keluar' => 'nullable|string|max:255',
                'dirawat_keterangan_keluar' => 'nullable|string|max:255',
                'kegawatan_kriteria_keluar' => 'nullable|string|max:255',
                'kegawatan_keterangan_keluar' => 'nullable|string|max:255',
                'penderita_kriteria_keluar' => 'nullable|string|max:255',
                'penderita_keterangan_keluar' => 'nullable|string|max:255',
                'iccu_kriteria_keluar' => 'nullable|string|max:255',
                'iccu_keterangan_keluar' => 'nullable|string|max:255',
                'rslain_kriteria_keluar' => 'nullable|string|max:255',
                'rslain_keterangan_keluar' => 'nullable|string|max:255',
                'rsud_kriteria_keluar' => 'nullable|string|max:255',
                'rsud_keterangan_keluar' => 'nullable|string|max:255',
            ]);

            // Cari data yang akan diupdate
            $iccu = ICCU::findOrFail($id);

            // Prepare data
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => Carbon::parse($tgl_masuk)->toDateString(),
                'urut_masuk' => $urut_masuk,
                'tanggal' => Carbon::parse($request->iccu_tanggal . ' ' . $request->iccu_jam),
                'user_edit' => Auth::user()->id, // Menambahkan user yang melakukan update
                'iccu_tanggal' => $request->iccu_tanggal,
                'iccu_jam' => $request->iccu_jam,
                'kd_dokter' => $request->kd_dokter,
                'vita_kriteria_masuk' => $request->vita_kriteria_masuk ?? 0,
                'vita_keterangan_masuk' => $request->vita_keterangan_masuk,
                'infark_kriteria_masuk' => $request->infark_kriteria_masuk ?? 0,
                'infark_keterangan_masuk' => $request->infark_keterangan_masuk,
                'angina_kriteria_masuk' => $request->angina_kriteria_masuk ?? 0,
                'angina_keterangan_masuk' => $request->angina_keterangan_masuk,
                'aritmia_kriteria_masuk' => $request->aritmia_kriteria_masuk ?? 0,
                'aritmia_keterangan_masuk' => $request->aritmia_keterangan_masuk,
                'blokav_kriteria_masuk' => $request->blokav_kriteria_masuk ?? 0,
                'blokav_keterangan_masuk' => $request->blokav_keterangan_masuk,
                'sinus_kriteria_masuk' => $request->sinus_kriteria_masuk ?? 0,
                'sinus_keterangan_masuk' => $request->sinus_keterangan_masuk,
                'sick_kriteria_masuk' => $request->sick_kriteria_masuk ?? 0,
                'sick_keterangan_masuk' => $request->sick_keterangan_masuk,
                'takikardia_kriteria_masuk' => $request->takikardia_kriteria_masuk ?? 0,
                'takikardia_keterangan_masuk' => $request->takikardia_keterangan_masuk,
                'fibrilasi_kriteria_masuk' => $request->fibrilasi_kriteria_masuk ?? 0,
                'fibrilasi_keterangan_masuk' => $request->fibrilasi_keterangan_masuk,
                'edema_kriteria_masuk' => $request->edema_kriteria_masuk ?? 0,
                'edema_keterangan_masuk' => $request->edema_keterangan_masuk,
                'miokarditis_kriteria_masuk' => $request->miokarditis_kriteria_masuk ?? 0,
                'miokarditis_keterangan_masuk' => $request->miokarditis_keterangan_masuk,
                'krisis_kriteria_masuk' => $request->krisis_kriteria_masuk ?? 0,
                'krisis_keterangan_masuk' => $request->krisis_keterangan_masuk,
                'penyakit_kriteria_masuk' => $request->penyakit_kriteria_masuk ?? 0,
                'penyakit_keterangan_masuk' => $request->penyakit_keterangan_masuk,
                'dirawat_kriteria_keluar' => $request->dirawat_kriteria_keluar ?? 0,
                'dirawat_keterangan_keluar' => $request->dirawat_keterangan_keluar,
                'kegawatan_kriteria_keluar' => $request->kegawatan_kriteria_keluar ?? 0,
                'kegawatan_keterangan_keluar' => $request->kegawatan_keterangan_keluar,
                'penderita_kriteria_keluar' => $request->penderita_kriteria_keluar ?? 0,
                'penderita_keterangan_keluar' => $request->penderita_keterangan_keluar,
                'iccu_kriteria_keluar' => $request->iccu_kriteria_keluar ?? 0,
                'iccu_keterangan_keluar' => $request->iccu_keterangan_keluar,
                'rslain_kriteria_keluar' => $request->rslain_kriteria_keluar ?? 0,
                'rslain_keterangan_keluar' => $request->rslain_keterangan_keluar,
                'rsud_kriteria_keluar' => $request->rsud_kriteria_keluar ?? 0,
                'rsud_keterangan_keluar' => $request->rsud_keterangan_keluar,
            ];

            // Update data di ICCU
            $iccu->update($data);
            DB::commit();

            return redirect()->route('rawat-inap.kriteria-masuk-keluar.iccu.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $dataIccu = ICCU::findOrFail($id);
            $dataIccu->delete();

            DB::commit();

            // Check if request is AJAX
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil dihapus'
                ]);
            }

            return redirect()->route('rawat-inap.kriteria-masuk-keluar.iccu.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();

            // Check if request is AJAX
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Fetch medical data with related models
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

        // Check if data exists
        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan.');
        }

        // Calculate patient age
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Fetch second opinion data
        $dataIccu = ICCU::findOrFail($id);
        $dokter = Dokter::where('status', 1)
                ->select('kd_dokter', 'nama_lengkap')
                ->get();

        // Load the Blade view and pass data
        $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.iccu.print', compact(
            'dataMedis',
            'dataIccu',
            'dokter'
        ));

        // Stream the PDF
        return $pdf->stream('kriteria-masuk-keluar-iccu-' . $id . '.pdf');
    }
}

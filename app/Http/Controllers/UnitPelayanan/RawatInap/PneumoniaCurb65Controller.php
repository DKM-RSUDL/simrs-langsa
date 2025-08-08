<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmePneumoniaCurb65;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PneumoniaCurb65Controller extends Controller
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Query data CURB-65
        $query = RmePneumoniaCurb65::with(['userCreated'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('level_resiko', 'LIKE', "%{$search}%")
                    ->orWhere('perawatan_disarankan', 'LIKE', "%{$search}%")
                    ->orWhere('mortalitas', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        $dataCurb65 = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.pneumonia-curb65.index', compact(
            'dataMedis',
            'dataCurb65'
        ));
    }


    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }


        return view('unit-pelayanan.rawat-inap.pelayanan.pneumonia-curb65.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $dataCurb = new RmePneumoniaCurb65();
            $dataCurb->kd_pasien = $kd_pasien;
            $dataCurb->tgl_masuk = $tgl_masuk;
            $dataCurb->kd_unit = $kd_unit;
            $dataCurb->urut_masuk = $urut_masuk;

            // Basic information
            $dataCurb->tanggal_implementasi = $request->tanggal_implementasi;
            $dataCurb->jam_implementasi = $request->jam_implementasi;

            // CURB-65 criteria (convert checkbox to boolean/integer)
            $dataCurb->confusion = $request->has('confusion') ? 1 : 0;
            $dataCurb->urea = $request->has('urea') ? 1 : 0;
            $dataCurb->respiratory = $request->has('respiratory') ? 1 : 0;
            $dataCurb->blood_pressure = $request->has('blood_pressure') ? 1 : 0;
            $dataCurb->age_65 = $request->has('age_65') ? 1 : 0;

            // Total score and interpretation
            $dataCurb->total_skor = $request->total_skor;
            $dataCurb->mortalitas = $request->mortalitas;
            $dataCurb->level_resiko = $request->level_resiko;
            $dataCurb->perawatan_disarankan = $request->perawatan_disarankan;

            $dataCurb->user_created = Auth::id();
            $dataCurb->save();

            DB::commit();

            return redirect()->route('rawat-inap.pneumonia.curb-65.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Data CURB-65 berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataCurb65 = RmePneumoniaCurb65::with(['userCreated'])
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataCurb65) {
            abort(404, 'Data CURB-65 not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.pneumonia-curb65.show', compact(
            'dataMedis',
            'dataCurb65'
        ));
    }

    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataCurb65 = RmePneumoniaCurb65::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataCurb65) {
            abort(404, 'Data CURB-65 not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.pneumonia-curb65.edit', compact(
            'dataMedis',
            'dataCurb65'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataCurb = RmePneumoniaCurb65::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->first();

            if (!$dataCurb) {
                return back()->with('error', 'Data CURB-65 tidak ditemukan!')->withInput();
            }

            // Basic information
            $dataCurb->tanggal_implementasi = $request->tanggal_implementasi;
            $dataCurb->jam_implementasi = $request->jam_implementasi;

            // CURB-65 criteria (convert checkbox to boolean/integer)
            $dataCurb->confusion = $request->has('confusion') ? 1 : 0;
            $dataCurb->urea = $request->has('urea') ? 1 : 0;
            $dataCurb->respiratory = $request->has('respiratory') ? 1 : 0;
            $dataCurb->blood_pressure = $request->has('blood_pressure') ? 1 : 0;
            $dataCurb->age_65 = $request->has('age_65') ? 1 : 0;

            // Total score and interpretation
            $dataCurb->total_skor = $request->total_skor;
            $dataCurb->mortalitas = $request->mortalitas;
            $dataCurb->level_resiko = $request->level_resiko;
            $dataCurb->perawatan_disarankan = $request->perawatan_disarankan;

            $dataCurb->user_updated = Auth::id();
            $dataCurb->save();

            DB::commit();

            return redirect()->route('rawat-inap.pneumonia.curb-65.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Data CURB-65 berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataCurb = RmePneumoniaCurb65::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->first();

            if (!$dataCurb) {
                return back()->with('error', 'Data CURB-65 tidak ditemukan!');
            }

            $dataCurb->delete();

            DB::commit();

            return redirect()->route('rawat-inap.pneumonia.curb-65.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Data CURB-65 berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}

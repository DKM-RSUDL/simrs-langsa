<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\RmePersetujuanImplementasiEvaluasiKeperawatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersetujuanImplementasiEvaluasiKeperawatanController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Mengambil data kunjungan
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

        // Query untuk data persetujuan implementasi evaluasi keperawatan
        $dataPersetujuan = RmePersetujuanImplementasiEvaluasiKeperawatan::with('userCreated')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->whereHas('dokter', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%');
                })->orWhere('tipe_penerima', 'like', '%' . $search . '%')
                    ->orWhere('nama_keluarga', 'like', '%' . $search . '%');
            })
            ->when(request('dari_tanggal'), function ($query) {
                $query->whereDate('tanggal_implementasi', '>=', request('dari_tanggal'));
            })
            ->when(request('sampai_tanggal'), function ($query) {
                $query->whereDate('tanggal_implementasi', '<=', request('sampai_tanggal'));
            })
            ->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.index', compact(
            'dataMedis',
            'dataPersetujuan'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Store the form data
            $dataHasilLab = new RmePersetujuanImplementasiEvaluasiKeperawatan();
            $dataHasilLab->kd_pasien = $kd_pasien;
            $dataHasilLab->kd_unit = $this->kdUnitDef_;
            $dataHasilLab->tgl_masuk = $tgl_masuk;
            $dataHasilLab->urut_masuk = $urut_masuk;

            // Basic Information
            $dataHasilLab->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHasilLab->jam_implementasi = $request->jam_implementasi;

            // User data
            $dataHasilLab->diagnosis_keperawatan = $request->diagnosis_keperawatan;
            $dataHasilLab->implementasi_keperawatan = $request->implementasi_keperawatan;
            $dataHasilLab->evaluasi_keperawatan = $request->evaluasi_keperawatan;

            // User audit
            $dataHasilLab->user_created = Auth::id();

            // Save the data
            $dataHasilLab->save();

            DB::commit();

            return response()->json(['message' => 'Data Persetujuan Implementasi Evaluasi Keperawatan berhasil disimpan!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $data = RmePersetujuanImplementasiEvaluasiKeperawatan::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        return response()->json([
            'tanggal_implementasi' => $data->tanggal_implementasi,
            'jam_implementasi' => $data->jam_implementasi,
            'diagnosis_keperawatan' => $data->diagnosis_keperawatan,
            'implementasi_keperawatan' => $data->implementasi_keperawatan,
            'evaluasi_keperawatan' => $data->evaluasi_keperawatan,
        ]);
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataHasilLab = RmePersetujuanImplementasiEvaluasiKeperawatan::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnitDef_)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Update the form data
            $dataHasilLab->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHasilLab->jam_implementasi = $request->jam_implementasi;
            $dataHasilLab->diagnosis_keperawatan = $request->diagnosis_keperawatan;
            $dataHasilLab->implementasi_keperawatan = $request->implementasi_keperawatan;
            $dataHasilLab->evaluasi_keperawatan = $request->evaluasi_keperawatan;
            $dataHasilLab->user_updated = Auth::id();

            // Save the data
            $dataHasilLab->save();

            DB::commit();

            return response()->json(['message' => 'Data Persetujuan Implementasi Evaluasi Keperawatan berhasil diperbarui!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataHasilLab = RmePersetujuanImplementasiEvaluasiKeperawatan::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $this->kdUnitDef_)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $dataHasilLab->delete();

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Persetujuan Implementasi Evaluasi Keperawatan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }


}

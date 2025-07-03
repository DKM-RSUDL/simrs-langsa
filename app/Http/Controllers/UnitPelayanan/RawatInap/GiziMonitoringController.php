<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeMonitoringGizi;
use App\Models\RmePengkajianGiziDewasa;
use App\Models\RmePengkajianIntervensiGiziDewasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiziMonitoringController extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {

            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data monitoring gizi
            $monitoringGizi = RmeMonitoringGizi::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->orderBy('tanggal_monitoring', 'desc')
                ->get();

            

            return view('unit-pelayanan.rawat-inap.pelayanan.gizi.monitoring.index', compact(
                'dataMedis',
                'monitoringGizi'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data TEE dari pengkajian gizi dewasa
            $dataGiziDewasa = RmePengkajianGiziDewasa::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->orderBy('waktu_asesmen', 'desc')
                ->first();

            $teeValue = null;
            if ($dataGiziDewasa) {
                $intervensiGizi = RmePengkajianIntervensiGiziDewasa::where('id_gizi', $dataGiziDewasa->id)->first();
                $teeValue = $intervensiGizi ? $intervensiGizi->tee : null;
            }

            return view('unit-pelayanan.rawat-inap.pelayanan.gizi.monitoring.create', compact(
                'dataMedis',
                'kd_unit',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk',
                'teeValue'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'energi' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'karbohidrat' => 'required|numeric|min:0',
            'lemak' => 'required|numeric|min:0'
        ]);

        try {
            $tanggal_monitoring = Carbon::createFromFormat('Y-m-d H:i', $request->tanggal . ' ' . $request->jam);

            RmeMonitoringGizi::create([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal_monitoring' => $tanggal_monitoring,
                'ahli_gizi' => Auth::id(),
                'energi' => $request->energi,
                'protein' => $request->protein,
                'karbohidrat' => $request->karbohidrat,
                'lemak' => $request->lemak,
                'masalah_perkembangan' => $request->masalah_perkembangan,
                'tindak_lanjut' => $request->tindak_lanjut,
                'user_create' => Auth::id(),
            ]);

            return redirect()->route('rawat-inap.gizi.monitoring.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk
            ])->with('success', 'Data monitoring gizi berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');
            $monitoring = RmeMonitoringGizi::findOrFail($id);
            $monitoring->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'id' => 'required|exists:rme_monitoring_gizi,id',
            'energi' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'karbohidrat' => 'required|numeric|min:0',
            'lemak' => 'required|numeric|min:0'
        ]);

        try {
            $monitoring = RmeMonitoringGizi::findOrFail($request->id);

            // Validasi apakah data ini milik pasien yang benar
            if (
                $monitoring->kd_unit != $kd_unit ||
                $monitoring->kd_pasien != $kd_pasien ||
                $monitoring->urut_masuk != $urut_masuk
            ) {
                return back()->with('error', 'Data tidak valid atau tidak ditemukan.');
            }

            $tanggal_monitoring = Carbon::createFromFormat('Y-m-d H:i', $request->tanggal . ' ' . $request->jam);

            $monitoring->update([
                'tanggal_monitoring' => $tanggal_monitoring,
                'energi' => $request->energi,
                'protein' => $request->protein,
                'karbohidrat' => $request->karbohidrat,
                'lemak' => $request->lemak,
                'masalah_perkembangan' => $request->masalah_perkembangan,
                'tindak_lanjut' => $request->tindak_lanjut,
                'user_update' => Auth::id(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Data monitoring gizi berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $monitoring = RmeMonitoringGizi::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$monitoring) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }

            // Format tanggal untuk form
            $tanggal = $monitoring->tanggal_monitoring ?
                Carbon::parse($monitoring->tanggal_monitoring)->format('Y-m-d') : '';
            $jam = $monitoring->tanggal_monitoring ?
                Carbon::parse($monitoring->tanggal_monitoring)->format('H:i') : '';

            return response()->json([
                'id' => $monitoring->id,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'energi' => $monitoring->energi,
                'protein' => $monitoring->protein,
                'karbohidrat' => $monitoring->karbohidrat,
                'lemak' => $monitoring->lemak,
                'masalah_perkembangan' => $monitoring->masalah_perkembangan,
                'tindak_lanjut' => $monitoring->tindak_lanjut,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}

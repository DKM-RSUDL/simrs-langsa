<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmeKontrolIstimewaJam;
use App\Services\AsesmenService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KontrolIstimewaJamController extends Controller
{
    protected $asesmenService;
    public function __construct()
    {
        $this->asesmenService = new AsesmenService();
        $this->middleware('can:read unit-pelayanan/rawat-inap');
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

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        return view('unit-pelayanan.rawat-inap.pelayanan.kontrol-istimewa-jam.create', compact('dataMedis'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nadi' => 'nullable|integer',
            'nafas' => 'nullable|integer',
            'sistole' => 'nullable|integer',
            'diastole' => 'nullable|integer',
            'pemberian_oral' => 'nullable|string|max:255',
            'cairan_intra_vena' => 'nullable|string|max:255',
            'diurosis' => 'nullable|string|max:255',
            'muntah' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            // Format jam untuk hanya jam (tanpa menit)
            $jam = date('H:00:00', strtotime($request->jam));

            $data = [
                'kd_pasien'         => $kd_pasien,
                'kd_unit'           => $kd_unit,
                'tgl_masuk'         => $tgl_masuk,
                'urut_masuk'        => $urut_masuk,
                'tanggal'           => $request->tanggal,
                'jam'               => $jam,
                'nadi'              => $request->nadi,
                'nafas'             => $request->nafas,
                'sistole'           => $request->sistole,
                'diastole'          => $request->diastole,
                'pemberian_oral'    => $request->pemberian_oral,
                'cairan_intra_vena' => $request->cairan_intra_vena,
                'diurosis'          => $request->diurosis,
                'muntah'            => $request->muntah,
                'keterangan'        => $request->keterangan,
                'user_create'       => Auth::id(),
            ];

            // Simpan Kontrol Istimewa Jam
            RmeKontrolIstimewaJam::create($data);

            // --- Tambahkan transaksi vital sign setelah create ---
            $vitalSignData = [
                'sistole'      => $request->sistole ? (int)$request->sistole : null,
                'diastole'     => $request->diastole ? (int)$request->diastole : null,
                'nadi'         => $request->nadi ? (int)$request->nadi : null,
                'respiration'  => $request->nafas ? (int)$request->nafas : null,
                'suhu'         => $request->suhu ? (float)$request->suhu : null,
                'tinggi_badan' => $request->tb ? (int)$request->tb : null,
                'berat_badan'  => $request->bb ? (int)$request->bb : null,
            ];

            $lastTransaction = $this->asesmenService->getTransaksiData(
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk
            );

            $this->asesmenService->store(
                $vitalSignData,
                $kd_pasien,
                $lastTransaction->no_transaction,
                $lastTransaction->kd_kasir
            );

            DB::commit();
            return to_route('rawat-inap.kontrol-istimewa.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Kontrol Istimewa per Jam berhasil ditambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
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

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $id = decrypt($idEncrypt);
        $kontrolJam = RmeKontrolIstimewaJam::find($id);

        if (empty($kontrolJam)) return back()->with('error', 'Data kontrol istimewa per jam tidak ditemukan !');

        return view('unit-pelayanan.rawat-inap.pelayanan.kontrol-istimewa-jam.edit', compact('dataMedis', 'kontrolJam'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nadi' => 'nullable|integer',
            'nafas' => 'nullable|integer',
            'sistole' => 'nullable|integer',
            'diastole' => 'nullable|integer',
            'pemberian_oral' => 'nullable|string|max:255',
            'cairan_intra_vena' => 'nullable|string|max:255',
            'diurosis' => 'nullable|string|max:255',
            'muntah' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $id = decrypt($idEncrypt);
            $kontrolJam = RmeKontrolIstimewaJam::find($id);
            if (empty($kontrolJam)) throw new Exception('Data kontrol istimewa per jam tidak ditemukan !');

            // Format jam untuk hanya jam (tanpa menit)
            $jam = date('H:00:00', strtotime($request->jam));

            $data = [
                'tanggal'           => $request->tanggal,
                'jam'               => $jam,
                'nadi'              => $request->nadi,
                'nafas'             => $request->nafas,
                'sistole'           => $request->sistole,
                'diastole'          => $request->diastole,
                'pemberian_oral'    => $request->pemberian_oral,
                'cairan_intra_vena' => $request->cairan_intra_vena,
                'diurosis'          => $request->diurosis,
                'muntah'            => $request->muntah,
                'keterangan'        => $request->keterangan,
                'user_edit'         => Auth::id(),
            ];

            RmeKontrolIstimewaJam::where('id', $kontrolJam->id)->update($data);

            DB::commit();
            return to_route('rawat-inap.kontrol-istimewa-jam.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Kontrol Istimewa per Jam berhasil diubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
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

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $id = decrypt($idEncrypt);
        $kontrolJam = RmeKontrolIstimewaJam::with(['userCreate'])->find($id);

        if (empty($kontrolJam)) return back()->with('error', 'Data kontrol istimewa per jam tidak ditemukan !');

        return view('unit-pelayanan.rawat-inap.pelayanan.kontrol-istimewa-jam.show', compact('dataMedis', 'kontrolJam'));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_kontrol);
            $kontrolJam = RmeKontrolIstimewaJam::find($id);

            if (empty($kontrolJam)) throw new Exception('Data kontrol istimewa per jam tidak ditemukan !');
            $kontrolJam->delete();

            DB::commit();
            return back()->with('success', 'Data kontrol istimewa per jam berhasil dihapus !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function pdf($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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

        if (empty($dataMedis)) return back()->with('error', 'Gagal menemukan data kunjungan !');

        $tglPrint = $request->tgl_print;

        $kontrolJam = RmeKontrolIstimewaJam::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->whereDate('tanggal', $tglPrint)
            ->orderBy('jam', 'ASC')
            ->get();

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.kontrol-istimewa-jam.pdf', compact(
            'dataMedis',
            'kontrolJam',
            'tglPrint'
        ))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('kontrolIstimewaJam_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\EWSPasienAnak;
use App\Models\EWSPasienDewasa;
use App\Models\EwsPasienObstetrik;
use App\Models\Kunjungan;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EWSPasienAnakController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
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

        // start fungsi Tabs
        $activeTab = $request->query('tab', 'dewasa');

        $allowedTabs = ['dewasa', 'anak', 'obstetri'];
        if (!in_array($activeTab, $allowedTabs)) {
            $activeTab = 'dewasa';
        }

        if ($activeTab == 'dewasa') {
            return $this->dewasaTab($dataMedis, $activeTab);
        } elseif ($activeTab == 'anak') {
            return $this->anakTab($dataMedis, $activeTab);
        } else {
            return $this->obstetriTab($dataMedis, $activeTab);
        }
        // end code
    }

    private function dewasaTab($dataMedis, $activeTab)
    {
        // EWSPasienDewasa

        $ewsPasienDewasa = EWSPasienDewasa::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-jalan.pelayanan.ews-pasien-dewasa.index', compact(
            'dataMedis',
            'ewsPasienDewasa',
            'activeTab'
        ));
    }

    private function anakTab($dataMedis, $activeTab)
    {
        // Data khusus untuk tab anak jika diperlukan

        $eWSPasienAnak = EWSPasienAnak::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-jalan.pelayanan.ews-pasien-anak.index', compact(
            'dataMedis',
            'activeTab',
            'eWSPasienAnak'
        ));
    }

    private function obstetriTab($dataMedis, $activeTab)
    {
        // Data khusus untuk tab obstetri jika diperlukan

        $ewsPsienObstetrik = EwsPasienObstetrik::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-jalan.pelayanan.ews-pasien-obstetrik.index', compact(
            'dataMedis',
            'activeTab',
            'ewsPsienObstetrik'
        ));
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }


        return view('unit-pelayanan.rawat-jalan.pelayanan.ews-pasien-anak.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        try {
            DB::beginTransaction();

            $request->validate([
                'keadaan_umum' => 'required',
                'kardiovaskular' => 'required',
                'respirasi' => 'required',
                'total_skor' => 'required',
                'hasil_ews' => 'required',
                'tanggal' => 'required',
                'jam_masuk' => 'required',
            ]);

            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => auth()->user()->id,
                'keadaan_umum' => $request->keadaan_umum,
                'kardiovaskular' => $request->kardiovaskular,
                'respirasi' => $request->respirasi,
                'total_skor' => $request->total_skor,
                'hasil_ews' => $request->hasil_ews,
                'tanggal' => $request->tanggal ? Carbon::parse($request->tanggal) : null,
                'jam_masuk' => $request->jam_masuk ? Carbon::parse($request->jam_masuk) : null,
            ];

            EWSPasienAnak::create($data);
            DB::commit();

            return to_route('rawat-jalan.ews-pasien-anak.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
                'tab' => 'anak'
            ])
                ->with('success', 'Data EWS Pasien Anak berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $eWSPasienAnak = EWSPasienAnak::findOrFail($id);

        return view('unit-pelayanan.rawat-jalan.pelayanan.ews-pasien-anak.show', compact(
            'dataMedis',
            'eWSPasienAnak'
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $eWSPasienAnak = EWSPasienAnak::findOrFail($id);

        // Return the edit view, not show view
        return view('unit-pelayanan.rawat-jalan.pelayanan.ews-pasien-anak.edit', compact(
            'dataMedis',
            'eWSPasienAnak'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'keadaan_umum' => 'required',
                'kardiovaskular' => 'required',
                'respirasi' => 'required',
                'total_skor' => 'required',
                'hasil_ews' => 'required',
                'tanggal' => 'required',
                'jam_masuk' => 'required',
            ]);

            // Find the record to update
            $eWSPasienAnak = EWSPasienAnak::findOrFail($id);

            // Combine date and time into a single datetime field
            $tanggalJam = Carbon::createFromFormat('Y-m-d H:i', $request->tanggal . ' ' . $request->jam_masuk);

            // Update the record
            $eWSPasienAnak->kd_pasien = $kd_pasien;
            $eWSPasienAnak->kd_unit = $kd_unit;
            $eWSPasienAnak->tgl_masuk = $tgl_masuk;
            $eWSPasienAnak->urut_masuk = $urut_masuk;
            $eWSPasienAnak->user_edit = auth()->user()->id;
            $eWSPasienAnak->keadaan_umum = $request->keadaan_umum;
            $eWSPasienAnak->kardiovaskular = $request->kardiovaskular;
            $eWSPasienAnak->respirasi = $request->respirasi;
            $eWSPasienAnak->total_skor = $request->total_skor;
            $eWSPasienAnak->hasil_ews = $request->hasil_ews;
            $eWSPasienAnak->tanggal = $tanggalJam;
            $eWSPasienAnak->save();
            DB::commit();

            return to_route('rawat-jalan.ews-pasien-anak.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
                'tab' => 'anak'
            ])
                ->with('success', 'Data EWS Pasien Anak berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $eWSPasienAnak = EWSPasienAnak::findOrFail($id);
            $eWSPasienAnak->delete();

            DB::commit();

            return to_route('rawat-jalan.ews-pasien-anak.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
                'tab' => 'anak'
            ])->with('success', 'Data EWS Pasien Anak berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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
            abort(404, 'Data medis tidak ditemukan.');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $eWSPasienAnak = EWSPasienAnak::findOrFail($id);

        $recordDate = Carbon::parse($eWSPasienAnak->tanggal)->startOfDay();

        $ewsRecords = EWSPasienAnak::where('kd_pasien', $kd_pasien)
            ->whereDate('tanggal', $recordDate)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        if ($ewsRecords->isEmpty()) {
            $ewsRecords = collect([$eWSPasienAnak]);
        }

        $pdf = PDF::loadView('unit-pelayanan.rawat-jalan.pelayanan.ews-pasien-anak.print', compact(
            'dataMedis',
            'eWSPasienAnak',
            'ewsRecords',
            'recordDate'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('ews-pasien-anak-' . $kd_pasien . '-' . Carbon::parse($recordDate)->format('d-m-Y') . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EWSPasienAnak;
use App\Models\EWSPasienDewasa;
use App\Models\EwsPasienObstetrik;
use App\Models\Kunjungan;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EWSPasienObstetrikController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    public function index(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
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
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-dewasa.index', compact(
            'dataMedis',
            'ewsPasienDewasa',
            'activeTab'
        ));
    }

    private function anakTab($dataMedis, $activeTab)
    {
        // Data khusus untuk tab anak jika diperlukan

        $eWSPasienAnak = EWSPasienAnak::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-anak.index', compact(
            'dataMedis',
            'activeTab',
            'eWSPasienAnak'
        ));
    }

    private function obstetriTab($dataMedis, $activeTab)
    {
        // Data khusus untuk tab obstetri jika diperlukan
        $ewsPsienObstetrik = EwsPasienObstetrik::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-obstetrik.index', compact(
            'dataMedis',
            'activeTab',
            'ewsPsienObstetrik'
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
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
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-obstetrik.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        try {
            DB::beginTransaction();

            $request->validate([
                'respirasi' => 'required',
                'saturasi_o2' => 'required',
                'suplemen_o2' => 'required',
                'tekanan_darah' => 'required',
                'detak_jantung' => 'required',
                'kesadaran' => 'required',
                'temperatur' => 'required',
                'discharge' => 'required',
                'proteinuria' => 'required',
                'total_skor' => 'required',
                'hasil_ews' => 'required',
                'code_blue' => 'required',
                'tanggal' => 'required',
                'jam_masuk' => 'required',
            ]);

            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => 3,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => auth()->user()->id,
                'respirasi' => $request->respirasi,
                'saturasi_o2' => $request->saturasi_o2,
                'suplemen_o2' => $request->suplemen_o2,
                'tekanan_darah' => $request->tekanan_darah,
                'detak_jantung' => $request->detak_jantung,
                'kesadaran' => $request->kesadaran,
                'temperatur' => $request->temperatur,
                'discharge' => $request->discharge,
                'proteinuria' => $request->proteinuria,
                'total_skor' => $request->total_skor,
                'hasil_ews' => $request->hasil_ews,
                'code_blue' => $request->code_blue,
                'tanggal' => $request->tanggal ? Carbon::parse($request->tanggal) : null,
                'jam_masuk' => $request->jam_masuk ? Carbon::parse($request->jam_masuk) : null,
            ];

            EwsPasienObstetrik::create($data);
            DB::commit();

            return to_route('ews-pasien-obstetrik.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
                'tab' => 'obstetri'
            ])
                ->with('success', 'Data EWS Pasien Obstetrik berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.kd_dokter', '=', 'dokter.kd_dokter')
            ->select('kunjungan.*', 't.*', 'dokter.nama as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $ewsPsienObstetrik = EwsPasienObstetrik::findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-obstetrik.show', compact(
            'dataMedis',
            'ewsPsienObstetrik'
        ));
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.kd_dokter', '=', 'dokter.kd_dokter')
            ->select('kunjungan.*', 't.*', 'dokter.nama as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk) // Tambahkan filter urut_masuk
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Ambil data EWS pasien dewasa dari database
        $ewsPsienObstetrik = EwsPasienObstetrik::findOrFail($id);

        // Pastikan semua properti memiliki nilai string yang konsisten

        // Return the edit view
        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-obstetrik.edit', compact(
            'dataMedis',
            'ewsPsienObstetrik'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'respirasi' => 'required',
                'saturasi_o2' => 'required',
                'suplemen_o2' => 'required',
                'tekanan_darah' => 'required',
                'detak_jantung' => 'required',
                'kesadaran' => 'required',
                'temperatur' => 'required',
                'discharge' => 'required',
                'proteinuria' => 'required',
                'total_skor' => 'required',
                'hasil_ews' => 'required',
                'code_blue' => 'required',
                'tanggal' => 'required',
                'jam_masuk' => 'required',
            ]);

            // Find the record to update
            $ewsPsienObstetrik = EwsPasienObstetrik::findOrFail($id);

            // Persiapkan nilai tanggal dan jam_masuk
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $jam_masuk = $request->jam_masuk;

            // Update the record
            $ewsPsienObstetrik->kd_pasien = $kd_pasien;
            $ewsPsienObstetrik->kd_unit = 3;
            $ewsPsienObstetrik->tgl_masuk = $tgl_masuk;
            $ewsPsienObstetrik->urut_masuk = $urut_masuk;
            $ewsPsienObstetrik->user_edit = auth()->user()->id;
            $ewsPsienObstetrik->respirasi = $request->respirasi;
            $ewsPsienObstetrik->saturasi_o2 = $request->saturasi_o2;
            $ewsPsienObstetrik->suplemen_o2 = $request->suplemen_o2;
            $ewsPsienObstetrik->tekanan_darah = $request->tekanan_darah;
            $ewsPsienObstetrik->detak_jantung = $request->detak_jantung;
            $ewsPsienObstetrik->kesadaran = $request->kesadaran;
            $ewsPsienObstetrik->temperatur = $request->temperatur;
            $ewsPsienObstetrik->discharge = $request->discharge;
            $ewsPsienObstetrik->proteinuria = $request->proteinuria;
            $ewsPsienObstetrik->total_skor = $request->total_skor;
            $ewsPsienObstetrik->hasil_ews = $request->hasil_ews;
            $ewsPsienObstetrik->code_blue = $request->code_blue;
            $ewsPsienObstetrik->tanggal = $tanggal;
            $ewsPsienObstetrik->jam_masuk = $jam_masuk;

            $ewsPsienObstetrik->save();
            DB::commit();

            return to_route('ews-pasien-obstetrik.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
                'tab' => 'obstetri'
            ])
                ->with('success', 'Data EWS Pasien Obstetrik berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $ewsPsienObstetrik = EwsPasienObstetrik::findOrFail($id);
            $ewsPsienObstetrik->delete();

            DB::commit();

            return to_route('ews-pasien-obstetrik.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
                'tab' => 'obstetri'
            ])->with('success', 'Data EWS Pasien Obstetrik berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generatePDF($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.kd_dokter', '=', 'dokter.kd_dokter')
            ->select('kunjungan.*', 't.*', 'dokter.nama as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->firstOrFail();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $ewsPsienObstetrik = EwsPasienObstetrik::findOrFail($id);

        $recordDate = Carbon::parse($ewsPsienObstetrik->tanggal)->startOfDay();

        $ewsRecords = EwsPasienObstetrik::where('kd_pasien', $kd_pasien)
            ->whereDate('tanggal', $recordDate)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        if ($ewsRecords->isEmpty()) {
            $ewsRecords = collect([$ewsPsienObstetrik]);
        }

        $pdf = PDF::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-obstetrik.print', compact(
            'dataMedis',
            'ewsPsienObstetrik',
            'ewsRecords',
            'recordDate'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('ews-pasien-obstetrik-' . $kd_pasien . '-' . Carbon::parse($recordDate)->format('d-m-Y') . '.pdf');
    }
}

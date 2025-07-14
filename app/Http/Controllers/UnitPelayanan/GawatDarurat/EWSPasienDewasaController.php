<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokterInap;
use App\Models\EWSPasienAnak;
use App\Models\EWSPasienDewasa;
use App\Models\EwsPasienObstetrik;
use App\Models\Kunjungan;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EWSPasienDewasaController extends Controller
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-dewasa.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        try {
            DB::beginTransaction();

            $request->validate([
                'avpu' => 'required',
                'saturasi_o2' => 'required',
                'dengan_bantuan' => 'required',
                'tekanan_darah' => 'required',
                'nadi' => 'required',
                'nafas' => 'required',
                'temperatur' => 'required',
                'total_skor' => 'required',
                'hasil_ews' => 'required',
                'tanggal' => 'required',
                'jam_masuk' => 'required',
            ]);

            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => 3,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => auth()->user()->id,
                'avpu' => $request->avpu,
                'saturasi_o2' => $request->saturasi_o2,
                'dengan_bantuan' => $request->dengan_bantuan,
                'tekanan_darah' => $request->tekanan_darah,
                'nadi' => $request->nadi,
                'nafas' => $request->nafas,
                'temperatur' => $request->temperatur,
                'total_skor' => $request->total_skor,
                'hasil_ews' => $request->hasil_ews,
                'tanggal' => $request->tanggal ? Carbon::parse($request->tanggal) : null,
                'jam_masuk' => $request->jam_masuk ? Carbon::parse($request->jam_masuk) : null,
            ];

            EWSPasienDewasa::create($data);
            DB::commit();

            return to_route('ews-pasien-dewasa.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])
                ->with('success', 'Data EWS Pasien Dewasa berhasil disimpan');
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

        $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-dewasa.show', compact(
            'dataMedis',
            'ewsPasienDewasa'
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
        $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);

        // Pastikan semua properti memiliki nilai string yang konsisten
        $ewsPasienDewasa->avpu = trim($ewsPasienDewasa->avpu ?? '');
        $ewsPasienDewasa->saturasi_o2 = trim($ewsPasienDewasa->saturasi_o2 ?? '');
        $ewsPasienDewasa->dengan_bantuan = trim($ewsPasienDewasa->dengan_bantuan ?? '');
        $ewsPasienDewasa->tekanan_darah = trim($ewsPasienDewasa->tekanan_darah ?? '');
        $ewsPasienDewasa->nadi = trim($ewsPasienDewasa->nadi ?? '');
        $ewsPasienDewasa->nafas = trim($ewsPasienDewasa->nafas ?? '');
        $ewsPasienDewasa->temperatur = trim($ewsPasienDewasa->temperatur ?? '');

        // Return the edit view
        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-dewasa.edit', compact(
            'dataMedis',
            'ewsPasienDewasa'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'avpu' => 'required',
                'saturasi_o2' => 'required',
                'dengan_bantuan' => 'required',
                'tekanan_darah' => 'required',
                'nadi' => 'required',
                'nafas' => 'required',
                'temperatur' => 'required',
                'total_skor' => 'required',
                'hasil_ews' => 'required',
                'tanggal' => 'required|date',
                'jam_masuk' => 'required',
            ]);

            // Find the record to update
            $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);

            // Persiapkan nilai tanggal dan jam_masuk
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $jam_masuk = $request->jam_masuk;

            // Update the record
            $ewsPasienDewasa->kd_pasien = $kd_pasien;
            $ewsPasienDewasa->kd_unit = 3;
            $ewsPasienDewasa->tgl_masuk = $tgl_masuk;
            $ewsPasienDewasa->urut_masuk = $urut_masuk;
            $ewsPasienDewasa->user_edit = auth()->user()->id;
            $ewsPasienDewasa->avpu = $request->avpu;
            $ewsPasienDewasa->saturasi_o2 = $request->saturasi_o2;
            $ewsPasienDewasa->dengan_bantuan = $request->dengan_bantuan;
            $ewsPasienDewasa->tekanan_darah = $request->tekanan_darah;
            $ewsPasienDewasa->nadi = $request->nadi;
            $ewsPasienDewasa->nafas = $request->nafas;
            $ewsPasienDewasa->temperatur = $request->temperatur;
            $ewsPasienDewasa->total_skor = $request->total_skor;
            $ewsPasienDewasa->hasil_ews = $request->hasil_ews;
            $ewsPasienDewasa->tanggal = $tanggal; // Simpan sebagai date
            $ewsPasienDewasa->jam_masuk = $jam_masuk; // Simpan sebagai time

            $ewsPasienDewasa->save();
            DB::commit();

            return to_route('ews-pasien-dewasa.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])
                ->with('success', 'Data EWS Pasien Dewasa berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);
            $ewsPasienDewasa->delete();

            DB::commit();

            return to_route('ews-pasien-dewasa.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])->with('success', 'Data EWS Pasien Dewasa berhasil dihapus');
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
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

        $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);

        $recordDate = Carbon::parse($ewsPasienDewasa->tanggal)->startOfDay();

        $ewsRecords = EWSPasienDewasa::where('kd_pasien', $kd_pasien)
            ->whereDate('tanggal', $recordDate)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        if ($ewsRecords->isEmpty()) {
            $ewsRecords = collect([$ewsPasienDewasa]);
        }

        $pdf = PDF::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-dewasa.print', compact(
            'dataMedis',
            'ewsPasienDewasa',
            'ewsRecords',
            'recordDate'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('ews-pasien-dewasa-' . $kd_pasien . '-' . Carbon::parse($recordDate)->format('d-m-Y') . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokterInap;
use App\Models\EWSPasienDewasa;
use App\Models\Kunjungan;
use App\Models\PermintaanSecondOpinion;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EWSPasienDewasaController extends Controller
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

        return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.index', compact(
            'dataMedis',
            'ewsPasienDewasa',
            'activeTab'
        ));
    }

    private function anakTab($dataMedis, $activeTab)
    {
        // Data khusus untuk tab anak jika diperlukan

        // return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-anak.index', compact(
        //     'dataMedis',
        //     'dataDokter',
        //     'activeTab',
        //     'dataAnak'
        // ));
    }

    private function obstetriTab($dataMedis, $activeTab)
    {
        // Data khusus untuk tab obstetri jika diperlukan

        // return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-obstetri.index', compact(
        //     'dataMedis',
        //     'dataDokter',
        //     'activeTab',
        //     'dataObstetri'
        // ));
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


        return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
                'kd_unit' => $kd_unit,
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

            return to_route('rawat-inap.ews-pasien-dewasa.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])
                ->with('success', 'Data EWS Pasien Dewasa berhasil disimpan');
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

        $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.show', compact(
            'dataMedis',
            'ewsPasienDewasa'
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

        $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);

        // Return the edit view, not show view
        return view('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.edit', compact(
            'dataMedis',
            'ewsPasienDewasa'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'avpu' => 'required',
                'saturasi_o2' => 'required|numeric',
                'dengan_bantuan' => 'required|numeric',
                'tekanan_darah' => 'required|numeric',
                'nadi' => 'required|numeric',
                'nafas' => 'required|numeric',
                'temperatur' => 'required|numeric',
                'total_skor' => 'required',
                'hasil_ews' => 'required',
                'tanggal' => 'required',
                'jam_masuk' => 'required',
            ]);

            // Find the record to update
            $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);

            // Combine date and time into a single datetime field
            $tanggalJam = Carbon::createFromFormat('Y-m-d H:i', $request->tanggal . ' ' . $request->jam_masuk);

            // Update the record
            $ewsPasienDewasa->kd_pasien = $kd_pasien;
            $ewsPasienDewasa->kd_unit = $kd_unit;
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
            $ewsPasienDewasa->tanggal = $tanggalJam;

            $ewsPasienDewasa->save();
            DB::commit();

            return to_route('rawat-inap.ews-pasien-dewasa.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])
                ->with('success', 'Data EWS Pasien Dewasa berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);
            $ewsPasienDewasa->delete();

            DB::commit();

            return to_route('rawat-inap.ews-pasien-dewasa.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])->with('success', 'Data EWS Pasien Dewasa berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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

        // Mengambil record EWS yang diminta
        $ewsPasienDewasa = EWSPasienDewasa::findOrFail($id);

        // Dapatkan tanggal dari record yang diminta
        $recordDate = Carbon::parse($ewsPasienDewasa->tanggal)->startOfDay();

        // Mengambil semua record EWS dari pasien tersebut untuk tanggal yang sama dengan record yang diminta
        $ewsRecords = EWSPasienDewasa::where('kd_pasien', $kd_pasien)
            ->whereDate('tanggal', $recordDate)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        // Jika tidak ada catatan untuk tanggal tersebut, minimal tampilkan catatan yang sedang dilihat
        if ($ewsRecords->isEmpty()) {
            $ewsRecords = collect([$ewsPasienDewasa]);
        }

        // Load the Blade view and pass data
        $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.print', compact(
            'dataMedis',
            'ewsPasienDewasa',
            'ewsRecords',
            'recordDate'
        ));

        // Set paper size and orientation to landscape
        $pdf->setPaper('a4', 'landscape');

        // Stream the PDF
        return $pdf->stream('ews-pasien-dewasa-' . $kd_pasien . '-' . Carbon::parse($recordDate)->format('d-m-Y') . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAudiometri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AudiometriController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    private function getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
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

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else if ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return $dataMedis;
    }

    private function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Get transaksi data
        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        // Get audiometri data
        $dataAudiometri = collect();
        if ($transaksi) {
            $dataAudiometri = RmeAudiometri::where('kd_kasir', $transaksi->kd_kasir)
                ->where('no_transaksi', $transaksi->no_transaksi)
                ->orderBy('tanggal_pemeriksaan', 'desc')
                ->orderBy('jam_pemeriksaan', 'desc')
                ->get();
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.audiometri.index', compact(
            'dataMedis',
            'dataAudiometri'
        ));
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        // Get transaksi data
        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan');
        }

        // Get specific audiometri data that belongs to this patient's transaction
        $dataAudiometri = RmeAudiometri::where('id', $id)
            ->where('kd_kasir', $transaksi->kd_kasir)
            ->where('no_transaksi', $transaksi->no_transaksi)
            ->first();

        if (!$dataAudiometri) {
            abort(404, 'Data audiometri tidak ditemukan');
        }

        // Decode JSON data
        $acKanan = json_decode($dataAudiometri->data_ac_kanan, true) ?? [];
        $bcKanan = json_decode($dataAudiometri->data_bc_kanan, true) ?? [];
        $acKiri = json_decode($dataAudiometri->data_ac_kiri, true) ?? [];
        $bcKiri = json_decode($dataAudiometri->data_bc_kiri, true) ?? [];

        // Prepare data for chart
        $frequencies = ['250', '500', '1000', '2000', '3000', '4000', '6000', '8000'];

        $chartData = [
            'frequencies' => $frequencies,
            'ac_kanan' => [],
            'bc_kanan' => [],
            'ac_kiri' => [],
            'bc_kiri' => []
        ];

        foreach ($frequencies as $freq) {
            $chartData['ac_kanan'][] = isset($acKanan[$freq]) && $acKanan[$freq] !== null ? (float)$acKanan[$freq] : null;
            $chartData['bc_kanan'][] = isset($bcKanan[$freq]) && $bcKanan[$freq] !== null ? (float)$bcKanan[$freq] : null;
            $chartData['ac_kiri'][] = isset($acKiri[$freq]) && $acKiri[$freq] !== null ? (float)$acKiri[$freq] : null;
            $chartData['bc_kiri'][] = isset($bcKiri[$freq]) && $bcKiri[$freq] !== null ? (float)$bcKiri[$freq] : null;
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.audiometri.show', compact(
            'dataMedis',
            'dataAudiometri',
            'acKanan',
            'bcKanan',
            'acKiri',
            'bcKiri',
            'chartData'
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.audiometri.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi input
        $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'jam_pemeriksaan' => 'required',

            // AC Kanan
            'ac_right_250' => 'nullable|numeric|min:-10|max:140',
            'ac_right_500' => 'nullable|numeric|min:-10|max:140',
            'ac_right_1000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_2000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_3000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_4000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_6000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_8000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_avg' => 'nullable|numeric',

            // BC Kanan
            'bc_right_250' => 'nullable|numeric|min:-10|max:140',
            'bc_right_500' => 'nullable|numeric|min:-10|max:140',
            'bc_right_1000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_2000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_3000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_4000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_6000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_8000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_avg' => 'nullable|numeric',

            // AC Kiri
            'ac_left_250' => 'nullable|numeric|min:-10|max:140',
            'ac_left_500' => 'nullable|numeric|min:-10|max:140',
            'ac_left_1000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_2000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_3000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_4000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_6000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_8000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_avg' => 'nullable|numeric',

            // BC Kiri
            'bc_left_250' => 'nullable|numeric|min:-10|max:140',
            'bc_left_500' => 'nullable|numeric|min:-10|max:140',
            'bc_left_1000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_2000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_3000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_4000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_6000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_8000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_avg' => 'nullable|numeric',

            'interpretasi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            // Prepare JSON data for AC Kanan
            $acKananData = [
                '250' => $request->ac_right_250,
                '500' => $request->ac_right_500,
                '1000' => $request->ac_right_1000,
                '2000' => $request->ac_right_2000,
                '3000' => $request->ac_right_3000,
                '4000' => $request->ac_right_4000,
                '6000' => $request->ac_right_6000,
                '8000' => $request->ac_right_8000,
                'rata_rata' => $request->ac_right_avg
            ];

            // Prepare JSON data for BC Kanan
            $bcKananData = [
                '250' => $request->bc_right_250,
                '500' => $request->bc_right_500,
                '1000' => $request->bc_right_1000,
                '2000' => $request->bc_right_2000,
                '3000' => $request->bc_right_3000,
                '4000' => $request->bc_right_4000,
                '6000' => $request->bc_right_6000,
                '8000' => $request->bc_right_8000,
                'rata_rata' => $request->bc_right_avg
            ];

            // Prepare JSON data for AC Kiri
            $acKiriData = [
                '250' => $request->ac_left_250,
                '500' => $request->ac_left_500,
                '1000' => $request->ac_left_1000,
                '2000' => $request->ac_left_2000,
                '3000' => $request->ac_left_3000,
                '4000' => $request->ac_left_4000,
                '6000' => $request->ac_left_6000,
                '8000' => $request->ac_left_8000,
                'rata_rata' => $request->ac_left_avg
            ];

            // Prepare JSON data for BC Kiri
            $bcKiriData = [
                '250' => $request->bc_left_250,
                '500' => $request->bc_left_500,
                '1000' => $request->bc_left_1000,
                '2000' => $request->bc_left_2000,
                '3000' => $request->bc_left_3000,
                '4000' => $request->bc_left_4000,
                '6000' => $request->bc_left_6000,
                '8000' => $request->bc_left_8000,
                'rata_rata' => $request->bc_left_avg
            ];

            // Simpan data audiometri
            $dataAudiometri = new RmeAudiometri();
            $dataAudiometri->kd_kasir = $transaksi->kd_kasir;
            $dataAudiometri->no_transaksi = $transaksi->no_transaksi;

            // Data dasar pemeriksaan
            $dataAudiometri->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
            $dataAudiometri->jam_pemeriksaan = $request->jam_pemeriksaan;

            // Data audiometri dalam format JSON
            $dataAudiometri->data_ac_kanan = json_encode($acKananData);
            $dataAudiometri->data_bc_kanan = json_encode($bcKananData);
            $dataAudiometri->data_ac_kiri = json_encode($acKiriData);
            $dataAudiometri->data_bc_kiri = json_encode($bcKiriData);

            // Data interpretasi dan catatan
            $dataAudiometri->interpretasi = $request->interpretasi;
            $dataAudiometri->catatan = $request->catatan;

            // Data audit
            $dataAudiometri->user_created = Auth::id();

            $dataAudiometri->save();

            DB::commit();

            return redirect()->route('rawat-inap.audiometri.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data audiometri berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }



    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        // Get transaksi data
        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan');
        }

        // Get specific audiometri data that belongs to this patient's transaction
        $dataAudiometri = RmeAudiometri::where('id', $id)
            ->where('kd_kasir', $transaksi->kd_kasir)
            ->where('no_transaksi', $transaksi->no_transaksi)
            ->first();

        if (!$dataAudiometri) {
            abort(404, 'Data audiometri tidak ditemukan');
        }

        // Decode JSON data for form population
        $acKanan = json_decode($dataAudiometri->data_ac_kanan, true) ?? [];
        $bcKanan = json_decode($dataAudiometri->data_bc_kanan, true) ?? [];
        $acKiri = json_decode($dataAudiometri->data_ac_kiri, true) ?? [];
        $bcKiri = json_decode($dataAudiometri->data_bc_kiri, true) ?? [];

        return view('unit-pelayanan.rawat-inap.pelayanan.audiometri.edit', compact(
            'dataMedis',
            'dataAudiometri',
            'acKanan',
            'bcKanan',
            'acKiri',
            'bcKiri'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Validasi input (sama seperti store method)
        $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'jam_pemeriksaan' => 'required',
            // AC Kanan
            'ac_right_250' => 'nullable|numeric|min:-10|max:140',
            'ac_right_500' => 'nullable|numeric|min:-10|max:140',
            'ac_right_1000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_2000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_3000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_4000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_6000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_8000' => 'nullable|numeric|min:-10|max:140',
            'ac_right_avg' => 'nullable|numeric',
            // BC Kanan
            'bc_right_250' => 'nullable|numeric|min:-10|max:140',
            'bc_right_500' => 'nullable|numeric|min:-10|max:140',
            'bc_right_1000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_2000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_3000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_4000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_6000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_8000' => 'nullable|numeric|min:-10|max:140',
            'bc_right_avg' => 'nullable|numeric',
            // AC Kiri
            'ac_left_250' => 'nullable|numeric|min:-10|max:140',
            'ac_left_500' => 'nullable|numeric|min:-10|max:140',
            'ac_left_1000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_2000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_3000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_4000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_6000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_8000' => 'nullable|numeric|min:-10|max:140',
            'ac_left_avg' => 'nullable|numeric',
            // BC Kiri
            'bc_left_250' => 'nullable|numeric|min:-10|max:140',
            'bc_left_500' => 'nullable|numeric|min:-10|max:140',
            'bc_left_1000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_2000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_3000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_4000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_6000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_8000' => 'nullable|numeric|min:-10|max:140',
            'bc_left_avg' => 'nullable|numeric',
            'interpretasi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            // Find existing audiometri record
            $dataAudiometri = RmeAudiometri::where('id', $id)
                ->where('kd_kasir', $transaksi->kd_kasir)
                ->where('no_transaksi', $transaksi->no_transaksi)
                ->first();

            if (!$dataAudiometri) {
                abort(404, 'Data audiometri tidak ditemukan');
            }

            // Prepare JSON data for AC Kanan
            $acKananData = [
                '250' => $request->ac_right_250,
                '500' => $request->ac_right_500,
                '1000' => $request->ac_right_1000,
                '2000' => $request->ac_right_2000,
                '3000' => $request->ac_right_3000,
                '4000' => $request->ac_right_4000,
                '6000' => $request->ac_right_6000,
                '8000' => $request->ac_right_8000,
                'rata_rata' => $request->ac_right_avg
            ];

            // Prepare JSON data for BC Kanan
            $bcKananData = [
                '250' => $request->bc_right_250,
                '500' => $request->bc_right_500,
                '1000' => $request->bc_right_1000,
                '2000' => $request->bc_right_2000,
                '3000' => $request->bc_right_3000,
                '4000' => $request->bc_right_4000,
                '6000' => $request->bc_right_6000,
                '8000' => $request->bc_right_8000,
                'rata_rata' => $request->bc_right_avg
            ];

            // Prepare JSON data for AC Kiri
            $acKiriData = [
                '250' => $request->ac_left_250,
                '500' => $request->ac_left_500,
                '1000' => $request->ac_left_1000,
                '2000' => $request->ac_left_2000,
                '3000' => $request->ac_left_3000,
                '4000' => $request->ac_left_4000,
                '6000' => $request->ac_left_6000,
                '8000' => $request->ac_left_8000,
                'rata_rata' => $request->ac_left_avg
            ];

            // Prepare JSON data for BC Kiri
            $bcKiriData = [
                '250' => $request->bc_left_250,
                '500' => $request->bc_left_500,
                '1000' => $request->bc_left_1000,
                '2000' => $request->bc_left_2000,
                '3000' => $request->bc_left_3000,
                '4000' => $request->bc_left_4000,
                '6000' => $request->bc_left_6000,
                '8000' => $request->bc_left_8000,
                'rata_rata' => $request->bc_left_avg
            ];

            // Update data audiometri
            $dataAudiometri->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
            $dataAudiometri->jam_pemeriksaan = $request->jam_pemeriksaan;

            // Update data audiometri dalam format JSON
            $dataAudiometri->data_ac_kanan = json_encode($acKananData);
            $dataAudiometri->data_bc_kanan = json_encode($bcKananData);
            $dataAudiometri->data_ac_kiri = json_encode($acKiriData);
            $dataAudiometri->data_bc_kiri = json_encode($bcKiriData);

            // Update interpretasi dan catatan
            $dataAudiometri->interpretasi = $request->interpretasi;
            $dataAudiometri->catatan = $request->catatan;

            // Update audit data
            $dataAudiometri->user_updated = Auth::id();
            $dataAudiometri->save();

            DB::commit();

            return redirect()->route('rawat-inap.audiometri.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data audiometri berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }
}

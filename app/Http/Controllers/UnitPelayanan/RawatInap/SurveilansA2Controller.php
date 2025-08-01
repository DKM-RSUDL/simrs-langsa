<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Nginap;
use App\Models\RmeSurveilansA2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveilansA2Controller extends Controller
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

        // Ambil data surveilans A2
        $query = RmeSurveilansA2::with(['userCreated'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('diagnosa_akhir', 'like', "%{$search}%")
                    ->orWhere('sebab_keluar', 'like', "%{$search}%")
                    ->orWhere('jenis_operasi', 'like', "%{$search}%")
                    ->orWhere('ahli_bedah', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        $dataSurveilans = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-inap.pelayanan.surveilans-a2.index', compact(
            'dataMedis',
            'dataSurveilans'
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

        $dataRawat = Nginap::with(['unitKamar', 'unit'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->orderBy('tgl_inap', 'asc')
            ->get();


        return view('unit-pelayanan.rawat-inap.pelayanan.surveilans-a2.create', compact(
            'dataMedis',
            'dataRawat',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Simpan data Surveilans A2
            $surveilansA2 = new RmeSurveilansA2();
            $surveilansA2->kd_pasien = $kd_pasien;
            $surveilansA2->tgl_masuk = $tgl_masuk;
            $surveilansA2->kd_unit = $kd_unit;
            $surveilansA2->urut_masuk = $urut_masuk;

            // Data dasar
            $surveilansA2->tanggal_implementasi = $request->tanggal_implementasi;
            $surveilansA2->jam_implementasi = $request->jam_implementasi;

            // Informasi Keluar
            $surveilansA2->tanggal_keluar = $request->tanggal_keluar;
            $surveilansA2->sebab_keluar = $request->sebab_keluar;
            $surveilansA2->diagnosa_akhir = $request->diagnosa_akhir;

            // Operasi
            $surveilansA2->ahli_bedah = $request->ahli_bedah;
            $surveilansA2->jenis_operasi = $request->jenis_operasi;
            $surveilansA2->scrub_nurse = $request->scrub_nurse;

            // Apendiks/CABG/Hernia
            $surveilansA2->tipe_operasi = $request->tipe_operasi;
            $surveilansA2->jenis_luka = $request->jenis_luka;
            $surveilansA2->lama_operasi = $request->lama_operasi;
            $surveilansA2->asa_score = $request->asa_score;
            $surveilansA2->risk_score = $request->risk_score;

            // Pemasangan Alat
            $surveilansA2->iv_perifer_tgl = $request->iv_perifer_tgl;
            $surveilansA2->iv_perifer_sd = $request->iv_perifer_sd;
            $surveilansA2->iv_sentral_tgl = $request->iv_sentral_tgl;
            $surveilansA2->iv_sentral_sd = $request->iv_sentral_sd;
            $surveilansA2->kateter_urine_tgl = $request->kateter_urine_tgl;
            $surveilansA2->kateter_urine_sd = $request->kateter_urine_sd;
            $surveilansA2->ventilasi_mekanik_tgl = $request->ventilasi_mekanik_tgl;
            $surveilansA2->ventilasi_mekanik_sd = $request->ventilasi_mekanik_sd;

            // Penggunaan Antibiotika
            $surveilansA2->pemakaian_antibiotika = $request->pemakaian_antibiotika;
            $surveilansA2->nama_jenis_obat = $request->nama_jenis_obat;
            $surveilansA2->tujuan_penggunaan = $request->tujuan_penggunaan;

            // Pemeriksaan Kultur
            $surveilansA2->pemeriksaan_kultur = $request->pemeriksaan_kultur;
            $surveilansA2->temp = $request->temp;
            $surveilansA2->hasil_kultur = $request->hasil_kultur;

            // Infeksi Nosokomial yang Terjadi
            $surveilansA2->bakteremia_sepsis = $request->bakteremia_sepsis;
            $surveilansA2->vap = $request->vap;
            $surveilansA2->infeksi_saluran_kemih = $request->infeksi_saluran_kemih;
            $surveilansA2->infeksi_luka_operasi = $request->infeksi_luka_operasi;
            $surveilansA2->dekubitus = $request->dekubitus;
            $surveilansA2->plebitis = $request->plebitis;

            // Infeksi Lain
            $surveilansA2->infeksi_lain = $request->infeksi_lain;

            $surveilansA2->user_created = Auth::id();
            $surveilansA2->save();

            DB::commit();

            return redirect()->route('rawat-inap.surveilans-ppi.a2.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Data Surveilans A2 berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
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

        // Ambil data surveilans A2 yang akan diedit
        $dataSurveilans = RmeSurveilansA2::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('id', $id)
            ->first();

        if (!$dataSurveilans) {
            return redirect()->route('rawat-inap.surveilans-ppi.a2.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('error', 'Data surveilans A2 tidak ditemukan!');
        }

        $dataRawat = Nginap::with(['unitKamar', 'unit'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->orderBy('tgl_inap', 'asc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.surveilans-a2.edit', compact(
            'dataMedis',
            'dataRawat',
            'dataSurveilans'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data surveilans A2 yang akan diupdate
            $surveilansA2 = RmeSurveilansA2::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('id', $id)
                ->first();

            if (!$surveilansA2) {
                return redirect()->route('rawat-inap.surveilans-ppi.a2.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                    ->with('error', 'Data surveilans A2 tidak ditemukan!');
            }

            // Update data dasar
            $surveilansA2->tanggal_implementasi = $request->tanggal_implementasi;
            $surveilansA2->jam_implementasi = $request->jam_implementasi;

            // Informasi Keluar
            $surveilansA2->tanggal_keluar = $request->tanggal_keluar;
            $surveilansA2->sebab_keluar = $request->sebab_keluar;
            $surveilansA2->diagnosa_akhir = $request->diagnosa_akhir;

            // Operasi
            $surveilansA2->ahli_bedah = $request->ahli_bedah;
            $surveilansA2->jenis_operasi = $request->jenis_operasi;
            $surveilansA2->scrub_nurse = $request->scrub_nurse;

            // Apendiks/CABG/Hernia
            $surveilansA2->tipe_operasi = $request->tipe_operasi;
            $surveilansA2->jenis_luka = $request->jenis_luka;
            $surveilansA2->lama_operasi = $request->lama_operasi;
            $surveilansA2->asa_score = $request->asa_score;
            $surveilansA2->risk_score = $request->risk_score;

            // Pemasangan Alat
            $surveilansA2->iv_perifer_tgl = $request->iv_perifer_tgl;
            $surveilansA2->iv_perifer_sd = $request->iv_perifer_sd;
            $surveilansA2->iv_sentral_tgl = $request->iv_sentral_tgl;
            $surveilansA2->iv_sentral_sd = $request->iv_sentral_sd;
            $surveilansA2->kateter_urine_tgl = $request->kateter_urine_tgl;
            $surveilansA2->kateter_urine_sd = $request->kateter_urine_sd;
            $surveilansA2->ventilasi_mekanik_tgl = $request->ventilasi_mekanik_tgl;
            $surveilansA2->ventilasi_mekanik_sd = $request->ventilasi_mekanik_sd;

            // Penggunaan Antibiotika
            $surveilansA2->pemakaian_antibiotika = $request->pemakaian_antibiotika;
            $surveilansA2->nama_jenis_obat = $request->nama_jenis_obat;
            $surveilansA2->tujuan_penggunaan = $request->tujuan_penggunaan;

            // Pemeriksaan Kultur
            $surveilansA2->pemeriksaan_kultur = $request->pemeriksaan_kultur;
            $surveilansA2->temp = $request->temp;
            $surveilansA2->hasil_kultur = $request->hasil_kultur;

            // Infeksi Nosokomial yang Terjadi
            $surveilansA2->bakteremia_sepsis = $request->bakteremia_sepsis;
            $surveilansA2->vap = $request->vap;
            $surveilansA2->infeksi_saluran_kemih = $request->infeksi_saluran_kemih;
            $surveilansA2->infeksi_luka_operasi = $request->infeksi_luka_operasi;
            $surveilansA2->dekubitus = $request->dekubitus;
            $surveilansA2->plebitis = $request->plebitis;

            // Infeksi Lain
            $surveilansA2->infeksi_lain = $request->infeksi_lain;

            $surveilansA2->user_updated = Auth::id();
            $surveilansA2->save();

            DB::commit();

            return redirect()->route('rawat-inap.surveilans-ppi.a2.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Data Surveilans A2 berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data surveilans A2 yang akan dihapus
            $surveilansA2 = RmeSurveilansA2::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('id', $id)
                ->first();

            if (!$surveilansA2) {
                return redirect()->route('rawat-inap.surveilans-ppi.a2.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                    ->with('error', 'Data surveilans A2 tidak ditemukan!');
            }

            // Hapus data
            $surveilansA2->delete();

            DB::commit();

            return redirect()->route('rawat-inap.surveilans-ppi.a2.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Data Surveilans A2 berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('rawat-inap.surveilans-ppi.a2.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
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

        // Ambil data surveilans A2 yang akan ditampilkan
        $surveilans = RmeSurveilansA2::with(['userCreated', 'userUpdated'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('id', $id)
            ->first();

        if (!$surveilans) {
            return redirect()->route('rawat-inap.surveilans-ppi.a2.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('error', 'Data surveilans A2 tidak ditemukan!');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.surveilans-a2.show', compact(
            'dataMedis',
            'surveilans'
        ));
    }

}

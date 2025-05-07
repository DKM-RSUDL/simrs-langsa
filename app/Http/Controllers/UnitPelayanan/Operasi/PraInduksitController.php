<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\DokterAnastesi;
use App\Models\Kunjungan;
use App\Models\OkAsesmen;
use App\Models\OkJenisAnastesi;
use App\Models\OkPraInduksi;
use App\Models\OkPraInduksiCtkp;
use App\Models\OkPraInduksiEpas;
use App\Models\OkPraInduksiIpb;
use App\Models\OkPraInduksiPsas;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PraInduksitController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();

        return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-induksi.create', compact('dataMedis', 'jenisAnastesi', 'dokterAnastesi'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {

        DB::beginTransaction();

        try {
            $praInduksit = new OkPraInduksi();
            $praInduksit->kd_pasien = $kd_pasien;
            $praInduksit->kd_unit = 71;
            $praInduksit->tgl_masuk = $tgl_masuk;
            $praInduksit->urut_masuk = $urut_masuk;

            $praInduksit->tgl_masuk_pra_induksi = $request->tgl_masuk_pra_induksi;
            $praInduksit->jam_masuk = $request->jam_masuk;
            $praInduksit->diagnosis = $request->diagnosis;
            $praInduksit->tindakan = $request->tindakan;
            $praInduksit->spesialis_anestesi = $request->spesialis_anestesi;
            $praInduksit->penata_anestesi = $request->penata_anestesi;
            $praInduksit->spesialis_bedah = $request->spesialis_bedah;

            $praInduksit->ras_tanggal = $request->ras_tanggal;
            $praInduksit->ras_tingkat_anestesi = $request->ras_tingkat_anestesi;
            $praInduksit->ras_jenis_sedasi = $request->ras_jenis_sedasi;
            $praInduksit->ras_analgesia_pasca = $request->ras_analgesia_pasca;
            $praInduksit->ras_obat_digunakan = $request->ras_obat_digunakan;

            $praInduksit->save();

            $praInduksitEpas = new OkPraInduksiEpas();
            $praInduksitEpas->id_pra_induksi = $praInduksit->id;
            $praInduksitEpas->tekanan_darah_sistole = $request->tekanan_darah_sistole;
            $praInduksitEpas->tekanan_darah_diastole = $request->tekanan_darah_diastole;
            $praInduksitEpas->nadi = $request->nadi;
            $praInduksitEpas->nafas = $request->nafas;
            $praInduksitEpas->respirasi = $request->respirasi;
            $praInduksitEpas->saturasi_tanpa_bantuan = $request->saturasi_tanpa_bantuan;
            $praInduksitEpas->saturasi_dengan_bantuan = $request->saturasi_dengan_bantuan;
            $praInduksitEpas->suhu = $request->suhu;
            $praInduksitEpas->avpu = $request->avpu;
            $praInduksitEpas->gcs_total = $request->gcs_total;
            $praInduksitEpas->golongan_darah = $request->golongan_darah;
            $praInduksitEpas->akses_intravena = $request->akses_intravena;
            $praInduksitEpas->status_fisik_asa = $request->status_fisik_asa;

            $praInduksitEpas->dukungan_pemberian_oksigen = $request->dukungan_pemberian_oksigen;
            $praInduksitEpas->dukungan_support_pernapasan = $request->dukungan_support_pernapasan;
            $praInduksitEpas->dukungan_terintubasi_o2 = $request->dukungan_terintubasi_o2;
            $praInduksitEpas->dukungan_terintubasi_spo2 = $request->dukungan_terintubasi_spo2;
            $praInduksitEpas->antropometri_tinggi_badan = $request->antropometri_tinggi_badan;
            $praInduksitEpas->antropometri_berat_badan = $request->antropometri_berat_badan;
            $praInduksitEpas->antropometri_imt = $request->antropometri_imt;
            $praInduksitEpas->antropometri_lpt = $request->antropometri_lpt;
            $praInduksitEpas->antropometri_obat_dan_pemantauan = $request->antropometri_obat_dan_pemantauan;
            $praInduksitEpas->save();

            $praInduksitPsas = new OkPraInduksiPsas();
            $praInduksitPsas->id_pra_induksi = $praInduksit->id;
            $praInduksitPsas->all_monitoring_data = $request->all_monitoring_data;
            $praInduksitPsas->hal_penting = $request->hal_penting;
            $praInduksitPsas->kedalaman_anestesi = $request->kedalaman_anestesi;
            $praInduksitPsas->respon_anestesi = $request->respon_anestesi;
            $praInduksitPsas->save();

            $praInduksitCtkp = new OkPraInduksiCtkp();
            $praInduksitCtkp->id_pra_induksi = $praInduksit->id;
            $praInduksitCtkp->jam_masuk_pemulihan_ckp = $request->jam_masuk_pemulihan_ckp;
            $praInduksitCtkp->jalan_nafas_ckp = $request->jalan_nafas_ckp;
            $praInduksitCtkp->nafas_spontan_ckp = $request->nafas_spontan_ckp;
            $praInduksitCtkp->kesadaran_pemulihan_ckp = $request->kesadaran_pemulihan_ckp;
            $praInduksitCtkp->all_observasi_data_ckp = $request->all_observasi_data_ckp;
            $praInduksitCtkp->pain_scale_data_json = $request->pain_scale_data_json;
            $praInduksitCtkp->patient_score_data_json = $request->patient_score_data_json;
            $praInduksitCtkp->jam_keluar = $request->jam_keluar;
            $praInduksitCtkp->nilai_skala_vas = $request->nilai_skala_vas;
            $praInduksitCtkp->lanjut_ruang = $request->lanjut_ruang;
            $praInduksitCtkp->catatan_pemulihan = $request->catatan_pemulihan;
            $praInduksitCtkp->save();

            $request->validate([
                'hardcopyform' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
            $praInduksitIpb = new OkPraInduksiIpb();
            $praInduksitIpb->id_pra_induksi = $praInduksit->id;
            $praInduksitIpb->bila_kesakitan = $request->bila_kesakitan;
            $praInduksitIpb->bila_mual_muntah = $request->bila_mual_muntah;
            $praInduksitIpb->antibiotika = $request->antibiotika;
            $praInduksitIpb->obat_lain = $request->obat_lain;
            $praInduksitIpb->cairan_infus = $request->cairan_infus;
            $praInduksitIpb->minum = $request->minum;
            $praInduksitIpb->pemantauan_tanda_vital = $request->pemantauan_tanda_vital;
            $praInduksitIpb->durasi_pemantauan = $request->durasi_pemantauan;
            $praInduksitIpb->dokter_edukasi = $request->dokter_edukasi;
            $praInduksitIpb->lain_lain = $request->lain_lain;

            if ($request->hasFile('hardcopyform')) {
                try {
                    $praInduksitIpb->hardcopyform = $request->file('hardcopyform')->store(
                        "uploads/operasi/pra-induksi/71/{$kd_pasien}/{$tgl_masuk}/{$urut_masuk}"
                    );
                } catch (\Exception $e) {
                    $praInduksitIpb->hardcopyform = null;
                }
            }
            $praInduksitIpb->save();

            DB::commit();
            return to_route('operasi.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pra Induksit berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $okPraInduksi = OkPraInduksi::with([
                'okPraInduksiEpas',
                'okPraInduksiPsas',
                'okPraInduksiCtkp',
                'okPraInduksiIpb'
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 71)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-induksi.show', compact(
                'okPraInduksi',
                'dataMedis'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $okPraInduksi = OkPraInduksi::with([
                'okPraInduksiEpas',
                'okPraInduksiPsas',
                'okPraInduksiCtkp',
                'okPraInduksiIpb'
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 71)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $jenisAnastesi = OkJenisAnastesi::all();
            $dokterAnastesi = DokterAnastesi::all();

            // Kirim data ke view
            return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-induksi.edit', compact(
                'okPraInduksi',
                'dataMedis',
                'jenisAnastesi',
                'dokterAnastesi'
            ));
        } catch (\Exception $e) {
            // Tangani error dan berikan pesan yang jelas
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage());
        }
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        DB::beginTransaction();

        try {
            $praInduksit = OkPraInduksi::findOrFail($id);
            $praInduksit->kd_pasien = $kd_pasien;
            $praInduksit->kd_unit = 71;
            $praInduksit->tgl_masuk = $tgl_masuk;
            $praInduksit->urut_masuk = $urut_masuk;

            $praInduksit->tgl_masuk_pra_induksi = $request->tgl_masuk_pra_induksi;
            $praInduksit->jam_masuk = $request->jam_masuk;
            $praInduksit->diagnosis = $request->diagnosis;
            $praInduksit->tindakan = $request->tindakan;
            $praInduksit->spesialis_anestesi = $request->spesialis_anestesi;
            $praInduksit->penata_anestesi = $request->penata_anestesi;
            $praInduksit->spesialis_bedah = $request->spesialis_bedah;

            $praInduksit->ras_tanggal = $request->ras_tanggal;
            $praInduksit->ras_tingkat_anestesi = $request->ras_tingkat_anestesi;
            $praInduksit->ras_jenis_sedasi = $request->ras_jenis_sedasi;
            $praInduksit->ras_analgesia_pasca = $request->ras_analgesia_pasca;
            $praInduksit->ras_obat_digunakan = $request->ras_obat_digunakan;
            $praInduksit->save();

            $praInduksitEpas = OkPraInduksiEpas::firstOrNew(['id_pra_induksi' => $praInduksit->id]);
            $praInduksitEpas->id_pra_induksi = $praInduksit->id;
            $praInduksitEpas->tekanan_darah_sistole = $request->tekanan_darah_sistole;
            $praInduksitEpas->tekanan_darah_diastole = $request->tekanan_darah_diastole;
            $praInduksitEpas->nadi = $request->nadi;
            $praInduksitEpas->nafas = $request->nafas;
            $praInduksitEpas->respirasi = $request->respirasi;
            $praInduksitEpas->saturasi_tanpa_bantuan = $request->saturasi_tanpa_bantuan;
            $praInduksitEpas->saturasi_dengan_bantuan = $request->saturasi_dengan_bantuan;
            $praInduksitEpas->suhu = $request->suhu;
            $praInduksitEpas->avpu = $request->avpu;
            $praInduksitEpas->gcs_total = $request->gcs_total;
            $praInduksitEpas->golongan_darah = $request->golongan_darah;
            $praInduksitEpas->akses_intravena = $request->akses_intravena;
            $praInduksitEpas->status_fisik_asa = $request->status_fisik_asa;

            $praInduksitEpas->dukungan_pemberian_oksigen = $request->dukungan_pemberian_oksigen;
            $praInduksitEpas->dukungan_support_pernapasan = $request->dukungan_support_pernapasan;
            $praInduksitEpas->dukungan_terintubasi_o2 = $request->dukungan_terintubasi_o2;
            $praInduksitEpas->dukungan_terintubasi_spo2 = $request->dukungan_terintubasi_spo2;
            $praInduksitEpas->antropometri_tinggi_badan = $request->antropometri_tinggi_badan;
            $praInduksitEpas->antropometri_berat_badan = $request->antropometri_berat_badan;
            $praInduksitEpas->antropometri_imt = $request->antropometri_imt;
            $praInduksitEpas->antropometri_lpt = $request->antropometri_lpt;
            $praInduksitEpas->antropometri_obat_dan_pemantauan = $request->antropometri_obat_dan_pemantauan;
            $praInduksitEpas->save();

            $praInduksitPsas = OkPraInduksiPsas::firstOrNew(['id_pra_induksi' => $praInduksit->id]);
            $praInduksitPsas->id_pra_induksi = $praInduksit->id;
            $praInduksitPsas->all_monitoring_data = $request->all_monitoring_data;
            $praInduksitPsas->hal_penting = $request->hal_penting;
            $praInduksitPsas->kedalaman_anestesi = $request->kedalaman_anestesi;
            $praInduksitPsas->respon_anestesi = $request->respon_anestesi;
            $praInduksitPsas->save();

            $praInduksitCtkp = OkPraInduksiCtkp::firstOrNew(['id_pra_induksi' => $praInduksit->id]);
            $praInduksitCtkp->id_pra_induksi = $praInduksit->id;
            $praInduksitCtkp->jam_masuk_pemulihan_ckp = $request->jam_masuk_pemulihan_ckp;
            $praInduksitCtkp->jalan_nafas_ckp = $request->jalan_nafas_ckp;
            $praInduksitCtkp->nafas_spontan_ckp = $request->nafas_spontan_ckp;
            $praInduksitCtkp->kesadaran_pemulihan_ckp = $request->kesadaran_pemulihan_ckp;
            $praInduksitCtkp->all_observasi_data_ckp = $request->all_observasi_data_ckp;
            $praInduksitCtkp->pain_scale_data_json = $request->pain_scale_data_json;
            $praInduksitCtkp->patient_score_data_json = $request->patient_score_data_json;
            $praInduksitCtkp->jam_keluar = $request->jam_keluar;
            $praInduksitCtkp->nilai_skala_vas = $request->nilai_skala_vas;
            $praInduksitCtkp->lanjut_ruang = $request->lanjut_ruang;
            $praInduksitCtkp->catatan_pemulihan = $request->catatan_pemulihan;
            $praInduksitCtkp->save();

            $request->validate([
                'hardcopyform' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
            $praInduksitIpb = OkPraInduksiIpb::firstOrNew(['id_pra_induksi' => $praInduksit->id]);
            $praInduksitIpb->id_pra_induksi = $praInduksit->id;
            $praInduksitIpb->bila_kesakitan = $request->bila_kesakitan;
            $praInduksitIpb->bila_mual_muntah = $request->bila_mual_muntah;
            $praInduksitIpb->antibiotika = $request->antibiotika;
            $praInduksitIpb->obat_lain = $request->obat_lain;
            $praInduksitIpb->cairan_infus = $request->cairan_infus;
            $praInduksitIpb->minum = $request->minum;
            $praInduksitIpb->pemantauan_tanda_vital = $request->pemantauan_tanda_vital;
            $praInduksitIpb->durasi_pemantauan = $request->durasi_pemantauan;
            $praInduksitIpb->dokter_edukasi = $request->dokter_edukasi;
            $praInduksitIpb->lain_lain = $request->lain_lain;

            // Logika untuk menangani file hardcopyform
            if ($request->hasFile('hardcopyform')) {
                try {
                    // Hapus file lama jika ada
                    if ($praInduksitIpb->hardcopyform && Storage::exists($praInduksitIpb->hardcopyform)) {
                        Storage::delete($praInduksitIpb->hardcopyform);
                    }

                    // Simpan file baru
                    $praInduksitIpb->hardcopyform = $request->file('hardcopyform')->store(
                        "uploads/operasi/pra-induksi/71/{$kd_pasien}/{$tgl_masuk}/{$urut_masuk}"
                    );
                } catch (\Exception $e) {
                    // Jika gagal menyimpan file baru, kembalikan ke file lama atau set null
                    if (!$praInduksitIpb->hardcopyform) {
                        $praInduksitIpb->hardcopyform = null;
                    }
                }
            }
            $praInduksitIpb->save();

            DB::commit();
            return to_route('operasi.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Pra Induksit berhasil di update !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
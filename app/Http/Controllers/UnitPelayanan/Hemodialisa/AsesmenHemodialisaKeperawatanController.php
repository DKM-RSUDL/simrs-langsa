<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeHdAsesmen;
use App\Models\RmeHdAsesmenKeperawatan;
use App\Models\RmeHdAsesmenKeperawatanMonitoringHeparinisasi;
use App\Models\RmeHdAsesmenKeperawatanMonitoringIntrahd;
use App\Models\RmeHdAsesmenKeperawatanMonitoringPosthd;
use App\Models\RmeHdAsesmenKeperawatanMonitoringPreekripsi;
use App\Models\RmeHdAsesmenKeperawatanMonitoringTindakan;
use App\Models\RmeHdAsesmenKeperawatanPemeriksaanFisik;
use App\Models\RmeHdAsesmenKeperawatanPempen;
use App\Models\RmeHdAsesmenKeperawatanRisikoJatuh;
use App\Models\RmeHdAsesmenKeperawatanStatusGizi;
use App\Models\RmeHdAsesmenKeperawatanStatusPsikososial;
use App\Models\RmeHdAsesmenPemeriksaanFisik;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenHemodialisaKeperawatanController extends Controller
{
    private $kdUnitDef_ = 72;

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
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

        $itemFisik = MrItemFisik::orderby('urut')->get();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $dokterPelaksana = DokterKlinik::with(['dokter'])
            ->where('kd_unit', 215)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        $dokter = Dokter::where('status', 1)->get();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();

        $perawat = HrdKaryawan::where('status_peg', 1)
        ->where('kd_ruangan', 29)
        ->where('kd_jenis_tenaga', 2)
        ->where('kd_detail_jenis_tenaga', 1)
        ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.asesmen.keperawatan.create', compact(
            'dataMedis',
            'itemFisik',
            'rmeMasterDiagnosis',
            'dokterPelaksana',
            'dokter',
            'perawat',
            'rmeMasterImplementasi'
        ));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            // store asesmen data parent
            $asesmen = new RmeHdAsesmen();
            $asesmen->kd_pasien = $kd_pasien;
            $asesmen->kd_unit = $this->kdUnitDef_;
            $asesmen->tgl_masuk = $tgl_masuk;
            $asesmen->urut_masuk = $urut_masuk;
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 2;
            $asesmen->user_create = Auth::id();
            $asesmen->save();

            // store keperawatan
            $keperawatan = new RmeHdAsesmenKeperawatan();
            $keperawatan->id_asesmen = $asesmen->id;
            $keperawatan->anamnesis = $request->anamnesis;
            // 3. Status Nyeri
            $keperawatan->status_skala_nyeri = $request->status_skala_nyeri;
            // 4. Riwayat Kesehatan
            $keperawatan->gagal_ginjal_stadium = $request->gagal_ginjal_stadium;
            $keperawatan->jenis_gagal_ginjal = $request->jenis_gagal_ginjal;
            $keperawatan->lama_menjalani_hd = $request->lama_menjalani_hd;
            $keperawatan->lama_menjalani_hd_unit = $request->lama_menjalani_hd_unit;
            $keperawatan->jadwal_hd_rutin = $request->jadwal_hd_rutin;
            $keperawatan->jadwal_hd_rutin_unit = $request->jadwal_hd_rutin_unit;
            $keperawatan->sesak_nafas = $request->sesak_nafas;
            // 5. Riwayat Obat dan Rekomendasi Dokter
            $keperawatan->obat_pasien = $request->obat_pasien;
            $keperawatan->obat_dokter = $request->obat_dokter;
            // 7. Alergi
            $keperawatan->alergi = $request->alergi;
            // 12. Penyulit Selama HD
            $keperawatan->klinis_values = $request->klinis_values;
            $keperawatan->teknis_values = $request->teknis_values;
            $keperawatan->mesin = $request->mesin;
            // 13. Disharge Planning
            $keperawatan->rencana_pulang_values = $request->rencana_pulang_values;
            // 14. Diagnosis
            $keperawatan->diagnosis_banding = $request->diagnosis_banding;
            $keperawatan->diagnosis_kerja = $request->diagnosis_kerja;
            $keperawatan->terapeutik = $request->terapeutik;
            $keperawatan->edukasi = $request->edukasi;
            $keperawatan->kolaborasi = $request->kolaborasi;
            $keperawatan->prognosis = $request->prognosis;
            // 16. Evaluasi
            $keperawatan->evaluasi_keperawatan = $request->evaluasi_keperawatan;
            $keperawatan->evaluasi_medis = $request->evaluasi_medis;

            $keperawatan->perawat_pemeriksa = $request->perawat_pemeriksa;
            $keperawatan->perawat_bertugas = $request->perawat_bertugas;
            $keperawatan->dokter_pelaksana = $request->dokter_pelaksana;
            $keperawatan->save();

            // store pemeriksaan fisik
            $KeperawatanFisik = new RmeHdAsesmenKeperawatanPemeriksaanFisik();
            $KeperawatanFisik->id_asesmen = $asesmen->id;
            $KeperawatanFisik->fisik_sistole = $request->fisik_sistole;
            $KeperawatanFisik->fisik_diastole = $request->fisik_diastole;
            $KeperawatanFisik->fisik_nadi = $request->fisik_nadi;
            $KeperawatanFisik->fisik_nafas = $request->fisik_nafas;
            $KeperawatanFisik->fisik_suhu = $request->fisik_suhu;
            $KeperawatanFisik->so_tb_o2 = $request->so_tb_o2;
            $KeperawatanFisik->so_db_o2 = $request->so_db_o2;
            $KeperawatanFisik->avpu = $request->avpu;
            $KeperawatanFisik->edema = $request->edema;
            $KeperawatanFisik->konjungtiva = $request->konjungtiva;
            $KeperawatanFisik->dehidrasi = $request->dehidrasi;
            $KeperawatanFisik->tinggi_badan = $request->tinggi_badan;
            $KeperawatanFisik->berat_badan = $request->berat_badan;
            $KeperawatanFisik->imt = $request->imt;
            $KeperawatanFisik->lpt = $request->lpt;
            $KeperawatanFisik->save();

            $keperawatanPempen = new RmeHdAsesmenKeperawatanPempen();
            $keperawatanPempen->id_asesmen = $asesmen->id;
            $keperawatanPempen->pre_ekg = $request->pre_ekg;
            $keperawatanPempen->pre_rontgent = $request->pre_rontgent;
            $keperawatanPempen->pre_usg = $request->pre_usg;
            $keperawatanPempen->pre_dll = $request->pre_dll;
            $keperawatanPempen->post_ekg = $request->post_ekg;
            $keperawatanPempen->post_rontgent = $request->post_rontgent;
            $keperawatanPempen->post_usg = $request->post_usg;
            $keperawatanPempen->post_dll = $request->post_dll;
            $keperawatanPempen->save();

            $keperawatanStatusGizi = new RmeHdAsesmenKeperawatanStatusGizi();
            $keperawatanStatusGizi->id_asesmen = $asesmen->id;

            // Konversi format datetime
            if ($request->gizi_tanggal_pengkajian) {
                $keperawatanStatusGizi->gizi_tanggal_pengkajian = Carbon::parse($request->gizi_tanggal_pengkajian)->format('Y-m-d H:i:s');
            } else {
                $keperawatanStatusGizi->gizi_tanggal_pengkajian = null;
            }

            $keperawatanStatusGizi->gizi_skore_mis = $request->gizi_skore_mis;
            $keperawatanStatusGizi->gizi_kesimpulan = $request->gizi_kesimpulan;
            $keperawatanStatusGizi->gizi_rencana_pengkajian = $request->gizi_rencana_pengkajian;
            $keperawatanStatusGizi->gizi_rekomendasi = $request->gizi_rekomendasi;
            $keperawatanStatusGizi->save();

            $keperawatanRisikoJatuh = new RmeHdAsesmenKeperawatanRisikoJatuh();
            $keperawatanRisikoJatuh->id_asesmen = $asesmen->id;
            $keperawatanRisikoJatuh->riwayat_jatuh = $request->riwayat_jatuh;
            $keperawatanRisikoJatuh->diagnosa_sekunder = $request->diagnosa_sekunder;
            $keperawatanRisikoJatuh->alat_bantu = $request->alat_bantu;
            $keperawatanRisikoJatuh->infus = $request->infus;
            $keperawatanRisikoJatuh->cara_berjalan = $request->cara_berjalan;
            $keperawatanRisikoJatuh->status_mental = $request->status_mental;
            $keperawatanRisikoJatuh->risiko_jatuh_skor = $request->risiko_jatuh_skor;
            $keperawatanRisikoJatuh->risiko_jatuh_kesimpulan = $request->risiko_jatuh_kesimpulan;
            $keperawatanRisikoJatuh->save();

            $keperawatanStatusPsikososial = new RmeHdAsesmenKeperawatanStatusPsikososial();
            $keperawatanStatusPsikososial->id_asesmen = $asesmen->id;

            // Konversi format tanggal
            if ($request->tanggal_pengkajian_psiko) {
                $keperawatanStatusPsikososial->tanggal_pengkajian_psiko = Carbon::parse($request->tanggal_pengkajian_psiko)->format('Y-m-d');
            } else {
                $keperawatanStatusPsikososial->tanggal_pengkajian_psiko = null;
            }

            $keperawatanStatusPsikososial->kendala_komunikasi = $request->kendala_komunikasi;
            $keperawatanStatusPsikososial->yang_merawat = $request->yang_merawat;

            // Handle kondisi_psikologis array dan konversi ke JSON
            if ($request->has('kondisi_psikologis') && is_array($request->kondisi_psikologis)) {
                // Simpan sebagai JSON di kondisi_psikologis_json
                $keperawatanStatusPsikososial->kondisi_psikologis_json = json_encode($request->kondisi_psikologis);
                // Dan gunakan implode untuk kondisi_psikologis sebagai string
                $keperawatanStatusPsikososial->kondisi_psikologis = implode(', ', $request->kondisi_psikologis);
            } else {
                $keperawatanStatusPsikososial->kondisi_psikologis = null;
                $keperawatanStatusPsikososial->kondisi_psikologis_json = null;
            }

            $keperawatanStatusPsikososial->kepatuhan_layanan = $request->kepatuhan_layanan;
            $keperawatanStatusPsikososial->jika_ya_jelaskan = $request->jika_ya_jelaskan;
            $keperawatanStatusPsikososial->save();

            $keperawatanMonitoringPreekripsi = new RmeHdAsesmenKeperawatanMonitoringPreekripsi();
            $keperawatanMonitoringPreekripsi->id_asesmen = $asesmen->id;
            $keperawatanMonitoringPreekripsi->inisiasi_hd_ke = $request->inisiasi_hd_ke;
            $keperawatanMonitoringPreekripsi->inisiasi_nomor_mesin = $request->inisiasi_nomor_mesin;
            $keperawatanMonitoringPreekripsi->inisiasi_bb_hd_lalu = $request->inisiasi_bb_hd_lalu;
            $keperawatanMonitoringPreekripsi->inisiasi_tekanan_vena = $request->inisiasi_tekanan_vena;
            $keperawatanMonitoringPreekripsi->inisiasi_lama_hd = $request->inisiasi_lama_hd;
            $keperawatanMonitoringPreekripsi->inisiasi_uf_profiling_detail = $request->inisiasi_uf_profiling_detail;
            $keperawatanMonitoringPreekripsi->inisiasi_bicarbonat_profiling_detail = $request->inisiasi_bicarbonat_profiling_detail;
            $keperawatanMonitoringPreekripsi->inisiasi_na_profiling_detail = $request->inisiasi_na_profiling_detail;

            $keperawatanMonitoringPreekripsi->akut_type_dializer = $request->akut_type_dializer;
            $keperawatanMonitoringPreekripsi->akut_uf_goal = $request->akut_uf_goal;
            $keperawatanMonitoringPreekripsi->akut_bb_pre_hd = $request->akut_bb_pre_hd;
            $keperawatanMonitoringPreekripsi->akut_tekanan_arteri = $request->akut_tekanan_arteri;
            $keperawatanMonitoringPreekripsi->akut_laju_uf = $request->akut_laju_uf;
            $keperawatanMonitoringPreekripsi->akut_lama_laju_uf = $request->akut_lama_laju_uf;

            $keperawatanMonitoringPreekripsi->rutin_nr_ke = $request->rutin_nr_ke;
            $keperawatanMonitoringPreekripsi->rutin_bb_kering = $request->rutin_bb_kering;
            $keperawatanMonitoringPreekripsi->rutin_bb_post_hd = $request->rutin_bb_post_hd;
            $keperawatanMonitoringPreekripsi->rutin_tmp = $request->rutin_tmp;
            $keperawatanMonitoringPreekripsi->rutin_av_shunt_detail = $request->rutin_av_shunt_detail;
            $keperawatanMonitoringPreekripsi->rutin_cdl_detail = $request->rutin_cdl_detail;
            $keperawatanMonitoringPreekripsi->rutin_femoral_detail = $request->rutin_femoral_detail;

            $keperawatanMonitoringPreekripsi->preop_dialisat = $request->preop_dialisat;
            $keperawatanMonitoringPreekripsi->preop_bicarbonat = $request->preop_bicarbonat;
            $keperawatanMonitoringPreekripsi->preop_conductivity = $request->preop_conductivity;
            $keperawatanMonitoringPreekripsi->preop_kalium = $request->preop_kalium;
            $keperawatanMonitoringPreekripsi->preop_suhu_dialisat = $request->preop_suhu_dialisat;
            $keperawatanMonitoringPreekripsi->preop_base_na = $request->preop_base_na;
            $keperawatanMonitoringPreekripsi->save();

            $keperawatanMonitoringHeparinisasi = new RmeHdAsesmenKeperawatanMonitoringHeparinisasi();
            $keperawatanMonitoringHeparinisasi->id_asesmen = $asesmen->id;
            $keperawatanMonitoringHeparinisasi->dosis_sirkulasi = $request->dosis_sirkulasi;
            $keperawatanMonitoringHeparinisasi->dosis_awal = $request->dosis_awal;
            $keperawatanMonitoringHeparinisasi->maintenance_kontinyu = $request->maintenance_kontinyu;
            $keperawatanMonitoringHeparinisasi->maintenance_intermiten = $request->maintenance_intermiten;
            $keperawatanMonitoringHeparinisasi->tanpa_heparin = $request->tanpa_heparin;
            $keperawatanMonitoringHeparinisasi->lmwh = $request->lmwh;
            $keperawatanMonitoringHeparinisasi->program_bilas_nacl = $request->program_bilas_nacl;
            $keperawatanMonitoringHeparinisasi->save();

            $keperawatanMonitoringTindakan = new RmeHdAsesmenKeperawatanMonitoringTindakan();
            $keperawatanMonitoringTindakan->id_asesmen = $asesmen->id;
            $keperawatanMonitoringTindakan->prehd_waktu_pre_hd = $request->prehd_waktu_pre_hd;
            $keperawatanMonitoringTindakan->prehd_qb = $request->prehd_qb;
            $keperawatanMonitoringTindakan->prehd_qd = $request->prehd_qd;
            $keperawatanMonitoringTindakan->prehd_uf_rate = $request->prehd_uf_rate;
            $keperawatanMonitoringTindakan->prehd_sistole = $request->prehd_sistole;
            $keperawatanMonitoringTindakan->prehd_diastole = $request->prehd_diastole;
            $keperawatanMonitoringTindakan->prehd_nadi = $request->prehd_nadi;
            $keperawatanMonitoringTindakan->prehd_nafas = $request->prehd_nafas;
            $keperawatanMonitoringTindakan->prehd_suhu = $request->prehd_suhu;
            $keperawatanMonitoringTindakan->prehd_nacl = $request->prehd_nacl;
            $keperawatanMonitoringTindakan->prehd_minum = $request->prehd_minum;
            $keperawatanMonitoringTindakan->prehd_intake_lain = $request->prehd_intake_lain;
            $keperawatanMonitoringTindakan->prehd_output = $request->prehd_output;
            $keperawatanMonitoringTindakan->save();


            $keperawatanMonitoringIntrahd = new RmeHdAsesmenKeperawatanMonitoringIntrahd();
            $keperawatanMonitoringIntrahd->id_asesmen = $asesmen->id;
            $keperawatanMonitoringIntrahd->waktu_intra_pre_hd = $request->waktu_intra_pre_hd;
            $keperawatanMonitoringIntrahd->qb_intra = $request->qb_intra;
            $keperawatanMonitoringIntrahd->qd_intra = $request->qd_intra;
            $keperawatanMonitoringIntrahd->uf_rate_intra = $request->uf_rate_intra;
            $keperawatanMonitoringIntrahd->sistole_intra = $request->sistole_intra;
            $keperawatanMonitoringIntrahd->diastole_intra = $request->diastole_intra;
            $keperawatanMonitoringIntrahd->nadi_intra = $request->nadi_intra;
            $keperawatanMonitoringIntrahd->nafas_intra = $request->nafas_intra;
            $keperawatanMonitoringIntrahd->suhu_intra = $request->suhu_intra;
            $keperawatanMonitoringIntrahd->nacl_intra = $request->nacl_intra;
            $keperawatanMonitoringIntrahd->minum_intra = $request->minum_intra;
            $keperawatanMonitoringIntrahd->intake_lain_intra = $request->intake_lain_intra;
            $keperawatanMonitoringIntrahd->output_intra = $request->output_intra;

            // Save the table data as JSON
            $keperawatanMonitoringIntrahd->observasi_data = $request->observasi_data;

            // Save to database
            $keperawatanMonitoringIntrahd->save();

            $keperawatanMonitoringPosthd = new RmeHdAsesmenKeperawatanMonitoringPosthd();
            $keperawatanMonitoringPosthd->id_asesmen = $asesmen->id;
            $keperawatanMonitoringPosthd->lama_waktu_post_hd = $request->lama_waktu_post_hd;
            $keperawatanMonitoringPosthd->qb_post = $request->qb_post;
            $keperawatanMonitoringPosthd->qd_post = $request->qd_post;
            $keperawatanMonitoringPosthd->uf_rate_post = $request->uf_rate_post;
            $keperawatanMonitoringPosthd->sistole_post = $request->sistole_post;
            $keperawatanMonitoringPosthd->diastole_post = $request->diastole_post;
            $keperawatanMonitoringPosthd->nadi_post = $request->nadi_post;
            $keperawatanMonitoringPosthd->nafas_post = $request->nafas_post;
            $keperawatanMonitoringPosthd->suhu_post = $request->suhu_post;
            $keperawatanMonitoringPosthd->nacl_post = $request->nacl_post;
            $keperawatanMonitoringPosthd->minum_post = $request->minum_post;
            $keperawatanMonitoringPosthd->intake_lain_post = $request->intake_lain_post;
            $keperawatanMonitoringPosthd->output_post = $request->output_post;
            $keperawatanMonitoringPosthd->jumlah_cairan_intake = $request->jumlah_cairan_intake;
            $keperawatanMonitoringPosthd->jumlah_cairan_output = $request->jumlah_cairan_output;
            $keperawatanMonitoringPosthd->ultrafiltration_total = $request->ultrafiltration_total;
            $keperawatanMonitoringPosthd->keterangan_soapie = $request->keterangan_soapie;
            $keperawatanMonitoringPosthd->save();

            // store ke tabel rme_hd_asesmen_pemeriksaan_fisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeHdAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $asesmen->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }

            //Simpan Diagnosa ke Master
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true);
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true);
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);
            foreach ($allDiagnoses as $diagnosa) {
                $existingDiagnosa = RmeMasterDiagnosis::where('nama_diagnosis', $diagnosa)->first();
                if (empty($existingDiagnosa)) {
                    RmeMasterDiagnosis::create(['nama_diagnosis' => $diagnosa]);
                }
            }

            DB::commit();
            return to_route('hemodialisa.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Asesmen Keperawatan berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}

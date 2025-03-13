<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKepOphtamology;
use App\Models\RmeAsesmenKepOphtamologyFisik;
use App\Models\RmeAsesmenKepOphtamologyKomprehensif;
use App\Models\RmeAsesmenKepOphtamologyRencanaPulang;
use App\Models\RmeAsesmenKepOphtamologyStatusNyeri;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeEfekNyeri;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\RmeMenjalar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenKepOpthamologyController extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $jenisnyeri = RmeJenisNyeri::all();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();

        // Mengambil data kunjungan dan tanggal triase terkait
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Mengambil nama alergen dari riwayat_alergi
        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'itemFisik',
            'menjalar',
            'frekuensinyeri',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'jenisnyeri',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            $dataAsesmen = new RmeAsesmen();
            $dataAsesmen->kd_pasien = $kd_pasien;
            $dataAsesmen->kd_unit = $kd_unit;
            $dataAsesmen->tgl_masuk = $tgl_masuk;
            $dataAsesmen->urut_masuk = $urut_masuk;
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
            $dataAsesmen->kategori = 2;
            $dataAsesmen->sub_kategori = 6;
            $dataAsesmen->anamnesis = $request->anamnesis;
            $alergis = collect(json_decode($request->alergis, true))->map(function ($item) {
                return [
                    'jenis' => $item['jenis'],
                    'alergen' => $item['alergen'],
                    'reaksi' => $item['reaksi'],
                    'keparahan' => $item['severe']
                ];
            })->toArray();
            $dataAsesmen->riwayat_alergi = json_encode($alergis);
            $dataAsesmen->save();


            $dataOphtamology = new RmeAsesmenKepOphtamology();
            $dataOphtamology->id_asesmen = $dataAsesmen->id;
            $dataOphtamology->waktu_masuk = $waktu_asesmen;
            $dataOphtamology->diagnosis_masuk = $request->diagnosis_masuk;
            $dataOphtamology->kondisi_masuk = $request->kondisi_masuk;
            $dataOphtamology->barang_berharga = $request->barang_berharga;
            $dataOphtamology->diagnosis_banding = $request->diagnosis_banding ?? '[]';
            $dataOphtamology->diagnosis_kerja = $request->diagnosis_kerja ?? '[]';
            $dataOphtamology->prognosis = $request->prognosis;
            $dataOphtamology->observasi = $request->observasi;
            $dataOphtamology->terapeutik = $request->terapeutik;
            $dataOphtamology->edukasi = $request->edukasi;
            $dataOphtamology->kolaborasi = $request->kolaborasi;
            $dataOphtamology->evaluasi = $request->evaluasi_keperawatan;
            $dataOphtamology->penyakit_yang_diderita = $request->penyakit_diderita ?? '[]';
            $dataOphtamology->riwayat_penyakit_keluarga = $request->riwayat_kesehatan_keluarga ?? '[]';
            $dataOphtamology->riwayat_penggunaan_obat = $request->riwayat_penggunaan_obat ?? '[]';
            $dataOphtamology->save();


            $dataOpthamologyFisik = new RmeAsesmenKepOphtamologyFisik();
            $dataOpthamologyFisik->id_asesmen = $dataAsesmen->id;
            $dataOpthamologyFisik->sistole = $request->sistole;
            $dataOpthamologyFisik->diastole = $request->diastole;
            $dataOpthamologyFisik->nadi = $request->nadi;
            $dataOpthamologyFisik->nafas = $request->nafas;
            $dataOpthamologyFisik->spo2_tanpa_bantuan = $request->spo_o2_tanpa;
            $dataOpthamologyFisik->spo2_dengan_bantuan = $request->spo_o2_dengan;
            $dataOpthamologyFisik->suhu = $request->suhu;
            $dataOpthamologyFisik->sensorium = $request->sensorium;
            $dataOpthamologyFisik->anemis = $request->anemis;
            $dataOpthamologyFisik->ikhterik = $request->ikhterik;
            $dataOpthamologyFisik->dyspnoe = $request->dyspnoe;
            $dataOpthamologyFisik->sianosis = $request->sianosis;
            $dataOpthamologyFisik->edema = $request->edema;
            $dataOpthamologyFisik->avpu = $request->avpu;
            $dataOpthamologyFisik->tinggi_badan = $request->tinggi_badan;
            $dataOpthamologyFisik->berat_badan = $request->berat_badan;
            $dataOpthamologyFisik->save();


            $dataOpthamologyKomrehensif = new RmeAsesmenKepOphtamologyKomprehensif();
            $dataOpthamologyKomrehensif->id_asesmen = $dataAsesmen->id;
            $dataOpthamologyKomrehensif->rpt = $request->rpt;
            $dataOpthamologyKomrehensif->rpo = $request->rpo;
            $dataOpthamologyKomrehensif->avod = $request->avdo;
            $dataOpthamologyKomrehensif->avos = $request->avso;
            $dataOpthamologyKomrehensif->sph_oculi_dextra = $request->sph_oculi_dextra;
            $dataOpthamologyKomrehensif->sph_oculi_sinistra = $request->sph_oculi_sinistra;
            $dataOpthamologyKomrehensif->cyl_oculi_dextra = $request->cyl_oculi_dextra;
            $dataOpthamologyKomrehensif->cyl_oculi_sinistra = $request->cyl_oculi_sinistra;
            $dataOpthamologyKomrehensif->menjadi_oculi_dextra = $request->menjadi_oculi_dextra;
            $dataOpthamologyKomrehensif->menjadi_oculi_sinistra = $request->menjadi_oculi_sinistra;
            $dataOpthamologyKomrehensif->kmb_oculi_dextra = $request->kmb_oculi_dextra;
            $dataOpthamologyKomrehensif->kmb_oculi_sinistra = $request->kmb_oculi_sinistra;
            $dataOpthamologyKomrehensif->tio_tod = $request->tio_tod;
            $dataOpthamologyKomrehensif->tio_tos = $request->tio_tos;
            $dataOpthamologyKomrehensif->visus_oculi_dextra = $request->visus_oculi_dextra;
            $dataOpthamologyKomrehensif->visus_oculi_sinistra = $request->visus_oculi_sinistra;
            $dataOpthamologyKomrehensif->koreksi_oculi_dextra = $request->koreksi_oculi_dextra;
            $dataOpthamologyKomrehensif->koreksi_oculi_sinistra = $request->koreksi_oculi_sinistra;
            $dataOpthamologyKomrehensif->subyektif_oculi_dextra = $request->subyektif_oculi_dextra;
            $dataOpthamologyKomrehensif->subyektif_oculi_sinistra = $request->subyektif_oculi_sinistra;
            $dataOpthamologyKomrehensif->obyektif_oculi_dextra = $request->obyektif_oculi_dextra;
            $dataOpthamologyKomrehensif->obyektif_oculi_sinistra = $request->obyektif_oculi_sinistra;
            $dataOpthamologyKomrehensif->tio_oculi_dextra = $request->tio_oculi_dextra;
            $dataOpthamologyKomrehensif->tio_oculi_sinistra = $request->tio_oculi_sinistra;
            $dataOpthamologyKomrehensif->posisi_oculi_dextra = $request->posisi_oculi_dextra;
            $dataOpthamologyKomrehensif->posisi_oculi_sinistra = $request->posisi_oculi_sinistra;
            $dataOpthamologyKomrehensif->palpebra_oculi_dextra = $request->palpebra_oculi_dextra;
            $dataOpthamologyKomrehensif->palpebra_oculi_sinistra = $request->palpebra_oculi_sinistra;
            $dataOpthamologyKomrehensif->inferior_oculi_dextra = $request->inferior_oculi_dextra;
            $dataOpthamologyKomrehensif->inferior_oculi_sinistra = $request->inferior_oculi_sinistra;
            $dataOpthamologyKomrehensif->tars_superior_oculi_dextra = $request->tars_superior_oculi_dextra;
            $dataOpthamologyKomrehensif->tars_superior_oculi_sinistra = $request->tars_superior_oculi_sinistra;
            $dataOpthamologyKomrehensif->tars_inferior_oculi_dextra = $request->tars_inferior_oculi_dextra;
            $dataOpthamologyKomrehensif->tars_inferior_oculi_sinistra = $request->tars_inferior_oculi_sinistra;
            $dataOpthamologyKomrehensif->bulbi_oculi_dextra = $request->bulbi_oculi_dextra;
            $dataOpthamologyKomrehensif->bulbi_oculi_sinistra = $request->bulbi_oculi_sinistra;
            $dataOpthamologyKomrehensif->sclera_oculi_dextra = $request->sclera_oculi_dextra;
            $dataOpthamologyKomrehensif->sclera_oculi_sinistra = $request->sclera_oculi_sinistra;
            $dataOpthamologyKomrehensif->cornea_oculi_dextra = $request->cornea_oculi_dextra;
            $dataOpthamologyKomrehensif->cornea_oculi_sinistra = $request->cornea_oculi_sinistra;
            $dataOpthamologyKomrehensif->anterior_oculi_dextra = $request->anterior_oculi_dextra;
            $dataOpthamologyKomrehensif->anterior_oculi_sinistra = $request->anterior_oculi_sinistra;
            $dataOpthamologyKomrehensif->pupil_oculi_dextra = $request->pupil_oculi_dextra;
            $dataOpthamologyKomrehensif->pupil_oculi_sinistra = $request->pupil_oculi_sinistra;
            $dataOpthamologyKomrehensif->iris_oculi_dextra = $request->iris_oculi_dextra;
            $dataOpthamologyKomrehensif->iris_oculi_sinistra = $request->iris_oculi_sinistra;
            $dataOpthamologyKomrehensif->lensa_oculi_dextra = $request->lensa_oculi_dextra;
            $dataOpthamologyKomrehensif->lensa_oculi_sinistra = $request->lensa_oculi_sinistra;
            $dataOpthamologyKomrehensif->vitreous_oculi_dextra = $request->vitreous_oculi_dextra;
            $dataOpthamologyKomrehensif->vitreous_oculi_sinistra = $request->vitreous_oculi_sinistra;
            $dataOpthamologyKomrehensif->media_oculi_dextra = $request->media_oculi_dextra;
            $dataOpthamologyKomrehensif->media_oculi_sinistra = $request->media_oculi_sinistra;
            $dataOpthamologyKomrehensif->papil_oculi_dextra = $request->papil_oculi_dextra;
            $dataOpthamologyKomrehensif->papil_oculi_sinistra = $request->papil_oculi_sinistra;
            $dataOpthamologyKomrehensif->macula_oculi_dextra = $request->macula_oculi_dextra;
            $dataOpthamologyKomrehensif->macula_oculi_sinistra = $request->macula_oculi_sinistra;
            $dataOpthamologyKomrehensif->retina_oculi_dextra = $request->retina_oculi_dextra;
            $dataOpthamologyKomrehensif->retina_oculi_sinistra = $request->retina_oculi_sinistra;
            $dataOpthamologyKomrehensif->save();


            //Simpan ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $dataAsesmen->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }


            //Simpan ke table RmeKepPerinatologyStatusNyeri
            $statusNyeri = new RmeAsesmenKepOphtamologyStatusNyeri();
            $statusNyeri->id_asesmen = $dataAsesmen->id;
            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = [
                    'NRS' => 1,
                    'FLACC' => 2,
                    'CRIES' => 3
                ];
                $statusNyeri->jenis_skala_nyeri = $jenisSkala[$request->jenis_skala_nyeri];
                $statusNyeri->nilai_nyeri = $request->nilai_skala_nyeri;
                $statusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;

                // Jika skala FLACC dipilih
                if ($request->jenis_skala_nyeri === 'FLACC') {
                    $statusNyeri->flacc_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->flacc_kaki = $request->kaki ? json_encode($request->kaki) : null;
                    $statusNyeri->flacc_aktivitas = $request->aktivitas ? json_encode($request->aktivitas) : null;
                    $statusNyeri->flacc_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->flacc_konsolabilitas = $request->konsolabilitas ? json_encode($request->konsolabilitas) : null;
                    $statusNyeri->flacc_jumlah_skala = $request->flaccTotal;
                }

                // Jika skala CRIES dipilih
                if ($request->jenis_skala_nyeri === 'CRIES') {
                    $statusNyeri->cries_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->cries_kebutuhan_oksigen = $request->oksigen ? json_encode($request->oksigen) : null;
                    $statusNyeri->cries_increased = $request->increased ? json_encode($request->increased) : null;
                    $statusNyeri->cries_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->cries_sulit_tidur = $request->tidur ? json_encode($request->tidur) : null;
                    $statusNyeri->cries_jumlah_skala = $request->criesTotal;
                }

                $statusNyeri->lokasi = $request->lokasi_nyeri;
                $statusNyeri->durasi = $request->durasi_nyeri;
                $statusNyeri->jenis_nyeri = $request->jenis_nyeri;
                $statusNyeri->frekuensi = $request->frekuensi_nyeri;
                $statusNyeri->menjalar = $request->nyeri_menjalar;
                $statusNyeri->kualitas = $request->kualitas_nyeri;
                $statusNyeri->faktor_pemberat = $request->faktor_pemberat;
                $statusNyeri->faktor_peringan = $request->faktor_peringan;
                $statusNyeri->efek_nyeri = $request->efek_nyeri;
            }
            $statusNyeri->save();


            // Simpan ke table RmeAsesmenKepOphtamologyRencanaPulang
            $asesmenRencana = new RmeAsesmenKepOphtamologyRencanaPulang();
            $asesmenRencana->id_asesmen = $dataAsesmen->id;
            $asesmenRencana->diagnosis_medis = $request->diagnosis_medis;
            $asesmenRencana->usia_lanjut = $request->usia_lanjut;
            $asesmenRencana->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenRencana->membutuhkan_pelayanan_medis = $request->penggunaan_media_berkelanjutan;
            $asesmenRencana->memerlukan_keterampilan_khusus = $request->keterampilan_khusus;
            $asesmenRencana->memerlukan_alat_bantu = $request->alat_bantu;
            $asesmenRencana->memiliki_nyeri_kronis = $request->nyeri_kronis;
            $asesmenRencana->perkiraan_lama_dirawat = $request->perkiraan_hari;
            $asesmenRencana->rencana_pulang = $request->tanggal_pulang;
            $asesmenRencana->kesimpulan = $request->kesimpulan_planing;
            $asesmenRencana->save();

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum"))
                ->with('success', 'Data asesmen anak berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen' . $e->getMessage());
        }
    }

}

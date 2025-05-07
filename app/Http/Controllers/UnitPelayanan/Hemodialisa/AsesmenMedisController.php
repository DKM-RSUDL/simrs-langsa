<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeHdAsesmen;
use App\Models\RmeHdAsesmenMedis;
use App\Models\RmeHdAsesmenMedisDeskripsi;
use App\Models\RmeHdAsesmenMedisEvaluasi;
use App\Models\RmeHdAsesmenMedisFisik;
use App\Models\RmeHdAsesmenMedisPenunjang;
use App\Models\RmeHdAsesmenPemeriksaanFisik;
use App\Models\RmeMasterDiagnosis;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenMedisController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();

        // Mengambil data kunjungan dan tanggal triase terkait
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

        $asesmen = RmeHdAsesmen::with(['fisik', 'pemFisik', 'penunjang', 'deskripsi', 'evaluasi', 'userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 72)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.asesmen.index', compact(
            'dataMedis',
            'asesmen'
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

        $perawat = HrdKaryawan::where('status_peg', 1)
            ->where('kd_ruangan', 29)
            ->where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.asesmen.medis.create', compact('dataMedis', 'itemFisik', 'rmeMasterDiagnosis', 'dokterPelaksana', 'dokter', 'perawat'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
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

            // store asesmen data parent
            $asesmen = new RmeHdAsesmen();
            $asesmen->kd_pasien = $kd_pasien;
            $asesmen->kd_unit = $this->kdUnitDef_;
            $asesmen->tgl_masuk = $tgl_masuk;
            $asesmen->urut_masuk = $urut_masuk;
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 1;
            $asesmen->user_create = Auth::id();
            $asesmen->save();


            // store pemeriksaan fisik
            $fisik = new RmeHdAsesmenMedisFisik();
            $fisik->id_asesmen = $asesmen->id;
            $fisik->anamnesis = $request->anamnesis;
            $fisik->sistole = $request->sistole;
            $fisik->diastole = $request->diastole;
            $fisik->nadi = $request->nadi;
            $fisik->nafas = $request->nafas;
            $fisik->suhu = $request->suhu;
            $fisik->so_tb_o2 = $request->so_tb_o2;
            $fisik->so_db_o2 = $request->so_db_o2;
            $fisik->avpu = $request->avpu;
            $fisik->tinggi_badan = $request->tinggi_badan;
            $fisik->berat_badan = $request->berat_badan;
            $fisik->imt = $request->imt;
            $fisik->lpt = $request->lpt;
            $fisik->skala_nyeri = $request->skala_nyeri;
            $fisik->penyakit_sekarang = $request->penyakitsekarang;
            $fisik->penyakit_dahulu = $request->penyakitdahulu;
            $fisik->efek_samping = $request->efek_samping;
            $fisik->terapi_obat = $request->terapi_obat;
            $fisik->save();

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


            // store penunjang
            $penunjangData = [
                'id_asesmen'    => $asesmen->id,
                'hb'            => $request->hb,
                'hbsag'            => $request->hbsag,
                'phospor'            => $request->phospor,
                'fe_serum'            => $request->fe_serum,
                'gol_darah'            => $request->gol_darah,
                'calcium'            => $request->calcium,
                'kalium'            => $request->kalium,
                'natrium'            => $request->natrium,
                'ureum'            => $request->ureum,
                'asam_urat'            => $request->asam_urat,
                'creatinin'            => $request->creatinin,
                'tibc'            => $request->tibc,
                'hcv'            => $request->hcv,
                'hiv'            => $request->hiv,
                'gula_darah'            => $request->gula_darah,
                'lab_lainnya'            => $request->lab_lainnya,
                'ekg'            => $request->ekg,
                'rongent'            => $request->rongent,
                'usg'            => $request->usg,
            ];

            RmeHdAsesmenMedisPenunjang::create($penunjangData);

            // store deskripsi
            $deskripsiData = [
                'id_asesmen'        => $asesmen->id,
                'jenis_hd'          => $request->jenis_hd,
                'rutin'          => $request->rutin,
                'jenis_dialisat'          => $request->jenis_dialisat,
                'suhu_dialisat'          => $request->suhu_dialisat,
                'akses_vaskular'          => $request->akses_vaskular,
                'lama_hd'          => $request->lama_hd,
                'qb'          => $request->qb,
                'qd'          => $request->qd,
                'uf_goal'          => $request->uf_goal,
                'dosis_awal'          => $request->dosis_awal,
                'm_kontinyu'          => $request->m_kontinyu,
                'm_intermiten'          => $request->m_intermiten,
                'tanpa_heparin'          => $request->tanpa_heparin,
                'lmwh'          => $request->lmwh,
                'ultrafiltrasi_mode'          => $request->ultrafiltrasi_mode,
                'natrium_mode'          => $request->natrium_mode,
                'bicabornat_mode'          => $request->bicabornat_mode,
            ];

            RmeHdAsesmenMedisDeskripsi::create($deskripsiData);


            // store evaluasi
            $evaluasi = new RmeHdAsesmenMedisEvaluasi();
            $evaluasi->id_asesmen           = $asesmen->id;
            $evaluasi->evaluasi_medis       = $request->evaluasi_medis;
            $evaluasi->dokter_pelaksana     = $request->dokter_pelaksana;
            $evaluasi->dpjp                 = $request->dpjp;
            $evaluasi->perawat              = $request->perawat;
            $evaluasi->diagnosis_banding    = $request->diagnosis_banding;
            $evaluasi->diagnosis_kerja      = $request->diagnosis_kerja;
            $evaluasi->save();

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
            return to_route('hemodialisa.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Asesmen medis berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
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

        $perawat = HrdKaryawan::where('status_peg', 1)
            ->where('kd_ruangan', 29)
            ->where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->get();

        $asesmen = RmeHdAsesmen::find($id);

        return view('unit-pelayanan.hemodialisa.pelayanan.asesmen.medis.edit', compact('dataMedis', 'itemFisik', 'rmeMasterDiagnosis', 'dokterPelaksana', 'dokter', 'perawat', 'asesmen'));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
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

            // store asesmen data parent
            $id = decrypt($idEncrypt);

            $asesmen = RmeHdAsesmen::find($id);
            $asesmen->user_edit = Auth::id();
            $asesmen->save();


            // store pemeriksaan fisik
            $fisik = RmeHdAsesmenMedisFisik::where('id_asesmen', $asesmen->id)->first();
            $fisik->anamnesis = $request->anamnesis;
            $fisik->sistole = $request->sistole;
            $fisik->diastole = $request->diastole;
            $fisik->nadi = $request->nadi;
            $fisik->nafas = $request->nafas;
            $fisik->suhu = $request->suhu;
            $fisik->so_tb_o2 = $request->so_tb_o2;
            $fisik->so_db_o2 = $request->so_db_o2;
            $fisik->avpu = $request->avpu;
            $fisik->tinggi_badan = $request->tinggi_badan;
            $fisik->berat_badan = $request->berat_badan;
            $fisik->imt = $request->imt;
            $fisik->lpt = $request->lpt;
            $fisik->skala_nyeri = $request->skala_nyeri;
            $fisik->penyakit_sekarang = $request->penyakitsekarang;
            $fisik->penyakit_dahulu = $request->penyakitdahulu;
            $fisik->efek_samping = $request->efek_samping;
            $fisik->terapi_obat = $request->terapi_obat;
            $fisik->save();

            // store ke tabel rme_hd_asesmen_pemeriksaan_fisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeHdAsesmenPemeriksaanFisik::updateOrCreate([
                    'id_asesmen' => $asesmen->id,
                    'id_item_fisik' => $item->id,
                ], [
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }


            // store penunjang
            $penunjangData = [
                'hb'            => $request->hb,
                'hbsag'            => $request->hbsag,
                'phospor'            => $request->phospor,
                'fe_serum'            => $request->fe_serum,
                'gol_darah'            => $request->gol_darah,
                'calcium'            => $request->calcium,
                'kalium'            => $request->kalium,
                'natrium'            => $request->natrium,
                'ureum'            => $request->ureum,
                'asam_urat'            => $request->asam_urat,
                'creatinin'            => $request->creatinin,
                'tibc'            => $request->tibc,
                'hcv'            => $request->hcv,
                'hiv'            => $request->hiv,
                'gula_darah'            => $request->gula_darah,
                'lab_lainnya'            => $request->lab_lainnya,
                'ekg'            => $request->ekg,
                'rongent'            => $request->rongent,
                'usg'            => $request->usg,
            ];

            RmeHdAsesmenMedisPenunjang::where('id_asesmen', $asesmen->id)->update($penunjangData);

            // store deskripsi
            $deskripsiData = [
                'jenis_hd'          => $request->jenis_hd,
                'rutin'          => $request->rutin,
                'jenis_dialisat'          => $request->jenis_dialisat,
                'suhu_dialisat'          => $request->suhu_dialisat,
                'akses_vaskular'          => $request->akses_vaskular,
                'lama_hd'          => $request->lama_hd,
                'qb'          => $request->qb,
                'qd'          => $request->qd,
                'uf_goal'          => $request->uf_goal,
                'dosis_awal'          => $request->dosis_awal,
                'm_kontinyu'          => $request->m_kontinyu,
                'm_intermiten'          => $request->m_intermiten,
                'tanpa_heparin'          => $request->tanpa_heparin,
                'lmwh'          => $request->lmwh,
                'ultrafiltrasi_mode'          => $request->ultrafiltrasi_mode,
                'natrium_mode'          => $request->natrium_mode,
                'bicabornat_mode'          => $request->bicabornat_mode,
            ];

            RmeHdAsesmenMedisDeskripsi::where('id_asesmen', $asesmen->id)->update($deskripsiData);


            // store evaluasi
            $evaluasi = RmeHdAsesmenMedisEvaluasi::where('id_asesmen', $asesmen->id)->first();
            $evaluasi->id_asesmen           = $asesmen->id;
            $evaluasi->evaluasi_medis       = $request->evaluasi_medis;
            $evaluasi->dokter_pelaksana     = $request->dokter_pelaksana;
            $evaluasi->dpjp                 = $request->dpjp;
            $evaluasi->perawat              = $request->perawat;
            $evaluasi->diagnosis_banding    = $request->diagnosis_banding;
            $evaluasi->diagnosis_kerja      = $request->diagnosis_kerja;
            $evaluasi->save();

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
            return to_route('hemodialisa.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Asesmen medis berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
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

        $perawat = HrdKaryawan::where('status_peg', 1)
            ->where('kd_ruangan', 29)
            ->where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->get();

        $asesmen = RmeHdAsesmen::find($id);

        return view('unit-pelayanan.hemodialisa.pelayanan.asesmen.medis.show', compact('dataMedis', 'itemFisik', 'rmeMasterDiagnosis', 'dokterPelaksana', 'dokter', 'perawat', 'asesmen'));
    }
}
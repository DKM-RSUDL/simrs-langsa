<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeDataHasilLab;
use App\Models\RmeDataHasilLabDtl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HDHasilLabController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Mengambil data kunjungan
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

        // Mengambil data hasil lab
        $dataHasilLab = RmeDataHasilLab::with('detail')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.hasil-lab.index', compact(
            'dataMedis',
            'dataHasilLab'
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

        return view('unit-pelayanan.hemodialisa.pelayanan.hasil-lab.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $dataHasilLab = new RmeDataHasilLab();
            $dataHasilLab->kd_pasien = $kd_pasien;
            $dataHasilLab->kd_unit = $this->kdUnitDef_;
            $dataHasilLab->tgl_masuk = $tgl_masuk;
            $dataHasilLab->urut_masuk = $urut_masuk;
            $dataHasilLab->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHasilLab->jam_implementasi = $request->jam_implementasi;
            $dataHasilLab->pemeriksaan_urine_rutin = $request->pemeriksaan_urine_rutin;
            $dataHasilLab->pemeriksaan_feres_rutin = $request->pemeriksaan_feres_rutin;
            $dataHasilLab->pemeriksaan_lain_lain = $request->pemeriksaan_lain_lain;
            $dataHasilLab->user_created = Auth::id();
            $dataHasilLab->save();

            //Hasil Lab
            $detailHasilLab = new RmeDataHasilLabDtl();
            $detailHasilLab->id_hasil_lab = $dataHasilLab->id;

            // Hematologi
            $detailHasilLab->hb = $request->hb;
            $detailHasilLab->leukosit = $request->leukosit;
            $detailHasilLab->thrombosit = $request->thrombosit;
            $detailHasilLab->hematokrit = $request->hematokrit;
            $detailHasilLab->eritrosit = $request->eritrosit;
            $detailHasilLab->led = $request->led;
            $detailHasilLab->golongan_darah = $request->golongan_darah;

            // Fungsi Ginjal
            $detailHasilLab->ureum_pre = $request->ureum_pre;
            $detailHasilLab->ureum_post = $request->ureum_post;
            $detailHasilLab->urr = $request->urr;
            $detailHasilLab->kreatinin_pre = $request->kreatinin_pre;
            $detailHasilLab->kreatinin_post = $request->kreatinin_post;
            $detailHasilLab->asam_urat = $request->asam_urat;

            // Anemia
            $detailHasilLab->besi_fe = $request->besi_fe;
            $detailHasilLab->tibc = $request->tibc;
            $detailHasilLab->saturasi_transferin = $request->saturasi_transferin;
            $detailHasilLab->feritin = $request->feritin;

            // Fungsi Hati
            $detailHasilLab->sgot = $request->sgot;
            $detailHasilLab->sgpt = $request->sgpt;
            $detailHasilLab->bilirubin_total = $request->bilirubin_total;
            $detailHasilLab->bilirubin_direct = $request->bilirubin_direct;
            $detailHasilLab->protein_total = $request->protein_total;
            $detailHasilLab->albumin = $request->albumin;
            $detailHasilLab->fosfatase_alkali = $request->fosfatase_alkali;
            $detailHasilLab->gamma_gt = $request->gamma_gt;

            // Diabetes Melitus
            $detailHasilLab->glukosa_puasa = $request->glukosa_puasa;
            $detailHasilLab->glukosa_2jam_pp = $request->glukosa_2jam_pp;
            $detailHasilLab->glukosa_sewaktu = $request->glukosa_sewaktu;
            $detailHasilLab->hb1a1c = $request->hb1a1c;

            // Lemak
            $detailHasilLab->kolesterol_total = $request->kolesterol_total;
            $detailHasilLab->ldl_c = $request->ldl_c;
            $detailHasilLab->hdl_c = $request->hdl_c;
            $detailHasilLab->trigliserida = $request->trigliserida;

            // Faal Jantung
            $detailHasilLab->ck = $request->ck;
            $detailHasilLab->ck_mb = $request->ck_mb;
            $detailHasilLab->troponin_t = $request->troponin_t;
            $detailHasilLab->troponin_i = $request->troponin_i;
            $detailHasilLab->ldh = $request->ldh;

            // Elektrolit
            $detailHasilLab->natrium = $request->natrium;
            $detailHasilLab->kalium = $request->kalium;
            $detailHasilLab->calcium_ion = $request->calcium_ion;
            $detailHasilLab->clorida = $request->clorida;
            $detailHasilLab->magnesium = $request->magnesium;
            $detailHasilLab->calcium_total = $request->calcium_total;
            $detailHasilLab->phospor = $request->phospor;

            // Imunoserology
            $detailHasilLab->hbsag_rapid = $request->hbsag_rapid;
            $detailHasilLab->hbsag_elisa = $request->hbsag_elisa;
            $detailHasilLab->anti_hcv_rapid = $request->anti_hcv_rapid;
            $detailHasilLab->anti_hiv_rapid = $request->anti_hiv_rapid;
            $detailHasilLab->anti_hiv_3_metode = $request->anti_hiv_3_metode;
            $detailHasilLab->fob = $request->fob;

            $detailHasilLab->save();

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.hasil-lab.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data hasil lab berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
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

        $dataHasilLab = RmeDataHasilLab::with('detail')->findOrFail($id);

        return view('unit-pelayanan.hemodialisa.pelayanan.hasil-lab.show', compact(
            'dataMedis',
            'dataHasilLab'
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

        $dataHasilLab = RmeDataHasilLab::with('detail')->findOrFail($id);

        return view('unit-pelayanan.hemodialisa.pelayanan.hasil-lab.edit', compact(
            'dataMedis',
            'dataHasilLab'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataHasilLab = RmeDataHasilLab::findOrFail($id);
            $dataHasilLab->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHasilLab->jam_implementasi = $request->jam_implementasi;
            $dataHasilLab->pemeriksaan_urine_rutin = $request->pemeriksaan_urine_rutin;
            $dataHasilLab->pemeriksaan_feres_rutin = $request->pemeriksaan_feres_rutin;
            $dataHasilLab->pemeriksaan_lain_lain = $request->pemeriksaan_lain_lain;
            $dataHasilLab->user_updated = Auth::id();
            $dataHasilLab->save();

            // Update detail hasil lab
            $detailHasilLab = RmeDataHasilLabDtl::where('id_hasil_lab', $id)->first();
            if (!$detailHasilLab) {
                $detailHasilLab = new RmeDataHasilLabDtl();
                $detailHasilLab->id_hasil_lab = $id;
            }

            // Hematologi
            $detailHasilLab->hb = $request->hb;
            $detailHasilLab->leukosit = $request->leukosit;
            $detailHasilLab->thrombosit = $request->thrombosit;
            $detailHasilLab->hematokrit = $request->hematokrit;
            $detailHasilLab->eritrosit = $request->eritrosit;
            $detailHasilLab->led = $request->led;
            $detailHasilLab->golongan_darah = $request->golongan_darah;

            // Fungsi Ginjal
            $detailHasilLab->ureum_pre = $request->ureum_pre;
            $detailHasilLab->ureum_post = $request->ureum_post;
            $detailHasilLab->urr = $request->urr;
            $detailHasilLab->kreatinin_pre = $request->kreatinin_pre;
            $detailHasilLab->kreatinin_post = $request->kreatinin_post;
            $detailHasilLab->asam_urat = $request->asam_urat;

            // Anemia
            $detailHasilLab->besi_fe = $request->besi_fe;
            $detailHasilLab->tibc = $request->tibc;
            $detailHasilLab->saturasi_transferin = $request->saturasi_transferin;
            $detailHasilLab->feritin = $request->feritin;

            // Fungsi Hati
            $detailHasilLab->sgot = $request->sgot;
            $detailHasilLab->sgpt = $request->sgpt;
            $detailHasilLab->bilirubin_total = $request->bilirubin_total;
            $detailHasilLab->bilirubin_direct = $request->bilirubin_direct;
            $detailHasilLab->protein_total = $request->protein_total;
            $detailHasilLab->albumin = $request->albumin;
            $detailHasilLab->fosfatase_alkali = $request->fosfatase_alkali;
            $detailHasilLab->gamma_gt = $request->gamma_gt;

            // Diabetes Melitus
            $detailHasilLab->glukosa_puasa = $request->glukosa_puasa;
            $detailHasilLab->glukosa_2jam_pp = $request->glukosa_2jam_pp;
            $detailHasilLab->glukosa_sewaktu = $request->glukosa_sewaktu;
            $detailHasilLab->hb1a1c = $request->hb1a1c;

            // Lemak
            $detailHasilLab->kolesterol_total = $request->kolesterol_total;
            $detailHasilLab->ldl_c = $request->ldl_c;
            $detailHasilLab->hdl_c = $request->hdl_c;
            $detailHasilLab->trigliserida = $request->trigliserida;

            // Faal Jantung
            $detailHasilLab->ck = $request->ck;
            $detailHasilLab->ck_mb = $request->ck_mb;
            $detailHasilLab->troponin_t = $request->troponin_t;
            $detailHasilLab->troponin_i = $request->troponin_i;
            $detailHasilLab->ldh = $request->ldh;

            // Elektrolit
            $detailHasilLab->natrium = $request->natrium;
            $detailHasilLab->kalium = $request->kalium;
            $detailHasilLab->calcium_ion = $request->calcium_ion;
            $detailHasilLab->clorida = $request->clorida;
            $detailHasilLab->magnesium = $request->magnesium;
            $detailHasilLab->calcium_total = $request->calcium_total;
            $detailHasilLab->phospor = $request->phospor;

            // Imunoserology
            $detailHasilLab->hbsag_rapid = $request->hbsag_rapid;
            $detailHasilLab->hbsag_elisa = $request->hbsag_elisa;
            $detailHasilLab->anti_hcv_rapid = $request->anti_hcv_rapid;
            $detailHasilLab->anti_hiv_rapid = $request->anti_hiv_rapid;
            $detailHasilLab->anti_hiv_3_metode = $request->anti_hiv_3_metode;
            $detailHasilLab->fob = $request->fob;

            $detailHasilLab->save();

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.hasil-lab.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data hasil lab berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataHasilLab = RmeDataHasilLab::findOrFail($id);

            // Hapus detail terlebih dahulu
            RmeDataHasilLabDtl::where('id_hasil_lab', $id)->delete();

            // Hapus header
            $dataHasilLab->delete();

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.hasil-lab.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data hasil lab berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}

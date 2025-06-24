<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAsesmenPraAnestesi;
use App\Models\RmeAsesmenPraAnestesiDiagnosisPmRtRo;
use App\Models\RmeAsesmenPraAnestesiKppKs;
use App\Models\RmeAsesmenPraAnestesiKuPfLaboratorium;
use App\Models\RmeAsesmenPraAnestesiRiwayatKeluarga;
use App\Models\RmeAsesmenPraAnestesiRppRml;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AsesmenPraAnestesiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        $asesmenPraAnestesi = RmeAsesmenPraAnestesi::where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal_create', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-pra-anestesi.index', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'user',
            'asesmenPraAnestesi'
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }


        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-pra-anestesi.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            $asesmenPraAnestesi = new RmeAsesmenPraAnestesi();

            // parameter dari method signature, bukan dari request
            $asesmenPraAnestesi->kd_pasien = $kd_pasien;
            $asesmenPraAnestesi->kd_unit = $kd_unit;
            $asesmenPraAnestesi->tgl_masuk = $tgl_masuk;
            $asesmenPraAnestesi->urut_masuk = $urut_masuk;

            $asesmenPraAnestesi->user_create = Auth::id();
            $asesmenPraAnestesi->tanggal_create = now();

            // Data dari form
            $asesmenPraAnestesi->umur = $request->umur ?? null;
            $asesmenPraAnestesi->jenis_kelamin = $request->jenis_kelamin ?? null;
            $asesmenPraAnestesi->menikah = $request->menikah ?? null;
            $asesmenPraAnestesi->pekerjaan = $request->pekerjaan ?? null;
            $asesmenPraAnestesi->merokok = $request->merokok ?? null;
            $asesmenPraAnestesi->alkohol = $request->alkohol ?? null;
            $asesmenPraAnestesi->obat_resep = $request->obat_resep ?? null;
            $asesmenPraAnestesi->obat_bebas = $request->obat_bebas ?? null;
            $asesmenPraAnestesi->aspirin_rutin = $request->aspirin_rutin ?? null;
            $asesmenPraAnestesi->aspirin_dosis = $request->aspirin_dosis ?? null;
            $asesmenPraAnestesi->obat_anti_sakit = $request->obat_anti_sakit ?? null;
            $asesmenPraAnestesi->anti_sakit_dosis = $request->anti_sakit_dosis ?? null;
            $asesmenPraAnestesi->injeksi_steroid = $request->injeksi_steroid ?? null;
            $asesmenPraAnestesi->steroid_lokasi = $request->steroid_lokasi ?? null;
            $asesmenPraAnestesi->alergi_obat = $request->alergi_obat ?? null;
            $asesmenPraAnestesi->alergi_obat_detail = $request->alergi_obat_detail ?? null;
            $asesmenPraAnestesi->alergi_lateks = $request->alergi_lateks ?? null;
            $asesmenPraAnestesi->alergi_plester = $request->alergi_plester ?? null;
            $asesmenPraAnestesi->alergi_makanan = $request->alergi_makanan ?? null;
            $asesmenPraAnestesi->save();

            // Riwayat Keluarga dan Komunikasi
            $asesmenPraAnestesiRiwayatKeluarga = new RmeAsesmenPraAnestesiRiwayatKeluarga();
            $asesmenPraAnestesiRiwayatKeluarga->id_asesmen_pra_anestesi = $asesmenPraAnestesi->id;
            $asesmenPraAnestesiRiwayatKeluarga->rk_perdarahan = $request->rk_perdarahan ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_pembekuan = $request->rk_pembekuan ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_anestesi = $request->rk_anestesi ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_operasi_jantung = $request->rk_operasi_jantung ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_diabetes = $request->rk_diabetes ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_serangan_jantung = $request->rk_serangan_jantung ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_hipertensi = $request->rk_hipertensi ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_tuberkulosis = $request->rk_tuberkulosis ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_penyakit_lain = $request->rk_penyakit_lain ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->rk_keterangan = $request->rk_keterangan ?? null;
            // Komunikasi
            $asesmenPraAnestesiRiwayatKeluarga->bahasa = $request->bahasa ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->bahasa_lain = $request->bahasa_lain ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->gangguan_pendengaran = $request->gangguan_pendengaran ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->gangguan_penglihatan = $request->gangguan_penglihatan ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->gangguan_bicara = $request->gangguan_bicara ?? null;
            $asesmenPraAnestesiRiwayatKeluarga->save();

            // Riwayat Penyakit Pasien dan Riwayat Medis Lainnya
            $asesmenPraAnestesiRppRml = new RmeAsesmenPraAnestesiRppRml();
            $asesmenPraAnestesiRppRml->id_asesmen_pra_anestesi = $asesmenPraAnestesi->id;
            $asesmenPraAnestesiRppRml->rp_perdarahan = $request->rp_perdarahan ?? null;
            $asesmenPraAnestesiRppRml->rp_pembekuan = $request->rp_pembekuan ?? null;
            $asesmenPraAnestesiRppRml->rp_maag = $request->rp_maag ?? null;
            $asesmenPraAnestesiRppRml->rp_anemia = $request->rp_anemia ?? null;
            $asesmenPraAnestesiRppRml->rp_sesak = $request->rp_sesak ?? null;
            $asesmenPraAnestesiRppRml->rp_asma = $request->rp_asma ?? null;
            $asesmenPraAnestesiRppRml->rp_diabetes = $request->rp_diabetes ?? null;
            $asesmenPraAnestesiRppRml->rp_pingsan = $request->rp_pingsan ?? null;
            $asesmenPraAnestesiRppRml->rp_serangan_jantung = $request->rp_serangan_jantung ?? null;
            $asesmenPraAnestesiRppRml->rp_hepatitis = $request->rp_hepatitis ?? null;
            $asesmenPraAnestesiRppRml->rp_hipertensi = $request->rp_hipertensi ?? null;
            $asesmenPraAnestesiRppRml->rp_sumbatan_nafas = $request->rp_sumbatan_nafas ?? null;
            $asesmenPraAnestesiRppRml->rp_mengorok = $request->rp_mengorok ?? null;
            $asesmenPraAnestesiRppRml->rp_penyakit_lain = $request->rp_penyakit_lain ?? null;
            $asesmenPraAnestesiRppRml->rp_keterangan = $request->rp_keterangan ?? null;
            // Riwayat Medis Lainnya
            $asesmenPraAnestesiRppRml->transfusi_darah = $request->transfusi_darah ?? null;
            $asesmenPraAnestesiRppRml->transfusi_tahun = $request->transfusi_tahun ?? null;
            $asesmenPraAnestesiRppRml->periksa_hiv = $request->periksa_hiv ?? null;
            $asesmenPraAnestesiRppRml->hiv_tahun = $request->hiv_tahun ?? null;
            $asesmenPraAnestesiRppRml->hasil_hiv = $request->hasil_hiv ?? null;
            $asesmenPraAnestesiRppRml->lensa_kontak = $request->lensa_kontak ?? null;
            $asesmenPraAnestesiRppRml->alat_bantu_dengar = $request->alat_bantu_dengar ?? null;
            $asesmenPraAnestesiRppRml->gigi_palsu = $request->gigi_palsu ?? null;
            $asesmenPraAnestesiRppRml->riwayat_operasi = $request->riwayat_operasi ?? null;
            $asesmenPraAnestesiRppRml->jenis_anestesi_sebelum = $request->jenis_anestesi_sebelum ?? null;
            $asesmenPraAnestesiRppRml->tanggal_periksa_terakhir = $request->tanggal_periksa_terakhir ?? null;
            $asesmenPraAnestesiRppRml->tempat_periksa_terakhir = $request->tempat_periksa_terakhir ?? null;
            $asesmenPraAnestesiRppRml->gangguan_periksa = $request->gangguan_periksa ?? null;
            $asesmenPraAnestesiRppRml->save();

            // Khusus Pasien Perempuan dan Diisi Oleh Dokter
            $asesmenPraAnestesiKppKs = new RmeAsesmenPraAnestesiKppKs();
            $asesmenPraAnestesiKppKs->id_asesmen_pra_anestesi = $asesmenPraAnestesi->id;
            $asesmenPraAnestesiKppKs->jumlah_kehamilan = $request->jumlah_kehamilan ?? null;
            $asesmenPraAnestesiKppKs->jumlah_anak = $request->jumlah_anak ?? null;
            $asesmenPraAnestesiKppKs->menstruasi_terakhir = $request->menstruasi_terakhir ?? null;
            $asesmenPraAnestesiKppKs->menyusui = $request->menyusui ?? null;
            // Diisi Oleh Dokter
            $asesmenPraAnestesiKppKs->hilangnya_gigi = $request->hilangnya_gigi ?? null;
            $asesmenPraAnestesiKppKs->masalah_mobilitas_leher = $request->masalah_mobilitas_leher ?? null;
            $asesmenPraAnestesiKppKs->leher_pendek = $request->leher_pendek ?? null;
            $asesmenPraAnestesiKppKs->batuk = $request->batuk ?? null;
            $asesmenPraAnestesiKppKs->sesak_nafas = $request->sesak_nafas ?? null;
            $asesmenPraAnestesiKppKs->baru_saja_infeksi = $request->baru_saja_infeksi ?? null;
            $asesmenPraAnestesiKppKs->menstruasi_tidak_normal = $request->menstruasi_tidak_normal ?? null;
            $asesmenPraAnestesiKppKs->pingsan = $request->pingsan ?? null;
            $asesmenPraAnestesiKppKs->sakit_dada = $request->sakit_dada ?? null;
            $asesmenPraAnestesiKppKs->denyut_jantung_tidak_normal = $request->denyut_jantung_tidak_normal ?? null;
            $asesmenPraAnestesiKppKs->muntah = $request->muntah ?? null;
            $asesmenPraAnestesiKppKs->susaah_bak = $request->susaah_bak ?? null;
            $asesmenPraAnestesiKppKs->kejang = $request->kejang ?? null;
            $asesmenPraAnestesiKppKs->sedang_hamil = $request->sedang_hamil ?? null;
            $asesmenPraAnestesiKppKs->stroke = $request->stroke ?? null;
            $asesmenPraAnestesiKppKs->obesitas = $request->obesitas ?? null;
            $asesmenPraAnestesiKppKs->saluran_nafas_atas = $request->saluran_nafas_atas ?? null;
            $asesmenPraAnestesiKppKs->save();

            // Keadaan Umum, Pemeriksaan Fisik dan Laboratorium
            $asesmenPraAnestesiKuPfLaboratorium = new RmeAsesmenPraAnestesiKuPfLaboratorium();
            $asesmenPraAnestesiKuPfLaboratorium->id_asesmen_pra_anestesi = $asesmenPraAnestesi->id;
            $asesmenPraAnestesiKuPfLaboratorium->kesadaran = $request->kesadaran ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->visus = $request->visus ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->faring = $request->faring ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->gigi_palus = $request->gigi_palus ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->keadaan_umum_keterangan = $request->keadaan_umum_keterangan ?? null;
            // Pemeriksaan Fisik
            $asesmenPraAnestesiKuPfLaboratorium->bb = $request->bb ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->td = $request->td ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->nadi = $request->nadi ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->suhu = $request->suhu ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->paru = $request->paru ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->jantung = $request->jantung ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->abdomen = $request->abdomen ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->ekstremitas = $request->ekstremitas ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->neurologi = $request->neurologi ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->pemeriksaan_fisik_keterangan = $request->pemeriksaan_fisik_keterangan ?? null;
            // Laboratorium
            $asesmenPraAnestesiKuPfLaboratorium->hb_leuco_thrombo = $request->hb_leuco_thrombo ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->pt_aptt = $request->pt_aptt ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->tes_kreatinin = $request->tes_kreatinin ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->ureum = $request->ureum ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->ekg = $request->ekg ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->na_cl_k = $request->na_cl_k ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->co2 = $request->co2 ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->ct_scan = $request->ct_scan ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->mri = $request->mri ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->usg = $request->usg ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->laboratorium_lain = $request->laboratorium_lain ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->laboratorium_keterangan = $request->laboratorium_keterangan ?? null;
            $asesmenPraAnestesiKuPfLaboratorium->save();

            $asesmenPraAnestesiDiagnosisPmRtRo = new RmeAsesmenPraAnestesiDiagnosisPmRtRo();
            $asesmenPraAnestesiDiagnosisPmRtRo->id_asesmen_pra_anestesi = $asesmenPraAnestesi->id;
            $asesmenPraAnestesiDiagnosisPmRtRo->asa_klasifikasi = $request->asa_klasifikasi ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->pusa_mulai = $request->pusa_mulai ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->pusa_mulai_jam = $request->pusa_mulai_jam ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->rencana_tindakan = $request->rencana_tindakan ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->rencana_tanggal = $request->rencana_tanggal ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->rencana_jam = $request->rencana_jam ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->rencana_operasi = $request->rencana_operasi ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->rencana_operasi_tanggal = $request->rencana_operasi_tanggal ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->rencana_operasi_jam = $request->rencana_operasi_jam ?? null;
            $asesmenPraAnestesiDiagnosisPmRtRo->save();

            DB::commit();

            return to_route('rawat-inap.asesmen-pra-anestesi.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])
                ->with('success', 'Data pra Anestesi dan Sedasi berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmenPraAnestesi = RmeAsesmenPraAnestesi::with([
                'rmeAsesmenPraAnestesiRiwayatKeluarga',
                'rmeAsesmenPraAnestesiRppRml',
                'rmeAsesmenPraAnestesiKppKs',
                'rmeAsesmenPraAnestesiKuPfLaboratorium',
                'rmeAsesmenPraAnestesiDiagnosisPmRtRo',
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Ganti view ke edit, bukan show
            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-pra-anestesi.edit', compact(
                'asesmenPraAnestesi',
                'dataMedis',
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmenPraAnestesi = RmeAsesmenPraAnestesi::with([
                'rmeAsesmenPraAnestesiRiwayatKeluarga',
                'rmeAsesmenPraAnestesiRppRml',
                'rmeAsesmenPraAnestesiKppKs',
                'rmeAsesmenPraAnestesiKuPfLaboratorium',
                'rmeAsesmenPraAnestesiDiagnosisPmRtRo',
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Ganti view ke edit, bukan show
            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-pra-anestesi.show', compact(
                'asesmenPraAnestesi',
                'dataMedis',
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenTerminal;
use App\Models\RmeAsesmenTerminalAf;
use App\Models\RmeAsesmenTerminalFmo;
use App\Models\RmeAsesmenTerminalUsk;
use App\Services\BaseService;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenTerminalController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-terminal.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        DB::beginTransaction();
        try {

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan !');

            // 1. record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 2;
            $asesmen->sub_kategori = 13; // Asesmen Terminal
            $asesmen->save();

            // 2. RmeAsesmen terminal (section 1)
            $asesmenTerminal = new RmeAsesmenTerminal();
            $asesmenTerminal->id_asesmen = $asesmen->id;
            $asesmenTerminal->user_create = Auth::id();
            $asesmenTerminal->tanggal = Carbon::parse($request->tanggal);
            $asesmenTerminal->jam_masuk = $request->jam_masuk;
            // Kegawatan pernafasan
            $asesmenTerminal->dyspnoe = $request->dyspnoe ? 1 : 0;
            $asesmenTerminal->nafas_tak_teratur = $request->nafas_tak_teratur ? 1 : 0;
            $asesmenTerminal->nafas_tak_teratur = $request->nafas_tak_teratur ? 1 : 0;
            $asesmenTerminal->ada_sekret = $request->ada_sekret ? 1 : 0;
            $asesmenTerminal->nafas_cepat_dangkal = $request->nafas_cepat_dangkal ? 1 : 0;
            $asesmenTerminal->nafas_melalui_mulut = $request->nafas_melalui_mulut ? 1 : 0;
            $asesmenTerminal->spo2_normal = $request->spo2_normal ? 1 : 0;
            $asesmenTerminal->nafas_lambat = $request->nafas_lambat ? 1 : 0;
            $asesmenTerminal->mukosa_oral_kering = $request->mukosa_oral_kering ? 1 : 0;
            $asesmenTerminal->tak = $request->tak ? 1 : 0;
            // Kegawatan Tikus otot
            $asesmenTerminal->mual = $request->mual ? 1 : 0;
            $asesmenTerminal->sulit_menelan = $request->sulit_menelan ? 1 : 0;
            $asesmenTerminal->inkontinensia_alvi = $request->inkontinensia_alvi ? 1 : 0;
            $asesmenTerminal->penurunan_pergerakan = $request->penurunan_pergerakan ? 1 : 0;
            $asesmenTerminal->distensi_abdomen = $request->distensi_abdomen ? 1 : 0;
            $asesmenTerminal->tak2 = $request->tak2 ? 1 : 0;
            $asesmenTerminal->sulit_berbicara = $request->sulit_berbicara ? 1 : 0;
            $asesmenTerminal->inkontinensia_urine = $request->inkontinensia_urine ? 1 : 0;
            // Nyeri
            $asesmenTerminal->nyeri = $request->nyeri;
            $asesmenTerminal->nyeri_keterangan = $request->nyeri_keterangan;
            // Perlambatan Sirkulasi
            $asesmenTerminal->bercerak_sianosis = $request->bercerak_sianosis ? 1 : 0;
            $asesmenTerminal->gelisah = $request->gelisah ? 1 : 0;
            $asesmenTerminal->lemas = $request->lemas ? 1 : 0;
            $asesmenTerminal->kulit_dingin = $request->kulit_dingin ? 1 : 0;
            $asesmenTerminal->tekanan_darah = $request->tekanan_darah ? 1 : 0;
            $asesmenTerminal->nadi_lambat = $request->nadi_lambat;
            $asesmenTerminal->tak3 = $request->tak3 ? 1 : 0;
            $asesmenTerminal->save();

            // 3. RmeAsesmen FMO (section 2,3,4)
            $asesmenTerminalFmo = new RmeAsesmenTerminalFmo();
            $asesmenTerminalFmo->id_asesmen = $asesmen->id;
            // section 2
            $asesmenTerminalFmo->melakukan_aktivitas = $request->melakukan_aktivitas ? 1 : 0;
            $asesmenTerminalFmo->pindah_posisi = $request->pindah_posisi ? 1 : 0;
            $asesmenTerminalFmo->faktor_lainnya = $request->faktor_lainnya;
            // section 3
            $asesmenTerminalFmo->masalah_mual = $request->masalah_mual ? 1 : 0;
            $asesmenTerminalFmo->masalah_perubahan_persepsi = $request->masalah_perubahan_persepsi ? 1 : 0;
            $asesmenTerminalFmo->masalah_pola_nafas = $request->masalah_pola_nafas ? 1 : 0;
            $asesmenTerminalFmo->masalah_konstipasi = $request->masalah_konstipasi ? 1 : 0;
            $asesmenTerminalFmo->masalah_bersihan_jalan_nafas = $request->masalah_bersihan_jalan_nafas ? 1 : 0;
            $asesmenTerminalFmo->masalah_defisit_perawatan = $request->masalah_defisit_perawatan ? 1 : 0;
            $asesmenTerminalFmo->masalah_nyeri_akut = $request->masalah_nyeri_akut ? 1 : 0;
            $asesmenTerminalFmo->masalah_nyeri_kronis = $request->masalah_nyeri_kronis ? 1 : 0;
            $asesmenTerminalFmo->masalah_keperawatan_lainnya = $request->masalah_keperawatan_lainnya;
            // section 4
            $asesmenTerminalFmo->perlu_pelayanan_spiritual = $request->perlu_pelayanan_spiritual ? 1 : 0;
            $asesmenTerminalFmo->spiritual_keterangan = $request->spiritual_keterangan;
            $asesmenTerminalFmo->save();

            // 3 RmeAsesmen USK (section 5,6,7)
            $asesmenterminalUsk = new RmeAsesmenTerminalUsk();
            $asesmenterminalUsk->id_asesmen = $asesmen->id;
            // section 5
            $asesmenterminalUsk->perlu_didoakan = $request->perlu_didoakan ? 1 : 0;
            $asesmenterminalUsk->perlu_bimbingan_rohani = $request->perlu_bimbingan_rohani ? 1 : 0;
            $asesmenterminalUsk->perlu_pendampingan_rohani = $request->perlu_pendampingan_rohani ? 1 : 0;
            // section 6
            $asesmenterminalUsk->orang_dihubungi = $request->orang_dihubungi ? 1 : 0;
            $asesmenterminalUsk->nama_dihubungi = $request->nama_dihubungi;
            $asesmenterminalUsk->hubungan_pasien = $request->hubungan_pasien;
            $asesmenterminalUsk->dinama = $request->dinama;
            $asesmenterminalUsk->no_telp_hp = $request->no_telp_hp;
            $asesmenterminalUsk->tetap_dirawat_rs = $request->tetap_dirawat_rs ? 1 : 0;
            $asesmenterminalUsk->dirawat_rumah = $request->dirawat_rumah ? 1 : 0;
            $asesmenterminalUsk->lingkungan_rumah_siap = $request->lingkungan_rumah_siap ? 1 : 0;
            $asesmenterminalUsk->mampu_merawat_rumah = $request->mampu_merawat_rumah ? 1 : 0;
            $asesmenterminalUsk->perawat_rumah_oleh = $request->perawat_rumah_oleh;
            $asesmenterminalUsk->perlu_home_care = $request->perlu_home_care ? 1 : 0;
            $asesmenterminalUsk->reaksi_menyangkal = $request->reaksi_menyangkal;
            $asesmenterminalUsk->reaksi_marah = $request->reaksi_marah ? 1 : 0;
            $asesmenterminalUsk->reaksi_takut = $request->reaksi_takut ? 1 : 0;
            $asesmenterminalUsk->reaksi_sedih_menangis = $request->reaksi_sedih_menangis ? 1 : 0;
            $asesmenterminalUsk->reaksi_rasa_bersalah = $request->reaksi_rasa_bersalah ? 1 : 0;
            $asesmenterminalUsk->reaksi_ketidak_berdayaan = $request->reaksi_ketidak_berdayaan ? 1 : 0;
            $asesmenterminalUsk->reaksi_anxietas = $request->reaksi_anxietas ? 1 : 0;
            $asesmenterminalUsk->reaksi_distress_spiritual = $request->reaksi_distress_spiritual ? 1 : 0;
            $asesmenterminalUsk->keluarga_marah = $request->keluarga_marah ? 1 : 0;
            $asesmenterminalUsk->keluarga_gangguan_tidur = $request->keluarga_gangguan_tidur ? 1 : 0;
            $asesmenterminalUsk->keluarga_penurunan_konsentrasi = $request->keluarga_penurunan_konsentrasi ? 1 : 0;
            $asesmenterminalUsk->keluarga_ketidakmampuan_memenuhi_peran = $request->keluarga_ketidakmampuan_memenuhi_peran ? 1 : 0;
            $asesmenterminalUsk->keluarga_kurang_berkomunikasi = $request->keluarga_kurang_berkomunikasi ? 1 : 0;
            $asesmenterminalUsk->keluarga_leth_lelah = $request->keluarga_leth_lelah ? 1 : 0;
            $asesmenterminalUsk->keluarga_rasa_bersalah = $request->keluarga_rasa_bersalah ? 1 : 0;
            $asesmenterminalUsk->keluarga_perubahan_pola_komunikasi = $request->keluarga_perubahan_pola_komunikasi ? 1 : 0;
            $asesmenterminalUsk->keluarga_kurang_berpartisipasi = $request->keluarga_kurang_berpartisipasi ? 1 : 0;
            $asesmenterminalUsk->masalah_koping_individu_tidak_efektif = $request->masalah_koping_individu_tidak_efektif ? 1 : 0;
            $asesmenterminalUsk->masalah_distress_spiritual = $request->masalah_distress_spiritual ? 1 : 0;
            // section 7
            $asesmenterminalUsk->pasien_perlu_didampingi = $request->pasien_perlu_didampingi ? 1 : 0;
            $asesmenterminalUsk->keluarga_dapat_mengunjungi_luar_waktu = $request->keluarga_dapat_mengunjungi_luar_waktu ? 1 : 0;
            $asesmenterminalUsk->sahabat_dapat_mengunjungi = $request->sahabat_dapat_mengunjungi ? 1 : 0;
            $asesmenterminalUsk->kebutuhan_dukungan_lainnya = $request->kebutuhan_dukungan_lainnya;
            $asesmenterminalUsk->save();

            // 4. RmeAsesmen AF (section 8,9)
            $asesmenTerminalAF = new RmeAsesmenTerminalAf();
            $asesmenTerminalAF->id_asesmen = $asesmen->id;
            // section 8
            $asesmenTerminalAF->alternatif_tidak = $request->alternatif_tidak ? 0 : 1;
            $asesmenTerminalAF->alternatif_autopsi = $request->alternatif_autopsi ? 1 : 0;
            $asesmenTerminalAF->alternatif_donasi_organ = $request->alternatif_donasi_organ ? 1 : 0;
            $asesmenTerminalAF->donasi_organ_detail = $request->donasi_organ_detail;
            $asesmenTerminalAF->alternatif_pelayanan_lainnya = $request->alternatif_pelayanan_lainnya;
            // section 9
            $asesmenTerminalAF->faktor_resiko_marah = $request->faktor_resiko_marah ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_depresi = $request->faktor_resiko_depresi ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_rasa_bersalah = $request->faktor_resiko_rasa_bersalah ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_perubahan_kebiasaan = $request->faktor_resiko_perubahan_kebiasaan ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_tidak_mampu_memenuhi = $request->faktor_resiko_tidak_mampu_memenuhi ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_leth_lelah = $request->faktor_resiko_leth_lelah ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_gangguan_tidur = $request->faktor_resiko_gangguan_tidur ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_sedih_menangis = $request->faktor_resiko_sedih_menangis ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_penurunan_konsentrasi = $request->faktor_resiko_penurunan_konsentrasi ? 1 : 0;
            $asesmenTerminalAF->masalah_koping_keluarga_tidak_efektif = $request->masalah_koping_keluarga_tidak_efektif ? 1 : 0;
            $asesmenTerminalAF->masalah_distress_spiritual_keluarga = $request->masalah_distress_spiritual_keluarga ? 1 : 0;
            $asesmenTerminalAF->save();


            // create resume
            $resumeData = [];
            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();
            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenTerminal',
                'rmeAsesmenTerminalFmo',
                'rmeAsesmenTerminalUsk',
                'rmeAsesmenTerminalAf',
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-terminal.show', compact(
                'asesmen',
                'dataMedis',
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenTerminal',
                'rmeAsesmenTerminalFmo',
                'rmeAsesmenTerminalUsk',
                'rmeAsesmenTerminalAf',
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-terminal.edit', compact(
                'asesmen',
                'dataMedis',
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        DB::beginTransaction();
        try {

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan !');

            // 1. record RmeAsesmen
            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 2;
            $asesmen->sub_kategori = 13; // Asesmen Terminal
            $asesmen->save();

            // 2. RmeAsesmen terminal (section 1)
            $asesmenTerminal = RmeAsesmenTerminal::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenTerminal->id_asesmen = $asesmen->id;
            $asesmenTerminal->user_edit = Auth::id();
            $asesmenTerminal->tanggal = Carbon::parse($request->tanggal);
            $asesmenTerminal->jam_masuk = $request->jam_masuk;
            // Kegawatan pernafasan
            $asesmenTerminal->dyspnoe = $request->dyspnoe ? 1 : 0;
            $asesmenTerminal->nafas_tak_teratur = $request->nafas_tak_teratur ? 1 : 0;
            $asesmenTerminal->nafas_tak_teratur = $request->nafas_tak_teratur ? 1 : 0;
            $asesmenTerminal->ada_sekret = $request->ada_sekret ? 1 : 0;
            $asesmenTerminal->nafas_cepat_dangkal = $request->nafas_cepat_dangkal ? 1 : 0;
            $asesmenTerminal->nafas_melalui_mulut = $request->nafas_melalui_mulut ? 1 : 0;
            $asesmenTerminal->spo2_normal = $request->spo2_normal ? 1 : 0;
            $asesmenTerminal->nafas_lambat = $request->nafas_lambat ? 1 : 0;
            $asesmenTerminal->mukosa_oral_kering = $request->mukosa_oral_kering ? 1 : 0;
            $asesmenTerminal->tak = $request->tak ? 1 : 0;
            // Kegawatan Tikus otot
            $asesmenTerminal->mual = $request->mual ? 1 : 0;
            $asesmenTerminal->sulit_menelan = $request->sulit_menelan ? 1 : 0;
            $asesmenTerminal->inkontinensia_alvi = $request->inkontinensia_alvi ? 1 : 0;
            $asesmenTerminal->penurunan_pergerakan = $request->penurunan_pergerakan ? 1 : 0;
            $asesmenTerminal->distensi_abdomen = $request->distensi_abdomen ? 1 : 0;
            $asesmenTerminal->tak2 = $request->tak2 ? 1 : 0;
            $asesmenTerminal->sulit_berbicara = $request->sulit_berbicara ? 1 : 0;
            $asesmenTerminal->inkontinensia_urine = $request->inkontinensia_urine ? 1 : 0;
            // Nyeri
            $asesmenTerminal->nyeri = $request->nyeri;
            $asesmenTerminal->nyeri_keterangan = $request->nyeri_keterangan;
            // Perlambatan Sirkulasi
            $asesmenTerminal->bercerak_sianosis = $request->bercerak_sianosis ? 1 : 0;
            $asesmenTerminal->gelisah = $request->gelisah ? 1 : 0;
            $asesmenTerminal->lemas = $request->lemas ? 1 : 0;
            $asesmenTerminal->kulit_dingin = $request->kulit_dingin ? 1 : 0;
            $asesmenTerminal->tekanan_darah = $request->tekanan_darah ? 1 : 0;
            $asesmenTerminal->nadi_lambat = $request->nadi_lambat;
            $asesmenTerminal->tak3 = $request->tak3 ? 1 : 0;
            $asesmenTerminal->save();

            // 3. RmeAsesmen FMO (section 2,3,4)
            $asesmenTerminalFmo = RmeAsesmenTerminalFmo::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenTerminalFmo->id_asesmen = $asesmen->id;
            // section 2
            $asesmenTerminalFmo->melakukan_aktivitas = $request->melakukan_aktivitas ? 1 : 0;
            $asesmenTerminalFmo->pindah_posisi = $request->pindah_posisi ? 1 : 0;
            $asesmenTerminalFmo->faktor_lainnya = $request->faktor_lainnya;
            // section 3
            $asesmenTerminalFmo->masalah_mual = $request->masalah_mual ? 1 : 0;
            $asesmenTerminalFmo->masalah_perubahan_persepsi = $request->masalah_perubahan_persepsi ? 1 : 0;
            $asesmenTerminalFmo->masalah_pola_nafas = $request->masalah_pola_nafas ? 1 : 0;
            $asesmenTerminalFmo->masalah_konstipasi = $request->masalah_konstipasi ? 1 : 0;
            $asesmenTerminalFmo->masalah_bersihan_jalan_nafas = $request->masalah_bersihan_jalan_nafas ? 1 : 0;
            $asesmenTerminalFmo->masalah_defisit_perawatan = $request->masalah_defisit_perawatan ? 1 : 0;
            $asesmenTerminalFmo->masalah_nyeri_akut = $request->masalah_nyeri_akut ? 1 : 0;
            $asesmenTerminalFmo->masalah_nyeri_kronis = $request->masalah_nyeri_kronis ? 1 : 0;
            $asesmenTerminalFmo->masalah_keperawatan_lainnya = $request->masalah_keperawatan_lainnya;
            // section 4
            $asesmenTerminalFmo->perlu_pelayanan_spiritual = $request->perlu_pelayanan_spiritual ? 1 : 0;
            $asesmenTerminalFmo->spiritual_keterangan = $request->spiritual_keterangan;
            $asesmenTerminalFmo->save();

            // 3 RmeAsesmen USK (section 5,6,7)
            $asesmenterminalUsk = RmeAsesmenTerminalUsk::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenterminalUsk->id_asesmen = $asesmen->id;
            // section 5
            $asesmenterminalUsk->perlu_didoakan = $request->perlu_didoakan ? 1 : 0;
            $asesmenterminalUsk->perlu_bimbingan_rohani = $request->perlu_bimbingan_rohani ? 1 : 0;
            $asesmenterminalUsk->perlu_pendampingan_rohani = $request->perlu_pendampingan_rohani ? 1 : 0;
            // section 6
            $asesmenterminalUsk->orang_dihubungi = $request->orang_dihubungi ? 1 : 0;
            $asesmenterminalUsk->nama_dihubungi = $request->nama_dihubungi;
            $asesmenterminalUsk->hubungan_pasien = $request->hubungan_pasien;
            $asesmenterminalUsk->dinama = $request->dinama;
            $asesmenterminalUsk->no_telp_hp = $request->no_telp_hp;
            $asesmenterminalUsk->tetap_dirawat_rs = $request->tetap_dirawat_rs ? 1 : 0;
            $asesmenterminalUsk->dirawat_rumah = $request->dirawat_rumah ? 1 : 0;
            $asesmenterminalUsk->lingkungan_rumah_siap = $request->lingkungan_rumah_siap ? 1 : 0;
            $asesmenterminalUsk->mampu_merawat_rumah = $request->mampu_merawat_rumah ? 1 : 0;
            $asesmenterminalUsk->perawat_rumah_oleh = $request->perawat_rumah_oleh;
            $asesmenterminalUsk->perlu_home_care = $request->perlu_home_care ? 1 : 0;
            $asesmenterminalUsk->reaksi_menyangkal = $request->reaksi_menyangkal;
            $asesmenterminalUsk->reaksi_marah = $request->reaksi_marah ? 1 : 0;
            $asesmenterminalUsk->reaksi_takut = $request->reaksi_takut ? 1 : 0;
            $asesmenterminalUsk->reaksi_sedih_menangis = $request->reaksi_sedih_menangis ? 1 : 0;
            $asesmenterminalUsk->reaksi_rasa_bersalah = $request->reaksi_rasa_bersalah ? 1 : 0;
            $asesmenterminalUsk->reaksi_ketidak_berdayaan = $request->reaksi_ketidak_berdayaan ? 1 : 0;
            $asesmenterminalUsk->reaksi_anxietas = $request->reaksi_anxietas ? 1 : 0;
            $asesmenterminalUsk->reaksi_distress_spiritual = $request->reaksi_distress_spiritual ? 1 : 0;
            $asesmenterminalUsk->keluarga_marah = $request->keluarga_marah ? 1 : 0;
            $asesmenterminalUsk->keluarga_gangguan_tidur = $request->keluarga_gangguan_tidur ? 1 : 0;
            $asesmenterminalUsk->keluarga_penurunan_konsentrasi = $request->keluarga_penurunan_konsentrasi ? 1 : 0;
            $asesmenterminalUsk->keluarga_ketidakmampuan_memenuhi_peran = $request->keluarga_ketidakmampuan_memenuhi_peran ? 1 : 0;
            $asesmenterminalUsk->keluarga_kurang_berkomunikasi = $request->keluarga_kurang_berkomunikasi ? 1 : 0;
            $asesmenterminalUsk->keluarga_leth_lelah = $request->keluarga_leth_lelah ? 1 : 0;
            $asesmenterminalUsk->keluarga_rasa_bersalah = $request->keluarga_rasa_bersalah ? 1 : 0;
            $asesmenterminalUsk->keluarga_perubahan_pola_komunikasi = $request->keluarga_perubahan_pola_komunikasi ? 1 : 0;
            $asesmenterminalUsk->keluarga_kurang_berpartisipasi = $request->keluarga_kurang_berpartisipasi ? 1 : 0;
            $asesmenterminalUsk->masalah_koping_individu_tidak_efektif = $request->masalah_koping_individu_tidak_efektif ? 1 : 0;
            $asesmenterminalUsk->masalah_distress_spiritual = $request->masalah_distress_spiritual ? 1 : 0;
            // section 7
            $asesmenterminalUsk->pasien_perlu_didampingi = $request->pasien_perlu_didampingi ? 1 : 0;
            $asesmenterminalUsk->keluarga_dapat_mengunjungi_luar_waktu = $request->keluarga_dapat_mengunjungi_luar_waktu ? 1 : 0;
            $asesmenterminalUsk->sahabat_dapat_mengunjungi = $request->sahabat_dapat_mengunjungi ? 1 : 0;
            $asesmenterminalUsk->kebutuhan_dukungan_lainnya = $request->kebutuhan_dukungan_lainnya;
            $asesmenterminalUsk->save();

            // 4. RmeAsesmen AF (section 8,9)
            $asesmenTerminalAF = RmeAsesmenTerminalAf::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenTerminalAF->id_asesmen = $asesmen->id;
            // section 8
            $asesmenTerminalAF->alternatif_tidak = $request->alternatif_tidak ? 0 : 1;
            $asesmenTerminalAF->alternatif_autopsi = $request->alternatif_autopsi ? 1 : 0;
            $asesmenTerminalAF->alternatif_donasi_organ = $request->alternatif_donasi_organ ? 1 : 0;
            $asesmenTerminalAF->donasi_organ_detail = $request->donasi_organ_detail;
            $asesmenTerminalAF->alternatif_pelayanan_lainnya = $request->alternatif_pelayanan_lainnya;
            // section 9
            $asesmenTerminalAF->faktor_resiko_marah = $request->faktor_resiko_marah ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_depresi = $request->faktor_resiko_depresi ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_rasa_bersalah = $request->faktor_resiko_rasa_bersalah ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_perubahan_kebiasaan = $request->faktor_resiko_perubahan_kebiasaan ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_tidak_mampu_memenuhi = $request->faktor_resiko_tidak_mampu_memenuhi ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_leth_lelah = $request->faktor_resiko_leth_lelah ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_gangguan_tidur = $request->faktor_resiko_gangguan_tidur ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_sedih_menangis = $request->faktor_resiko_sedih_menangis ? 1 : 0;
            $asesmenTerminalAF->faktor_resiko_penurunan_konsentrasi = $request->faktor_resiko_penurunan_konsentrasi ? 1 : 0;
            $asesmenTerminalAF->masalah_koping_keluarga_tidak_efektif = $request->masalah_koping_keluarga_tidak_efektif ? 1 : 0;
            $asesmenTerminalAF->masalah_distress_spiritual_keluarga = $request->masalah_distress_spiritual_keluarga ? 1 : 0;
            $asesmenTerminalAF->save();


            // create resume
            $resumeData = [];
            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();
            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }
}

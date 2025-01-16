<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAsesmen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;
use App\Models\RmeAsesmenKepUmum;
use App\Models\RmeAsesmenKepUmumBreathing;
use App\Models\RmeAsesmenKepUmumCirculation;
use App\Models\RmeAsesmenKepUmumDisability;
use App\Models\RmeAsesmenKepUmumExpo;
use App\Models\RmeAsesmenKepUmumExposure;
use App\Models\RmeAsesmenKepUmumGizi;
use App\Models\RmeAsesmenKepUmumRisikoJatuh;
use App\Models\RmeAsesmenKepUmumSkalaNyeri;
use App\Models\RmeAsesmenKepUmumSosialEkonomi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AsesmenKeperawatanController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
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
            ->where('kunjungan.kd_unit', 3)
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

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.create', compact(
            'kd_pasien',
            'tgl_masuk',
            'dataMedis',
            'user'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk)
    {
        $asesmen = new RmeAsesmen();
        $asesmen->kd_pasien = $kd_pasien;
        $asesmen->kd_unit = 3;
        $asesmen->tgl_masuk = $tgl_masuk;
        $asesmen->urut_masuk = $request->urut_masuk;
        $asesmen->user_id = Auth::id();
        $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
        $asesmen->kategori = 2;
        $asesmen->sub_kategori = 1;
        $asesmen->save();

        $asesmenKepUmum = new RmeAsesmenKepUmum();
        $asesmenKepUmum->id_asesmen = $asesmen->id;
        $asesmenKepUmum->airway_status = $request->airway_status;
        $asesmenKepUmum->airway_suara_nafas = $request->airway_suara_nafas;
        $asesmenKepUmum->airway_diagnosis = $request->airway_diagnosis_type;
        $asesmenKepUmum->airway_tindakan = json_encode($request->airway_tindakan_keperawatan);
        $asesmenKepUmum->psikologis_kondisi = $request->psikologis_kondisi;
        $asesmenKepUmum->psikologis_potensi_menyakiti = $request->psikologis_potensi_menyakiti;
        $asesmenKepUmum->psikologis_lainnya = $request->psikologis_lainnya;
        $asesmenKepUmum->spiritual_agama = $request->spiritual_agama;
        $asesmenKepUmum->spiritual_nilai = $request->spiritual_nilai;
        $asesmenKepUmum->status_fungsional = $request->status_fungsional;
        $asesmenKepUmum->kebutuhan_edukasi_gaya_bicara = $request->kebutuhan_edukasi_gaya_bicara;
        $asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari = $request->kebutuhan_edukasi_bahasa_sehari_hari;
        $asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah = $request->kebutuhan_edukasi_perlu_penerjemah;
        $asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi = $request->kebutuhan_edukasi_hambatan_komunikasi;
        $asesmenKepUmum->kebutuhan_edukasi_media_belajar = $request->kebutuhan_edukasi_media_belajar;
        $asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan = $request->kebutuhan_edukasi_tingkat_pendidikan;
        $asesmenKepUmum->kebutuhan_edukasi_edukasi_dibutuhkan = $request->kebutuhan_edukasi_edukasi_dibutuhkan;
        $asesmenKepUmum->kebutuhan_edukasi_keterangan_lain = $request->kebutuhan_edukasi_keterangan_lain;
        $asesmenKepUmum->discharge_planning_diagnosis_medis = $request->discharge_planning_diagnosis_medis;
        $asesmenKepUmum->discharge_planning_usia_lanjut = $request->discharge_planning_usia_lanjut;
        $asesmenKepUmum->discharge_planning_hambatan_mobilisasi = $request->discharge_planning_hambatan_mobilisasi;
        $asesmenKepUmum->discharge_planning_pelayanan_medis = $request->discharge_planning_pelayanan_medis;
        $asesmenKepUmum->discharge_planning_ketergantungan_aktivitas = $request->discharge_planning_ketergantungan_aktivitas;
        $asesmenKepUmum->discharge_planning_kesimpulan = $request->discharge_planning_kesimpulan;
        $asesmenKepUmum->save();

        $asesmenKepUmumBreathing = new RmeAsesmenKepUmumBreathing();
        $asesmenKepUmumBreathing->id_asesmen = $asesmen->id;
        $asesmenKepUmumBreathing->breathing_frekuensi_nafas = $request->breathing_frekuensi_nafas;
        $asesmenKepUmumBreathing->breathing_pola_nafas = $request->breathing_pola_nafas;
        $asesmenKepUmumBreathing->breathing_bunyi_nafas = $request->breathing_bunyi_nafas;
        $asesmenKepUmumBreathing->breathing_irama_nafas = (int)$request->breathing_irama_nafas;
        $asesmenKepUmumBreathing->breathing_tanda_distress = $request->breathing_tanda_distress;
        $asesmenKepUmumBreathing->breathing_jalan_nafas = (int)$request->breathing_jalan_nafas;
        $asesmenKepUmumBreathing->breathing_lainnya = $request->breathing_lainnya;
        $asesmenKepUmumBreathing->breathing_tindakan = json_encode($request->breathing_tindakan_keperawatan);

        // Untuk breathing_diagnosis_nafas
        $nafasValue = 1;
        $diagnosisNafas = $request->input('breathing_diagnosis_nafas', []);
        if (is_array($diagnosisNafas) && !empty($diagnosisNafas)) {
            $nafasValue = max(array_values($diagnosisNafas));
        }
        $asesmenKepUmumBreathing->breathing_diagnosis_nafas = (int)$nafasValue;

        // Untuk breathing_gangguan
        $gangguanValue = 1;
        $breathing_gangguan = $request->input('breathing_gangguan', []);
        if (is_array($breathing_gangguan) && !empty($breathing_gangguan)) {
            $gangguanValue = max(array_values($breathing_gangguan));
        }
        $asesmenKepUmumBreathing->breathing_gangguan = (int)$gangguanValue;

        $asesmenKepUmumBreathing->save();


        return redirect()->route('asesmen-keperawatan.index', [
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk
        ])->with(['success' => 'created successfully']);
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\SatsetPrognosis;
use App\Models\RmeAsesmenMedisRanap;
use App\Models\RmeAsesmenMedisRanapFisik;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AsesmenPengkajianAwalMedis extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    private function getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien')
                    ->on('kunjungan.kd_unit', '=', 't.kd_unit')
                    ->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi')
                    ->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } elseif ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return $dataMedis;
    }

    private function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return Transaksi::select('kd_kasir', 'no_transaksi')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_transaksi', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();
    }

    private function getMasterData($kd_pasien)
    {
        return [
            'rmeMasterDiagnosis' => RmeMasterDiagnosis::all(),
            'rmeMasterImplementasi' => RmeMasterImplementasi::all(),
            'satsetPrognosis' => SatsetPrognosis::all(),
            'alergiPasien' => RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get()
        ];
    }

    private function saveDiagnosisToMaster($diagnosisList)
    {
        foreach ($diagnosisList as $diagnosa) {
            if (!empty($diagnosa)) {
                RmeMasterDiagnosis::firstOrCreate(['nama_diagnosis' => $diagnosa]);
            }
        }
    }
    private function saveImplementasiToMaster($dataList, $column)
    {
        foreach ($dataList as $item) {
            if (!empty($item)) {
                RmeMasterImplementasi::firstOrCreate([$column => $item]);
            }
        }
    }

    private function handleAlergiData($request, $kd_pasien)
    {
        $alergiData = json_decode($request->alergis, true);

        if (!empty($alergiData)) {
            RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

            foreach ($alergiData as $alergi) {
                if (!empty($alergi['jenis_alergi']) || !empty($alergi['alergen'])) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }
        }
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.create',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
            ], $masterData)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kd_pasien' => 'required',
            'kd_unit' => 'required',
            'tgl_masuk' => 'required|date',
            'urut_masuk' => 'required',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'keluhan_utama' => 'nullable|string',
            'sistole' => 'nullable|numeric',
            'diastole' => 'nullable|numeric',
            'respirasi' => 'nullable|numeric',
            'suhu' => 'nullable|numeric',
            'nadi' => 'nullable|numeric',
            'skala_nyeri' => 'nullable|numeric|min:0|max:10',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = $this->getTransaksiData(
                $request->kd_unit,
                $request->kd_pasien,
                $request->tgl_masuk,
                $request->urut_masuk
            );

            if (!$transaksi) {
                throw new \Exception('Data transaksi tidak ditemukan');
            }

            // 1. Buat record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = now();
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            // 2. Buat record RmeAsesmenMedisRanap dengan id_asesmen
            $asesmenMedis = RmeAsesmenMedisRanap::create([
                'id_asesmen' => $asesmen->id,
                'kd_kasir' => $transaksi->kd_kasir,
                'no_transaksi' => $transaksi->no_transaksi,
                'kd_pasien' => $request->kd_pasien,
                'kd_unit' => $request->kd_unit,
                'tgl_masuk' => $request->tgl_masuk,
                'urut_masuk' => $request->urut_masuk,
                'user_create' => Auth::id(),
                'user_edit' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam_masuk,
                'keluhan_utama' => $request->keluhan_utama,
                'riwayat_penyakit_sekarang' => $request->riwayat_penyakit_sekarang,
                'riwayat_penyakit_terdahulu' => $request->riwayat_penyakit_terdahulu,
                'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga,
                'riwayat_penggunaan_obat' => $request->riwayat_penggunaan_obat,
                'sistole' => $request->sistole,
                'diastole' => $request->diastole,
                'respirasi' => $request->respirasi,
                'suhu' => $request->suhu,
                'nadi' => $request->nadi,
                'skala_nyeri_nilai' => $request->skala_nyeri,
                'paru_prognosis' => $request->paru_prognosis,
                'diagnosis_banding' => $request->diagnosis_banding,
                'diagnosis_kerja' => $request->diagnosis_kerja,
                'rencana_pengobatan' => $request->rencana_pengobatan,
                'diagnosis_medis' => $request->diagnosis_medis,
                'usia_lanjut' => $request->usia_lanjut,
                'hambatan_mobilisasi' => $request->hambatan_mobilisasi,
                'penggunaan_media_berkelanjutan' => $request->penggunaan_media_berkelanjutan,
                'ketergantungan_aktivitas' => $request->ketergantungan_aktivitas,
                'rencana_pulang_khusus' => $request->rencana_pulang_khusus,
                'rencana_lama_perawatan' => $request->rencana_lama_perawatan,
                'rencana_tgl_pulang' => $request->rencana_tgl_pulang,
                'kesimpulan_planing' => $request->kesimpulan_planing,
                'alergis' => $request->alergis,
            ]);

            // 3. Buat record pemeriksaan fisik
            RmeAsesmenMedisRanapFisik::create([
                'id_asesmen' => $asesmen->id,
                'pengkajian_kepala' => $request->pengkajian_kepala ?? 1,
                'pengkajian_kepala_keterangan' => $request->pengkajian_kepala_keterangan,
                'pengkajian_mata' => $request->pengkajian_mata ?? 1,
                'pengkajian_mata_keterangan' => $request->pengkajian_mata_keterangan,
                'pengkajian_tht' => $request->pengkajian_tht ?? 1,
                'pengkajian_tht_keterangan' => $request->pengkajian_tht_keterangan,
                'pengkajian_leher' => $request->pengkajian_leher ?? 1,
                'pengkajian_leher_keterangan' => $request->pengkajian_leher_keterangan,
                'pengkajian_mulut' => $request->pengkajian_mulut ?? 1,
                'pengkajian_mulut_keterangan' => $request->pengkajian_mulut_keterangan,
                'pengkajian_jantung' => $request->pengkajian_jantung ?? 1,
                'pengkajian_jantung_keterangan' => $request->pengkajian_jantung_keterangan,
                'pengkajian_thorax' => $request->pengkajian_thorax ?? 1,
                'pengkajian_thorax_keterangan' => $request->pengkajian_thorax_keterangan,
                'pengkajian_abdomen' => $request->pengkajian_abdomen ?? 1,
                'pengkajian_abdomen_keterangan' => $request->pengkajian_abdomen_keterangan,
                'pengkajian_tulang_belakang' => $request->pengkajian_tulang_belakang ?? 1,
                'pengkajian_tulang_belakang_keterangan' => $request->pengkajian_tulang_belakang_keterangan,
                'pengkajian_sistem_syaraf' => $request->pengkajian_sistem_syaraf ?? 1,
                'pengkajian_sistem_syaraf_keterangan' => $request->pengkajian_sistem_syaraf_keterangan,
                'pengkajian_genetalia' => $request->pengkajian_genetalia ?? 1,
                'pengkajian_genetalia_keterangan' => $request->pengkajian_genetalia_keterangan,
                'pengkajian_status_lokasi' => $request->pengkajian_status_lokasi ?? 1,
                'pengkajian_status_lokasi_keterangan' => $request->pengkajian_status_lokasi_keterangan,
            ]);

            // 4. Handle data alergi
            $this->handleAlergiData($request, $request->kd_pasien);

            // 5. Simpan diagnosis dan implementasi ke master
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true);
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true);
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);
            $this->saveDiagnosisToMaster($allDiagnoses);

            // Simpan implementasi
            $implementasiData = [
                'prognosis' => json_decode($request->prognosis ?? '[]', true),
                'observasi' => json_decode($request->observasi ?? '[]', true),
                'terapeutik' => json_decode($request->terapeutik ?? '[]', true),
                'edukasi' => json_decode($request->edukasi ?? '[]', true),
                'kolaborasi' => json_decode($request->kolaborasi ?? '[]', true),
            ];

            foreach ($implementasiData as $column => $dataList) {
                $this->saveImplementasiToMaster($dataList, $column);
            }

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $request->kd_unit,
                'kd_pasien' => $request->kd_pasien,
                'tgl_masuk' => $request->tgl_masuk,
                'urut_masuk' => $request->urut_masuk,
                'id' => $asesmenMedis->id
            ])->with('success', 'Asesmen pengkajian awal medis berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Load data utama dengan relationships
            $asesmen = RmeAsesmen::with([
                'asesmenMedisRanap',
                'asesmenMedisRanapFisik',
            ])->findOrFail($id);

        } catch (\Exception $e) {
            $asesmen = RmeAsesmen::findOrFail($id);
        }

        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.edit',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
                'asesmen' => $asesmen,
                'readonly' => true
            ], $masterData)
        );
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Load data utama dengan relationships
            $asesmen = RmeAsesmen::with([
                'asesmenMedisRanap',
                'asesmenMedisRanapFisik',
            ])->findOrFail($id);

        } catch (\Exception $e) {
            $asesmen = RmeAsesmen::findOrFail($id);
        }

        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.edit',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
                'asesmen' => $asesmen,
                'readonly' => false
            ], $masterData)
        );
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'keluhan_utama' => 'nullable|string',
            'sistole' => 'nullable|numeric',
            'diastole' => 'nullable|numeric',
            'respirasi' => 'nullable|numeric',
            'suhu' => 'nullable|numeric',
            'nadi' => 'nullable|numeric',
            'skala_nyeri' => 'nullable|numeric|min:0|max:10',
        ]);


        DB::beginTransaction();
        try {
            $tanggal = \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d');
            $jam = \Carbon\Carbon::createFromFormat('H:i', $request->jam_masuk)->format('H:i:s');

            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = now();
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            // Update main assessment record
            $asesmen->asesmenMedisRanap()->updateOrCreate(
            ['id_asesmen' => $asesmen->id],
            [
                    'user_edit' => Auth::id(),
                    'tanggal' => $tanggal,
                    'jam' => $jam,
                    'keluhan_utama' => $request->keluhan_utama,
                    'riwayat_penyakit_sekarang' => $request->riwayat_penyakit_sekarang,
                    'riwayat_penyakit_terdahulu' => $request->riwayat_penyakit_terdahulu,
                    'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga,
                    'riwayat_penggunaan_obat' => $request->riwayat_penggunaan_obat,
                    'sistole' => $request->sistole,
                    'diastole' => $request->diastole,
                    'respirasi' => $request->respirasi,
                    'suhu' => $request->suhu,
                    'nadi' => $request->nadi,
                    'skala_nyeri_nilai' => $request->skala_nyeri,
                    'paru_prognosis' => $request->paru_prognosis,
                    'diagnosis_banding' => $request->diagnosis_banding,
                    'diagnosis_kerja' => $request->diagnosis_kerja,
                    'rencana_pengobatan' => $request->rencana_pengobatan,
                    'diagnosis_medis' => $request->diagnosis_medis,
                    'usia_lanjut' => $request->usia_lanjut,
                    'hambatan_mobilisasi' => $request->hambatan_mobilisasi,
                    'penggunaan_media_berkelanjutan' => $request->penggunaan_media_berkelanjutan,
                    'ketergantungan_aktivitas' => $request->ketergantungan_aktivitas,
                    'rencana_pulang_khusus' => $request->rencana_pulang_khusus,
                    'rencana_lama_perawatan' => $request->rencana_lama_perawatan,
                    'rencana_tgl_pulang' => $request->rencana_tgl_pulang,
                    'kesimpulan_planing' => $request->kesimpulan_planing,
                    'alergis' => $request->alergis,
            ]);

            $foreignKeyColumn = 'id_asesmen_medis_ranap';

            // Update or create physical examination record
            $asesmen->asesmenMedisRanapFisik()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'pengkajian_kepala' => $request->pengkajian_kepala ?? 1,
                    'pengkajian_kepala_keterangan' => $request->pengkajian_kepala_keterangan,
                    'pengkajian_mata' => $request->pengkajian_mata ?? 1,
                    'pengkajian_mata_keterangan' => $request->pengkajian_mata_keterangan,
                    'pengkajian_tht' => $request->pengkajian_tht ?? 1,
                    'pengkajian_tht_keterangan' => $request->pengkajian_tht_keterangan,
                    'pengkajian_leher' => $request->pengkajian_leher ?? 1,
                    'pengkajian_leher_keterangan' => $request->pengkajian_leher_keterangan,
                    'pengkajian_mulut' => $request->pengkajian_mulut ?? 1,
                    'pengkajian_mulut_keterangan' => $request->pengkajian_mulut_keterangan,
                    'pengkajian_jantung' => $request->pengkajian_jantung ?? 1,
                    'pengkajian_jantung_keterangan' => $request->pengkajian_jantung_keterangan,
                    'pengkajian_thorax' => $request->pengkajian_thorax ?? 1,
                    'pengkajian_thorax_keterangan' => $request->pengkajian_thorax_keterangan,
                    'pengkajian_abdomen' => $request->pengkajian_abdomen ?? 1,
                    'pengkajian_abdomen_keterangan' => $request->pengkajian_abdomen_keterangan,
                    'pengkajian_tulang_belakang' => $request->pengkajian_tulang_belakang ?? 1,
                    'pengkajian_tulang_belakang_keterangan' => $request->pengkajian_tulang_belakang_keterangan,
                    'pengkajian_sistem_syaraf' => $request->pengkajian_sistem_syaraf ?? 1,
                    'pengkajian_sistem_syaraf_keterangan' => $request->pengkajian_sistem_syaraf_keterangan,
                    'pengkajian_genetalia' => $request->pengkajian_genetalia ?? 1,
                    'pengkajian_genetalia_keterangan' => $request->pengkajian_genetalia_keterangan,
                    'pengkajian_status_lokasi' => $request->pengkajian_status_lokasi ?? 1,
                    'pengkajian_status_lokasi_keterangan' => $request->pengkajian_status_lokasi_keterangan,
                ]
            );

            // Handle data alergi
            $this->handleAlergiData($request, $kd_pasien);

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('success', 'Asesmen pengkajian awal medis berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $asesmenMedis = RmeAsesmenMedisRanap::findOrFail($id);

        DB::beginTransaction();
        try {
            RmeAsesmenMedisRanapFisik::where('asesmen_medis_ranap', $asesmenMedis->id)->delete();

            $asesmenMedis->delete();

            if ($asesmenMedis->id_asesmen) {
                RmeAsesmen::where('id', $asesmenMedis->id_asesmen)->delete();
            }

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Asesmen pengkajian awal medis berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}

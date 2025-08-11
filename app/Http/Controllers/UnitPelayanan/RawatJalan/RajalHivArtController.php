<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeHivArt;
use App\Models\RmeHivArtAkhiriFollowUp;
use App\Models\RmeHivArtDataPemeriksaanKlinis;
use App\Models\RmeHivArtTerapiAntiretroviral;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RajalHivArtController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    private function getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
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

    /**
     * **FUNGSI UTAMA: Format JSON yang bersih tanpa escape characters**
     * Hasil: ["jangkauan"] bukan [\"jangkauan\"]
     */
    private function formatCleanJson($data)
    {
        if (empty($data)) {
            return null;
        }

        if (is_array($data)) {
            // Filter data yang tidak kosong
            $cleanData = array_filter($data, function ($item) {
                return !empty($item) && $item !== null && $item !== '';
            });

            if (empty($cleanData)) {
                return null;
            }

            // **FORMAT JSON BERSIH tanpa escape characters**
            return json_encode(array_values($cleanData), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $this->formatCleanJson($decoded);
            }

            // Jika string biasa, buat array
            return json_encode([$data], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return null;
    }

    // ===== CRUD METHODS =====

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Get existing HIV ART records
        $hivArtRecords = RmeHivArt::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->with(['dataPemeriksaanKlinis', 'terapiAntiretroviral'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        // Get existing HIV ART follow-up data
        $hivArtData = RmeHivArtAkhiriFollowUp::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        // Handle tabs
        $activeTab = $request->query('tab', 'ikhtisar');
        $allowedTabs = ['ikhtisar', 'followUp'];
        if (!in_array($activeTab, $allowedTabs)) {
            $activeTab = 'ikhtisar';
        }

        if ($activeTab == 'ikhtisar') {
            return $this->ikhtisarTab($dataMedis, $activeTab, $hivArtRecords, $alergiPasien);
        } else {
            return $this->followUpTab($dataMedis, $activeTab, $hivArtData);
        }
    }

    private function ikhtisarTab($dataMedis, $activeTab, $hivArtRecords, $alergiPasien)
    {
        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.index', compact(
            'dataMedis',
            'activeTab',
            'hivArtRecords',
            'alergiPasien'
        ));
    }

    private function followUpTab($dataMedis, $activeTab, $hivArtData)
    {
        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art_akhiri_follow_up.index', compact(
            'dataMedis',
            'activeTab',
            'hivArtData'
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.create', compact('dataMedis', 'alergiPasien'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'jam' => 'required',
            'no_reg_nas' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:20',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'alamat_telp' => 'nullable|string',
            'no_telp_pasien' => 'nullable|string',
            'pmo' => 'nullable|string|max:255',
            'hubungan_pasien' => 'nullable|string|max:255',
            'alamat_no_telp_pmo' => 'nullable|string|max:255',
            'no_telp_pmo' => 'nullable|string|max:255',
            'tgl_tes_hiv' => 'nullable|date',
            'tempat_tes_hiv' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'data_keluarga' => 'nullable|string',
            'menerima_art' => 'nullable|string|max:255',
            'jenis_art' => 'nullable|string|max:255',
            'tempat_art' => 'nullable|string|max:255',
            'nama_dosis_arv' => 'nullable|string',
            // **PERBAIKAN: Tambahkan validasi untuk field yang hilang**
            'rujukan_keterangan' => 'nullable|string',
            'jangkauan_keterangan' => 'nullable|string',
            'lainnya_kia_keterangan' => 'nullable|string',
            'tgl_mulai_terapi_tb' => 'nullable|date',
            'tgl_selesai_terapi_tb' => 'nullable|date',
            'indikasi_inisiasi_art' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // **Format JSON yang bersih**
            $kiaDetails = $this->formatCleanJson($request->kia_details);
            $faktorRisiko = $this->formatCleanJson($request->faktor_risiko);

            // Create main HIV ART record
            $hivArt = RmeHivArt::create([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'no_reg_nas' => $request->no_reg_nas,
                'nik' => $request->nik,
                'nama_ibu_kandung' => $request->nama_ibu_kandung,
                'alamat_telp' => $request->alamat_telp,
                'no_telp_pasien' => $request->no_telp_pasien,
                'pmo' => $request->pmo,
                'hubungan_pasien' => $request->hubungan_pasien,
                'alamat_no_telp_pmo' => $request->alamat_no_telp_pmo,
                'no_telp_pmo' => $request->no_telp_pmo,
                'tgl_tes_hiv' => $request->tgl_tes_hiv,
                'tempat_tes_hiv' => $request->tempat_tes_hiv,

                // **PERBAIKAN: Pastikan field yang hilang masuk ke database**
                'kia_details' => $kiaDetails,
                'rujukan_keterangan' => $request->rujukan_keterangan,
                'jangkauan_keterangan' => $request->jangkauan_keterangan,
                'lainnya_kia_keterangan' => $request->lainnya_kia_keterangan,

                'pendidikan' => $request->pendidikan,
                'pekerjaan' => $request->pekerjaan,
                'faktor_risiko' => $faktorRisiko,
                'lain_lainnya_keterangan' => $request->lain_lainnya_keterangan,
                'status_pernikahan' => $request->status_pernikahan,
                'data_keluarga' => $request->data_keluarga,
                'menerima_art' => $request->menerima_art,
                'jenis_art' => $request->jenis_art,
                'tempat_art' => $request->tempat_art,
                'nama_dosis_arv' => $request->nama_dosis_arv,

                // **PERBAIKAN: Data TB masuk ke tabel utama**
                'tgl_mulai_terapi_tb' => $request->tgl_mulai_terapi_tb,
                'tgl_selesai_terapi_tb' => $request->tgl_selesai_terapi_tb,
                'klasifikasi_tb' => $request->klasifikasi_tb,
                'lokasi_tb_ekstra' => $request->lokasi_tb_ekstra,
                'paduan_tb' => $request->paduan_tb,
                'tipe_tb' => $request->tipe_tb,
                'kabupaten_tb' => $request->kabupaten_tb,
                'nama_sarana_kesehatan' => $request->nama_sarana_kesehatan,
                'no_reg_tb' => $request->no_reg_tb,
                'indikasi_inisiasi_art' => $request->indikasi_inisiasi_art,
            ]);

            // Create Data Pemeriksaan Klinis record
            $this->storePemeriksaanKlinis($request, $hivArt->id);

            // Create Terapi Antiretroviral records
            $this->storeTerapiAntiretroviral($request, $hivArt->id);

            // Validasi data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    // Skip data yang sudah ada di database (is_existing = true)
                    // kecuali jika ingin update
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('rawat-jalan.hiv_art.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data HIV ART berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        $hivArt = RmeHivArt::with(['dataPemeriksaanKlinis', 'terapiAntiretroviral', 'rmeAlergiPasien'])
            ->findOrFail($id);

        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.show', compact(
            'dataMedis',
            'hivArt',
            'alergiPasien'
        ));
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        $hivArt = RmeHivArt::with(['dataPemeriksaanKlinis', 'terapiAntiretroviral', 'rmeAlergiPasien'])
            ->findOrFail($id);

        return view('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.edit', compact(
            'dataMedis',
            'hivArt',
            'alergiPasien'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'jam' => 'required',
            'no_reg_nas' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:20',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'alamat_telp' => 'nullable|string',
            'no_telp_pasien' => 'nullable|string',
            'pmo' => 'nullable|string|max:255',
            'hubungan_pasien' => 'nullable|string|max:255',
            'alamat_no_telp_pmo' => 'nullable|string|max:255',
            'no_telp_pmo' => 'nullable|string|max:255',
            'tgl_tes_hiv' => 'nullable|date',
            'tempat_tes_hiv' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'data_keluarga' => 'nullable|string',
            'menerima_art' => 'nullable|string|max:255',
            'jenis_art' => 'nullable|string|max:255',
            'tempat_art' => 'nullable|string|max:255',
            'nama_dosis_arv' => 'nullable|string',
            // **PERBAIKAN: Tambahkan validasi untuk field yang hilang**
            'rujukan_keterangan' => 'nullable|string',
            'jangkauan_keterangan' => 'nullable|string',
            'lainnya_kia_keterangan' => 'nullable|string',
            'tgl_mulai_terapi_tb' => 'nullable|date',
            'tgl_selesai_terapi_tb' => 'nullable|date',
            'indikasi_inisiasi_art' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $hivArt = RmeHivArt::findOrFail($id);

            // **Format JSON yang bersih**
            $kiaDetails = $this->formatCleanJson($request->kia_details);
            $faktorRisiko = $this->formatCleanJson($request->faktor_risiko);

            // Update main record
            $hivArt->update([
                'user_edit' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'no_reg_nas' => $request->no_reg_nas,
                'nik' => $request->nik,
                'nama_ibu_kandung' => $request->nama_ibu_kandung,
                'alamat_telp' => $request->alamat_telp,
                'no_telp_pasien' => $request->no_telp_pasien,
                'pmo' => $request->pmo,
                'hubungan_pasien' => $request->hubungan_pasien,
                'alamat_no_telp_pmo' => $request->alamat_no_telp_pmo,
                'no_telp_pmo' => $request->no_telp_pmo,
                'tgl_tes_hiv' => $request->tgl_tes_hiv,
                'tempat_tes_hiv' => $request->tempat_tes_hiv,

                // **PERBAIKAN: Pastikan field yang hilang di-update**
                'kia_details' => $kiaDetails,
                'rujukan_keterangan' => $request->rujukan_keterangan,
                'jangkauan_keterangan' => $request->jangkauan_keterangan,
                'lainnya_kia_keterangan' => $request->lainnya_kia_keterangan,

                'pendidikan' => $request->pendidikan,
                'pekerjaan' => $request->pekerjaan,
                'faktor_risiko' => $faktorRisiko,
                'lain_lainnya_keterangan' => $request->lain_lainnya_keterangan,
                'status_pernikahan' => $request->status_pernikahan,
                'data_keluarga' => $request->data_keluarga,
                'menerima_art' => $request->menerima_art,
                'jenis_art' => $request->jenis_art,
                'tempat_art' => $request->tempat_art,
                'nama_dosis_arv' => $request->nama_dosis_arv,

                // **PERBAIKAN: Data TB di-update**
                'tgl_mulai_terapi_tb' => $request->tgl_mulai_terapi_tb,
                'tgl_selesai_terapi_tb' => $request->tgl_selesai_terapi_tb,
                'klasifikasi_tb' => $request->klasifikasi_tb,
                'lokasi_tb_ekstra' => $request->lokasi_tb_ekstra,
                'paduan_tb' => $request->paduan_tb,
                'tipe_tb' => $request->tipe_tb,
                'kabupaten_tb' => $request->kabupaten_tb,
                'nama_sarana_kesehatan' => $request->nama_sarana_kesehatan,
                'no_reg_tb' => $request->no_reg_tb,
                'indikasi_inisiasi_art' => $request->indikasi_inisiasi_art,
            ]);

            // Update related records
            $this->updatePemeriksaanKlinis($request, $hivArt->id);
            $this->updateTerapiAntiretroviral($request, $hivArt->id);

            // Update data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            } else {
                // Jika tidak ada data alergi baru, hapus yang lama
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();
            }

            DB::commit();

            return redirect()->route('rawat-jalan.hiv_art.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data HIV ART berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $hivArt = RmeHivArt::findOrFail($id);

            // Delete related records
            RmeHivArtDataPemeriksaanKlinis::where('id_hiv_art', $id)->delete();
            RmeHivArtTerapiAntiretroviral::where('id_hiv_art', $id)->delete();

            // Delete main record
            $hivArt->delete();

            DB::commit();

            return redirect()->route('rawat-jalan.hiv_art.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data HIV ART berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    // ===== HELPER METHODS FOR CRUD =====

    private function storePemeriksaanKlinis($request, $hivArtId)
    {
        $pemeriksaanData = [
            'id_hiv_art' => $hivArtId,

            // Kunjungan Pertama
            'kunjungan_pertama_tanggal' => $request->kunjungan_pertama_tanggal,
            'kunjungan_pertama_klinis' => $request->kunjungan_pertama_klinis,
            'kunjungan_pertama_bb' => $request->kunjungan_pertama_bb,
            'kunjungan_pertama_status_fungsional' => $request->kunjungan_pertama_status_fungsional,
            'kunjungan_pertama_cd4' => $request->kunjungan_pertama_cd4,
            'kunjungan_pertama_lain' => $request->kunjungan_pertama_lain,

            // Memenuhi Syarat
            'memenuhi_syarat_tanggal' => $request->memenuhi_syarat_tanggal,
            'memenuhi_syarat_klinis' => $request->memenuhi_syarat_klinis,
            'memenuhi_syarat_bb' => $request->memenuhi_syarat_bb,
            'memenuhi_syarat_status_fungsional' => $request->memenuhi_syarat_status_fungsional,
            'memenuhi_syarat_cd4' => $request->memenuhi_syarat_cd4,
            'memenuhi_syarat_lain' => $request->memenuhi_syarat_lain,

            // Saat Mulai ART
            'saat_mulai_art_tanggal' => $request->saat_mulai_art_tanggal,
            'saat_mulai_art_klinis' => $request->saat_mulai_art_klinis,
            'saat_mulai_art_bb' => $request->saat_mulai_art_bb,
            'saat_mulai_art_status_fungsional' => $request->saat_mulai_art_status_fungsional,
            'saat_mulai_art_cd4' => $request->saat_mulai_art_cd4,
            'saat_mulai_art_lain' => $request->saat_mulai_art_lain,

            // 6 Bulan
            'setelah_6_bulan_tanggal' => $request->setelah_6_bulan_tanggal,
            'setelah_6_bulan_klinis' => $request->setelah_6_bulan_klinis,
            'setelah_6_bulan_bb' => $request->setelah_6_bulan_bb,
            'setelah_6_bulan_status_fungsional' => $request->setelah_6_bulan_status_fungsional,
            'setelah_6_bulan_cd4' => $request->setelah_6_bulan_cd4,
            'setelah_6_bulan_lain' => $request->setelah_6_bulan_lain,

            // 12 Bulan
            'setelah_12_bulan_tanggal' => $request->setelah_12_bulan_tanggal,
            'setelah_12_bulan_klinis' => $request->setelah_12_bulan_klinis,
            'setelah_12_bulan_bb' => $request->setelah_12_bulan_bb,
            'setelah_12_bulan_status_fungsional' => $request->setelah_12_bulan_status_fungsional,
            'setelah_12_bulan_cd4' => $request->setelah_12_bulan_cd4,
            'setelah_12_bulan_lain' => $request->setelah_12_bulan_lain,

            // 24 Bulan
            'setelah_24_bulan_tanggal' => $request->setelah_24_bulan_tanggal,
            'setelah_24_bulan_klinis' => $request->setelah_24_bulan_klinis,
            'setelah_24_bulan_bb' => $request->setelah_24_bulan_bb,
            'setelah_24_bulan_status_fungsional' => $request->setelah_24_bulan_status_fungsional,
            'setelah_24_bulan_cd4' => $request->setelah_24_bulan_cd4,
            'setelah_24_bulan_lain' => $request->setelah_24_bulan_lain,
        ];

        RmeHivArtDataPemeriksaanKlinis::create($pemeriksaanData);
    }

    private function storeTerapiAntiretroviral($request, $hivArtId)
    {
        // Proses data terapi ART dengan format JSON yang bersih
        $artDataRaw = $request->data_terapi_art;
        $artData = [];

        if (!empty($artDataRaw)) {
            $decodedData = json_decode($artDataRaw, true);
            if (is_array($decodedData) && !empty($decodedData)) {
                $artData = $decodedData;
            }
        }

        // Jika tidak ada data ART, buat satu record default
        if (empty($artData)) {
            $artData = [[]];
        }

        // Format JSON yang bersih untuk data ART
        $cleanArtData = !empty($artData) ? json_encode($artData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;

        // Simpan sebagai satu record
        RmeHivArtTerapiAntiretroviral::create([
            'id_hiv_art' => $hivArtId,
            'data_terapi_art' => $cleanArtData,
            'tgl_mulai_terapi_tb' => $request->tgl_mulai_terapi_tb,
            'tgl_selesai_terapi_tb' => $request->tgl_selesai_terapi_tb,
            'klasifikasi_tb' => $request->klasifikasi_tb,
            'lokasi_tb_ekstra' => $request->lokasi_tb_ekstra,
            'paduan_tb' => $request->paduan_tb,
            'tipe_tb' => $request->tipe_tb,
            'kabupaten_tb' => $request->kabupaten_tb,
            'nama_sarana_kesehatan' => $request->nama_sarana_kesehatan,
            'no_reg_tb' => $request->no_reg_tb,
            'indikasi_inisiasi_art' => $request->indikasi_inisiasi_art,
        ]);
    }

    private function updatePemeriksaanKlinis($request, $hivArtId)
    {
        $pemeriksaan = RmeHivArtDataPemeriksaanKlinis::where('id_hiv_art', $hivArtId)->first();

        $data = [
            // Kunjungan Pertama
            'kunjungan_pertama_tanggal' => $request->kunjungan_pertama_tanggal,
            'kunjungan_pertama_klinis' => $request->kunjungan_pertama_klinis,
            'kunjungan_pertama_bb' => $request->kunjungan_pertama_bb,
            'kunjungan_pertama_status_fungsional' => $request->kunjungan_pertama_status_fungsional,
            'kunjungan_pertama_cd4' => $request->kunjungan_pertama_cd4,
            'kunjungan_pertama_lain' => $request->kunjungan_pertama_lain,

            // Memenuhi Syarat
            'memenuhi_syarat_tanggal' => $request->memenuhi_syarat_tanggal,
            'memenuhi_syarat_klinis' => $request->memenuhi_syarat_klinis,
            'memenuhi_syarat_bb' => $request->memenuhi_syarat_bb,
            'memenuhi_syarat_status_fungsional' => $request->memenuhi_syarat_status_fungsional,
            'memenuhi_syarat_cd4' => $request->memenuhi_syarat_cd4,
            'memenuhi_syarat_lain' => $request->memenuhi_syarat_lain,

            // Saat Mulai ART
            'saat_mulai_art_tanggal' => $request->saat_mulai_art_tanggal,
            'saat_mulai_art_klinis' => $request->saat_mulai_art_klinis,
            'saat_mulai_art_bb' => $request->saat_mulai_art_bb,
            'saat_mulai_art_status_fungsional' => $request->saat_mulai_art_status_fungsional,
            'saat_mulai_art_cd4' => $request->saat_mulai_art_cd4,
            'saat_mulai_art_lain' => $request->saat_mulai_art_lain,

            // 6 Bulan
            'setelah_6_bulan_tanggal' => $request->setelah_6_bulan_tanggal,
            'setelah_6_bulan_klinis' => $request->setelah_6_bulan_klinis,
            'setelah_6_bulan_bb' => $request->setelah_6_bulan_bb,
            'setelah_6_bulan_status_fungsional' => $request->setelah_6_bulan_status_fungsional,
            'setelah_6_bulan_cd4' => $request->setelah_6_bulan_cd4,
            'setelah_6_bulan_lain' => $request->setelah_6_bulan_lain,

            // 12 Bulan
            'setelah_12_bulan_tanggal' => $request->setelah_12_bulan_tanggal,
            'setelah_12_bulan_klinis' => $request->setelah_12_bulan_klinis,
            'setelah_12_bulan_bb' => $request->setelah_12_bulan_bb,
            'setelah_12_bulan_status_fungsional' => $request->setelah_12_bulan_status_fungsional,
            'setelah_12_bulan_cd4' => $request->setelah_12_bulan_cd4,
            'setelah_12_bulan_lain' => $request->setelah_12_bulan_lain,

            // 24 Bulan
            'setelah_24_bulan_tanggal' => $request->setelah_24_bulan_tanggal,
            'setelah_24_bulan_klinis' => $request->setelah_24_bulan_klinis,
            'setelah_24_bulan_bb' => $request->setelah_24_bulan_bb,
            'setelah_24_bulan_status_fungsional' => $request->setelah_24_bulan_status_fungsional,
            'setelah_24_bulan_cd4' => $request->setelah_24_bulan_cd4,
            'setelah_24_bulan_lain' => $request->setelah_24_bulan_lain,
        ];

        if ($pemeriksaan) {
            $pemeriksaan->update($data);
        } else {
            $data['id_hiv_art'] = $hivArtId;
            RmeHivArtDataPemeriksaanKlinis::create($data);
        }
    }

    private function updateTerapiAntiretroviral($request, $hivArtId)
    {
        // Delete existing records
        RmeHivArtTerapiAntiretroviral::where('id_hiv_art', $hivArtId)->delete();

        // Create new records
        $this->storeTerapiAntiretroviral($request, $hivArtId);
    }
}

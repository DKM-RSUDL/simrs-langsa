<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeMonitoringGizi;
use App\Models\RmePengkajianGiziDewasa;
use App\Models\RmePengkajianGiziDewasaDtl;
use App\Models\RmePengkajianIntervensiGiziDewasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiziDewasaController extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
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
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data pengkajian gizi dewasa
            $dataPengkajianGiziDewasa = RmePengkajianGiziDewasa::with([
                'asesmenGizi', // relasi ke RmePengkajianGiziDewasaDtl
                'intervensiGizi', // relasi ke RmePengkajianIntervensiGiziDewasa
                'userCreate' // relasi ke User
            ])
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->orderBy('waktu_asesmen', 'desc')
                ->get();

            return view('unit-pelayanan.rawat-inap.pelayanan.gizi.dewasa.index', compact(
                'dataMedis',
                'dataPengkajianGiziDewasa'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        $user = auth()->user();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

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

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.dewasa.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'alergiPasien',
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            $dataGiziDewasa = new RmePengkajianGiziDewasa();
            $dataGiziDewasa->kd_pasien = $kd_pasien;
            $dataGiziDewasa->kd_unit = $kd_unit;
            $dataGiziDewasa->tgl_masuk = $tgl_masuk;
            $dataGiziDewasa->urut_masuk = $urut_masuk;
            $dataGiziDewasa->waktu_asesmen = $waktu_asesmen;

            $dataGiziDewasa->diagnosis_medis = $request->diagnosis_medis;
            $dataGiziDewasa->makan_pagi = $request->makan_pagi;
            $dataGiziDewasa->makan_siang = $request->makan_siang;
            $dataGiziDewasa->makan_malam = $request->makan_malam;
            $dataGiziDewasa->frekuensi_ngemil = $request->frekuensi_ngemil;
            $dataGiziDewasa->alergi_makanan = $request->alergi_makanan;
            $dataGiziDewasa->jenis_alergi = $request->jenis_alergi;
            $dataGiziDewasa->pantangan_makanan = $request->pantangan_makanan;
            $dataGiziDewasa->jenis_pantangan = $request->jenis_pantangan;

            // Gangguan GI - convert array to string
            $dataGiziDewasa->gangguan_gi = is_array($request->gangguan_gi)
                ? implode(',', $request->gangguan_gi)
                : $request->gangguan_gi;

            $dataGiziDewasa->frekuensi_makan_rs = $request->frekuensi_makan_rs;

            $dataGiziDewasa->makanan_pokok = $request->makanan_pokok;
            $dataGiziDewasa->lauk_hewani = $request->lauk_hewani;
            $dataGiziDewasa->lauk_nabati = $request->lauk_nabati;
            $dataGiziDewasa->sayuran = $request->sayuran;
            $dataGiziDewasa->buah_buahan = $request->buah_buahan;
            $dataGiziDewasa->minuman = $request->minuman;

            $dataGiziDewasa->recall_makan_pagi = $request->recall_makan_pagi;
            $dataGiziDewasa->recall_snack_pagi = $request->recall_snack_pagi;
            $dataGiziDewasa->recall_makan_siang = $request->recall_makan_siang;
            $dataGiziDewasa->recall_snack_sore = $request->recall_snack_sore;
            $dataGiziDewasa->recall_makan_malam = $request->recall_makan_malam;
            $dataGiziDewasa->recall_snack_malam = $request->recall_snack_malam;
            $dataGiziDewasa->asupan_sebelum_rs = $request->asupan_sebelum_rs;

            $dataGiziDewasa->diagnosa_gizi = $request->diagnosa_gizi;
            $dataGiziDewasa->user_create = Auth::id();
            $dataGiziDewasa->save();

            //Asesmen Gizi Anak
            $asesmenGiziDewasa = new RmePengkajianGiziDewasaDtl();
            $asesmenGiziDewasa->id_gizi = $dataGiziDewasa->id;
            $asesmenGiziDewasa->berat_badan = $request->berat_badan;
            $asesmenGiziDewasa->tinggi_badan = $request->tinggi_badan;
            $asesmenGiziDewasa->imt = $request->imt;
            $asesmenGiziDewasa->bbi = $request->bbi;
            $asesmenGiziDewasa->biokimia = $request->biokimia;
            $asesmenGiziDewasa->kimia_fisik = $request->kimia_fisik;
            $asesmenGiziDewasa->riwayat_gizi = $request->riwayat_gizi;
            $asesmenGiziDewasa->save();

            //Intervensi Gizi Dewasa
            $intervensiGiziDewasa = new RmePengkajianIntervensiGiziDewasa();
            $intervensiGiziDewasa->id_gizi = $dataGiziDewasa->id;
            $intervensiGiziDewasa->umur = $request->umur;
            $intervensiGiziDewasa->faktor_aktivitas = $request->faktor_aktivitas;
            $intervensiGiziDewasa->faktor_stress = $request->faktor_stress;

            // Perhitungan Kebutuhan Energi
            $intervensiGiziDewasa->bee = $request->bee; // Basal Energy Expenditure
            $intervensiGiziDewasa->bmr = $request->bmr; // Basal Metabolic Rate
            $intervensiGiziDewasa->tee = $request->tee; // Total Energy Expenditure
            $intervensiGiziDewasa->kebutuhan_kalori = $request->kebutuhan_kalori;

            // Bentuk Makanan dan Cara Pemberian
            $intervensiGiziDewasa->bentuk_makanan = $request->bentuk_makanan;
            $intervensiGiziDewasa->cara_pemberian = $request->cara_pemberian;

            // Kebutuhan Makronutrien
            $intervensiGiziDewasa->protein_persen = $request->protein_persen;
            $intervensiGiziDewasa->protein_gram = $request->protein_gram;
            $intervensiGiziDewasa->lemak_persen = $request->lemak_persen;
            $intervensiGiziDewasa->lemak_gram = $request->lemak_gram;
            $intervensiGiziDewasa->kh_persen = $request->kh_persen; // karbohidrat
            $intervensiGiziDewasa->kh_gram = $request->kh_gram;

            // Rencana Diet dan Monitoring
            $intervensiGiziDewasa->jenis_diet = $request->jenis_diet;
            $intervensiGiziDewasa->rencana_monitoring = $request->rencana_monitoring;
            $intervensiGiziDewasa->catatan_intervensi = $request->catatan_intervensi;

            $intervensiGiziDewasa->save();

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

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/dewasa"))
                ->with('success', 'Data Pengkajian Gizi Anak berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen' . $e->getMessage());
        }
    }

    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $user = auth()->user();

            // Ambil data pengkajian gizi dewasa berdasarkan ID
            $dataGiziDewasa = RmePengkajianGiziDewasa::with([
                'asesmenGizi',
                'intervensiGizi'
            ])->findOrFail($id);

            // Validasi data apakah sesuai dengan parameter
            if (
                $dataGiziDewasa->kd_pasien != $kd_pasien ||
                $dataGiziDewasa->kd_unit != $kd_unit ||
                date('Y-m-d', strtotime($dataGiziDewasa->tgl_masuk)) != $tgl_masuk ||
                $dataGiziDewasa->urut_masuk != $urut_masuk
            ) {
                abort(404, 'Data tidak ditemukan atau tidak sesuai');
            }

            // Ambil data alergi pasien
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

            // Mengambil data kunjungan
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
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

            return view('unit-pelayanan.rawat-inap.pelayanan.gizi.dewasa.edit', compact(
                'kd_unit',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk',
                'dataMedis',
                'alergiPasien',
                'user',
                'dataGiziDewasa'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Ambil data yang akan diupdate
            $dataGiziDewasa = RmePengkajianGiziDewasa::findOrFail($id);

            // Validasi data apakah sesuai dengan parameter
            if (
                $dataGiziDewasa->kd_pasien != $kd_pasien ||
                $dataGiziDewasa->kd_unit != $kd_unit ||
                date('Y-m-d', strtotime($dataGiziDewasa->tgl_masuk)) != $tgl_masuk ||
                $dataGiziDewasa->urut_masuk != $urut_masuk
            ) {
                throw new \Exception('Data tidak sesuai dengan parameter yang diberikan');
            }

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Update data pengkajian gizi dewasa
            $dataGiziDewasa->waktu_asesmen = $waktu_asesmen;
            $dataGiziDewasa->diagnosis_medis = $request->diagnosis_medis;
            $dataGiziDewasa->makan_pagi = $request->makan_pagi;
            $dataGiziDewasa->makan_siang = $request->makan_siang;
            $dataGiziDewasa->makan_malam = $request->makan_malam;
            $dataGiziDewasa->frekuensi_ngemil = $request->frekuensi_ngemil;
            $dataGiziDewasa->alergi_makanan = $request->alergi_makanan;
            $dataGiziDewasa->jenis_alergi = $request->jenis_alergi;
            $dataGiziDewasa->pantangan_makanan = $request->pantangan_makanan;
            $dataGiziDewasa->jenis_pantangan = $request->jenis_pantangan;

            // Gangguan GI - convert array to string
            $dataGiziDewasa->gangguan_gi = is_array($request->gangguan_gi)
                ? implode(',', $request->gangguan_gi)
                : $request->gangguan_gi;

            $dataGiziDewasa->frekuensi_makan_rs = $request->frekuensi_makan_rs;
            $dataGiziDewasa->makanan_pokok = $request->makanan_pokok;
            $dataGiziDewasa->lauk_hewani = $request->lauk_hewani;
            $dataGiziDewasa->lauk_nabati = $request->lauk_nabati;
            $dataGiziDewasa->sayuran = $request->sayuran;
            $dataGiziDewasa->buah_buahan = $request->buah_buahan;
            $dataGiziDewasa->minuman = $request->minuman;
            $dataGiziDewasa->recall_makan_pagi = $request->recall_makan_pagi;
            $dataGiziDewasa->recall_snack_pagi = $request->recall_snack_pagi;
            $dataGiziDewasa->recall_makan_siang = $request->recall_makan_siang;
            $dataGiziDewasa->recall_snack_sore = $request->recall_snack_sore;
            $dataGiziDewasa->recall_makan_malam = $request->recall_makan_malam;
            $dataGiziDewasa->recall_snack_malam = $request->recall_snack_malam;
            $dataGiziDewasa->asupan_sebelum_rs = $request->asupan_sebelum_rs;
            $dataGiziDewasa->diagnosa_gizi = $request->diagnosa_gizi;
            $dataGiziDewasa->user_update = Auth::id();
            $dataGiziDewasa->save();

            // Update atau create asesmen gizi dewasa detail
            $asesmenGiziDewasa = RmePengkajianGiziDewasaDtl::where('id_gizi', $dataGiziDewasa->id)->first();
            if (!$asesmenGiziDewasa) {
                $asesmenGiziDewasa = new RmePengkajianGiziDewasaDtl();
                $asesmenGiziDewasa->id_gizi = $dataGiziDewasa->id;
            }

            $asesmenGiziDewasa->berat_badan = $request->berat_badan;
            $asesmenGiziDewasa->tinggi_badan = $request->tinggi_badan;
            $asesmenGiziDewasa->imt = $request->imt;
            $asesmenGiziDewasa->bbi = $request->bbi;
            $asesmenGiziDewasa->biokimia = $request->biokimia;
            $asesmenGiziDewasa->kimia_fisik = $request->kimia_fisik;
            $asesmenGiziDewasa->riwayat_gizi = $request->riwayat_gizi;
            $asesmenGiziDewasa->save();

            // Update atau create intervensi gizi dewasa
            $intervensiGiziDewasa = RmePengkajianIntervensiGiziDewasa::where('id_gizi', $dataGiziDewasa->id)->first();
            if (!$intervensiGiziDewasa) {
                $intervensiGiziDewasa = new RmePengkajianIntervensiGiziDewasa();
                $intervensiGiziDewasa->id_gizi = $dataGiziDewasa->id;
            }

            $intervensiGiziDewasa->umur = $request->umur;
            $intervensiGiziDewasa->faktor_aktivitas = $request->faktor_aktivitas;
            $intervensiGiziDewasa->faktor_stress = $request->faktor_stress;
            $intervensiGiziDewasa->bee = $request->bee;
            $intervensiGiziDewasa->bmr = $request->bmr;
            $intervensiGiziDewasa->tee = $request->tee;
            $intervensiGiziDewasa->kebutuhan_kalori = $request->kebutuhan_kalori;
            $intervensiGiziDewasa->bentuk_makanan = $request->bentuk_makanan;
            $intervensiGiziDewasa->cara_pemberian = $request->cara_pemberian;
            $intervensiGiziDewasa->protein_persen = $request->protein_persen;
            $intervensiGiziDewasa->protein_gram = $request->protein_gram;
            $intervensiGiziDewasa->lemak_persen = $request->lemak_persen;
            $intervensiGiziDewasa->lemak_gram = $request->lemak_gram;
            $intervensiGiziDewasa->kh_persen = $request->kh_persen;
            $intervensiGiziDewasa->kh_gram = $request->kh_gram;
            $intervensiGiziDewasa->jenis_diet = $request->jenis_diet;
            $intervensiGiziDewasa->rencana_monitoring = $request->rencana_monitoring;
            $intervensiGiziDewasa->catatan_intervensi = $request->catatan_intervensi;
            $intervensiGiziDewasa->save();

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
            }

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/dewasa"))
                ->with('success', 'Data Pengkajian Gizi Dewasa berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data asesmen: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data pengkajian gizi dewasa berdasarkan ID
            $dataGiziDewasa = RmePengkajianGiziDewasa::with([
                'asesmenGizi',
                'intervensiGizi',
                'userCreate'
            ])->findOrFail($id);

            // Validasi data apakah sesuai dengan parameter
            if (
                $dataGiziDewasa->kd_pasien != $kd_pasien ||
                $dataGiziDewasa->kd_unit != $kd_unit ||
                date('Y-m-d', strtotime($dataGiziDewasa->tgl_masuk)) != $tgl_masuk ||
                $dataGiziDewasa->urut_masuk != $urut_masuk
            ) {
                abort(404, 'Data tidak ditemukan atau tidak sesuai');
            }

            // Ambil data alergi pasien
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

            // Mengambil data kunjungan
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
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data monitoring gizi
            $monitoringGizi = RmeMonitoringGizi::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->orderBy('tanggal_monitoring', 'desc')
                ->get();

            return view('unit-pelayanan.rawat-inap.pelayanan.gizi.dewasa.show', compact(
                'kd_unit',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk',
                'dataMedis',
                'alergiPasien',
                'monitoringGizi',
                'dataGiziDewasa'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Ambil data yang akan dihapus
            $dataGiziDewasa = RmePengkajianGiziDewasa::findOrFail($id);

            // Validasi data apakah sesuai dengan parameter
            if (
                $dataGiziDewasa->kd_pasien != $kd_pasien ||
                $dataGiziDewasa->kd_unit != $kd_unit ||
                date('Y-m-d', strtotime($dataGiziDewasa->tgl_masuk)) != $tgl_masuk ||
                $dataGiziDewasa->urut_masuk != $urut_masuk
            ) {
                throw new \Exception('Data tidak sesuai dengan parameter yang diberikan');
            }

            // Hapus data terkait terlebih dahulu
            // Hapus asesmen gizi detail
            RmePengkajianGiziDewasaDtl::where('id_gizi', $dataGiziDewasa->id)->delete();

            // Hapus intervensi gizi
            RmePengkajianIntervensiGiziDewasa::where('id_gizi', $dataGiziDewasa->id)->delete();

            // Hapus data pengkajian gizi dewasa
            $dataGiziDewasa->delete();

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/dewasa"))
                ->with('success', 'Data Pengkajian Gizi Dewasa berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}

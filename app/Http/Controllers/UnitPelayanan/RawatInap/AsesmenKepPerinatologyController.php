<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKepPerinatology;
use App\Models\RmeAsesmenKepPerinatologyFisik;
use App\Models\RmeAsesmenKepPerinatologyPemeriksaanLanjut;
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

class AsesmenKepPerinatologyController extends Controller
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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.create', compact(
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
            $dataAsesmen->sub_kategori = 2;
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->save();

            //simpan ke table RmeAsesemnKepPerinatology
            $tglLahir = $request->tgl_lahir;
            $jamLahir = $request->jam_lahir;
            $waktuLahir = $tglLahir . ' ' . $jamLahir;

            // Validasi file yang diunggah
            $request->validate([
                'sidik_kaki_kiri' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // max 10MB (10240KB)
                'sidik_kaki_kanan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // max 10MB (10240KB)
            ], [
                'sidik_kaki_kiri.mimes' => 'Format file harus berupa JPG, PNG, atau PDF',
                'sidik_kaki_kiri.max' => 'Ukuran file maksimal 10MB',
                'sidik_kaki_kanan.mimes' => 'Format file harus berupa JPG, PNG, atau PDF',
                'sidik_kaki_kanan.max' => 'Ukuran file maksimal 10MB',
            ]);

            $asesmenPerinatology = new RmeAsesmenKepPerinatology();
            $asesmenPerinatology->id_asesmen = $dataAsesmen->id;
            $asesmenPerinatology->data_masuk = $waktu_asesmen;
            $asesmenPerinatology->agama_orang_tua = $request->agama_orang_tua;
            $asesmenPerinatology->tgl_lahir_bayi = $waktuLahir;
            $asesmenPerinatology->nama_bayi = $request->nama_bayi;
            $asesmenPerinatology->jenis_kelamin = $request->jenis_kelamin;
            $asesmenPerinatology->nama_ibu = $request->nama_ibu;
            $asesmenPerinatology->nik_ibu = $request->nik_ibu;

            $pathSidikKakiKiri = ($request->hasFile('sidik_kaki_kiri')) ? $request->file('sidik_kaki_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk") : "";
            $pathSidikKakiKanan = ($request->hasFile('sidik_kaki_kanan')) ? $request->file('sidik_kaki_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk") : "";
            $pathSidikJariKiri = ($request->hasFile('sidik_jari_kiri')) ? $request->file('sidik_jari_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk") : "";
            $pathSidikJariKanan = ($request->hasFile('sidik_jari_kanan')) ? $request->file('sidik_jari_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk") : "";

            $asesmenPerinatology->sidik_telapak_kaki_kiri = $pathSidikKakiKiri;
            $asesmenPerinatology->sidik_telapak_kaki_kanan = $pathSidikKakiKanan;
            $asesmenPerinatology->sidik_jari_ibu_kiri = $pathSidikJariKiri;
            $asesmenPerinatology->sidik_jari_ibu_kanan = $pathSidikJariKanan;

            $asesmenPerinatology->alamat = $request->alamat;
            $asesmenPerinatology->save();

            //simpan ke table RmeAsesemnKepPerinatologyFisik
            $perinatologyFisik = new RmeAsesmenKepPerinatologyFisik();
            $perinatologyFisik->id_asesmen = $dataAsesmen->id;
            $perinatologyFisik->jenis_kelamin = $request->jenis_kelamin;
            $perinatologyFisik->frekuensi_nadi = $request->frekuensi;
            $perinatologyFisik->status_frekuensi = $request->status_frekuensi;
            $perinatologyFisik->frekuensi_nafas = $request->frekuensi_nafas;
            $perinatologyFisik->suhu = $request->suhu;
            $perinatologyFisik->spo2_tanpa_bantuan = $request->spo_tanpa_o2;
            $perinatologyFisik->spo2_dengan_bantuan = $request->spo_dengan_o2;
            $perinatologyFisik->tinggi_badan = $request->tinggi_badan;
            $perinatologyFisik->berat_badan = $request->berat_badan;
            $perinatologyFisik->lingkar_kepala = $request->lingkar_kepala;
            $perinatologyFisik->lingkar_dada = $request->lingkar_dada;
            $perinatologyFisik->lingkar_perut = $request->lingkar_perut;
            $perinatologyFisik->kesadaran = $request->kesadaran;
            $perinatologyFisik->avpu = $request->avpu;

            //simpan ke table RmeAsesemnKepPerinatologyPemeriksaanLanjut
            $perinatologyPemeriksaanLanjut = new RmeAsesmenKepPerinatologyPemeriksaanLanjut();
            $perinatologyPemeriksaanLanjut->id_asesmen = $dataAsesmen->id;
            $perinatologyPemeriksaanLanjut->warna_kulit = $request->warna_kulit;
            $perinatologyPemeriksaanLanjut->sianosis = $request->sianosis;
            $perinatologyPemeriksaanLanjut->kemerahan = $request->kemerahan;
            $perinatologyPemeriksaanLanjut->turgor_kulit = $request->turgor_kulit;
            $perinatologyPemeriksaanLanjut->tanda_lahir = $request->tanda_lahir;
            $perinatologyPemeriksaanLanjut->fontanel_anterior = $request->fontanel_anterior;
            $perinatologyPemeriksaanLanjut->sutura_sagitalis = $request->sutura_sagitalis;
            $perinatologyPemeriksaanLanjut->gambaran_wajah = $request->gambaran_wajah;
            $perinatologyPemeriksaanLanjut->cephalhemeton = $request->cephalhemeton;
            $perinatologyPemeriksaanLanjut->caput_succedaneun = $request->caput_succedaneun;
            $perinatologyPemeriksaanLanjut->mulut = $request->mulut;
            $perinatologyPemeriksaanLanjut->mucosa_mulut = $request->mucosa_mulut;
            $perinatologyPemeriksaanLanjut->dada_paru = $request->dada_paru;
            $perinatologyPemeriksaanLanjut->suara_nafas = $request->suara_nafas;
            $perinatologyPemeriksaanLanjut->respirasi = $request->respirasi;
            $perinatologyPemeriksaanLanjut->down_score = $request->down_score;
            $perinatologyPemeriksaanLanjut->bunyi_jantung = $request->bunyi_jantung;
            $perinatologyPemeriksaanLanjut->waktu_pengisian_kapiler = $request->waktu_pengisian_kapiler;
            $perinatologyPemeriksaanLanjut->keadaan_perut = $request->keadaan_perut;
            $perinatologyPemeriksaanLanjut->umbilikus = $request->umbilikus;
            $perinatologyPemeriksaanLanjut->warna_umbilikus = $request->warna_umbilikus;
            $perinatologyPemeriksaanLanjut->genitalis = $request->genitalis;
            $perinatologyPemeriksaanLanjut->gerakan = $request->gerakan;
            $perinatologyPemeriksaanLanjut->ekstremitas_atas = $request->ekstremitas_atas;
            $perinatologyPemeriksaanLanjut->ekstremitas_bawah = $request->ekstremitas_bawah;
            $perinatologyPemeriksaanLanjut->tulang_belakang = $request->tulang_belakang;
            $perinatologyPemeriksaanLanjut->refleks = $request->refleks;
            $perinatologyPemeriksaanLanjut->genggaman = $request->genggaman;
            $perinatologyPemeriksaanLanjut->menghisap = $request->menghisap;
            $perinatologyPemeriksaanLanjut->aktivitas = $request->aktivitas;
            $perinatologyPemeriksaanLanjut->menangis = $request->menangis;

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

        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen');
        }
    }
}

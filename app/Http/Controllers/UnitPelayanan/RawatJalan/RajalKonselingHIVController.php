<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeKonselingHiv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RajalKonselingHIVController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Ambil data medis dari tabel Kunjungan
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Ambil data konseling HIV yang terkait dengan pasien
        $dataKonselingHiv = RmeKonselingHiv::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();  // gunakan get() untuk mendapatkan koleksi data, bukan first()

        if ($dataKonselingHiv->isEmpty()) {
            $dataKonselingHiv = null; // Jika tidak ada data konseling HIV
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.konseling-hiv.index', compact(
            'dataMedis',
            'alergiPasien',
            'dataKonselingHiv' 
        ));
    }



    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }


        return view('unit-pelayanan.rawat-jalan.pelayanan.konseling-hiv.create', compact(
            'dataMedis',
            'alergiPasien'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Create a new RmeKonselingHiv instance
            $konselingHiv = new RmeKonselingHiv();
            $konselingHiv->kd_pasien = $kd_pasien;
            $konselingHiv->kd_unit = $kd_unit;
            $konselingHiv->tgl_masuk = $tgl_masuk;
            $konselingHiv->urut_masuk = $urut_masuk;
            $konselingHiv->user_created = Auth::id();

            // Store all form fields as properties of the RmeKonselingHiv model
            $konselingHiv->tgl_implementasi = $request->input('tgl_implementasi');
            $konselingHiv->jam_implementasi = $request->input('jam_implementasi');
            $konselingHiv->status_kunjungan = $request->input('status_kunjungan');
            $konselingHiv->status_rujukan = $request->input('status_rujukan');
            $konselingHiv->warga_binaan = $request->input('warga_binaan');
            $konselingHiv->status_kehamilan = $request->input('status_kehamilan');
            $konselingHiv->umur_anak_terakhir = $request->input('umur_anak_terakhir');
            $konselingHiv->jumlah_anak_kandung = $request->input('jumlah_anak_kandung');
            $konselingHiv->jenis_kelamin = $request->input('jenis_kelamin');
            $konselingHiv->pasangan_tetap = $request->input('pasangan_tetap');
            $konselingHiv->kelompok_risiko = $request->input('kelompok_risiko');
            $konselingHiv->jenis_ps = $request->input('jenis_ps');
            $konselingHiv->pasangan_perempuan = $request->input('pasangan_perempuan');
            $konselingHiv->pasangan_hamil = $request->input('pasangan_hamil');
            $konselingHiv->tgl_lahir_pasangan = $request->input('tgl_lahir_pasangan');
            $konselingHiv->status_hiv_pasangan = $request->input('status_hiv_pasangan');
            $konselingHiv->tgl_tes_terakhir_pasangan = $request->input('tgl_tes_terakhir_pasangan');
            $konselingHiv->tgl_konseling_pra_tes = $request->input('tgl_konseling_pra_tes');
            $konselingHiv->status_klien = $request->input('status_klien');
            $konselingHiv->alasan_tes = json_encode($request->input('alasan_tes'));
            $konselingHiv->alasan_tes_lainnya = $request->input('alasan_tes_lainnya');
            $konselingHiv->mengetahui_tes_dari = $request->input('mengetahui_tes_dari');
            $konselingHiv->seks_vaginal_berisiko = $request->input('seks_vaginal_berisiko');
            $konselingHiv->seks_vaginal_kapan = $request->input('seks_vaginal_kapan');
            $konselingHiv->anal_seks_berisiko = $request->input('anal_seks_berisiko');
            $konselingHiv->anal_seks_kapan = $request->input('anal_seks_kapan');
            $konselingHiv->bergantian_suntik = $request->input('bergantian_suntik');
            $konselingHiv->bergantian_suntik_kapan = $request->input('bergantian_suntik_kapan');
            $konselingHiv->transfusi_darah = $request->input('transfusi_darah');
            $konselingHiv->transfusi_darah_kapan = $request->input('transfusi_darah_kapan');
            $konselingHiv->transmisi_ibu_anak = $request->input('transmisi_ibu_anak');
            $konselingHiv->transmisi_ibu_anak_kapan = $request->input('transmisi_ibu_anak_kapan');
            $konselingHiv->lainnya_risiko = $request->input('lainnya_risiko');
            $konselingHiv->lainnya_risiko_kapan = $request->input('lainnya_risiko_kapan');
            $konselingHiv->periode_jendela = $request->input('periode_jendela');
            $konselingHiv->periode_jendela_kapan = $request->input('periode_jendela_kapan');
            $konselingHiv->kesediaan_tes = $request->input('kesediaan_tes');
            $konselingHiv->pernah_tes_hiv = $request->input('pernah_tes_hiv');
            $konselingHiv->pernah_tes_dimana = $request->input('pernah_tes_dimana');
            $konselingHiv->pernah_tes_kapan = $request->input('pernah_tes_kapan');
            $konselingHiv->hasil_tes_sebelumnya = $request->input('hasil_tes_sebelumnya');
            $konselingHiv->nomor_registrasi_pdp = $request->input('nomor_registrasi_pdp');
            $konselingHiv->tgl_masuk_pdp = $request->input('tgl_masuk_pdp');
            $konselingHiv->tindak_lanjut = json_encode($request->input('tindak_lanjut'));
            $konselingHiv->bagaimana_status_hiv_pasangan = $request->input('bagaimana_status_hiv_pasangan');
            $konselingHiv->tgl_konseling_pasca_tes = $request->input('tgl_konseling_pasca_tes');
            $konselingHiv->terima_hasil = $request->input('terima_hasil');
            $konselingHiv->kaji_gejala_tb = $request->input('kaji_gejala_tb');
            $konselingHiv->jumlah_kondom = $request->input('jumlah_kondom');
            $konselingHiv->tindak_lanjut_kts = json_encode($request->input('tindak_lanjut_kts'));
            $konselingHiv->nama_konselor = $request->input('nama_konselor');
            $konselingHiv->status_layanan = $request->input('status_layanan');
            $konselingHiv->jenis_pelayanan = $request->input('jenis_pelayanan');

            // Save to the database
            $konselingHiv->save();

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-jalan/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/konseling-hiv"))
                ->with('success', 'Data Konseling HIV berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // Ambil data medis dari tabel Kunjungan
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Ambil data konseling HIV yang akan diedit
        $konselingHiv = RmeKonselingHiv::find($data);  // $data adalah ID konseling

        if (!$konselingHiv) {
            abort(404, 'Data Konseling HIV tidak ditemukan');
        }

        // Ambil data alergi pasien
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.rawat-jalan.pelayanan.konseling-hiv.edit', compact(
            'dataMedis',
            'alergiPasien',
            'konselingHiv' // Menambahkan data konseling HIV untuk diedit
        ));
    }


    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Find the existing RmeKonselingHiv record
            $konselingHiv = RmeKonselingHiv::find($id);

            if (!$konselingHiv) {
                abort(404, 'Data Konseling HIV tidak ditemukan');
            }

            // Update all form fields
            $konselingHiv->tgl_implementasi = $request->input('tgl_implementasi');
            $konselingHiv->jam_implementasi = $request->input('jam_implementasi');
            $konselingHiv->status_kunjungan = $request->input('status_kunjungan');
            $konselingHiv->status_rujukan = $request->input('status_rujukan');
            $konselingHiv->warga_binaan = $request->input('warga_binaan');
            $konselingHiv->status_kehamilan = $request->input('status_kehamilan');
            $konselingHiv->umur_anak_terakhir = $request->input('umur_anak_terakhir');
            $konselingHiv->jumlah_anak_kandung = $request->input('jumlah_anak_kandung');
            $konselingHiv->jenis_kelamin = $request->input('jenis_kelamin');
            $konselingHiv->pasangan_tetap = $request->input('pasangan_tetap');
            $konselingHiv->kelompok_risiko = $request->input('kelompok_risiko');
            $konselingHiv->jenis_ps = $request->input('jenis_ps');
            $konselingHiv->pasangan_perempuan = $request->input('pasangan_perempuan');
            $konselingHiv->pasangan_hamil = $request->input('pasangan_hamil');
            $konselingHiv->tgl_lahir_pasangan = $request->input('tgl_lahir_pasangan');
            $konselingHiv->status_hiv_pasangan = $request->input('status_hiv_pasangan');
            $konselingHiv->tgl_tes_terakhir_pasangan = $request->input('tgl_tes_terakhir_pasangan');
            $konselingHiv->tgl_konseling_pra_tes = $request->input('tgl_konseling_pra_tes');
            $konselingHiv->status_klien = $request->input('status_klien');
            $konselingHiv->alasan_tes = json_encode($request->input('alasan_tes', []));
            $konselingHiv->alasan_tes_lainnya = $request->input('alasan_tes_lainnya');
            $konselingHiv->mengetahui_tes_dari = $request->input('mengetahui_tes_dari');
            $konselingHiv->seks_vaginal_berisiko = $request->input('seks_vaginal_berisiko');
            $konselingHiv->seks_vaginal_kapan = $request->input('seks_vaginal_kapan');
            $konselingHiv->anal_seks_berisiko = $request->input('anal_seks_berisiko');
            $konselingHiv->anal_seks_kapan = $request->input('anal_seks_kapan');
            $konselingHiv->bergantian_suntik = $request->input('bergantian_suntik');
            $konselingHiv->bergantian_suntik_kapan = $request->input('bergantian_suntik_kapan');
            $konselingHiv->transfusi_darah = $request->input('transfusi_darah');
            $konselingHiv->transfusi_darah_kapan = $request->input('transfusi_darah_kapan');
            $konselingHiv->transmisi_ibu_anak = $request->input('transmisi_ibu_anak');
            $konselingHiv->transmisi_ibu_anak_kapan = $request->input('transmisi_ibu_anak_kapan');
            $konselingHiv->lainnya_risiko = $request->input('lainnya_risiko');
            $konselingHiv->lainnya_risiko_kapan = $request->input('lainnya_risiko_kapan');
            $konselingHiv->periode_jendela = $request->input('periode_jendela');
            $konselingHiv->periode_jendela_kapan = $request->input('periode_jendela_kapan');
            $konselingHiv->kesediaan_tes = $request->input('kesediaan_tes');
            $konselingHiv->pernah_tes_hiv = $request->input('pernah_tes_hiv');
            $konselingHiv->pernah_tes_dimana = $request->input('pernah_tes_dimana');
            $konselingHiv->pernah_tes_kapan = $request->input('pernah_tes_kapan');
            $konselingHiv->hasil_tes_sebelumnya = $request->input('hasil_tes_sebelumnya');
            $konselingHiv->nomor_registrasi_pdp = $request->input('nomor_registrasi_pdp');
            $konselingHiv->tgl_masuk_pdp = $request->input('tgl_masuk_pdp');
            $konselingHiv->tindak_lanjut = json_encode($request->input('tindak_lanjut', []));
            $konselingHiv->bagaimana_status_hiv_pasangan = $request->input('bagaimana_status_hiv_pasangan');
            $konselingHiv->tgl_konseling_pasca_tes = $request->input('tgl_konseling_pasca_tes');
            $konselingHiv->terima_hasil = $request->input('terima_hasil');
            $konselingHiv->kaji_gejala_tb = $request->input('kaji_gejala_tb');
            $konselingHiv->jumlah_kondom = $request->input('jumlah_kondom');
            $konselingHiv->tindak_lanjut_kts = json_encode($request->input('tindak_lanjut_kts', []));
            $konselingHiv->nama_konselor = $request->input('nama_konselor');
            $konselingHiv->status_layanan = $request->input('status_layanan');
            $konselingHiv->jenis_pelayanan = $request->input('jenis_pelayanan');
            $konselingHiv->user_updated = Auth::id();

            // Save to the database
            $konselingHiv->save();

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-jalan/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/konseling-hiv"))
                ->with('success', 'Data Konseling HIV berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupdate data asesmen: ' . $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // Ambil data medis dari tabel Kunjungan
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data konseling HIV yang akan ditampilkan
        $konselingHiv = RmeKonselingHiv::with('user')->find($data);

        if (!$konselingHiv) {
            abort(404, 'Data Konseling HIV tidak ditemukan');
        }

        // Ambil data alergi pasien
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.rawat-jalan.pelayanan.konseling-hiv.show', compact(
            'dataMedis',
            'alergiPasien',
            'konselingHiv'
        ));
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // Cari data konseling HIV yang akan dihapus
        $konselingHiv = RmeKonselingHiv::find($data);

        if ($konselingHiv) {
            $konselingHiv->delete(); // Hapus data
            return redirect()->route('rawat-jalan.konseling-hiv.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data konseling HIV berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data konseling HIV tidak ditemukan');
        }
    }

}

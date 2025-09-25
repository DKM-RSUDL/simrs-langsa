<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\OkAsesmen;
use App\Models\OkPraOperasiPerawat;
use App\Models\Produk;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PraAnestesiPerawatController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $perawat = HrdKaryawan::where('status_peg', 1)
            ->where('kd_ruangan', 4)
            ->where('kd_jenis_tenaga', 2)
            ->get();

        $jenisOperasi = DB::table('produk as p')
            ->select(
                'p.kd_produk',
                'p.kp_produk',
                'p.deskripsi',
                't.kd_tarif',
                't.tarif',
                't.kd_unit',
                't.tgl_berlaku',
                'p.kd_klas'
            )
            ->join(
                DB::raw('(tarif as t INNER JOIN tarif_cust as tc ON t.kd_tarif = tc.kd_tarif)'),
                'p.kd_produk',
                '=',
                't.kd_produk'
            )
            ->whereIn('t.kd_unit', [71, 7])
            ->where('t.kd_tarif', 'TU')
            ->whereRaw("t.tgl_berlaku = (
            SELECT TOP 1 tgl_berlaku
            FROM tarif
            WHERE KD_PRODUK = t.kd_produk
            AND KD_TARIF = t.kd_tarif
            AND KD_UNIT = t.kd_unit
            AND (Tgl_Berakhir IS NULL OR Tgl_Berakhir >= '2025-02-21')
            ORDER BY tgl_berlaku DESC
        )")
            ->whereRaw("(t.Tgl_Berakhir IS NULL OR t.Tgl_Berakhir >= '2025-02-21')")
            ->whereRaw("LEFT(p.kd_klas, 2) = '61'")
            ->orderBy('t.tgl_berlaku', 'DESC')
            ->get();

        return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.perawat.create', compact('dataMedis', 'perawat', 'jenisOperasi'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            // create asesmen
            $asesmen = new OkAsesmen();
            $asesmen->kd_pasien = $kd_pasien;
            $asesmen->kd_unit = 71;
            $asesmen->tgl_masuk = $tgl_masuk;
            $asesmen->urut_masuk = $urut_masuk;
            $asesmen->kategori = 2;
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->user_create = Auth::id();
            $asesmen->save();

            // create asesmen pra operasi perawat
            $data = [
                'id_asesmen'    => $asesmen->id,
                'tgl_op'     => $request->tgl_masuk,
                'jam_op'     => $request->jam_masuk,
                'sistole'   => $request->sistole,
                'diastole'   => $request->diastole,
                'nadi'   => $request->nadi,
                'nafas'   => $request->nafas,
                'suhu'   => $request->suhu,
                'skala_nyeri'   => $request->skala_nyeri,
                'tinggi_badan'   => $request->tinggi_badan,
                'berat_badan'   => $request->berat_badan,
                'imt'   => $request->imt,
                'lpt'   => $request->lpt,
                'status_mental'   => $request->status_mental,
                'penyakit_sekarang'   => $request->penyakitsekarang ?? [],
                'penyakit_dahulu'   => $request->penyakitdahulu ?? [],
                'alat_bantu'   => $request->alat_bantu,
                'jenis_operasi'   => $request->jenisoperasi ?? [],
                'tgl_bedah'   => $request->tgl_bedah,
                'tempat_bedah'   => $request->tempat_bedah,
                'alergi'   => $request->alergi ?? [],
                'hasil_lab'   => $request->hasil_lab ?? [],
                'hasil_lab_lainnya'   => $request->hasil_lab_lainnya,
                'batuk'   => $request->batuk,
                'haid'   => $request->haid,
                'verifikasi_pasien'   => $request->verifikasi ?? [],
                'persiapan_fisik_pasien'   => $request->persiapan_fisik ?? [],
                'id_perawat_penerima'   => $request->perawat_penerima,
                'tgl_periksa'   => $request->tgl_periksa,
                'jam_periksa'   => $request->jam_periksa,
                'site_marking'   => $request->site_marking,
                'penjelasan_prosedur'   => $request->penjelasan_prosedur
            ];

            OkPraOperasiPerawat::create($data);

            DB::commit();
            return to_route('operasi.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Asesmen Pra Operatif Perawat berhasil di tambah !');
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $perawat = User::with(['karyawan'])
            ->whereRelation('karyawan', 'status_peg', 1)
            ->whereRelation('karyawan', 'kd_ruangan', 4)
            ->whereRelation('karyawan', 'kd_jenis_tenaga', 2)
            ->get();

        $jenisOperasi = DB::table('produk as p')
            ->select(
                'p.kd_produk',
                'p.kp_produk',
                'p.deskripsi',
                't.kd_tarif',
                't.tarif',
                't.kd_unit',
                't.tgl_berlaku',
                'p.kd_klas'
            )
            ->join(
                DB::raw('(tarif as t INNER JOIN tarif_cust as tc ON t.kd_tarif = tc.kd_tarif)'),
                'p.kd_produk',
                '=',
                't.kd_produk'
            )
            ->whereIn('t.kd_unit', [71, 7])
            ->where('t.kd_tarif', 'TU')
            ->whereRaw("t.tgl_berlaku = (
            SELECT TOP 1 tgl_berlaku
            FROM tarif
            WHERE KD_PRODUK = t.kd_produk
            AND KD_TARIF = t.kd_tarif
            AND KD_UNIT = t.kd_unit
            AND (Tgl_Berakhir IS NULL OR Tgl_Berakhir >= '2025-02-21')
            ORDER BY tgl_berlaku DESC
        )")
            ->whereRaw("(t.Tgl_Berakhir IS NULL OR t.Tgl_Berakhir >= '2025-02-21')")
            ->whereRaw("LEFT(p.kd_klas, 2) = '61'")
            ->orderBy('t.tgl_berlaku', 'DESC')
            ->get();

        $asesmen = OkAsesmen::find($id);

        return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.perawat.edit', compact('dataMedis', 'asesmen', 'perawat', 'jenisOperasi'));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idEncrypt);
            $PraOperatif = OkPraOperasiPerawat::find($id);

            $asesmen = OkAsesmen::find($PraOperatif->id_asesmen);
            $asesmen->user_edit = Auth::id();
            $asesmen->save();

            $PraOperatif->tgl_op     = $request->tgl_masuk;
            $PraOperatif->jam_op     = $request->jam_masuk;
            $PraOperatif->sistole   = $request->sistole;
            $PraOperatif->diastole   = $request->diastole;
            $PraOperatif->nadi   = $request->nadi;
            $PraOperatif->nafas   = $request->nafas;
            $PraOperatif->suhu   = $request->suhu;
            $PraOperatif->skala_nyeri   = $request->skala_nyeri;
            $PraOperatif->tinggi_badan   = $request->tinggi_badan;
            $PraOperatif->berat_badan   = $request->berat_badan;
            $PraOperatif->imt   = $request->imt;
            $PraOperatif->lpt   = $request->lpt;
            $PraOperatif->status_mental   = $request->status_mental;
            $PraOperatif->penyakit_sekarang   = $request->penyakitsekarang ?? [];
            $PraOperatif->penyakit_dahulu   = $request->penyakitdahulu ?? [];
            $PraOperatif->alat_bantu   = $request->alat_bantu;
            $PraOperatif->jenis_operasi   = $request->jenisoperasi ?? [];
            $PraOperatif->tgl_bedah   = $request->tgl_bedah;
            $PraOperatif->tempat_bedah   = $request->tempat_bedah;
            $PraOperatif->alergi   = $request->alergi ?? [];
            $PraOperatif->hasil_lab   = $request->hasil_lab ?? [];
            $PraOperatif->hasil_lab_lainnya   = $request->hasil_lab_lainnya;
            $PraOperatif->batuk   = $request->batuk;
            $PraOperatif->haid   = $request->haid;
            $PraOperatif->verifikasi_pasien   = $request->verifikasi ?? [];
            $PraOperatif->persiapan_fisik_pasien   = $request->persiapan_fisik ?? [];
            $PraOperatif->id_perawat_penerima   = $request->perawat_penerima;
            $PraOperatif->tgl_periksa   = $request->tgl_periksa;
            $PraOperatif->jam_periksa   = $request->jam_periksa;
            $PraOperatif->site_marking   = $request->site_marking;
            $PraOperatif->penjelasan_prosedur   = $request->penjelasan_prosedur;
            $PraOperatif->save();

            DB::commit();
            return to_route('operasi.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Asesmen Pra Operatif Perawat berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.kd_unit', 71)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            // Menghitung umur berdasarkan tgl_lahir jika ada
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            $perawat = User::with(['karyawan'])
                ->whereRelation('karyawan', 'status_peg', 1)
                ->whereRelation('karyawan', 'kd_ruangan', 4)
                ->whereRelation('karyawan', 'kd_jenis_tenaga', 2)
                ->get();

            $jenisOperasi = DB::table('produk as p')
                ->select(
                    'p.kd_produk',
                    'p.kp_produk',
                    'p.deskripsi',
                    't.kd_tarif',
                    't.tarif',
                    't.kd_unit',
                    't.tgl_berlaku',
                    'p.kd_klas'
                )
                ->join(
                    DB::raw('(tarif as t INNER JOIN tarif_cust as tc ON t.kd_tarif = tc.kd_tarif)'),
                    'p.kd_produk',
                    '=',
                    't.kd_produk'
                )
                ->whereIn('t.kd_unit', [71, 7])
                ->where('t.kd_tarif', 'TU')
                ->whereRaw("t.tgl_berlaku = (
            SELECT TOP 1 tgl_berlaku
            FROM tarif
            WHERE KD_PRODUK = t.kd_produk
            AND KD_TARIF = t.kd_tarif
            AND KD_UNIT = t.kd_unit
            AND (Tgl_Berakhir IS NULL OR Tgl_Berakhir >= '2025-02-21')
            ORDER BY tgl_berlaku DESC
        )")
                ->whereRaw("(t.Tgl_Berakhir IS NULL OR t.Tgl_Berakhir >= '2025-02-21')")
                ->whereRaw("LEFT(p.kd_klas, 2) = '61'")
                ->orderBy('t.tgl_berlaku', 'DESC')
                ->get();

            $asesmen = OkAsesmen::find($id);

            return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.perawat.show', compact('dataMedis', 'asesmen', 'perawat', 'jenisOperasi'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
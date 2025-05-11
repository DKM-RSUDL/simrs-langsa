<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmePenundaanPelayanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenundaanPelayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        $penundaan = RmePenundaanPelayanan::with(['userCreate', 'dokter'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.penundaan.index', compact(
            'dataMedis',
            'penundaan'
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $dokter = Dokter::where('status', 1)->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.penundaan.create', compact('dataMedis', 'dokter'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $data = [
                'kd_pasien'         => $kd_pasien,
                'kd_unit'         => $kd_unit,
                'tgl_masuk'         => $tgl_masuk,
                'urut_masuk'         => $urut_masuk,
                'tanggal'         => $request->tanggal,
                'jam'         => $request->jam,
                'status_penerima_informasi'         => $request->status_penerima_informasi,
                'nama_penerima_informasi'         => ($request->status_penerima_informasi != 1) ? $request->nama_penerima_informasi : $pasien->nama,
                'kd_dokter'         => $request->kd_dokter,
                'pelayanan_diberikan'         => $request->pelayanan_diberikan,
                'manfaat_risiko_alternatif'         => $request->manfaat_risiko_alternatif,
                'risiko_penundaan'         => $request->risiko_penundaan,
                'penyebab_kerusakan_alat'         => $request->penyebab_kerusakan_alat,
                'penyebab_kondisi_umum_pasien'         => $request->penyebab_kondisi_umum_pasien,
                'penyebab_penundaan_penjadwalan'         => $request->penyebab_penundaan_penjadwalan,
                'penyebab_pemadaman_listrik'         => $request->penyebab_pemadaman_listrik,
                'penyebab_lainnya'         => $request->penyebab_lainnya,
                'alternatif_tgl'         => $request->alternatif_tgl,
                'alternatif_jam'         => $request->alternatif_jam,
                'alternatif_rujuk'         => $request->alternatif_rujuk,
                'alternatif_kembali'         => $request->alternatif_kembali ?? 0,
                'alternatif_lainnya'         => $request->alternatif_lainnya,
                'user_create'         => Auth::id(),
            ];

            RmePenundaanPelayanan::create($data);

            DB::commit();
            return to_route('rawat-inap.penundaan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan penundaan pelayanan berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
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
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $dokter = Dokter::where('status', 1)->get();
        $id = decrypt($idEncrypt);
        $penundaan = RmePenundaanPelayanan::find($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.penundaan.edit', compact('dataMedis', 'dokter', 'penundaan'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $id = decrypt($idEncrypt);
            $penundaan = RmePenundaanPelayanan::find($id);
            if (empty($penundaan)) throw new Exception('Data penundaan pelayanan tidak ditemukan !');

            $data = [
                'tanggal'         => $request->tanggal,
                'jam'         => $request->jam,
                'status_penerima_informasi'         => $request->status_penerima_informasi,
                'nama_penerima_informasi'         => ($request->status_penerima_informasi != 1) ? $request->nama_penerima_informasi : $pasien->nama,
                'kd_dokter'         => $request->kd_dokter,
                'pelayanan_diberikan'         => $request->pelayanan_diberikan,
                'manfaat_risiko_alternatif'         => $request->manfaat_risiko_alternatif,
                'risiko_penundaan'         => $request->risiko_penundaan,
                'penyebab_kerusakan_alat'         => $request->penyebab_kerusakan_alat,
                'penyebab_kondisi_umum_pasien'         => $request->penyebab_kondisi_umum_pasien,
                'penyebab_penundaan_penjadwalan'         => $request->penyebab_penundaan_penjadwalan,
                'penyebab_pemadaman_listrik'         => $request->penyebab_pemadaman_listrik,
                'penyebab_lainnya'         => $request->penyebab_lainnya,
                'alternatif_tgl'         => $request->alternatif_tgl,
                'alternatif_jam'         => $request->alternatif_jam,
                'alternatif_rujuk'         => $request->alternatif_rujuk,
                'alternatif_kembali'         => $request->alternatif_kembali ?? 0,
                'alternatif_lainnya'         => $request->alternatif_lainnya,
                'user_edit'         => Auth::id(),
            ];

            RmePenundaanPelayanan::where('id', $penundaan->id)->update($data);

            DB::commit();
            return to_route('rawat-inap.penundaan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan penundaan pelayanan berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
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
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $dokter = Dokter::where('status', 1)->get();
        $id = decrypt($idEncrypt);
        $penundaan = RmePenundaanPelayanan::find($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.penundaan.show', compact('dataMedis', 'dokter', 'penundaan'));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_penundaan);
            $penundaan = RmePenundaanPelayanan::find($id);

            if (empty($penundaan)) throw new Exception('Data penundaan pelayanan tidak ditemukan !');

            $penundaan->delete();

            DB::commit();
            return back()->with('success', 'Data penundaan pelayanan berhasil dihapus !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function pdf($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
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

        if (empty($dataMedis)) return back()->with('error', 'Gagal menemukan data kunjungan !');

        $id = decrypt($idEncrypt);
        $penundaan = RmePenundaanPelayanan::find($id);

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.penundaan.pdf', compact(
            'dataMedis',
            'penundaan'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('penundaan_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
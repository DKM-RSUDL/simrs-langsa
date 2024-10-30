<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\DokterInap;
use App\Models\DokterKlinik;
use App\Models\Kunjungan;
use App\Models\ListTindakanPasien;
use App\Models\Produk;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TindakanController extends Controller
{
    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                            ->join('transaksi as t', function($join) {
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

        $produk = Produk::select([
                            'tarif.kd_produk',
                            'produk.deskripsi',
                            'tarif.tarif',
                            'tarif.kd_unit',
                            'tarif.tgl_berakhir',
                            'tarif.tgl_berlaku'
                        ])
                        ->leftJoin('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
                        ->where('tarif.kd_unit', $kd_unit)
                        ->where('tarif.kd_tarif', 'TU')
                        // ->whereDate('tarif.tgl_berlaku','2016-05-08')
                        ->where('tarif.tgl_berlaku', '<=', Carbon::now()->toDateString())
                        ->whereIn('tarif.tgl_berlaku', function ($query) {
                            $query->select('tgl_berlaku')
                                ->from('tarif as t')
                                ->whereColumn('t.KD_PRODUK', 'tarif.kd_produk')
                                ->whereColumn('t.KD_TARIF', 'tarif.kd_tarif')
                                ->whereColumn('t.KD_UNIT', 'tarif.kd_unit')
                                ->where(function ($q) {
                                    $q->whereNull('t.Tgl_Berakhir')
                                        ->orWhere('t.Tgl_Berakhir', '>=', Carbon::now()->toDateString());
                                })
                                ->orderBy('t.tgl_berlaku', 'asc')
                                ->limit(1);
                        })
                        ->whereRaw('LEFT(produk.kd_klas, 1) = ?', ['6'])
                        ->orderBy('produk.deskripsi')
                        ->orderBy('tarif.kd_unit')
                        ->orderBy('tarif.kd_produk')
                        ->orderBy('tarif.TGL_BERLAKU', 'desc')
                        ->distinct()
                        ->get();


        $tindakan = ListTindakanPasien::with(['produk', 'ppa', 'unit'])
                                    ->where('kd_pasien', $kd_pasien)
                                    ->where('tgl_masuk', $tgl_masuk)
                                    ->where('kd_unit', $kd_unit)
                                    ->where('urut_masuk', $urut_masuk)
                                    ->get();


        $dokter = DokterInap::with(['dokter', 'unit'])
                            ->where('kd_unit', '1001')
                            ->whereRelation('dokter', 'status', 1)
                            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }


        return view('unit-pelayanan.rawat-inap.pelayanan.tindakan.index', compact(
            'dataMedis', 
            'dokter',
            'produk',
            'tindakan'
        ));
    }

    public function storeTindakan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $messageErr = [
            'tindakan.required'         => 'Tindakan harus dipilih!',
            'ppa.required'              => 'PPA harus dipilih!',
            'tgl_tindakan.required'     => 'Tanggal harus dipilih!',
            'jam_tindakan.required'     => 'Jam harus dipilih!',
            'laporan.required'          => 'Laporan tindakan harus diisi!',
            'kesimpulan.required'       => 'Kesimpulan tindakan harus diisi!',
            'gambar_tindakan.required'  => 'Gambar harus dipilih!',
            'gambar_tindakan.image'     => 'Format file gambar tindakan tidak sesuai!',
            'gambar_tindakan.max'       => 'Gambar tindakan maksimak 5 mb!'
        ];

        $request->validate([
            'tindakan'          => 'required',
            'ppa'               => 'required',
            'tgl_tindakan'      => 'required',
            'jam_tindakan'      => 'required',
            'laporan'           => 'required',
            'kesimpulan'        => 'required',
            'gambar_tindakan'   => 'required|image|file|max:5120',
        ], $messageErr);



        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                            ->join('transaksi as t', function($join) {
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

        $lastTindakanUrut = ListTindakanPasien::select(['urut_list'])
                                            ->where('kd_pasien', $kd_pasien)
                                            ->where('kd_unit', $kd_unit)
                                            ->where('tgl_masuk', $tgl_masuk)
                                            ->where('urut_masuk', $urut_masuk)
                                            ->orderBy('urut_list', 'desc')
                                            ->first();

        $urut_list = !empty($lastTindakanUrut) ? $lastTindakanUrut->urut_list + 1 : 1;

        // upload gambar tindakan
        $pathGambarTindakan = ($request->hasFile('gambar_tindakan')) ? $request->file('gambar_tindakan')->store('uploads/rawat-inap/tindakan-pasien') : '';

        // insert data tindakan
        $tindakanData = [
            'kd_pasien'         => $kd_pasien,
            'kd_unit'           => $kd_unit,
            'tgl_masuk'         => $tgl_masuk,
            'urut_masuk'        => $urut_masuk,
            'urut_list'         => $urut_list,
            'tgl_tindakan'      => $request->tgl_tindakan,
            'jam_tindakan'      => $request->jam_tindakan,
            'kd_dokter'         => $request->ppa,
            'kd_produk'         => $request->tindakan,
            'kesimpulan'        => $request->kesimpulan,
            'gambar'            => $pathGambarTindakan,
            'laporan_hasil'     => $request->laporan,
        ];

        ListTindakanPasien::create($tindakanData);


        // insert detail_transaksi

        $lastDetailTransaksiUrut = DetailTransaksi::select(['urut'])
                                            ->where('no_transaksi', $kunjungan->no_transaksi)
                                            ->orderBy('urut', 'desc')
                                            ->first();

        $urut = !empty($lastDetailTransaksiUrut) ? $lastDetailTransaksiUrut->urut + 1 : 1;

        $dataDetailTransaksi = [
            'no_transaksi'  => $kunjungan->no_transaksi,
            'kd_kasir'      => $kunjungan->kd_kasir,
            'tgl_transaksi' => $tgl_masuk,
            'urut'          => $urut,
            'kd_tarif'      => 'TU',
            'kd_produk'     => $request->tindakan,
            'kd_unit'       => $kd_unit,
            'kd_unit_tr'    => $kd_unit,
            'tgl_berlaku'   => $request->tgl_berlaku,
            'kd_user'       => $request->ppa,
            'shift'         => 0,
            'harga'         => $request->tarif_tindakan,
            'qty'           => 1,
            'flag'          => 0,
            'jns_trans'     => 0,
        ];

        DetailTransaksi::create($dataDetailTransaksi);

        return back()->with('success', 'Tindakan berhasil ditambah');
    }

    public function getTindakanAjax($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {

            $tindakan = ListTindakanPasien::with(['produk', 'ppa', 'unit'])
                                        ->select([
                                            'list_tindakan_pasien.urut_list',
                                            'list_tindakan_pasien.keterangan',
                                            'list_tindakan_pasien.tgl_tindakan',
                                            'list_tindakan_pasien.jam_tindakan',
                                            'list_tindakan_pasien.kd_dokter',
                                            'list_tindakan_pasien.status',
                                            'list_tindakan_pasien.kd_produk',
                                            'list_tindakan_pasien.kesimpulan',
                                            'list_tindakan_pasien.gambar',
                                            'list_tindakan_pasien.laporan_hasil',
                                            'dt.kd_kasir',
                                            'dt.urut',
                                            'dt.kd_unit',
                                            'dt.tgl_berlaku',
                                            'dt.harga',
                                        ])
                                        ->join('detail_transaksi as dt', function($join) {
                                            $join->on('dt.tgl_transaksi', '=', 'list_tindakan_pasien.tgl_masuk')
                                                ->on('dt.kd_unit', '=', 'list_tindakan_pasien.kd_unit')
                                                ->on('dt.kd_produk', '=', 'list_tindakan_pasien.kd_produk');
                                        })
                                        ->where('list_tindakan_pasien.kd_pasien', $kd_pasien)
                                        ->where('list_tindakan_pasien.kd_unit', $kd_unit)
                                        ->where('list_tindakan_pasien.tgl_masuk', $tgl_masuk)
                                        ->where('list_tindakan_pasien.urut_masuk', $urut_masuk)
                                        ->where('list_tindakan_pasien.urut_list', $request->urut_list)
                                        ->where('list_tindakan_pasien.kd_produk', $request->kd_produk)
                                        ->where('dt.no_transaksi', $request->no_transaksi)
                                        ->first();

            if(empty($tindakan)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan',
                    'data'      => []
                ], 200);
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'Data ditemukan',
                'data'      => $tindakan
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'        => 'error',
                'message'       => $e->getMessage(),
                'data'          => []
            ], 500);
        }
    }

    public function updateTindakan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $messageErr = [
            'tindakan.required'         => 'Tindakan harus dipilih!',
            'ppa.required'              => 'PPA harus dipilih!',
            'tgl_tindakan.required'     => 'Tanggal harus dipilih!',
            'jam_tindakan.required'     => 'Jam harus dipilih!',
            'laporan.required'          => 'Laporan tindakan harus diisi!',
            'kesimpulan.required'       => 'Kesimpulan tindakan harus diisi!',
        ];

        $rules = [
            'tindakan'          => 'required',
            'ppa'               => 'required',
            'tgl_tindakan'      => 'required',
            'jam_tindakan'      => 'required',
            'laporan'           => 'required',
            'kesimpulan'        => 'required',
        ];

        if($request->hasFile('gambar_tindakan')) {
            $rules['gambar_tindakan'] = 'required|image|file|max:5120';

            $messageErr['gambar_tindakan.required'] = 'Gambar harus dipilih!';
            $messageErr['gambar_tindakan.image'] = 'Format file gambar tindakan tidak sesuai!';
            $messageErr['gambar_tindakan.max'] = 'Gambar tindakan maksimak 5 mb!';
        }

        $request->validate($rules, $messageErr);

        $tindakan = ListTindakanPasien::where('kd_pasien', $kd_pasien)
                                    ->where('kd_unit', $kd_unit)
                                    ->whereDate('tgl_masuk', $tgl_masuk)
                                    ->where('urut_masuk', $urut_masuk)
                                    ->where('urut_list', $request->urut_list)
                                    ->first();

        // update data tindakan
        $tindakanData = [
            'tgl_tindakan'      => $request->tgl_tindakan,
            'jam_tindakan'      => $request->jam_tindakan,
            'kd_dokter'         => $request->ppa,
            'kd_produk'         => $request->tindakan,
            'kesimpulan'        => $request->kesimpulan,
            'laporan_hasil'     => $request->laporan,
        ];

        if($request->hasFile('gambar_tindakan')) {
            if (Storage::exists($tindakan->gambar)) Storage::delete($tindakan->gambar);

            // upload gambar tindakan
            $pathGambarTindakan = ($request->hasFile('gambar_tindakan')) ? $request->file('gambar_tindakan')->store('uploads/rawat-inap/tindakan-pasien') : '';
            $tindakanData['gambar'] = $pathGambarTindakan;
        }

        ListTindakanPasien::where('kd_pasien', $kd_pasien)
                        ->where('kd_unit', $kd_unit)
                        ->whereDate('tgl_masuk', $tgl_masuk)
                        ->where('urut_masuk', $urut_masuk)
                        ->where('urut_list', $request->urut_list)
                        ->update($tindakanData);


        $dataDetailTransaksi = [
            'kd_produk'     => $request->tindakan,
            'tgl_berlaku'   => $request->tgl_berlaku,
            'kd_user'       => $request->ppa,
            'harga'         => $request->tarif_tindakan,
        ];

        DetailTransaksi::where('no_transaksi', $request->no_transaksi)
                    ->where('kd_unit', $kd_unit)
                    ->where('kd_produk', $tindakan->kd_produk)
                    ->whereDate('tgl_transaksi', $tgl_masuk)
                    ->update($dataDetailTransaksi);

        return back()->with('success', 'Tindakan berhasil diubah');
    }

    public function deleteTindakan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {

            $tindakan = ListTindakanPasien::where('kd_pasien', $kd_pasien)
                                    ->where('kd_unit', $kd_unit)
                                    ->whereDate('tgl_masuk', $tgl_masuk)
                                    ->where('urut_masuk', $urut_masuk)
                                    ->where('urut_list', $request->urut_list)
                                    ->first();

            // delete tindakan
            ListTindakanPasien::where('kd_pasien', $kd_pasien)
                                    ->where('kd_unit', $kd_unit)
                                    ->whereDate('tgl_masuk', $tgl_masuk)
                                    ->where('urut_masuk', $urut_masuk)
                                    ->where('urut_list', $request->urut_list)
                                    ->delete();

            // delete detail transaksi
            DetailTransaksi::where('no_transaksi', $request->no_transaksi)
                                            ->where('kd_unit', $kd_unit)
                                            ->where('kd_produk', $tindakan->kd_produk)
                                            ->whereDate('tgl_transaksi', $tgl_masuk)
                                            ->delete();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Tindakan berhasil dihapus',
                'data'      => []
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ],500);
        }
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Produk;
use App\Models\SegalaOrder;
use App\Models\SegalaOrderDet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RadiologiController extends Controller
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
                            ->where('kunjungan.urut_masuk', $urut_masuk)
                            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                            ->first();

        $dokter = Dokter::all();

        $produk = Produk::with(['klas'])
                    ->distinct()
                    ->select('produk.kd_produk', 'produk.kp_produk', 'produk.deskripsi', 't.kd_tarif', 't.tarif', 't.kd_unit', 't.tgl_berlaku', 'produk.kd_klas')
                    ->join('tarif as t', 'produk.kd_produk', '=', 't.kd_produk')
                    ->join('tarif_cust as tc', 't.kd_tarif', '=', 'tc.kd_tarif')
                    ->where('t.kd_unit', 10013)
                    // ->where('produk.deskripsi', 'like', '%thorax%')
                    ->where('t.kd_tarif', 'TU')
                    ->where('produk.aktif', 1)
                    ->whereIn('t.tgl_berlaku', function ($query) {
                        $query->select(DB::raw('MAX(tgl_berlaku)'))
                            ->from('tarif')
                            ->whereColumn('tarif.kd_produk', 't.kd_produk')
                            ->whereColumn('tarif.kd_tarif', 't.kd_tarif')
                            ->whereColumn('tarif.kd_unit', 't.kd_unit')
                            ->where(function ($query) {
                                $query->whereNull('tarif.tgl_berakhir')
                                      ->orWhere('tarif.tgl_berakhir', '>=', '2024-10-04');
                            });
                    })
                    ->where(function ($query) {
                        $query->whereNull('t.tgl_berakhir')
                              ->orWhere('t.tgl_berakhir', '>=', '2024-10-04');
                    })
                    ->where(DB::raw('LEFT(produk.kd_klas, 2)'), '72')
                    ->orderBy('produk.deskripsi', 'asc')
                    ->orderBy('t.tgl_berlaku', 'desc')
                    ->get();

        $radList = SegalaOrder::with(['details', 'dokter'])
                                ->where('kd_pasien', $kd_pasien)
                                ->where('kategori', 'RD')
                                ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.radiologi.index',[
            'dataMedis'     => $dataMedis,
            'dokter'        => $dokter,
            'produk'        => $produk,
            'radList'       => $radList
        ]);
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {

        $valMessage = [
            'kd_dokter.required'    => 'Dokter harus dipilih!',
            'tgl_order.required'    => 'Tanggal order harus dipilih!',
            'jam_order.required'    => 'Jam order harus dipilih!',
            'cyto.required'         => 'Cito harus dipilih!',
            'puasa.required'        => 'Puasa harus dipilih!',
        ];

        $request->validate([
            'kd_dokter'     => 'required',
            'tgl_order'     => 'required',
            'jam_order'     => 'required',
            'cyto'          => 'required',
            'puasa'         => 'required',
        ], $valMessage);

        // check produk
        if(empty($request->kd_produk)) return back()->with('error', 'Produk harus di pilih minimal 1!');

        // get kunjungan data
        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'customer'])
                            ->join('transaksi as t', function($join) {
                                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                            })
                            ->where('kunjungan.kd_unit', $kd_unit)
                            ->where('kunjungan.kd_pasien', $kd_pasien)
                            ->where('kunjungan.urut_masuk', $urut_masuk)
                            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                            ->where('kunjungan.urut_masuk', $request->urut_masuk)
                            ->first();


        // get new order number
        $tglFormat = (int) Carbon::parse($tgl_masuk)->format('Ymd');

        $lastOrder = SegalaOrder::whereBetween('kd_order', [$tglFormat . '0001', $tglFormat . '9999'])
                                ->orderBy('kd_order', 'desc')
                                ->first();

        $newOrderNumber = (empty($lastOrder)) ? $tglFormat . '0001' : $lastOrder->kd_order + 1;

        // store segala order
        $segalaOrderData = [
            'kd_pasien'             => $kunjungan->kd_pasien,
            'kd_unit'               => $kunjungan->kd_unit,
            'tgl_masuk'             => $kunjungan->tgl_masuk,
            'urut_masuk'            => $kunjungan->urut_masuk,
            'kd_dokter'             => $request->kd_dokter,
            'tgl_order'             => "$request->tgl_order $request->jam_order",
            'dilayani'              => 0,
            'kategori'              => 'RD',
            'kd_order'              => (int) $newOrderNumber,
            'no_transaksi'          => $kunjungan->no_transaksi,
            'kd_kasir'              => $kunjungan->kd_kasir,
            'status_order'          => 1,
            'transaksi_penunjang'   => null,
            'cyto'                  => $request->cyto,
            'puasa'                 => $request->puasa,
            'jadwal_pemeriksaan'    => "$request->tgl_pemeriksaan $request->jam_pemeriksaan",
            'diagnosis'             => $request->diagnosis
        ];

        SegalaOrder::create($segalaOrderData);

        // store segala order detail
        $noUrut = 1;
        $kdProduk = $request->kd_produk;

        foreach($kdProduk as $prd) {
            $detailData = [
                'kd_order'      => $newOrderNumber,
                'urut'          => $noUrut,
                'kd_produk'     => $prd,
                'jumlah'        => 1,
                'status'        => 0,
                'kd_dokter'     => $request->kd_dokter
            ];

            SegalaOrderDet::create($detailData);
            $noUrut++;
        }

        return back()->with('success', 'Order berhasil');
    }

    public function getRadDetailAjax(Request $request)
    {
        try {
            $kdOrder = $request->kd_order;

            $order = SegalaOrder::with(['dokter'])
                                ->where('kd_order', $kdOrder)
                                ->first();

            $orderDet = SegalaOrderDet::with(['produk'])
                                        ->where('kd_order', $kdOrder)
                                        ->get();

            if(!empty($order) && !empty($orderDet)) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data ditemukan',
                    'data'      => [
                        'order'         => $order,
                        'order_detail'  => $orderDet
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan',
                    'data'      => []
                ], 204);
            }

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {

        $valMessage = [
            'kd_dokter.required'    => 'Dokter harus dipilih!',
            'tgl_order.required'    => 'Tanggal order harus dipilih!',
            'jam_order.required'    => 'Jam order harus dipilih!',
            'cyto.required'         => 'Cito harus dipilih!',
            'puasa.required'        => 'Puasa harus dipilih!',
        ];

        $request->validate([
            'kd_dokter'     => 'required',
            'tgl_order'     => 'required',
            'jam_order'     => 'required',
            'cyto'          => 'required',
            'puasa'         => 'required',
        ], $valMessage);

        // check produk
        if(empty($request->kd_produk)) return back()->with('error', 'Produk harus di pilih minimal 1!');
        if(empty($request->kd_order)) return back()->with('error', 'Order gagal di pilih!');

        // get kunjungan data
        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'customer'])
                            ->join('transaksi as t', function($join) {
                                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                            })
                            ->where('kunjungan.kd_unit', $kd_unit)
                            ->where('kunjungan.kd_pasien', $kd_pasien)
                            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                            ->where('kunjungan.urut_masuk', $urut_masuk)
                            ->first();


        // update order
        $order = SegalaOrder::where('kd_order', $request->kd_order)
                            ->first();

        $order->kd_dokter = $request->kd_dokter;
        $order->tgl_order = "$request->tgl_order $request->jam_order";
        $order->cyto = $request->cyto;
        $order->puasa = $request->puasa;
        $order->diagnosis = $request->diagnosis;
        $order->jadwal_pemeriksaan = "$request->tgl_pemeriksaan $request->jam_pemeriksaan";
        $order->save();

        // update order detail
        SegalaOrderDet::where('kd_order', $request->kd_order)->delete();
        $noUrut = 1;
        $kdProduk = $request->kd_produk;

        foreach($kdProduk as $prd) {
            $detailData = [
                'kd_order'      => $order->kd_order,
                'urut'          => $noUrut,
                'kd_produk'     => $prd,
                'jumlah'        => 1,
                'status'        => 0,
                'kd_dokter'     => $request->kd_dokter
            ];

            SegalaOrderDet::create($detailData);
            $noUrut++;
        }

        return back()->with('success', 'Order berhasil di ubah');
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            $kdOrder = $request->kd_order;

            // delete
            SegalaOrder::where('kd_order', $kdOrder)->delete();
            SegalaOrderDet::where('kd_order', $kdOrder)->delete();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Order berhasil dihapus',
                'data'      => []
            ],200);
            
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ],500);
        }
    }
}

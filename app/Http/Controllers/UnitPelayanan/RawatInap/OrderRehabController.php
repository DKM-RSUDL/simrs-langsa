<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\DokterSpesial;
use App\Models\OrderRehabMedik;
use App\Models\Produk;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderRehabController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->baseService = new BaseService();
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // get data kunjungan
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (empty($dataMedis)) abort(404, 'Data kunjungan tidak ditemukan');

        // get data order
        $orders = OrderRehabMedik::with(['produk', 'dokter', 'userCreate'])
            ->where('kd_kasir_asal', $dataMedis->kd_kasir)
            ->where('no_transaksi_asal', $dataMedis->no_transaksi)
            ->orderBy('tgl_order', 'desc')
            ->orderBy('jam_order', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.rehab.index', compact('dataMedis', 'orders'));
    }

    private function getProduct()
    {
        $today = date('Y-m-d');

        $produk = Produk::select([
            'tarif.kd_produk',
            'produk.deskripsi',
            'tarif.tarif',
            'tarif.kd_unit',
            'tarif.tgl_berakhir',
            'tarif.tgl_berlaku'
        ])
            ->leftJoin('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
            ->where('tarif.kd_unit', '74')
            ->where('tarif.kd_tarif', 'TU')
            // ->whereDate('tarif.tgl_berlaku','2016-05-08')
            ->whereDate('tarif.tgl_berlaku', '<=', $today)
            ->whereIn('tarif.tgl_berlaku', function ($query) use ($today) {
                $query->select('tgl_berlaku')
                    ->from('tarif as t')
                    ->whereColumn('t.KD_PRODUK', 'tarif.kd_produk')
                    ->whereColumn('t.KD_TARIF', 'tarif.kd_tarif')
                    ->whereColumn('t.KD_UNIT', 'tarif.kd_unit')
                    ->where(function ($q) use ($today) {
                        $q->whereNull('t.Tgl_Berakhir')
                            ->orWhereDate('t.Tgl_Berakhir', '>=', $today);
                    })
                    ->orderBy('t.tgl_berlaku', 'asc')
                    ->limit(1);
            })
            ->whereRaw('LEFT(produk.kd_klas, 2) = ?', ['74'])
            ->where('produk.aktif', 1)
            ->orderBy('produk.deskripsi')
            ->orderBy('tarif.kd_unit')
            ->orderBy('tarif.kd_produk')
            ->orderBy('tarif.TGL_BERLAKU', 'desc')
            ->distinct()
            ->get();

        return $produk;
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (empty($dataMedis)) abort(404, 'Data kunjungan tidak ditemukan');

        $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (empty($nginap)) abort(404, 'Data Inap tidak ditemukan');

        $products = $this->getProduct();


        $dokter = DokterSpesial::with(['dokter'])
            ->where('kd_spesial', 20)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.rehab.create', compact('dataMedis', 'nginap', 'products', 'dokter'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan');

            $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($nginap)) throw new Exception('Data Inap tidak ditemukan');


            // cek order aktif
            $orderAktif = OrderRehabMedik::where('kd_kasir_asal', $dataMedis->kd_kasir)
                ->where('no_transaksi_asal', $dataMedis->no_transaksi)
                ->whereIn('status', [0, 1])
                ->count();

            if ($orderAktif > 0) throw new Exception('Terdapat order rehabilitasi medik aktif pada pasien ini !');


            // store order_rehab
            $orderData = [
                'kd_kasir_asal' => $dataMedis->kd_kasir,
                'no_transaksi_asal' => $dataMedis->no_transaksi,
                'kd_unit_order' => $nginap->kd_unit_kamar,
                'tgl_order' => $request->tgl_order,
                'jam_order' => $request->jam_order,
                'status'    => 0,
                'kd_produk' => $request->kd_produk,
                'kd_dokter' => $request->kd_dokter,
                'user_create' => Auth::user()->kd_karyawan
            ];

            OrderRehabMedik::create($orderData);

            DB::commit();
            return to_route('rawat-inap.order-rehab.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk])->with('success', 'Order Rehab Medik berhasil dibuat');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idHash)
    {
        $id = decrypt($idHash);
        $order = OrderRehabMedik::find($id);
        if (empty($order)) abort(404, 'Data order tidak ditemukan');

        if (in_array($order->status, [1, '1', 2, '2'])) {
            return back()->with('error', 'Order Rehab Medik yang sudah diproses tidak dapat diubah');
        }

        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (empty($dataMedis)) abort(404, 'Data kunjungan tidak ditemukan');

        $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (empty($nginap)) abort(404, 'Data Inap tidak ditemukan');

        $products = $this->getProduct();

        $dokter = DokterSpesial::with(['dokter'])
            ->where('kd_spesial', 20)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.rehab.edit', compact('dataMedis', 'nginap', 'products', 'dokter', 'order'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idHash, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idHash);
            $order = OrderRehabMedik::find($id);
            if (empty($order)) throw new Exception('Data order tidak ditemukan');

            if (in_array($order->status, [1, '1', 2, '2'])) {
                throw new Exception('Order Rehab Medik yang sudah diproses tidak dapat diubah');
            }

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan');

            $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($nginap)) throw new Exception('Data Inap tidak ditemukan');


            // update order_rehab
            $order->tgl_order = $request->tgl_order;
            $order->jam_order = $request->jam_order;
            $order->kd_produk = $request->kd_produk;
            $order->kd_dokter = $request->kd_dokter;
            $order->user_edit = Auth::user()->kd_karyawan;
            $order->save();

            DB::commit();
            return to_route('rawat-inap.order-rehab.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk])->with('success', 'Order Rehab Medik berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idHash)
    {
        $id = decrypt($idHash);
        $order = OrderRehabMedik::find($id);
        if (empty($order)) abort(404, 'Data order tidak ditemukan');

        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (empty($dataMedis)) abort(404, 'Data kunjungan tidak ditemukan');

        return view('unit-pelayanan.rawat-inap.pelayanan.order.rehab.show', compact('dataMedis', 'order'));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idHash, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idHash);
            $order = OrderRehabMedik::find($id);
            if (empty($order)) throw new Exception('Data order tidak ditemukan');

            if (in_array($order->status, [1, '1', 2, '2'])) {
                throw new Exception('Order Rehab Medik yang sudah diproses tidak dapat diubah');
            }

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan');

            // delete order_rehab
            $order->delete();

            DB::commit();
            return to_route('rawat-inap.order-rehab.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk])->with('success', 'Order Rehab Medik berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}

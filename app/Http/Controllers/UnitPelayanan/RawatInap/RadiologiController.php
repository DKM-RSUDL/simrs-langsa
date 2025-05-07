<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DokterInap;
use App\Models\Kunjungan;
use App\Models\Produk;
use App\Models\RadHasil;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SegalaOrder;
use App\Models\SegalaOrderDet;
use App\Models\UnitAsal;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RadiologiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        // get tab
        $tabContent = $request->query('tab');

        if ($tabContent == 'hasil') {
            return $this->hasilTabs($kd_unit, $dataMedis, $request);
        } else {
            return $this->orderTabs($kd_unit, $dataMedis, $request);
        }
    }

    private function orderTabs($kd_unit, $dataMedis, $request)
    {
        $dokter = DokterInap::with(['dokter', 'unit'])
            ->where('kd_unit', '1001')
            ->whereRelation('dokter', 'status', 1)
            ->get();

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

        $search = $request->input('search');
        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $radList = SegalaOrder::with(['details', 'dokter'])
            // filter data per periode to anas
            ->when($periode && $periode !== 'semua', function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_order', $now->year)
                            ->whereMonth('tgl_order', $now->month);
                    case 'option2':
                        return $query->where('tgl_order', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_order', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_order', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_order', '>=', $now->subMonths(9));
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_order', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_order', '<=', $endDate);
            })
            ->when($search, function ($query, $search) {
                $search = strtolower($search);
                if (is_numeric($search) && strlen($search) > 3) {
                    return $query->where('kd_order', $search);
                }
                return $query->whereRaw('LOWER(kd_order) like ?', ["%$search%"])
                    ->orWhereHas('dokter', function ($q) use ($search) {
                        $q->whereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                    });
            })
            // end filter
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('kategori', 'RD')
            ->orderBy('kd_order', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.radiologi.index', [
            'dataMedis'     => $dataMedis,
            'dokter'        => $dokter,
            'produk'        => $produk,
            'radList'       => $radList
        ]);
    }

    private function hasilTabs($kd_unit, $dataMedis, $request)
    {
        // get data trx radiologi by trx unit asal
        $unitAsal = UnitAsal::where('no_transaksi_asal', $dataMedis->no_transaksi)
            ->where('kd_kasir_asal', $dataMedis->kd_kasir)
            ->where('kd_kasir', '09')
            ->get();

        // get data transaksi rad
        $dataTransaksi = [];

        foreach ($unitAsal as $ua) {
            $dataRadHasil = RadHasil::select([
                't.kd_pasien',
                't.kd_unit',
                't.tgl_transaksi',
                't.urut_masuk',
                'rad_hasil.urut',
                'k.kd_dokter',
                'd.nama_lengkap as nama_dokter',
                'rad_hasil.kd_test as kd_produk',
                'p.deskripsi as nama_produk',
                'rad_hasil.hasil',
                'rad_hasil.kd_alat',
                'rad_hasil.accession_number',
            ])
                ->join('transaksi as t', function ($q) {
                    $q->on('rad_hasil.kd_pasien', '=', 't.kd_pasien');
                    $q->on('rad_hasil.kd_unit', '=', 't.kd_unit');
                    $q->on('rad_hasil.tgl_masuk', '=', 't.tgl_transaksi');
                    $q->on('rad_hasil.urut_masuk', '=', 't.urut_masuk');
                })
                ->join('kunjungan as k', function ($q) {
                    $q->on('k.kd_pasien', '=', 't.kd_pasien');
                    $q->on('k.kd_unit', '=', 't.kd_unit');
                    $q->on('k.tgl_masuk', '=', 't.tgl_transaksi');
                    $q->on('k.urut_masuk', '=', 't.urut_masuk');
                })
                ->join('dokter as d', 'd.kd_dokter', '=', 'k.kd_dokter')
                ->join('produk as p', 'p.kd_produk', '=', 'rad_hasil.kd_test')
                ->where('t.no_transaksi', $ua->no_transaksi)
                ->where('t.kd_kasir', $ua->kd_kasir)
                ->where('rad_hasil.kd_pasien', $dataMedis->kd_pasien)
                ->where('rad_hasil.kd_unit', 5)
                ->get()
                ->toArray();

            foreach ($dataRadHasil as $rh) {
                array_push($dataTransaksi, $rh);
            }
        }

        // get pacs url
        for ($i = 0; $i < count($dataTransaksi); $i++) {
            // get pacs
            $trx = $dataTransaksi[$i];
            $pacs = '';

            if (!empty($trx['accession_number'])) {
                $response = Http::post('https://e-rsudlangsa.id/api/pacs/get_order', ['acc' => intval($trx['accession_number'])]);
                $result = $response->json();

                if (isset($result['data']['UrlLink'])) $pacs = $result['data']['UrlLink'];
            }

            $dataTransaksi[$i]['pacs'] = $pacs;
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.radiologi.hasil-tab', compact(
            'dataMedis',
            'dataTransaksi'
        ));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {

        $valMessage = [
            'kd_dokter.required'    => 'Dokter harus dipilih!',
            'tgl_order.required'    => 'Tanggal order harus dipilih!',
            'jam_order.required'    => 'Jam order harus dipilih!',
            'cyto.required'         => 'Cito harus dipilih!',
            // 'puasa.required'        => 'Puasa harus dipilih!',
        ];

        $request->validate([
            'kd_dokter'     => 'required',
            'tgl_order'     => 'required',
            'jam_order'     => 'required',
            'cyto'          => 'required',
            // 'puasa'         => 'required',
        ], $valMessage);

        // check produk
        if (empty($request->kd_produk)) return back()->with('error', 'Produk harus di pilih minimal 1!');

        DB::beginTransaction();

        try {

            // get kunjungan data
            $kunjungan = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->join('transaksi as t', function ($join) {
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

            $jadwalPemeriksaan = null;

            if (!empty($request->tgl_pemeriksaan) && !empty($request->jam_pemeriksaan)) $jadwalPemeriksaan = "$request->tgl_pemeriksaan $request->jam_pemeriksaan";

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
                'puasa'                 => 0,
                'jadwal_pemeriksaan'    => $jadwalPemeriksaan,
                'diagnosis'             => $request->diagnosis
            ];

            SegalaOrder::create($segalaOrderData);

            // store segala order detail
            $noUrut = 1;
            $kdProduk = $request->kd_produk;

            foreach ($kdProduk as $prd) {
                $detailData = [
                    'kd_order'      => $newOrderNumber,
                    'urut'          => $noUrut,
                    'kd_produk'     => $prd,
                    'jumlah'        => 1,
                    'status'        => 0,
                    'kd_dokter'     => 466
                ];

                SegalaOrderDet::create($detailData);
                $noUrut++;
            }

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            DB::commit();
            return back()->with('success', 'Order berhasil');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
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

            if (!empty($order) && !empty($orderDet)) {
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
                ], 200);
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
            // 'puasa.required'        => 'Puasa harus dipilih!',
        ];

        $request->validate([
            'kd_dokter'     => 'required',
            'tgl_order'     => 'required',
            'jam_order'     => 'required',
            'cyto'          => 'required',
            // 'puasa'         => 'required',
        ], $valMessage);

        // check produk
        if (empty($request->kd_produk)) return back()->with('error', 'Produk harus di pilih minimal 1!');
        if (empty($request->kd_order)) return back()->with('error', 'Order gagal di pilih!');

        DB::beginTransaction();

        try {

            // get kunjungan data
            $kunjungan = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->join('transaksi as t', function ($join) {
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

            $jadwalPemeriksaan = null;
            if (!empty($request->tgl_pemeriksaan) && !empty($request->jam_pemeriksaan)) $jadwalPemeriksaan = "$request->tgl_pemeriksaan $request->jam_pemeriksaan";

            $order->kd_dokter = $request->kd_dokter;
            $order->tgl_order = "$request->tgl_order $request->jam_order";
            $order->cyto = $request->cyto;
            // $order->puasa = $request->puasa;
            $order->diagnosis = $request->diagnosis;
            $order->jadwal_pemeriksaan = $jadwalPemeriksaan;
            $order->save();

            // update order detail
            SegalaOrderDet::where('kd_order', $request->kd_order)->delete();
            $noUrut = 1;
            $kdProduk = $request->kd_produk;

            foreach ($kdProduk as $prd) {
                $detailData = [
                    'kd_order'      => $order->kd_order,
                    'urut'          => $noUrut,
                    'kd_produk'     => $prd,
                    'jumlah'        => 1,
                    'status'        => 0,
                    'kd_dokter'     => 466
                ];

                SegalaOrderDet::create($detailData);
                $noUrut++;
            }

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            DB::commit();
            return back()->with('success', 'Order berhasil di ubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {

            $kdOrder = $request->kd_order;

            // delete
            SegalaOrder::where('kd_order', $kdOrder)->delete();
            SegalaOrderDet::where('kd_order', $kdOrder)->delete();

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Order berhasil dihapus',
                'data'      => []
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }


    public function createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (empty($resume)) {
            $resumeData = [
                'kd_pasien'     => $kd_pasien,
                'kd_unit'       => $kd_unit,
                'tgl_masuk'     => $tgl_masuk,
                'urut_masuk'    => $urut_masuk,
                'status'        => 0
            ];

            $newResume = RMEResume::create($resumeData);
            $newResume->refresh();

            // create resume detail
            $resumeDtlData = [
                'id_resume'     => $newResume->id
            ];

            RmeResumeDtl::create($resumeDtlData);
        } else {
            // get resume dtl
            $resumeDtl = RmeResumeDtl::where('id_resume', $resume->id)->first();
            $resumeDtlData = [
                'id_resume'     => $resume->id
            ];

            if (empty($resumeDtl)) RmeResumeDtl::create($resumeDtlData);
        }
    }
}
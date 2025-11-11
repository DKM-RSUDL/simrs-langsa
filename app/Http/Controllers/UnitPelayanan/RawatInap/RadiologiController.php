<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\Dokter;
use App\Models\DokterInap;
use App\Models\Kunjungan;
use App\Models\MrAnamnesis;
use App\Models\Produk;
use App\Models\RadHasil;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SegalaOrder;
use App\Models\SegalaOrderDet;
use App\Models\SjpKunjungan;
use App\Models\Transaksi;
use App\Models\Unit;
use App\Models\UnitAsal;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RadiologiController extends Controller
{
    private $baseService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // get tab
        $tabContent = $request->query('tab');

        $radiologiIGD = $this->getDataIGD($dataMedis);

        if ($tabContent == 'hasil') {
            return $this->hasilTabs($kd_unit, $dataMedis, $radiologiIGD, $request);
        } else {
            return $this->orderTabs($kd_unit, $dataMedis, $radiologiIGD, $request);
        }
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

        $validatedData = $request->validate([
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
            $tglOrder = (int) Carbon::parse($tgl_masuk)->format('Ymd');

            $lastOrder = SegalaOrder::where('kd_order', 'like', $tglOrder . '%')
                ->orderBy('kd_order', 'desc')
                ->first();

            $newOrderNumber = $lastOrder ? ((int)substr($lastOrder->kd_order, -4)) + 1 : 1;
            $newOrderNumber = str_pad((string)$newOrderNumber, 4, '0', STR_PAD_LEFT);
            $newOrderNumber = $tglOrder . $newOrderNumber;

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

    private function orderTabs($kd_unit, $dataMedis, $radiologiIGD, $request)
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
            'radList'       => $radList,
            'radiologiIGD'  => $radiologiIGD
        ]);
    }

    private function hasilTabs($kd_unit, $dataMedis, $radiologiIGD, $request)
    {
        // Dapatkan data radiologi menggunakan query yang lengkap
        $dataRadiologi = $this->getRadiologyResults(
            $dataMedis->kd_pasien,
            $dataMedis->tgl_masuk,
            $dataMedis->urut_masuk
        );

        // get data trx radiologi by trx unit asal (untuk data yang berasal dari unit lain)
        $unitAsal = UnitAsal::where('no_transaksi_asal', $dataMedis->no_transaksi)
            ->where('kd_kasir_asal', $dataMedis->kd_kasir)
            ->where('kd_kasir', '09')
            ->get();

        // get data transaksi rad dari unit asal menggunakan Eloquent
        $dataTransaksi = [];

        foreach ($unitAsal as $ua) {
            $dataRadHasil = RadHasil::with([
                'produk.klas',
                'kunjungan.dokter'
            ])
                ->whereHas('kunjungan.transaksi', function ($query) use ($ua) {
                    $query->where('no_transaksi', $ua->no_transaksi)
                        ->where('kd_kasir', $ua->kd_kasir);
                })
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', 5)
                ->get()
                ->map(function ($item) {
                    return [
                        'kd_pasien' => $item->kd_pasien,
                        'kd_unit' => $item->kd_unit,
                        'tgl_transaksi' => $item->tgl_masuk,
                        'urut_masuk' => $item->urut_masuk,
                        'urut' => $item->urut,
                        'kd_dokter' => $item->kunjungan->dokter->kd_dokter ?? null,
                        'nama_dokter' => $item->kunjungan->dokter->nama_lengkap ?? null,
                        'kd_produk' => $item->kd_test,
                        'nama_produk' => $item->produk->deskripsi ?? null,
                        'hasil' => $item->hasil,
                        'kd_alat' => $item->kd_alat,
                        'accession_number' => $item->accession_number,
                        'klasifikasi' => $item->produk->klas->klasifikasi ?? null
                    ];
                })
                ->toArray();

            $dataTransaksi = array_merge($dataTransaksi, $dataRadHasil);
        }

        // get pacs url untuk data dari unit asal
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

        // get pacs url untuk data radiologi lengkap
        $dataRadiologi = $dataRadiologi->map(function ($item) {
            $pacs = '';
            if (!empty($item->ACCESSION_NUMBER)) {
                $response = Http::post('https://e-rsudlangsa.id/api/pacs/get_order', ['acc' => intval($item->ACCESSION_NUMBER)]);
                $result = $response->json();

                if (isset($result['data']['UrlLink'])) {
                    $pacs = $result['data']['UrlLink'];
                }
            }
            $item->pacs = $pacs;
            return $item;
        });

        return view('unit-pelayanan.rawat-inap.pelayanan.radiologi.hasil-tab', compact(
            'dataMedis',
            'dataTransaksi',
            'dataRadiologi'
        ));
    }


    // === Get Data IGD ===
    private function getDataIGD($dataMedis)
    {
        $dataRadiologi = [];

        // GET ASAL IGD
        $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)->where('no_transaksi', $dataMedis->no_transaksi)->first();

        if (!empty($asalIGD)) {
            $kunjunganIGD = $this->baseService->getDataMedisbyTransaksi($asalIGD->kd_kasir_asal, $asalIGD->no_transaksi_asal);

            // Get main data
            $dataRadiologi = SegalaOrder::with(['details', 'laplisitempemeriksaan', 'dokter', 'produk', 'unit'])
                ->where('kategori', 'RD')
                ->where('kd_pasien', $kunjunganIGD->kd_pasien)
                ->where('tgl_masuk', $kunjunganIGD->tgl_transaksi)
                ->where('urut_masuk', $kunjunganIGD->urut_masuk)
                ->where('kd_unit', $kunjunganIGD->kd_unit)
                ->orderBy('tgl_order', 'desc')
                ->paginate(10);

            // Transform the data to include lab results
            $dataRadiologi->getCollection()->transform(function ($item) {
                $labResults = $this->getRadioData(
                    $item->kd_order,
                    $item->kd_pasien,
                    $item->tgl_masuk,
                    $item->kd_unit,
                    $item->urut_masuk
                );

                $item->labResults = $labResults;
                return $item;
            });
        }

        return $dataRadiologi;
    }

    protected function getRadioData($kd_order, $kd_pasien, $tgl_masuk, $kd_unit, $urut_masuk)
    {

        $results = DB::table('SEGALA_ORDER as so')
            ->select([
                'so.kd_order',
                'so.kd_pasien',
                'so.tgl_order',
                'so.tgl_masuk',
                'sod.kd_produk',
                'p.deskripsi as nama_produk',
                'kp.klasifikasi',
                'lt.item_test',
                'sod.jumlah',
                'sod.status',
                'lh.hasil',
                'lh.satuan',
                'lh.nilai_normal',
                'lh.tgl_masuk',
                'lh.KD_UNIT',
                'lh.URUT_MASUK',
                'lt.kd_test'
            ])
            ->join('SEGALA_ORDER_DET as sod', 'so.kd_order', '=', 'sod.kd_order')
            ->join('PRODUK as p', 'sod.kd_produk', '=', 'p.kp_produk')
            ->join('KLAS_PRODUK as kp', 'p.kd_klas', '=', 'kp.kd_klas')
            ->join('LAB_HASIL as lh', function ($join) {
                // $join->on('sod.kd_produk', '=', 'lh.kd_produk')
                $join->on('p.kd_produk', '=', 'lh.kd_produk')
                    ->on('so.kd_pasien', '=', 'lh.kd_pasien')
                    ->on('so.tgl_masuk', '=', 'lh.tgl_masuk');
            })
            ->join('LAB_TEST as lt', function ($join) {
                $join->on('lh.kd_lab', '=', 'lt.kd_lab')
                    ->on('lh.kd_test', '=', 'lt.kd_test');
            })
            ->where([
                'so.tgl_masuk' => $tgl_masuk,
                'so.kd_order' => $kd_order,
                'so.kd_pasien' => $kd_pasien,
                'so.kd_unit'    => $kd_unit,
                'so.urut_masuk' => $urut_masuk
            ])
            ->orderBy('lt.kd_test')
            ->get();

        // Mengelompokkan hasil berdasarkan nama produk
        $groupedResults = collect($results)->groupBy('klasifikasi')->map(function ($group) {
            return $group->map(function ($item) {
                return [
                    'item_test' => $item->item_test ?? '-',
                    'hasil' => $item->hasil ?? '-',
                    'satuan' => $item->satuan ?? '',
                    'nilai_normal' => $item->nilai_normal ?? '-',
                    'kd_test' => $item->kd_test
                ];
            });
        });

        return $groupedResults;
    }

    /**
     * Get comprehensive radiology results using Eloquent ORM
     * Simplified version using available relationships
     */
    protected function getRadiologyResults($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $results = RadHasil::with([
            'radTest',
            'produk.klas',
            'pasien'
        ])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('kd_test')
            ->get();

        // Transform the data to match the expected format
        $transformedResults = $results->map(function ($item) {
            // Get additional data using separate queries for complex joins
            $kunjungan = Kunjungan::with(['dokter', 'unit'])
                ->where('kd_pasien', $item->kd_pasien)
                ->where('kd_unit', $item->kd_unit)
                ->where('tgl_masuk', $item->tgl_masuk)
                ->where('urut_masuk', $item->urut_masuk)
                ->first();

            // Get unit asal data
            $unitAsal = null;
            $dokterPoli = null;
            $poli = null;
            $sjp = null;
            $noTransaksi = null;

            if ($kunjungan) {
                $transaksi = Transaksi::where('kd_pasien', $kunjungan->kd_pasien)
                    ->where('kd_unit', $kunjungan->kd_unit)
                    ->where('tgl_transaksi', $kunjungan->tgl_masuk)
                    ->where('urut_masuk', $kunjungan->urut_masuk)
                    ->first();

                if ($transaksi) {
                    $noTransaksi = $transaksi->no_transaksi;

                    $unitAsal = UnitAsal::where('kd_kasir', $transaksi->kd_kasir)
                        ->where('no_transaksi', $transaksi->no_transaksi)
                        ->first();

                    if ($unitAsal) {
                        $transaksiAsal = Transaksi::where('no_transaksi', $unitAsal->no_transaksi_asal)
                            ->where('kd_kasir', $unitAsal->kd_kasir_asal)
                            ->first();

                        if ($transaksiAsal) {
                            $kunjunganAsal = Kunjungan::with(['dokter'])
                                ->where('kd_pasien', $transaksiAsal->kd_pasien)
                                ->where('kd_unit', $transaksiAsal->kd_unit)
                                ->where('tgl_masuk', $transaksiAsal->tgl_transaksi)
                                ->where('urut_masuk', $transaksiAsal->urut_masuk)
                                ->first();

                            if ($kunjunganAsal) {
                                $dokterPoli = $kunjunganAsal->dokter->nama ?? null;

                                $unit = Unit::where('kd_unit', $transaksiAsal->kd_unit)->first();
                                $poli = $unit->nama_unit ?? null;

                                // Get SJP data
                                $sjpData = SjpKunjungan::where('kd_pasien', $transaksiAsal->kd_pasien)
                                    ->where('kd_unit', $transaksiAsal->kd_unit)
                                    ->where('tgl_masuk', $transaksiAsal->tgl_transaksi)
                                    ->where('urut_masuk', $transaksiAsal->urut_masuk)
                                    ->first();
                                $sjp = $sjpData->no_sjp ?? null;

                                // Get anamnesis data
                                $anamnesis = MrAnamnesis::where('kd_pasien', $transaksiAsal->kd_pasien)
                                    ->where('kd_unit', $transaksiAsal->kd_unit)
                                    ->where('tgl_masuk', $transaksiAsal->tgl_transaksi)
                                    ->where('urut_masuk', $transaksiAsal->urut_masuk)
                                    ->orderBy('urut', 'desc')
                                    ->first();
                            }
                        }
                    }
                }
            }

            $keluhan = null;
            if (isset($anamnesis) && ($anamnesis->anamnesis || $anamnesis->dd)) {
                $keluhan = "- anamnesis : " . ($anamnesis->anamnesis ?? '') . "\n" .
                    "- diagnosa banding : " . ($anamnesis->dd ?? '');
            }

            return (object) [
                'no_asuransi' => $item->pasien->no_asuransi ?? null,
                'NO_SJP' => $sjp,
                'Klasifikasi' => $item->produk->klas->klasifikasi ?? null,
                'deskripsi' => $item->produk->deskripsi ?? null,
                'hasil' => $item->hasil,
                'TGL_MASUK' => $item->tgl_masuk,
                'nama' => $item->pasien->nama ?? null,
                'kd_pasien' => $item->kd_pasien,
                'jenis_kelamin' => $item->pasien->jenis_kelamin ?? null,
                'Tgl_Lahir' => $item->pasien->tgl_lahir ?? null,
                'alamat' => $item->pasien->alamat ?? null,
                'dokter' => $kunjungan->dokter->nama ?? null,
                'poli' => $poli,
                'dokterPoli' => $dokterPoli,
                'No_transaksi' => $noTransaksi,
                'keluhan' => $keluhan,
                'ACCESSION_NUMBER' => $item->accession_number ? (string) $item->accession_number : null,
                'kd_test' => $item->kd_test,
                'urut_rad' => $item->urut,
                'kd_unit_rad' => $item->kd_unit
            ];
        });

        return collect($transformedResults);
    }
}

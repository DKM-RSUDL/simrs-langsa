<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\Dokter;
use App\Models\DokterInap;
use App\Models\Kunjungan;
use App\Models\LapLisItemPemeriksaan;
use App\Models\Otoritas;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SegalaOrder;
use App\Models\SegalaOrderDet;
use App\Models\Transaksi;
use App\Models\UnitAsal;
use App\Services\BaseService;
use App\Services\CheckResumeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RawatInapLabPatologiKlinikController extends Controller
{
    protected $checkResumeService;
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->checkResumeService = new CheckResumeService();
        $this->baseService = new BaseService();
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $DataLapPemeriksaan = LapLisItemPemeriksaan::with('produk')
            ->select('kategori', 'kd_produk')
            ->get()
            ->groupBy('kategori');

        // $dataDokter = Dokter::where('status', 1)->get();

        $dataDokter = DokterInap::with(['dokter', 'unit'])
            ->where('kd_unit', '1001')
            ->whereRelation('dokter', 'status', 1)
            ->get();

        // ambil Diagnosis dari emr_resume
        $dataDiagnosis = RMEResume::with(['kunjungan'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->orderBy('tgl_masuk', 'desc')
            ->first();

        // Jika data ada, ambil nilai array diagnosis
        $diagnosisList = [];
        if ($dataDiagnosis && is_array($dataDiagnosis->diagnosis)) {
            $diagnosisList = array_map(function ($item) {
                return trim($item, '"[]');
            }, $dataDiagnosis->diagnosis);
        }

        $search = $request->input('search');
        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $search = $request->input('search');
        $dataLabor = SegalaOrder::with(['details', 'laplisitempemeriksaan', 'dokter', 'produk', 'unit', 'produk.labHasil'])
            ->when($periode, function ($query) use ($periode) {
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
                    default:
                        return $query;
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
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->orderBy('tgl_order',  'desc')
            ->paginate(10);

        // Transform the data to include lab results
        $dataLabor->getCollection()->transform(function ($item) {
            $labResults = $this->getLabData(
                $item->kd_order,
                $item->kd_pasien,
                $item->tgl_masuk,
                $item->kd_unit,
                $item->urut_masuk
            );

            $item->labResults = $labResults;
            return $item;
        });

        $laborIGD = $this->getDataIGD($dataMedis);

        return view('unit-pelayanan.rawat-inap.pelayanan.labor.index', compact(
            'dataMedis',
            'DataLapPemeriksaan',
            'dataDokter',
            'dataLabor',
            'dataDiagnosis',
            'diagnosisList',
            'laborIGD'
        ));
    }

    private function getDataIGD($dataMedis)
    {
        $dataLabor = [];

        // GET ASAL IGD
        $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)->where('no_transaksi', $dataMedis->no_transaksi)->first();

        if (!empty($asalIGD)) {
            $kunjunganIGD = $this->baseService->getDataMedisbyTransaksi($asalIGD->kd_kasir_asal, $asalIGD->no_transaksi_asal);

            // Get main data
            $dataLabor = SegalaOrder::with(['details', 'laplisitempemeriksaan', 'dokter', 'produk', 'unit'])
                ->where('kategori', 'LB')
                ->where('kd_pasien', $kunjunganIGD->kd_pasien)
                ->where('tgl_masuk', $kunjunganIGD->tgl_transaksi)
                ->where('urut_masuk', $kunjunganIGD->urut_masuk)
                ->where('kd_unit', $kunjunganIGD->kd_unit)
                ->orderBy('tgl_order', 'desc')
                ->paginate(10);

            // Transform the data to include lab results
            $dataLabor->getCollection()->transform(function ($item) {
                $labResults = $this->getLabData(
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

        return $dataLabor;
    }

    // hasil data raboratorium
    protected function getLabData($kd_order, $kd_pasien, $tgl_masuk, $kd_unit, $urut_masuk)
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

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
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

        return view('unit-pelayanan.rawat-inap.pelayanan.labor.createpk', compact('kd_pasien', 'tgl_masuk'));
    }

    function generateNoOrder($tglMasuk)
    {
        // Pastikan $tglMasuk berupa Carbon atau tanggal yang valid
        $tanggal = Carbon::parse($tglMasuk)->format('Y-m-d');

        // Ambil data terakhir berdasarkan tanggal masuk
        $lastOrder = SegalaOrder::whereDate('tgl_masuk', $tanggal)
            ->orderByDesc('kd_order')
            ->first();

        // Format dasar tanggal: yyyyMMdd
        $prefix = Carbon::parse($tglMasuk)->format('Ymd');

        if (!$lastOrder) {
            // Jika belum ada data untuk tanggal tersebut
            $noOrder = $prefix . '0001';
        } else {
            // Ambil KD_ORDER terakhir
            $lastKdOrder = $lastOrder->kd_order;

            // Jika prefix berbeda dengan tanggal saat ini, reset ke 0001
            if (substr($lastKdOrder, 0, 8) !== $prefix) {
                $noOrder = $prefix . '0001';
            } else {
                // Tambah 1 dari KD_ORDER terakhir
                $noOrder = str_pad($lastKdOrder + 1, 12, '0', STR_PAD_LEFT);
            }
        }

        return $noOrder;
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $validatedData = $request->validate([
            // Field untuk SegalaOrder
            'kd_pasien' => 'required|string|max:12',
            'kd_unit' => 'required|string|max:5',
            'tgl_masuk' => 'required|date_format:Y-m-d H:i:s',
            'urut_masuk' => 'required|integer',
            'tgl_order' => 'required|date_format:Y-m-d\TH:i',
            'dilayani' => 'nullable|integer',
            'kategori' => 'nullable|string|max:10',
            'no_transaksi' => 'nullable|string|max:20',
            'kd_kasir' => 'nullable|string|max:20',
            'status_order' => 'nullable|string|max:20',
            'transaksi_penunjang' => 'nullable|string|max:255',
            'cyto' => 'required|string|max:2',
            'puasa' => 'required|string|max:2',
            'jadwal_pemeriksaan' => 'nullable|date_format:Y-m-d\TH:i',
            'diagnosis' => 'nullable|string|max:255',

            // Field untuk SegalaOrderDet (ubah menjadi array)
            'urut' => 'required|array',
            'urut.*' => 'required|integer',
            'kd_produk' => 'required|array',
            'kd_produk.*' => 'required|string|max:10',
            'jumlah' => 'nullable|array',
            'jumlah.*' => 'nullable|integer',
            'status' => 'nullable|array',
            'status.*' => 'nullable|integer',
            'kd_dokter' => 'required|string|max:3',
        ]);

        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (empty($dataMedis)) {
                throw new Exception('Data medis tidak ditemukan.');
            }

            $validatedData['kategori'] = $validatedData['kategori'] ?? 'LB';

            if (empty($validatedData['no_transaksi'])) {
                $existingTransaction = Transaksi::where('kd_pasien', $validatedData['kd_pasien'])
                    ->orderBy('tgl_transaksi', 'desc')
                    ->first();

                if ($existingTransaction) {
                    $validatedData['no_transaksi'] = $existingTransaction->no_transaksi;
                } else {
                    $validatedData['no_transaksi'] = Transaksi::generateNoTransaksi($validatedData['kd_pasien']);
                }
            }
            if (empty($validatedData['kd_kasir'])) {
                $existingTransaction = Transaksi::where('kd_pasien', $validatedData['kd_pasien'])
                    ->whereNotNull('kd_kasir')
                    ->orderBy('tgl_transaksi', 'desc')
                    ->first();

                if ($existingTransaction) {
                    $validatedData['kd_kasir'] = $existingTransaction->kd_kasir;
                } else {
                    $validatedData['kd_kasir'] = Transaksi::generateNoTransaksi($validatedData['kd_pasien']);
                }
            }

            // $tglOrder = (int) Carbon::parse($tgl_masuk)->format('Ymd');

            // $lastOrder = SegalaOrder::where('KD_ORDER', 'like', "$tglOrder%")
            //     ->orderBy('kd_order', 'desc')
            //     ->first();

            $newOrderNumber = $this->generateNoOrder($tgl_masuk);

            $segalaOrder = SegalaOrder::create([
                'kd_order' => $newOrderNumber,
                'kd_pasien' => $validatedData['kd_pasien'],
                'kd_unit' => $validatedData['kd_unit'],
                'tgl_masuk' => $validatedData['tgl_masuk'],
                'urut_masuk' => $validatedData['urut_masuk'],
                'kd_dokter' => $validatedData['kd_dokter'],
                'tgl_order' => $validatedData['tgl_order'],
                'cyto' => $validatedData['cyto'],
                'puasa' => $validatedData['puasa'],
                'jadwal_pemeriksaan' => $validatedData['jadwal_pemeriksaan'] ?? null,
                'diagnosis' => $validatedData['diagnosis'] ?? null,
                'dilayani' => 0,
                'kategori' => $validatedData['kategori'],
                'no_transaksi' => $validatedData['no_transaksi'],
                'kd_kasir' => $validatedData['kd_kasir'] ?? null,
                'status_order' => 1,
                'transaksi_penunjang' => $validatedData['transaksi_penunjang'] ?? null,
            ]);

            foreach ($validatedData['kd_produk'] as $index => $kd_produk) {
                $segalaOrderDet = SegalaOrderDet::create([
                    'kd_order' => $newOrderNumber,
                    'urut' => $validatedData['urut'][$index],
                    'kd_produk' => $kd_produk,
                    'jumlah' => 1,
                    'status' => 0,
                    'kd_dokter' => 381,
                ]);
            }

            // create resume
            $resumeData = [];
            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-inap.lab-patologi-klinik.index', [
                'kd_unit' => $validatedData['kd_unit'],
                'kd_pasien' => $validatedData['kd_pasien'],
                'tgl_masuk' => $validatedData['tgl_masuk'],
                'urut_masuk' => $validatedData['urut_masuk']
            ])->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error',  $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $validatedData = $request->validate([
            // Field untuk SegalaOrder
            'kd_pasien' => 'required|string|max:12',
            'kd_unit' => 'required|string|max:5',
            'tgl_masuk' => 'required|date_format:Y-m-d H:i:s',
            'urut_masuk' => 'required|integer',
            'tgl_order' => 'required|date_format:Y-m-d\TH:i',
            'dilayani' => 'nullable|integer',
            'kategori' => 'nullable|string|max:10',
            'no_transaksi' => 'nullable|string|max:20',
            'kd_kasir' => 'nullable|string|max:20',
            'status_order' => 'nullable|string|max:20',
            'transaksi_penunjang' => 'nullable|string|max:255',
            'cyto' => 'required|string|max:2',
            'puasa' => 'required|string|max:2',
            'jadwal_pemeriksaan' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:tgl_order',
            'diagnosis' => 'nullable|string|max:255',

            // Field untuk SegalaOrderDet (ubah menjadi array)
            'urut' => 'required|array',
            'urut.*' => 'required|integer',
            'kd_produk' => 'required|array',
            'kd_produk.*' => 'required|string|max:10',
            'jumlah' => 'nullable|array',
            'jumlah.*' => 'required|integer|min:1',
            'status' => 'nullable|array',
            'status.*' => 'nullable|integer',
            'kd_dokter' => 'required|string|max:3',
        ]);

        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            $segalaOrder = SegalaOrder::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $kd_order = $segalaOrder->kd_order;

            // Update no_transaksi and kd_kasir if not provided
            if (empty($validatedData['no_transaksi']) || empty($validatedData['kd_kasir'])) {
                $existingTransaction = Transaksi::where('kd_pasien', $validatedData['kd_pasien'])
                    ->whereNotNull('no_transaksi')
                    ->whereNotNull('kd_kasir')
                    ->orderBy('tgl_transaksi', 'desc')
                    ->first();

                if (empty($validatedData['no_transaksi'])) {
                    $validatedData['no_transaksi'] = $existingTransaction
                        ? $existingTransaction->no_transaksi
                        : Transaksi::generateNoTransaksi($validatedData['kd_pasien']);
                }

                if (empty($validatedData['kd_kasir'])) {
                    $validatedData['kd_kasir'] = $existingTransaction
                        ? $existingTransaction->kd_kasir
                        : Transaksi::generateNoTransaksi($validatedData['kd_pasien']);
                }
            }

            $segalaOrder->update([
                'kd_pasien' => $validatedData['kd_pasien'],
                'kd_unit' => $validatedData['kd_unit'],
                'tgl_masuk' => $validatedData['tgl_masuk'],
                'urut_masuk' => $validatedData['urut_masuk'],
                'tgl_order' => $validatedData['tgl_order'],
                'cyto' => $validatedData['cyto'],
                'puasa' => $validatedData['puasa'],
                'jadwal_pemeriksaan' => $validatedData['jadwal_pemeriksaan'] ?? null,
                'diagnosis' => $validatedData['diagnosis'] ?? null,
                'kategori' => $validatedData['kategori'] ?? 'LB',
                'no_transaksi' => $validatedData['no_transaksi'],
                'kd_kasir' => $validatedData['kd_kasir'],
                'status_order' => 1,
                'transaksi_penunjang' => $validatedData['transaksi_penunjang'] ?? null,
                'kd_dokter' => $validatedData['kd_dokter'],
            ]);

            // Delete existing order details
            SegalaOrderDet::where('kd_order', $kd_order)->delete();

            // Create new order details
            foreach ($validatedData['kd_produk'] as $index => $kd_produk) {
                SegalaOrderDet::create([
                    'kd_order' => $kd_order,
                    'urut' => $validatedData['urut'][$index],
                    'kd_produk' => $kd_produk,
                    'jumlah' => 1,
                    'status' => 0,
                    'kd_dokter' => 381,
                ]);
            }

            // create resume
            $resumeData = [];
            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-inap.lab-patologi-klinik.index', [
                'kd_unit' => $validatedData['kd_unit'],
                'kd_pasien' => $validatedData['kd_pasien'],
                'tgl_masuk' => $validatedData['tgl_masuk'],
                'urut_masuk' => $validatedData['urut_masuk']
            ])->with(['success' => 'Updated successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $laborPK = SegalaOrder::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $laborPK->delete();

            return redirect()->route('rawat-inap.lab-patologi-klinik.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with(['success' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return redirect()->route('rawat-inap.lab-patologi-klinik.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with(['error' => 'Ada kesalahan sistem. Silakan coba lagi.']);
        }
    }

    private function checkAndCreateResume($data)
    {
        try {
            // Cek apakah resume sudah ada
            $resume = RMEResume::where('kd_pasien', $data['kd_pasien'])
                ->where('kd_unit', $data['kd_unit'])
                ->where('tgl_masuk', $data['tgl_masuk'])
                ->where('urut_masuk', $data['urut_masuk'])
                ->first();

            if (!$resume) {
                // Jika belum ada
                $resume = RMEResume::create([
                    'kd_pasien' => $data['kd_pasien'],
                    'kd_unit' => $data['kd_unit'],
                    'tgl_masuk' => $data['tgl_masuk'],
                    'urut_masuk' => $data['urut_masuk'],
                    'status' => 0,
                ]);

                $resume = RMEResume::where('kd_pasien', $data['kd_pasien'])
                    ->where('kd_unit', $data['kd_unit'])
                    ->where('tgl_masuk', $data['tgl_masuk'])
                    ->where('urut_masuk', $data['urut_masuk'])
                    ->first();
            }

            // Entri di RMEResumeDtl
            if ($resume) {
                $resumeDetail = RmeResumeDtl::where('id_resume', $resume->id)->first();

                if (!$resumeDetail) {
                    DB::table('RME_RESUME_DTL')->insert([
                        'id_resume' => $resume->id
                    ]);
                }

                DB::commit();
                return $resume;
            }
            throw new \Exception('Gagal membuat atau mendapatkan data resume');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function print(Request $request, $kd_pasien, $tgl_masuk)
    {

        $validator = Validator::make($request->all(), [
            'no_transaksi'    => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'No Transaksi kosong !',
                'data'      => []
            ]);
        }

        $no_transaksi = $request->no_transaksi;
        $unitAsal = UnitAsal::where('no_transaksi_asal', $no_transaksi)->first();

        if (empty($unitAsal)) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data tidak ditemukan !',
                'data'      => []
            ]);
        }

        $otoritas = Otoritas::where('no_transaksi', $unitAsal->no_transaksi)
            ->where('kd_kasir', $unitAsal->kd_kasir)
            ->where('kd_pasien', $kd_pasien)
            ->where('status', 1)
            ->first();

        if (empty($otoritas)) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data Otoritas tidak ditemukan !',
                'data'      => []
            ]);
        }

        if (empty($otoritas->file)) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'File tidak ditemukan !',
                'data'      => []
            ]);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'OK',
            'data'      => [
                'file_url'  => "https://e-rsudlangsa.id/dokumen/lab_pk/$otoritas->file"
            ]
        ]);
    }
}

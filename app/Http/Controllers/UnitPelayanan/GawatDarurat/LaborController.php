<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\Kunjungan;
use App\Models\LabHasil;
use App\Models\LapLisItemPemeriksaan;
use App\Models\Otoritas;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SegalaOrder;
use App\Models\SegalaOrderDet;
use App\Models\Transaksi;
use App\Models\UnitAsal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class LaborController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    public function index(Request $request, $kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit', 'registrasiHasil'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        $DataLapPemeriksaan = LapLisItemPemeriksaan::with('produk')
            ->select('kategori', 'kd_produk')
            ->get()
            ->groupBy('kategori');


        // $dataDokter = Dokter::where('status', 1)->get();

        $dataDokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        // ambil Diagnosis dari emr_resume
        $dataDiagnosis = RMEResume::with(['kunjungan'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', 3)
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

        // Get main data
        $dataLabor = SegalaOrder::with(['details', 'laplisitempemeriksaan', 'dokter', 'produk', 'unit'])
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
            ->orderBy('tgl_order', 'desc')
            ->paginate(10);

        // Transform the data to include lab results
        $dataLabor->getCollection()->transform(function ($item) {
            $labResults = $this->getLabData(
                $item->kd_order,
                $item->kd_pasien,
                $item->tgl_masuk,
                $item->urut_masuk
            );

            $item->labResults = $labResults;
            return $item;
        });

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.index', compact(
            'dataMedis',
            'DataLapPemeriksaan',
            'dataDokter',
            'dataLabor',
            'dataDiagnosis',
            'diagnosisList'
        ));
    }

    // hasil data raboratorium
    protected function getLabData($kd_order, $kd_pasien, $tgl_masuk, $urut_masuk)
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
                'so.kd_unit'    => 3,
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

    public function create($kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.createpk', compact('kd_pasien', 'tgl_masuk'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
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
                'jumlah.*' => 'nullable|integer',
                'status' => 'nullable|array',
                'status.*' => 'nullable|integer',
                'kd_dokter' => 'required|string|max:3',
            ]);

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

            $tglOrder = \Carbon\Carbon::parse($validatedData['tgl_order'])->format('Ymd');
            $lastOrder = SegalaOrder::where('kd_order', 'like', $tglOrder . '%')
                ->orderBy('kd_order', 'desc')
                ->first();

            $newOrderNumber = $lastOrder ? ((int)substr($lastOrder->kd_order, -4)) + 1 : 1;
            $newOrderNumber = str_pad((string)$newOrderNumber, 4, '0', STR_PAD_LEFT);
            $newKdOrder = $tglOrder . $newOrderNumber;

            while (SegalaOrder::where('kd_order', $newKdOrder)->exists()) {
                $newOrderNumber = (int)$newOrderNumber + 1;
                $newOrderNumber = str_pad((string)$newOrderNumber, 4, '0', STR_PAD_LEFT);
                $newKdOrder = $tglOrder . $newOrderNumber;
            }

            $segalaOrder = SegalaOrder::create([
                'kd_order' => $newKdOrder,
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
                'user_create' => Auth::id()
            ]);

            foreach ($validatedData['kd_produk'] as $index => $kd_produk) {
                $segalaOrderDet = SegalaOrderDet::create([
                    'kd_order' => $newKdOrder,
                    'urut' => $validatedData['urut'][$index],
                    'kd_produk' => $kd_produk,
                    'jumlah' => 1,
                    'status' => 0,
                    'kd_dokter' => 381,
                ]);
            }

            // Buat atau dapatkan resume
            $resume = $this->checkAndCreateResume([
                'kd_pasien' => $validatedData['kd_pasien'],
                'kd_unit' => $validatedData['kd_unit'],
                'tgl_masuk' => $validatedData['tgl_masuk'],
                'urut_masuk' => $validatedData['urut_masuk']
            ]);

            DB::commit();

            return redirect()->route('labor.index', [
                'kd_pasien' => $validatedData['kd_pasien'],
                'tgl_masuk' => $validatedData['tgl_masuk']
            ])->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $kd_order)
    {
        DB::beginTransaction();

        try {

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
                'jadwal_pemeriksaan' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:tgl_order',
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

            $segalaOrder = SegalaOrder::findOrFail($kd_order);

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
                'user_edit' => Auth::id()
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

            DB::commit();

            return redirect()->route('labor.index', [
                'kd_pasien' => $validatedData['kd_pasien'],
                'tgl_masuk' => $validatedData['tgl_masuk']
            ])->with(['success' => 'updated successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $kd_order)
    {
        DB::beginTransaction();

        try {
            $labPK = SegalaOrder::findOrFail($kd_order);
            $labPK->delete();

            DB::commit();

            return redirect()->route('labor.index', [
                'kd_pasien' => $labPK->kd_pasien,
                'tgl_masuk' => $labPK->tgl_masuk
            ])->with(['success' => 'Deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('labor.index', [
                'kd_pasien' => $labPK->kd_pasien ?? 'default_kd_pasien',
                'tgl_masuk' => $labPK->tgl_masuk ?? 'default_tgl_masuk'
            ])->with(['error' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
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

    public function cetak(Request $request, $kd_pasien, $tgl_masuk)
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
<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\DetailTransaksi;
use App\Models\DokterInap;
use App\Models\Kunjungan;
use App\Models\ListTindakanPasien;
use App\Models\Produk;
use App\Models\RMEResume;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SjpKunjungan;
use App\Services\BaseService;

class TindakanController extends Controller
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

        $produk = Produk::select([
            'tarif.kd_produk',
            'produk.deskripsi',
            'tarif.tarif',
            'tarif.kd_unit',
            'tarif.tgl_berakhir',
            'tarif.tgl_berlaku'
        ])
            ->leftJoin('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
            // ->where('tarif.kd_unit', $kd_unit)
            ->where('tarif.kd_unit', 10013)
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


        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        // Query tindakan untuk Rawat Inap
        $tindakanRawatInap = ListTindakanPasien::with(['produk', 'ppa', 'unit'])
            // filter data per periode to anas
            ->when($periode && $periode !== 'semua', function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_tindakan', $now->year)
                            ->whereMonth('tgl_tindakan', $now->month);
                    case 'option2':
                        return $query->where('tgl_tindakan', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_tindakan', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_tindakan', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_tindakan', '>=', $now->subMonths(9));
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_tindakan', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_tindakan', '<=', $endDate);
            })
            // end filter data
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            // Filter pencarian to anas
            ->when($search, function ($query, $search) {
                $search = strtolower($search);

                if (is_numeric($search) && strlen($search) > 3) {
                    return $query->where('tgl_tindakan', $search);
                }
                return $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(tgl_tindakan) like ?', ["%$search%"])
                        ->orWhereHas('ppa', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                        })
                        ->orWhereHas('produk', function ($q) use ($search) {
                            $q->whereRaw('LOWER(deskripsi) like ?', ["%$search%"]);
                        });
                });
            })
            ->get();

        // Gabungkan dengan tindakan dari IGD jika ada asal IGD
        $tindakanIGD = $this->getTindakanIGD($dataMedis);
        $dokter = DokterInap::with(['dokter', 'unit'])
            ->where('kd_unit', '1001')
            ->whereRelation('dokter', 'status', 1)
            ->get();


        return view('unit-pelayanan.rawat-inap.pelayanan.tindakan.index', compact(
            'dataMedis',
            'dokter',
            'produk',
            'tindakanRawatInap',
            'tindakanIGD'
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
            // 'gambar_tindakan.required'  => 'Gambar harus dipilih!',
            // 'gambar_tindakan.image'     => 'Format file gambar tindakan tidak sesuai!',
            // 'gambar_tindakan.max'       => 'Gambar tindakan maksimak 5 mb!'
        ];

        $request->validate([
            'tindakan'          => 'required',
            'ppa'               => 'required',
            'tgl_tindakan'      => 'required',
            'jam_tindakan'      => 'required',
            'laporan'           => 'required',
            'kesimpulan'        => 'required',
            // 'gambar_tindakan'   => 'required|image|file|max:5120',
        ], $messageErr);

        DB::beginTransaction();

        try {

            $kunjungan = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

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
                // 'kd_unit'       => $kd_unit,
                'kd_unit'       => 10013,
                'kd_unit_tr'    => $kd_unit,
                // 'kd_unit_tr'    => $kd_unit,
                'tgl_berlaku'   => $request->tgl_berlaku,
                'kd_user'       => $request->ppa,
                'shift'         => 0,
                'harga'         => $request->tarif_tindakan,
                'qty'           => 1,
                'flag'          => 0,
                'jns_trans'     => 0,
            ];

            DetailTransaksi::create($dataDetailTransaksi);

            // create resume
            $resumeData = [];
            $this->baseService->updateResumeMedis($kunjungan->kd_unit, $kunjungan->kd_pasien, $kunjungan->tgl_masuk, $kunjungan->urut_masuk, $resumeData);

            DB::commit();
            return back()->with('success', 'Tindakan berhasil ditambah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
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
                ->join('detail_transaksi as dt', function ($join) use ($request) {
                    $join->on('dt.no_transaksi', '=', DB::raw("'{$request->no_transaksi}'"))
                        ->on('dt.kd_produk', '=', 'list_tindakan_pasien.kd_produk');
                })
                ->where('list_tindakan_pasien.kd_produk', $request->kd_produk)
                ->where('list_tindakan_pasien.urut_list', $request->urut_list)
                ->first();

            if (empty($tindakan)) {
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

        if ($request->hasFile('gambar_tindakan')) {
            $rules['gambar_tindakan'] = 'required|image|file|max:5120';

            $messageErr['gambar_tindakan.required'] = 'Gambar harus dipilih!';
            $messageErr['gambar_tindakan.image'] = 'Format file gambar tindakan tidak sesuai!';
            $messageErr['gambar_tindakan.max'] = 'Gambar tindakan maksimak 5 mb!';
        }

        $request->validate($rules, $messageErr);

        DB::beginTransaction();

        try {

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data medis tidak ditemukan');

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

            if ($request->hasFile('gambar_tindakan')) {
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

            // create resume
            $resumeData = [];
            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();
            return back()->with('success', 'Tindakan berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteTindakan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

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

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Tindakan berhasil dihapus',
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

    public function printPDF(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // 1. Logika untuk mendapatkan $dataMedis
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

        // Gabungkan tindakan Rawat Inap dan IGD
        $tindakanRawatInap = ListTindakanPasien::with(['produk', 'ppa', 'unit'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('urut_masuk', (int)$dataMedis->urut_masuk)
            ->get();

        $tindakanIGD = $this->getTindakanIGD($dataMedis);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', (int)$dataMedis->urut_masuk)
            ->first();

        // 4. AMBIL DATA NO SJP (Cara Model)
        $sjp = SjpKunjungan::where('KD_PASIEN', $kd_pasien)
            ->where('KD_UNIT', $dataMedis->kd_unit)
            ->where('TGL_MASUK', $tgl_masuk)
            ->where('URUT_MASUK', $dataMedis->urut_masuk)
            ->first();


        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.tindakan.print', compact(
            'dataMedis',
            'tindakanRawatInap',
            'tindakanIGD',
            'resume',
            'sjp'
        ));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('daftar-tindakan-' . $dataMedis->pasien->nama_pasien . '.pdf');
    }

    // Private Function
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

    // Fungsi baru untuk mengambil tindakan dari IGD jika ada asal IGD
    private function getTindakanIGD($dataMedis)
    {
        $tindakanIGD = collect(); // Koleksi kosong sebagai default

        // Cek asal IGD
        $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)->where('no_transaksi', $dataMedis->no_transaksi)->first();

        if (!empty($asalIGD)) {
            // Dapatkan kunjungan IGD
            $kunjunganIGD = $this->baseService->getDataMedisbyTransaksi($asalIGD->kd_kasir_asal, $asalIGD->no_transaksi_asal);

            if ($kunjunganIGD) {
                // Ambil tindakan dari unit IGD (kd_unit = 3)
                $tindakanIGD = ListTindakanPasien::with(['produk', 'ppa', 'unit'])
                    ->where('kd_pasien', $kunjunganIGD->kd_pasien)
                    ->where('kd_unit', 3) // Unit Gawat Darurat
                    ->where('tgl_masuk', $kunjunganIGD->tgl_transaksi)
                    ->where('urut_masuk', $kunjunganIGD->urut_masuk)
                    ->get()
                    ->map(function ($item) use ($kunjunganIGD) {
                        $item->no_transaksi = $kunjunganIGD->no_transaksi;
                        return $item;
                    });
            }
        }

        return $tindakanIGD;
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\DokterKlinik;
use App\Models\Konsultasi;
use App\Models\Kunjungan;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\Transaksi;
use App\Models\Unit;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class KonsultasiController extends Controller
{
    private $baseService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
        $this->baseService = new BaseService();
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan.');
        }

        $dokterPengirim = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', $kd_unit)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        $unit = Unit::where('kd_bagian', 2)
            ->where('aktif', 1)
            ->whereNot('kd_unit', $kd_unit)
            ->get();

        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        $konsultasi = Konsultasi::with(['unit_tujuan', 'dokter_asal', 'unit_asal'])
            // filter data per periode to anas
            ->when($periode && $periode !== 'semua', function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_masuk_tujuan', $now->year)
                            ->whereMonth('tgl_masuk_tujuan', $now->month);
                    case 'option2':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(9));
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_masuk_tujuan', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_masuk_tujuan', '<=', $endDate);
            })
            // end filter data
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            // Filter pencarian to anas
            ->when($search, function ($query, $search) {
                $search = strtolower($search);

                if (is_numeric($search) && strlen($search) > 3) {
                    return $query->where('tgl_masuk_tujuan', $search);
                }
                return $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(tgl_masuk_tujuan) like ?', ["%$search%"])
                        ->orWhereHas('dokter_asal', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                        })
                        ->orWhereHas('unit_tujuan', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_unit) like ?', ["%$search%"]);
                        });
                });
            })
            ->get();


        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view(
            'unit-pelayanan.rawat-jalan.pelayanan.konsultasi.index',
            compact(
                'dataMedis',
                'dokterPengirim',
                'unit',
                'konsultasi'
            )
        );
    }
    public function terima(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan.');
        }

        $dokterPengirim = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', $kd_unit)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        $unit = Unit::where('kd_bagian', 2)
            ->where('aktif', 1)
            ->whereNot('kd_unit', $kd_unit)
            ->get();

        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        $konsultasi = Konsultasi::with(['unit_tujuan', 'dokter_asal', 'unit_asal'])
            // filter data per periode to anas
            ->when($periode && $periode !== 'semua', function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_masuk_tujuan', $now->year)
                            ->whereMonth('tgl_masuk_tujuan', $now->month);
                    case 'option2':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(9));
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_masuk_tujuan', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_masuk_tujuan', '<=', $endDate);
            })
            // end filter data
            ->where('kd_pasien_tujuan', $kd_pasien)
            ->whereDate('tgl_masuk_tujuan', $tgl_masuk)
            ->where('kd_unit_tujuan', $kd_unit)
            ->where('urut_masuk_tujuan', $urut_masuk)
            // Filter pencarian to anas
            ->when($search, function ($query, $search) {
                $search = strtolower($search);

                if (is_numeric($search) && strlen($search) > 3) {
                    return $query->where('tgl_masuk_tujuan', $search);
                }
                return $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(tgl_masuk_tujuan) like ?', ["%$search%"])
                        ->orWhereHas('dokter_asal', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                        })
                        ->orWhereHas('unit_tujuan', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_unit) like ?', ["%$search%"]);
                        });
                });
            })
            ->get();


        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view(
            'unit-pelayanan.rawat-jalan.pelayanan.konsultasi.index',
            compact(
                'dataMedis',
                'dokterPengirim',
                'unit',
                'konsultasi'
            )
        );
    }

    public function getDokterbyUnit(Request $request)
    {
        try {
            $dokter = DokterKlinik::with(['dokter', 'unit'])
                ->where('kd_unit', $request->kd_unit)
                ->whereRelation('dokter', 'status', 1)
                ->get();

            if (count($dokter) > 0) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data ditemukan',
                    'data'      => $dokter
                ]);
            } else {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan',
                    'data'      => []
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }

    public function storeKonsultasi($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        // Validation
        $msgErr = [
            'dokter_pengirim.required'      => 'Dokter pengirim harus dipilih!',
            'tgl_konsul.required'           => 'Tanggal konsul harus dipilih!',
            'tgl_konsul.date_format'        => 'Tanggal konsul harus format yang benar!',
            'jam_konsul.required'           => 'Jam konsul harus dipilih!',
            'jam_konsul.date_format'        => 'Jam konsul harus format yang benar!',
            'unit_tujuan.required'          => 'Unit tujuan harus dipilih!',
            'dokter_unit_tujuan.required'   => 'Dokter tujuan harus dipilih!',
            'konsulen_harap.required'       => 'Konsulen diharapkan harus dipilih!',
            'catatan.required'              => 'Catatan harus di isi!',
            'konsul.required'               => 'Konsul harus di isi!',
        ];

        $request->validate([
            'dokter_pengirim'       => 'required',
            'tgl_konsul'            => 'required|date_format:Y-m-d',
            'jam_konsul'            => 'required|date_format:H:i',
            'unit_tujuan'           => 'required',
            'dokter_unit_tujuan'    => 'required',
            'konsulen_harap'        => 'required',
            'catatan'               => 'required',
            'konsul'                => 'required',
        ], $msgErr);


        // get kunjungan
        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
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

        $unit = Unit::where('kd_unit', $kd_unit)->first();


        if (empty($kunjungan)) return back()->with('error', 'Kunjungan gagal terdeteksi sistem!');


        // Create New Kunjungan Tujuan

        // get request data
        $tgl_konsul = $request->tgl_konsul;
        $jam_konsul = $request->jam_konsul;
        $dokter_pengirim = $request->dokter_pengirim;
        $unit_tujuan = $request->unit_tujuan;
        $dokter_unit_tujuan = $request->dokter_unit_tujuan;
        $konsulen_harap = $request->konsulen_harap;
        $catatan = $request->catatan;
        $konsul = $request->konsul;

        // get antrian terakhir
        $getLastAntrian = Kunjungan::select('antrian')
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->where('kd_unit', $unit_tujuan)
            ->orderBy('antrian', 'desc')
            ->first();

        $no_antrian = !empty($getLastAntrian) ? $getLastAntrian->antrian + 1 : 1;

        // pasien not null get last urut masuk
        $getLastUrutMasukPatient = Kunjungan::select('urut_masuk')
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->orderBy('urut_masuk', 'desc')
            ->first();

        $new_urut_masuk = !empty($getLastUrutMasukPatient) ? $getLastUrutMasukPatient->urut_masuk + 1 : 0;

        // insert ke tabel kunjungan
        $dataKunjungan = [
            'kd_pasien'         => $kd_pasien,
            'kd_unit'           => $unit_tujuan,
            'tgl_masuk'         => $tgl_konsul,
            'urut_masuk'        => $new_urut_masuk,
            'jam_masuk'         => $jam_konsul,
            'asal_pasien'       => 0,
            'cara_penerimaan'   => 99,
            'kd_rujukan'        => 1,
            'no_surat'          => '',
            'kd_dokter'         => $dokter_unit_tujuan,
            'baru'              => 1,
            'kd_customer'       => '0000000001',
            'shift'             => 0,
            'kontrol'           => 0,
            'antrian'           => $no_antrian,
            'tgl_surat'         => $tgl_konsul,
            'jasa_raharja'      => 0,
            'catatan'           => '',
            'is_rujukan'        => 1,
            'rujukan_ket'       => $unit->nama_unit
        ];

        Kunjungan::create($dataKunjungan);

        // delete rujukan_kunjungan
        RujukanKunjungan::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $unit_tujuan)
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->where('urut_masuk', $new_urut_masuk)
            ->delete();


        // insert transaksi
        $lastTransaction = Transaksi::select('no_transaksi')
            ->where('kd_kasir', '01')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastTransactionNumber = (int) $lastTransaction->no_transaksi;
            $newTransactionNumber = $lastTransactionNumber + 1;
        } else {
            $newTransactionNumber = 1;
        }

        // formatted new transaction number with 7 digits length
        $formattedTransactionNumber = str_pad($newTransactionNumber, 7, '0', STR_PAD_LEFT);

        $dataTransaksi = [
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_pasien'     => $kd_pasien,
            'kd_unit'       => $unit_tujuan,
            'tgl_transaksi' => $tgl_konsul,
            'app'           => 0,
            'ispay'         => 0,
            'co_status'     => 0,
            'urut_masuk'    => $new_urut_masuk,
            'kd_user'       => $dokter_pengirim, // nanti diambil dari user yang login
            'lunas'         => 0,
        ];

        Transaksi::create($dataTransaksi);


        // insert detail_transaksi
        $dataDetailTransaksi = [
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_kasir'      => '01',
            'tgl_transaksi' => $tgl_konsul,
            'urut'          => 1,
            'kd_tarif'      => 'TU',
            'kd_produk'     => 3634,
            'kd_unit'       => $unit_tujuan,
            'kd_unit_tr'    => $kd_unit,
            'tgl_berlaku'   => '2019-07-01',
            'kd_user'       => $dokter_pengirim,
            'shift'         => 0,
            'harga'         => 15000,
            'qty'           => 1,
            'flag'          => 0,
            'jns_trans'     => 0,
        ];

        DetailTransaksi::create($dataDetailTransaksi);


        // insert detail_prsh
        $dataDetailPrsh = [
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'urut'          => 1,
            'tgl_transaksi' => $tgl_konsul,
            'hak'           => 15000,
            'selisih'       => 0,
            'disc'          => 0
        ];

        DetailPrsh::create($dataDetailPrsh);


        // delete detail_component
        DetailComponent::where('kd_kasir', '01')
            ->where('no_transaksi', $formattedTransactionNumber)
            ->where('urut', 1)
            ->delete();


        // insert detail_component
        $dataDetailComponent = [
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'tgl_transaksi' => $tgl_konsul,
            'urut'          => 1,
            'kd_component'  => '30',
            'tarif'         => 15000,
            'disc'          => 0
        ];

        DetailComponent::create($dataDetailComponent);

        // insert sjp_kunjungan
        $sjpKunjunganData = [
            'kd_pasien'     => $kd_pasien,
            'kd_unit'       => $unit_tujuan,
            'tgl_masuk'     => $tgl_konsul,
            'urut_masuk'    => $new_urut_masuk,
            'no_sjp'        => '',
            'penjamin_laka' => 0,
            'katarak'       => 0,
            'dpjp'          => $dokter_unit_tujuan,
            'cob'           => 0
        ];

        SjpKunjungan::create($sjpKunjunganData);

        // Insert konsultasi
        $getLastUrutKonsul = Konsultasi::select(['urut_konsul'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('urut_konsul', 'desc')
            ->first();

        $urut_konsul = !empty($getLastUrutKonsul) ? $getLastUrutKonsul->urut_konsul + 1 : 1;

        $konsultasiData = [
            'kd_pasien'                 => $kd_pasien,
            'kd_unit'                   => $kd_unit,
            'tgl_masuk'                 => $tgl_masuk,
            'urut_masuk'                => $urut_masuk,
            'kd_pasien_tujuan'          => $kd_pasien,
            'kd_unit_tujuan'            => $unit_tujuan,
            'tgl_masuk_tujuan'          => $tgl_konsul,
            'urut_masuk_tujuan'         => $new_urut_masuk,
            'urut_konsul'               => $urut_konsul,
            'jam_masuk_tujuan'          => $jam_konsul,
            'kd_dokter'                 => $dokter_pengirim,
            'kd_dokter_tujuan'          => $dokter_unit_tujuan,
            'kd_konsulen_diharapkan'    => $konsulen_harap,
            'catatan'                   => $catatan,
            'konsul'                    => $konsul
        ];

        Konsultasi::create($konsultasiData);


        // create resume
        $resumeData = [
            'unit_rujuk_internal'   => $unit_tujuan,
        ];


        $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);
        return back()->with('success', 'Konsultasi berhasil di tambah!');
    }

    public function getKonsulAjax($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            // get konsultasi
            $konsultasi = Konsultasi::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('kd_unit_tujuan', $request->kd_unit_tujuan)
                ->where('tgl_masuk_tujuan', $request->tgl_masuk_tujuan)
                ->where('jam_masuk_tujuan', $request->jam_masuk_tujuan)
                ->where('urut_konsul', $request->urut_konsul)
                ->first();

            $dokter = DokterKlinik::with(['dokter', 'unit'])
                ->where('kd_unit', $request->kd_unit_tujuan)
                ->whereRelation('dokter', 'status', 1)
                ->get();

            if (empty($konsultasi)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data konsultasi tidak ditemukan!',
                    'data'      => []
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data konsultasi ditemukan',
                    'data'      => [
                        "konsultasi" => $konsultasi,
                        'dokter' => $dokter
                    ]
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

    public function updateKonsultasi($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        // Validation
        $msgErr = [
            'konsulen_harap.required'       => 'Konsulen diharapkan harus dipilih!',
            'catatan.required'              => 'Catatan harus di isi!',
            'konsul.required'               => 'Konsul harus di isi!',
        ];

        $request->validate([
            'konsulen_harap'        => 'required',
            'catatan'               => 'required',
            'konsul'                => 'required',
        ], $msgErr);


        // update konsul
        Konsultasi::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kd_unit_tujuan', $request->old_kd_unit_tujuan)
            ->where('tgl_masuk_tujuan', $request->old_tgl_konsul)
            ->where('jam_masuk_tujuan', $request->old_jam_konsul)
            ->where('urut_konsul', $request->urut_konsul)
            ->update([
                'kd_konsulen_diharapkan'    => $request->konsulen_harap,
                'catatan'                   => $request->catatan,
                'konsul'                    => $request->konsul,
            ]);

        return back()->with('success', 'Konsultasi berhasil di ubah');
    }


    public function deleteKonsultasi(
        string $kd_unit,
        string $kd_pasien,
        string $tgl_masuk,
        string $urut_masuk,
        string $kd_unit_tujuan,
        string $tgl_masuk_tujuan,
        string $jam_masuk_tujuan,
        string $urut_konsul
    ) {
        try {
            DB::beginTransaction();

            // Normalisasi tanggal & jam
            $tglAsal   = Carbon::parse($tgl_masuk)->toDateString();
            $tglTujuan = Carbon::parse($tgl_masuk_tujuan)->toDateString();
            $jamTujuan = $jam_masuk_tujuan; // biarkan apa adanya (HH:MM[:SS])

            // Ambil konsultasi target (BERDASARKAN PARAMETER, BUKAN ID)
            $konsultasi = Konsultasi::query()
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tglAsal)
                ->where('urut_masuk', $urut_masuk)
                ->where('kd_unit_tujuan', $kd_unit_tujuan)
                ->whereDate('tgl_masuk_tujuan', $tglTujuan)
                ->where('jam_masuk_tujuan', $jamTujuan)
                ->where('urut_konsul', $urut_konsul)
                ->first();

            if (!$konsultasi) {
                return back()->with('error', 'Data konsultasi tidak ditemukan.');
            }

            $urutMasukTujuan = $konsultasi->urut_masuk_tujuan;

            // Kumpulkan semua no_transaksi terkait episode tujuan
            $noTransaksi = Transaksi::query()
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit_tujuan)
                ->whereDate('tgl_transaksi', $tglTujuan)
                ->where('urut_masuk', $urutMasukTujuan)
                ->pluck('no_transaksi');

            if ($noTransaksi->isNotEmpty()) {
                // Hapus detail (sesuai logika awal: kd_kasir = '01')
                DetailTransaksi::query()
                    ->whereIn('no_transaksi', $noTransaksi)
                    ->whereDate('tgl_transaksi', $tglTujuan)
                    ->where('kd_kasir', '01')
                    ->delete();

                DetailPrsh::query()
                    ->whereIn('no_transaksi', $noTransaksi)
                    ->whereDate('tgl_transaksi', $tglTujuan)
                    ->where('kd_kasir', '01')
                    ->delete();

                DetailComponent::query()
                    ->whereIn('no_transaksi', $noTransaksi)
                    ->whereDate('tgl_transaksi', $tglTujuan)
                    ->where('kd_kasir', '01')
                    ->delete();

                // Hapus header transaksi
                Transaksi::query()
                    ->whereIn('no_transaksi', $noTransaksi)
                    ->delete();
            }

            // Hapus kunjungan tujuan
            Kunjungan::query()
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit_tujuan)
                ->whereDate('tgl_masuk', $tglTujuan)
                ->where('urut_masuk', $urutMasukTujuan)
                ->delete();

            Konsultasi::query()
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tglAsal)
                ->where('urut_masuk', $urut_masuk)
                ->where('kd_unit_tujuan', $kd_unit_tujuan)
                ->whereDate('tgl_masuk_tujuan', $tglTujuan)
                ->where('jam_masuk_tujuan', $jamTujuan)
                ->where('urut_konsul', $urut_konsul)
                ->delete();

            DB::commit();
            return back()->with('success', 'Konsultasi berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus konsultasi: ' . $e->getMessage());
        }
    }

    public function createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        $resumeDtlData = [
            'tindak_lanjut_code'    => 4,
            'tindak_lanjut_name'    => 'Konsul/Rujuk internal',
            'unit_rujuk_internal'   => $data['unit_rujuk_internal'],
        ];

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
            $resumeDtlData['id_resume'] = $newResume->id;
            RmeResumeDtl::create($resumeDtlData);
        } else {
            // get resume dtl
            $resumeDtl = RmeResumeDtl::where('id_resume', $resume->id)->first();
            $resumeDtlData['id_resume'] = $resume->id;

            if (empty($resumeDtl)) {
                RmeResumeDtl::create($resumeDtlData);
            } else {
                $resumeDtl->tindak_lanjut_code  = 4;
                $resumeDtl->tindak_lanjut_name  = 'Konsul/Rujuk internal';
                $resumeDtl->unit_rujuk_internal = $data['unit_rujuk_internal'];
                $resumeDtl->save();
            }
        }
    }

    public function terimaKonsultasi(
        string $kd_unit,
        string $kd_pasien,
        string $tgl_masuk,
        string $urut_masuk
    ) {
        try {
            // Ambil konsultasi target (BERDASARKAN PARAMETER, BUKAN ID)
            $updated = Konsultasi::query()
                ->where('kd_pasien_tujuan', $kd_pasien)
                ->whereDate('tgl_masuk_tujuan', $tgl_masuk)
                ->where('kd_unit_tujuan', $kd_unit)
                ->where('urut_masuk_tujuan', $urut_masuk)
                ->update(['status' => 1]);

            if ($updated) {
                return back()->with('success', 'Konsultasi berhasil diterima.');
            } else {
                return back()->with('error', 'Gagal menerima konsultasi. Data tidak ditemukan.');
            }
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
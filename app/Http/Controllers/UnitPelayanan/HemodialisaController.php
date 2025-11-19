<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\OrderHD;
use App\Models\Produk;
use App\Models\RmeSerahTerima;
use App\Models\RmeTransferPasienAntarRuang;
use App\Models\Transaksi;
use App\Models\Unit;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HemodialisaController extends Controller
{
    private $kdUnitDef_;
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
        $this->baseService = new BaseService();
    }


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $dokterFilter = $request->get('dokter');

            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('t.kd_unit', $this->kdUnitDef_)
                ->whereNull('kunjungan.tgl_keluar')
                ->whereNull('kunjungan.jam_keluar');

            // Filte dokter
            if (!empty($dokterFilter)) $data->where('kd_dokter', $dokterFilter);

            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($searchValue = $request->get('search')['value']) {
                        $query->where(function ($q) use ($searchValue) {
                            if (is_numeric($searchValue) && strlen($searchValue) == 4) {
                                $q->whereRaw("YEAR(kunjungan.tgl_masuk) = ?", [$searchValue]);
                            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $searchValue)) {
                                $q->whereRaw("CONVERT(varchar, kunjungan.tgl_masuk, 23) like ?", ["%{$searchValue}%"]);
                            } elseif (preg_match('/^\d{2}:\d{2}$/', $searchValue)) {
                                $q->whereRaw("FORMAT(kunjungan.jam_masuk, 'HH:mm') like ?", ["%{$searchValue}%"]);
                            } else {
                                $q->where('kunjungan.kd_pasien', 'like', "%{$searchValue}%")
                                    ->orWhereHas('pasien', function ($q) use ($searchValue) {
                                        $q->where('nama', 'like', "%{$searchValue}%")
                                            ->orWhere('alamat', 'like', "%{$searchValue}%");
                                    })
                                    ->orWhereHas('dokter', function ($q) use ($searchValue) {
                                        $q->where('nama_lengkap', 'like', "%{$searchValue}%");
                                    })
                                    ->orWhereHas('customer', function ($q) use ($searchValue) {
                                        $q->where('customer', 'like', "%{$searchValue}%");
                                    });
                            }
                        });
                    }
                })

                ->order(function ($query) {
                    $query->orderBy('kunjungan.tgl_masuk', 'desc')
                        ->orderBy('kunjungan.antrian', 'desc')
                        ->orderBy('kunjungan.urut_masuk', 'desc');
                })
                ->editColumn('tgl_masuk', fn($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
                ->addColumn('bed', fn($row) => '' ?: '-')
                ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
                ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
                ->addColumn('jaminan', fn($row) =>  $row->customer->customer ?: '-')
                ->addColumn('instruksi', fn($row) => '' ?: '-')
                ->addColumn('kd_dokter', fn($row) => $row->dokter->nama ?: '-')
                ->addColumn('waktu_masuk', function ($row) {

                    $tglMasuk = Carbon::parse($row->tgl_masuk)->format('d M Y');
                    $jamMasuk = date('H:i', strtotime($row->jam_masuk));
                    return "$tglMasuk $jamMasuk";
                })
                // Hitung umur dari tabel pasien
                ->addColumn('umur', function ($row) {
                    return $row->pasien && $row->pasien->tgl_lahir
                        ? Carbon::parse($row->pasien->tgl_lahir)->age . ''
                        : 'Tidak diketahui';
                })
                ->addColumn('action', fn($row) => $row->kd_pasien)  // Return raw data, no HTML
                ->addColumn('del', fn($row) => $row->kd_pasien)     // Return raw data
                ->addColumn('profile', fn($row) => $row)
                ->rawColumns(['action', 'del', 'profile'])
                ->make(true);
        }

        $dokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 215)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.hemodialisa.index', compact('dokter'));
    }

    public function pendingOrder(Request $request)
    {
        if ($request->ajax()) {
            $data = OrderHD::select([
                'order_hd.*',
                'p.nama as nama_pasien',
                'p.tgl_lahir',
                'p.jenis_kelamin',
                'p.alamat',
                'c.customer as jaminan',
                'k.kd_pasien',
                'u.nama_unit as unit_order'
            ])
                ->join('transaksi as t', function ($q) {
                    $q->on('order_hd.kd_kasir_asal', '=', 't.kd_kasir');
                    $q->on('order_hd.no_transaksi_asal', '=', 't.no_transaksi');
                })
                ->join('kunjungan as k', function ($q) {
                    $q->on('t.kd_pasien', '=', 'k.kd_pasien');
                    $q->on('t.kd_unit', '=', 'k.kd_unit');
                    $q->on('t.tgl_transaksi', '=', 'k.tgl_masuk');
                    $q->on('t.urut_masuk', '=', 'k.urut_masuk');
                })
                ->join('customer as c', 'k.kd_customer', '=', 'c.kd_customer')
                ->join('pasien as p', 't.kd_pasien', '=', 'p.kd_pasien')
                ->join('unit as u', 'order_hd.kd_unit_order', '=', 'u.kd_unit')
                ->where('status', 0);


            return DataTables::of($data)
                // ->filter(function ($query) use ($request) {
                //     if ($searchValue = $request->get('search')['value']) {
                //         $query->where(function ($q) use ($searchValue) {
                //             if (is_numeric($searchValue) && strlen($searchValue) == 4) {
                //                 $q->whereRaw("YEAR(kunjungan.tgl_masuk) = ?", [$searchValue]);
                //             } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $searchValue)) {
                //                 $q->whereRaw("CONVERT(varchar, kunjungan.tgl_masuk, 23) like ?", ["%{$searchValue}%"]);
                //             } elseif (preg_match('/^\d{2}:\d{2}$/', $searchValue)) {
                //                 $q->whereRaw("FORMAT(kunjungan.jam_masuk, 'HH:mm') like ?", ["%{$searchValue}%"]);
                //             } else {
                //                 $q->where('kunjungan.kd_pasien', 'like', "%{$searchValue}%")
                //                     ->orWhereHas('pasien', function ($q) use ($searchValue) {
                //                         $q->where('nama', 'like', "%{$searchValue}%")
                //                             ->orWhere('alamat', 'like', "%{$searchValue}%");
                //                     })
                //                     ->orWhereHas('dokter', function ($q) use ($searchValue) {
                //                         $q->where('nama_lengkap', 'like', "%{$searchValue}%");
                //                     })
                //                     ->orWhereHas('customer', function ($q) use ($searchValue) {
                //                         $q->where('customer', 'like', "%{$searchValue}%");
                //                     });
                //             }
                //         });
                //     }
                // })

                ->order(function ($query) {
                    $query->orderBy('order_hd.tgl_order', 'desc')
                        ->orderBy('order_hd.jam_order', 'desc');
                })
                ->addColumn('waktu_order', function ($row) {
                    $tglOrder = Carbon::parse($row->tgl_order)->format('d M Y');
                    $jamOrder = date('H:i', strtotime($row->jam_order));
                    return "$tglOrder $jamOrder";
                })
                ->addColumn('umur', function ($row) {
                    return hitungUmur($row->tgl_lahir);
                })
                ->addColumn('id_hash', function ($row) {
                    return encrypt($row->id);
                })
                ->make(true);
        }

        return view('unit-pelayanan.hemodialisa.pending-order');
    }

    public function terimaOrder($idEncrypt)
    {
        $id = decrypt($idEncrypt);
        // cek order
        $order = OrderHD::find($id);
        if (empty($order)) return back()->with('error', 'Order tidak ditemukan');

        // get kunjungan asal
        $dataMedis = $this->baseService->getDataMedisbyTransaksi($order->kd_kasir_asal, $order->no_transaksi_asal);

        if (empty($dataMedis)) return back()->with('error', 'data kunjungan asal tidak ditemukan');


        $transfer = RmeTransferPasienAntarRuang::with(['serahTerima'])
        ->whereHas('serahTerima',function($q){
            $q->where('kd_unit_tujuan',$this->kdUnitDef_);
        })
         ->where('kd_pasien',$dataMedis->kd_pasien)
         ->where('kd_unit',$dataMedis->kd_unit)
         ->where('tgl_masuk',$dataMedis->tgl_masuk)
         ->where('urut_masuk',$dataMedis->urut_masuk)
         ->orderBy('id','desc')
         ->first();
   
        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_bagian', 1)
            ->where('aktif', 1)
            ->whereNot('kd_unit', $dataMedis->kd_unit)
            ->get();

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();
       
        // get data serah terima
        $serahTerima = RmeSerahTerima::find($order->id_serah_terima);

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->where('kd_karyawan', '!=', Auth::user()->kd_karyawan)
            ->get();

        $dokterAll = Dokter::where('status', 1)
        ->orderBy('nama_lengkap', 'asc')->get();

        $dokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 215)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        $produk = Produk::select([
            'tarif.kd_produk',
            'produk.deskripsi',
            'tarif.tarif',
            'tarif.kd_unit',
            'tarif.tgl_berakhir',
            'tarif.tgl_berlaku'
        ])
            ->leftJoin('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
            ->where('tarif.kd_unit', $this->kdUnitDef_)
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
            ->whereRaw('LEFT(produk.kd_klas, 2) = ?', ['77'])
            ->orderBy('produk.deskripsi')
            ->orderBy('tarif.kd_unit')
            ->orderBy('tarif.kd_produk')
            ->orderBy('tarif.TGL_BERLAKU', 'desc')
            ->distinct()
            ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.order.terima.index', compact('dataMedis', 'order', 'serahTerima', 'petugas', 'produk', 'dokter','transfer','dokterAll'));
    }

    public function storeTerimaOrder(Request $request, $idEncrypt)
    {
        $id = decrypt($idEncrypt);

       

        // cek order
        $order = OrderHD::find($id);
        if (empty($order)) return back()->with('error', 'Order tidak ditemukan');
        if($order->status != 0) return back()->with('error', 'Order tidak valid!');

        // get kunjungan asal
        $dataMedis = $this->baseService->getDataMedisbyTransaksi($order->kd_kasir_asal, $order->no_transaksi_asal);
        if (empty($dataMedis)) return back()->with('error', 'data kunjungan asal tidak ditemukan');

        DB::beginTransaction();
        try {

            $tglSekarang = date('Y-m-d');
            $jamSekarang = date('H:i:s');

            // Ambil urut masuk terakhir untuk pasien yang sudah ada
            $getLastUrutMasukPatientToday = Kunjungan::select('urut_masuk')
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->whereDate('tgl_masuk', $tglSekarang)
                ->orderBy('urut_masuk', 'desc')
                ->first();

            $urut_masuk = !empty($getLastUrutMasukPatientToday) ? $getLastUrutMasukPatientToday->urut_masuk + 1 : 0;

            // Simpan ke tabel kunjungan
            $dataKunjungan = [
                'kd_pasien' => $dataMedis->kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_masuk' => $tglSekarang,
                'urut_masuk' => $urut_masuk,
                'kd_dokter' => $request->kd_dokter,
                'kd_rujukan' => 1,
                'kd_customer' => $dataMedis->kd_customer,
                'jam_masuk' => $jamSekarang,
                'cara_penerimaan' => 1,
                'asal_pasien' => $request->asal_pasien,
                'baru' => 1,
                'shift' => 1,
                'no_surat' => '',
                'kontrol' => 0,
            ];

            Kunjungan::create($dataKunjungan);


            // Simpan transaksi
            $lastTransaction = Transaksi::select('no_transaksi')
                ->where('kd_unit', $this->kdUnitDef_)
                ->where('kd_kasir', $request->kd_kasir)
                ->orderBy('no_transaksi', 'desc')
                ->first();

            if ($lastTransaction) {
                $lastTransactionNumber = (int) $lastTransaction->no_transaksi;
                $newTransactionNumber = $lastTransactionNumber + 1;
            } else {
                $newTransactionNumber = 1;
            }

            $formattedTransactionNumber = str_pad($newTransactionNumber, 7, '0', STR_PAD_LEFT);

            $dataTransaksi = [
                'kd_kasir' => $request->kd_kasir,
                'no_transaksi' => $formattedTransactionNumber,
                'kd_pasien' => $dataMedis->kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_transaksi' => $tglSekarang,
                'urut_masuk' => $urut_masuk,
                'co_status' => 0,
                'ispay' => 0,
                'app' => 0,
                'lunas' => 0,
            ];

            Transaksi::create($dataTransaksi);


            // Simpan detail_transaksi
            $dataDetailTransaksi = [
                'kd_kasir' => $request->kd_kasir,
                'no_transaksi' => $formattedTransactionNumber,
                'urut' => 1,
                'tgl_transaksi' => $tglSekarang,
                'kd_tarif' => 'TU',
                'kd_produk' => $request->kd_produk,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_berlaku' => $request->tgl_berlaku,
                'qty' => 1,
                'harga' => $request->tarif,
                'shift' => 1,
                'kd_unit_tr' => $order->kd_unit_order,
                'flag' => 0,
            ];

            DetailTransaksi::create($dataDetailTransaksi);

            // update order
            $order->status = 1;
            $order->kd_kasir_hd = $request->kd_kasir;
            $order->no_transaksi_hd = $formattedTransactionNumber;
            $order->kd_produk = $request->kd_produk;
            $order->save();

            // update serah terima
            // $serahTerima = RmeSerahTerima::find($order->id_serah_terima);

            // if (!empty($serahTerima)) {
            //     $serahTerima->tanggal_terima = $request->tanggal_terima;
            //     $serahTerima->jam_terima = $request->jam_terima;
            //     $serahTerima->petugas_terima = $request->petugas_terima;
            //     $serahTerima->status = 2;
            //     $serahTerima->save();
            // }

            DB::commit();
            return to_route('hemodialisa.pelayanan', [$dataMedis->kd_pasien, $tglSekarang, $urut_masuk])->with('success', 'Order berhasil diterima');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pelayanan($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.hemodialisa.pelayanan', compact('dataMedis'));
    }
}

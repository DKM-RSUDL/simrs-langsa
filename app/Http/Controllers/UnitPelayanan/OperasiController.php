<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\DokterKlinik;
use App\Models\DokterPenunjang;
use App\Models\Kunjungan;
use App\Models\OrderOK;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OperasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->where('kd_unit', 71);

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
                                    ->orWhereHas('customer', function ($q) use ($searchValue) {
                                        $q->where('customer', 'like', "%{$searchValue}%");
                                    });
                            }
                        });
                    }
                })

                ->order(function ($query) {
                    $query->orderBy('tgl_masuk', 'desc')
                        ->orderBy('jam_masuk', 'desc');
                })
                ->editColumn('tgl_masuk', fn($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
                ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
                ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
                ->addColumn('jaminan', fn($row) =>  $row->customer->customer ?: '-')
                ->addColumn('status_pelayanan', fn($row) => '' ?: '-')
                ->addColumn('keterangan', fn($row) => '' ?: '-')
                ->addColumn('tindak_lanjut', fn($row) => '' ?: '-')
                ->addColumn('no_antrian', fn($row) => '' ?: '-')
                // Hitung umur dari tabel pasien
                ->addColumn('umur', function ($row) {
                    return $row->pasien && $row->pasien->tgl_lahir
                        ? Carbon::parse($row->pasien->tgl_lahir)->age . ''
                        : 'Tidak diketahui';
                })
                ->addColumn('profile', fn($row) => $row)
                ->addColumn('action', fn($row) => $row->kd_pasien)
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }

        $dokter = DokterPenunjang::with(['dokter', 'unit'])
            ->where('kd_unit', 71)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.operasi.index', compact('dokter'));
    }

    public function pendingOrder(Request $request)
    {
        if ($request->ajax()) {
            $data = OrderOK::with(['produk', 'kamar', 'dokter', 'jenisOperasi', 'spesialisasi', 'subSpesialisasi'])
                ->select([
                    'order_ok.*',
                    'p.nama as nama_pasien',
                    'p.tgl_lahir',
                    'p.jenis_kelamin',
                    'p.alamat',
                    'c.customer as jaminan',
                    'k.kd_pasien',
                    'u.nama_unit as unit_order'
                ])
                ->join('transaksi as t', function ($q) {
                    $q->on('order_ok.kd_kasir', '=', 't.kd_kasir');
                    $q->on('order_ok.no_transaksi', '=', 't.no_transaksi');
                })
                ->join('kunjungan as k', function ($q) {
                    $q->on('t.kd_pasien', '=', 'k.kd_pasien');
                    $q->on('t.kd_unit', '=', 'k.kd_unit');
                    $q->on('t.tgl_transaksi', '=', 'k.tgl_masuk');
                    $q->on('t.urut_masuk', '=', 'k.urut_masuk');
                })
                ->join('customer as c', 'order_ok.penjamin', '=', 'c.kd_customer')
                ->join('pasien as p', 't.kd_pasien', '=', 'p.kd_pasien')
                ->join('unit as u', 'order_ok.kd_kamar_order', '=', 'u.kd_unit')
                ->where('status', 0);


            return DataTables::of($data)
                ->order(function ($query) {
                    $query->orderBy('order_ok.tgl_jadwal', 'desc')
                        ->orderBy('order_ok.jam_op', 'desc');
                })
                ->addColumn('waktu_order', function ($row) {
                    $tglOrder = Carbon::parse($row->tgl_jadwal)->format('d M Y');
                    $jamOrder = date('H:i', strtotime($row->jam_op));
                    return "$tglOrder $jamOrder";
                })
                ->addColumn('umur', function ($row) {
                    return hitungUmur($row->tgl_lahir);
                })
                ->make(true);
        }

        return view('unit-pelayanan.operasi.pending-order');
    }

    public function pelayanan($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->where('kd_unit', 71)
            ->where('kd_pasien', $kd_pasien)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.operasi.pelayanan.index', compact('dataMedis'));
    }
}

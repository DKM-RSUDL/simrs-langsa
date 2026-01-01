<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Kunjungan;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BerkasDigitalController extends Controller
{
    private $pelArr;
    private $pel;

    public function __construct(Request $request)
    {
        $this->pelArr = ['ri', 'rj']; // 'ri' for Rawat Inap, 'rj' for Rawat Jalan
        $this->pel = in_array($request->get('pel'), $this->pelArr) ? $request->get('pel') : 'ri';
    }


    private function dataTableRanap($request)
    {
        $unit_filter = $request->get('unit_filter');
        $customer_filter = $request->get('customer_filter');
        $status_filter = $request->get('status_filter');
        $startdate_filter = $request->get('startdate_filter');
        $enddate_filter = $request->get('enddate_filter');

        $data = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('nginap', function ($q) {
                $q->on('kunjungan.kd_pasien', 'nginap.kd_pasien');
                $q->on('kunjungan.kd_unit', 'nginap.kd_unit');
                $q->on('kunjungan.tgl_masuk', 'nginap.tgl_masuk');
                $q->on('kunjungan.urut_masuk', 'nginap.urut_masuk');
            })
            ->join('transaksi as t', function ($q) {
                $q->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $q->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $q->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $q->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('nginap.akhir', 1)
            ->where(function ($q) {
                $q->whereNull('kunjungan.status_inap');
                $q->orWhere('kunjungan.status_inap', 1);
            })
            ->whereNotNull('kunjungan.tgl_pulang')
            ->whereNotNull('kunjungan.jam_pulang')
            ->whereYear('kunjungan.tgl_masuk', '>=', 2025);

        if (! empty($unit_filter)) {
            $data->where('nginap.kd_unit_kamar', $unit_filter);
        }

        if (! empty($customer_filter)) {
            $data->where('kunjungan.kd_customer', $customer_filter);
        }

        if (! empty($status_filter)) {
            $data->where('kunjungan.status_klaim', $status_filter);
        }

        if (! empty($startdate_filter)) {
            $data->whereDate('kunjungan.tgl_masuk', '>=', $startdate_filter);
        }

        if (! empty($enddate_filter)) {
            $data->whereDate('kunjungan.tgl_masuk', '<=', $enddate_filter);
        }

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
                            $normalized = str_replace('-', '', $searchValue);
                            $q->whereRaw("REPLACE(kunjungan.kd_pasien, '-', '') like ?", ["%{$normalized}%"])
                                ->orWhereHas('pasien', function ($q) use ($searchValue, $normalized) {
                                    $q->whereRaw("REPLACE(kd_pasien, '-', '') like ?", ["%{$normalized}%"])
                                        ->orWhere('nama', 'like', "%{$searchValue}%")
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
                $query->orderBy('kunjungan.tgl_masuk', 'desc')
                    ->orderBy('kunjungan.jam_masuk', 'desc');
            })
            ->editColumn('tgl_masuk', fn($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
            ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
            ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
            ->addColumn('jaminan', fn($row) =>  $row->customer->customer ?: '-')
            // Hitung umur dari tabel pasien
            ->addColumn('umur', function ($row) {
                return hitungUmur($row->pasien->tgl_lahir);
            })
            ->addColumn('ruang', function ($row) {
                $unit = Unit::where('kd_unit', $row->kd_unit_kamar)->first();
                return !empty($unit) ? $unit->nama_unit : '-';
            })
            ->addColumn('profile', fn($row) => $row)
            ->addColumn('action', function ($row) {
                $payload = encrypt([
                    'kd_kasir' => $row->kd_kasir,
                    'no_transaksi' => $row->no_transaksi
                ]);

                return "<div class='text-center'>
                                <a href='#' class='btn btn-primary mb-2'>
                                    Lihat Data Klaim
                                </a>

                                <button class='btn btn-warning btnUnggahBerkas' data-ref='$payload'>
                                    Unggah Berkas Pasien
                                </button>
                            </div>";
            })
            ->rawColumns(['action', 'profile'])
            ->make(true);
    }

    private function dataTableRajal($request)
    {
        $unit_filter = $request->get('unit_filter');
        $customer_filter = $request->get('customer_filter');
        $status_filter = $request->get('status_filter');
        $startdate_filter = $request->get('startdate_filter');
        $enddate_filter = $request->get('enddate_filter');

        $data = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            // ->where('kunjungan.kd_unit', $kd_unit)
            // ->whereDate('kunjungan.tgl_masuk', '>=', now()->subDay()->format('Y-m-d'))
            // ->whereDate('kunjungan.tgl_masuk', '<=', now()->endOfDay()->format('Y-m-d'))
            ->whereYear('kunjungan.tgl_masuk', '>=', 2025)
            ->where('t.Dilayani', 1);


        if (! empty($unit_filter)) {
            $data->where('kunjungan.kd_unit', $unit_filter);
        }

        if (! empty($customer_filter)) {
            $data->where('kunjungan.kd_customer', $customer_filter);
        }

        if (! empty($status_filter)) {
            $data->where('kunjungan.status_klaim', $status_filter);
        }

        if (! empty($startdate_filter)) {
            $data->whereDate('kunjungan.tgl_masuk', '>=', $startdate_filter);
        }

        if (! empty($enddate_filter)) {
            $data->whereDate('kunjungan.tgl_masuk', '<=', $enddate_filter);
        }

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
            // Hitung umur dari tabel pasien
            ->addColumn('umur', function ($row) {
                return hitungUmur($row->pasien->tgl_lahir);
            })
            ->addColumn('ruang', fn($row) =>  $row->unit->nama_unit ?: '-')
            ->addColumn('profile', fn($row) => $row)
            ->addColumn('action', function ($row) {
                $payload = encrypt([
                    'kd_kasir' => $row->kd_kasir,
                    'no_transaksi' => $row->no_transaksi
                ]);

                return "<div class='text-center'>
                                <a href='#' class='btn btn-primary mb-2'>
                                    Lihat Data Klaim
                                </a>

                                <button class='btn btn-warning btnUnggahBerkas' data-ref='$payload'>
                                    Unggah Berkas Pasien
                                </button>
                            </div>";
            })
            ->rawColumns(['action', 'profile'])
            ->make(true);
    }

    public function index(Request $request)
    {
        $kdBagian = $this->pel == 'rj' ? 2 : 1;
        $unit = Unit::where('kd_bagian', $kdBagian)->where('aktif', 1)->get();
        $customer = Customer::where('aktif', 1)->get();


        if ($request->ajax()) {
            if ($this->pel == 'ri') {
                return $this->dataTableRanap($request);
            }

            if ($this->pel == 'rj') {
                return $this->dataTableRajal($request);
            }

            return response()->json(['data' => []]);
        }

        return view('berkas-digital.document.index', compact('unit', 'customer'));
    }
}
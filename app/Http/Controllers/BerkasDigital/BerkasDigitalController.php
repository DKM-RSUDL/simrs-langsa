<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Kunjungan;
use App\Models\MasterBerkasDigital;
use App\Models\RmeDokumenBerkasDigital;
use App\Models\Unit;
use App\Services\BaseService;
use App\Services\BerkasDigitalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BerkasDigitalController extends Controller
{
    private $pelArr;
    private $pel;
    private $baseService;
    private $berkasDigitalService;

    public function __construct(Request $request)
    {
        $this->pelArr = ['ri', 'rj']; // 'ri' for Rawat Inap, 'rj' for Rawat Jalan
        $this->pel = in_array($request->get('pel'), $this->pelArr) ? $request->get('pel') : 'ri';
        $this->baseService = new BaseService();
        $this->berkasDigitalService = new BerkasDigitalService();
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
            // ->where('nginap.akhir', 1)
            // ->where(function ($q) {
            //     $q->whereNull('kunjungan.status_inap');
            //     $q->orWhere('kunjungan.status_inap', 1);
            // })
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

                $unit = Unit::where('kd_unit', $row->kd_unit_kamar)->first();
                $tglMasuk = date('d-m-Y', strtotime($row->tgl_masuk));

                return "<div class='text-center'>
                                <a href='/berkas-digital/dokumen/show?ref={$payload}' class='btn btn-primary mb-2'>
                                    Lihat Data Klaim
                                </a>

                                <button class='btn btn-warning btnUnggahBerkas' data-nama='{$row->pasien->nama}' data-rm='{$row->kd_pasien}' data-unit='{$unit->nama_unit}' data-tgl='{$tglMasuk}' data-ref='{$payload}'>
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

                $tglMasuk = date('d-m-Y', strtotime($row->tgl_masuk));

                return "<div class='text-center'>
                                <a href='#' class='btn btn-primary mb-2'>
                                    Lihat Data Klaim
                                </a>

                                <button class='btn btn-warning btnUnggahBerkas' data-nama='{$row->pasien->nama}' data-rm='{$row->kd_pasien}' data-unit='{$row->unit->nama_unit}' data-tgl='{$tglMasuk}' data-ref='{$payload}'>
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
        $jenisBerkas = MasterBerkasDigital::all();


        if ($request->ajax()) {
            if ($this->pel == 'ri') {
                return $this->dataTableRanap($request);
            }

            if ($this->pel == 'rj') {
                return $this->dataTableRajal($request);
            }

            return response()->json(['data' => []]);
        }

        return view('berkas-digital.document.index', compact('unit', 'customer', 'jenisBerkas'));
    }

    public function show(Request $request)
    {
        $ref = $request->get('ref');
        if (empty($ref)) {
            return abort(404, 'Parameter kunjungan tidak ditemukan');
        }
        try {
            $refDecrypted = decrypt($ref);
        } catch (\Exception $e) {
            return abort(404, 'Parameter kunjungan tidak valid');
        }

        // Ambil data medis terkait
        $dataMedis = $this->baseService->getDataMedisbyTransaksi($refDecrypted['kd_kasir'], $refDecrypted['no_transaksi']);
        if (!$dataMedis) {
            return abort(404, 'Data kunjungan tidak ditemukan');
        }

        // Ambil semua dokumen berkas digital berdasarkan transaksi
        $listDokumen = RmeDokumenBerkasDigital::with(['jenisBerkas', 'userCreate'])
            ->where('kd_kasir', $refDecrypted['kd_kasir'])
            ->where('no_transaksi', $refDecrypted['no_transaksi'])
            ->get();

        $pasien = isset($dataMedis->pasien) ? $dataMedis->pasien : null;
        $unit = isset($dataMedis->unit) ? $dataMedis->unit : null;
        $customer = isset($dataMedis->customer) ? $dataMedis->customer : null;

        // Ambil data asesmen via service
        $asesmenData = $this->berkasDigitalService->getAsesmenData($dataMedis);
        extract($asesmenData); // Bikin $asesmen, $triase, $riwayatAlergi tersedia

        return view('berkas-digital.document.show', compact('listDokumen', 'dataMedis', 'pasien', 'unit', 'customer', 'asesmen', 'triase', 'riwayatAlergi'));
    }

    public function storeBerkas(Request $request)
    {
        DB::beginTransaction();

        try {
            $ref = $request->get('ref');
            if (empty($ref)) throw new Exception("Parameter kunjungan tidak ditemukan!");
            $refDecrypted = decrypt($ref);

            // validation request
            $validator = Validator::make($request->all(), [
                'jenis_berkas' => 'required|exists:rme_mr_berkas_digital,id',
                'file_berkas' => 'required|file|mimes:pdf|max:3072',
            ], [
                'jenis_berkas.required' => 'Jenis berkas wajib diisi.',
                'jenis_berkas.exists' => 'Jenis berkas tidak valid.',
                'file_berkas.required' => 'File berkas wajib diunggah.',
                'file_berkas.file' => 'File berkas harus berupa file yang valid.',
                'file_berkas.mimes' => 'File berkas harus berformat PDF.',
                'file_berkas.max' => 'Ukuran file berkas maksimal 3MB.',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                throw new Exception(implode(' ', $errors));
            }

            // get kunjungan data
            $dataMedis = $this->baseService->getDataMedisbyTransaksi($refDecrypted['kd_kasir'], $refDecrypted['no_transaksi']);
            if (empty($dataMedis)) throw new Exception("Data kunjungan tidak ditemukan!");

            // get request
            $jenisBerkasId = $request->jenis_berkas;
            $fileBerkas = $request->file('file_berkas');

            // get jenis berkas
            $jenisBerkas = MasterBerkasDigital::find($jenisBerkasId);
            if (empty($jenisBerkas)) throw new Exception("Jenis berkas tidak ditemukan!");

            // store file berkas
            $path = $fileBerkas->store("uploads/berkas_digital/$dataMedis->kd_kasir/$dataMedis->no_transaksi/$jenisBerkas->slug");
            if (empty($path)) throw new Exception("Gagal menyimpan berkas pasien.");

            RmeDokumenBerkasDigital::create([
                'kd_kasir' => $dataMedis->kd_kasir,
                'no_transaksi' => $dataMedis->no_transaksi,
                'file' => $path,
                'jenis_berkas_id' => $jenisBerkas->id,
                'user_create' => Auth::user()->karyawan->kd_karyawan
            ]);

            DB::commit();
            return to_route('berkas-digital.dokumen.index', $request->except(['_token', 'ref', 'jenis_berkas', 'file_berkas']))->with('success', "Berkas $jenisBerkas->nama_berkas pasien {$dataMedis->pasien->nama} berhasil diunggah.");
        } catch (Exception $e) {
            DB::rollBack();
            return to_route('berkas-digital.dokumen.index', $request->except(['_token', 'ref', 'jenis_berkas', 'file_berkas']))->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $dokumen = RmeDokumenBerkasDigital::find($id);
        if (!$dokumen) {
            return back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Hapus file fisik jika ada
        if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
            Storage::disk('public')->delete($dokumen->file);
        }

        $dokumen->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}

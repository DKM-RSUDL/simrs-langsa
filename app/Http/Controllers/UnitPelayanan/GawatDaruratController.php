<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\DataTriase;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmeSerahTerima;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\Transaksi;
use App\Models\Unit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Services\AsesmenService;


class GawatDaruratController extends Controller
{
    protected $roleService;
    protected $asesmenService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
        $this->asesmenService = new AsesmenService();
    }

    public function index(Request $request)
    {
        $tglBatasData = date('Y-m-d', strtotime('-2 days', strtotime(date('Y-m-d'))));

        if ($request->ajax()) {
            $dokterFilter = $request->get('dokter');

            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_unit', 3)
                ->where('t.Dilayani', 0)
                ->where('t.co_status', 0)
                ->whereNull('kunjungan.tgl_keluar')
                ->whereNull('kunjungan.jam_keluar');
            // ->whereDate('tgl_masuk', '>=', $tglBatasData);

            // Filte dokter
            if (! empty($dokterFilter)) {
                $data->where('kd_dokter', $dokterFilter);
            }

            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($searchValue = $request->get('search')['value']) {
                        $query->where(function ($q) use ($searchValue) {
                            if (is_numeric($searchValue) && strlen($searchValue) == 4) {
                                $q->whereRaw('YEAR(kunjungan.tgl_masuk) = ?', [$searchValue]);
                            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $searchValue)) {
                                $q->whereRaw('CONVERT(varchar, kunjungan.tgl_masuk, 23) like ?', ["%{$searchValue}%"]);
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
                ->editColumn('tgl_masuk', fn ($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
                ->addColumn('triase', fn ($row) => $row->kd_triase ?: '-')
                ->addColumn('bed', fn ($row) => '' ?: '-')
                ->addColumn('no_rm', fn ($row) => $row->kd_pasien ?: '-')
                ->addColumn('alamat', fn ($row) => $row->pasien->alamat ?: '-')
                ->addColumn('jaminan', fn ($row) => $row->customer->customer ?: '-')
                ->addColumn('instruksi', fn ($row) => '' ?: '-')
                ->addColumn('kd_dokter', fn ($row) => $row->dokter->nama ?: '-')
                ->addColumn('waktu_masuk', function ($row) {

                    $tglMasuk = Carbon::parse($row->tgl_masuk)->format('d M Y');
                    $jamMasuk = date('H:i', strtotime($row->jam_masuk));

                    return "$tglMasuk $jamMasuk";
                })
                // Hitung umur dari tabel pasien
                ->addColumn('umur', function ($row) {
                    return $row->pasien && $row->pasien->tgl_lahir
                        ? Carbon::parse($row->pasien->tgl_lahir)->age.''
                        : 'Tidak diketahui';
                })
                ->addColumn('action', fn ($row) => $row->kd_pasien)  // Return raw data, no HTML
                ->addColumn('del', fn ($row) => $row->kd_pasien)     // Return raw data
                ->addColumn('profile', fn ($row) => $row)
                ->rawColumns(['action', 'del', 'profile'])
                ->make(true);
        }

        $dokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.gawat-darurat.index', compact('dokter'));
    }

    public function getTriaseData(Request $request)
    {
        try {
            $kdKasir = $request->kd_kasir;
            $noTrx = $request->no_transaksi;

            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit', 'getVitalSign'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('t.kd_kasir', $kdKasir)
                ->where('t.no_transaksi', $noTrx)
                ->first();

            $triaseData = DataTriase::find($dataMedis->triase_id);

            return response()->json([
                'status' => 'success',
                'message' => 'OK',
                'data' => [
                    'kunjungan' => $dataMedis,
                    'triase' => $triaseData,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ]);
        }
    }

    public function updateFotoTriase($kd_kasir, $no_transaksi, Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'foto_pasien' => 'nullable|file|image|max:3072',
                'triase_id' => 'required',
            ]);

            if ($validator->fails()) {
                throw new Exception('Terjadi kesalahan pada input form !');
            }

            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit', 'getVitalSign'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('t.kd_kasir', $kd_kasir)
                ->where('t.no_transaksi', $no_transaksi)
                ->first();

            if (empty($dataMedis)) {
                throw new Exception('Kunjungan Pasien tidak ditemukan !');
            }
            if ($dataMedis->triase_id != $request->triase_id) {
                throw new Exception('Request perubahan tidak valid !');
            }

            $triaseData = DataTriase::find($request->triase_id);
            if (empty($triaseData)) {
                throw new Exception('Triase Pasien tidak ditemukan !');
            }

            if ($request->hasFile('foto_pasien')) {
                $file = $request->file('foto_pasien');

                // delete foto lama
                if (Storage::exists($file)) {
                    Storage::delete($file);
                }

                // store
                $path = $file->store('uploads/triase/'.date('Y-m-d', strtotime($dataMedis->tgl_masuk))."/$dataMedis->kd_pasien/$dataMedis->urut_masuk");
                $triaseData->foto_pasien = $path;
                $triaseData->save();

                DB::commit();

                return back()->with('success', 'Foto triase pasien berhasil di ubah !');
            } else {
                throw new Exception('Tidak ada perubahan foto triase');
            }
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function triaseIndex()
    {
        $dokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.triase.index', compact('dokter'));
    }

    public function storeTriase(Request $request)
    {
        DB::beginTransaction();

        try {
            $no_rm = $request->no_rm ?? null;

            // Ambil data pasien
            $pasien = Pasien::where('kd_pasien', $no_rm)->first();

            // Ambil data dari request
            $dokter_triase = $request->dokter_triase;
            $tgl_masuk = $request->tgl_masuk;
            $jam_masuk = $request->jam_masuk;
            $nama_pasien = $request->nama_pasien;
            $usia_tahun = $request->usia_tahun ?? 18;
            $usia_bulan = $request->usia_bulan ?? 5;
            $jenis_kelamin = ! empty($pasien) ? $pasien->jenis_kelamin : $request->jenis_kelamin;
            $rujukan = $request->rujukan;
            $rujukan_ket = $request->rujukan_ket ?? null;
            $tanggal_lahir = Carbon::now()->subYears($usia_tahun)->subMonths($usia_bulan)->format('Y-m-d');
            $tanggal_lahir = ! empty($pasien) ? date('Y-m-d', strtotime($pasien->tgl_lahir)) : $tanggal_lahir;
            $hasil_triase = $request->ket_triase;
            $kode_triase = $request->kd_triase;
            $dataTriase = [
                'hasil_triase' => $hasil_triase,
                'kode_triase' => $kode_triase,
                'air_way' => $request->airway ?? null,
                'breathing' => $request->breathing ?? null,
                'circulation' => $request->circulation ?? null,
                'disability' => $request->disability ?? null,
            ];

            // Tentukan nomor IGD baru
            $prefix = 'IGD-';
            $lastIgdNumber = Pasien::select('kd_pasien')
                ->where('kd_pasien', 'like', "$prefix%")
                ->orderBy('kd_pasien', 'desc')
                ->first();

            if (empty($lastIgdNumber)) {
                $lastIgdNumber = $prefix.'000001';
            } else {
                $lastIgdNumber = $lastIgdNumber->kd_pasien;
                $lastIgdNumber = explode('-', $lastIgdNumber);
                $lastIgdNumber = $lastIgdNumber[1];
                $lastIgdNumber = (int) $lastIgdNumber + 1;
                $lastIgdNumber = str_pad($lastIgdNumber, 6, '0', STR_PAD_LEFT);
                $lastIgdNumber = $prefix.$lastIgdNumber;
            }

            // Gunakan kd_pasien jika pasien sudah ada
            if (! empty($pasien)) {
                $lastIgdNumber = $pasien->kd_pasien;
            }

            $finalNoRm = $lastIgdNumber;

            // Upload foto pasien
            $pathFotoPasien = $request->hasFile('foto_pasien') ? $request->file('foto_pasien')->store('uploads/gawat-darurat/triase') : '';

            // Simpan ke tabel data_triase
            $triase = new DataTriase;
            $triase->nama_pasien = $nama_pasien;
            $triase->usia = $usia_tahun;
            $triase->usia_bulan = $usia_bulan;
            $triase->jenis_kelamin = $jenis_kelamin;
            $triase->tanggal_lahir = $tanggal_lahir;
            $triase->status = 1;
            $triase->kd_pasien = null;
            $triase->kd_pasien_triase = $finalNoRm;
            $triase->keterangan = null;
            $triase->tanggal_triase = "$tgl_masuk $jam_masuk";
            $triase->triase = json_encode($dataTriase);
            $triase->hasil_triase = $hasil_triase;
            $triase->dokter_triase = $dokter_triase;
            $triase->kode_triase = $kode_triase;
            $triase->foto_pasien = $pathFotoPasien;
            $triase->save();

            // Simpan ke tabel pasien jika pasien baru
            if (empty($pasien)) {
                $dataPasien = [
                    'kd_pasien' => $finalNoRm,
                    'nama' => $nama_pasien,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tempat_lahir' => '',
                    'tgl_lahir' => $tanggal_lahir,
                    'kd_agama' => 0,
                    'gol_darah' => 0,
                    'status_marita' => 0,
                    'alamat' => '',
                    'telepon' => '',
                    'kd_kelurahan' => null,
                    'kd_pendidikan' => null,
                    'kd_pekerjaan' => 16, // lain-lain
                    'no_pengenal' => '',
                    'no_asuransi' => '',
                    'pemegang_asuransi' => '',
                    'jns_peserta' => '',
                    'wni' => 0,
                    'kd_suku' => null,
                    'tanda_pengenal' => 0,
                    'kd_pos' => null,
                    'nama_keluarga' => '',
                    'ibu_kandung' => null,
                    'kelas' => null,
                    'kd_bahasa' => 0,
                    'kd_cacat' => 0,
                    'email' => '',
                    'gelar_dpn' => '',
                    'gelar_blkg' => '',
                    'kd_negara' => '',
                    'tgl_pass' => null,
                ];

                Pasien::create($dataPasien);
            }

            // Ambil antrian terakhir
            $getLastAntrianToday = Kunjungan::select('antrian')
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('kd_unit', 3)
                ->orderBy('antrian', 'desc')
                ->first();

            $no_antrian = ! empty($getLastAntrianToday) ? $getLastAntrianToday->antrian + 1 : 1;

            // Ambil urut masuk terakhir untuk pasien yang sudah ada
            $urut_masuk = 0;
            if (! empty($pasien)) {
                $getLastUrutMasukPatientToday = Kunjungan::select('urut_masuk')
                    ->where('kd_pasien', $pasien->kd_pasien)
                    ->whereDate('tgl_masuk', $tgl_masuk)
                    ->orderBy('urut_masuk', 'desc')
                    ->first();

                $urut_masuk = ! empty($getLastUrutMasukPatientToday) ? $getLastUrutMasukPatientToday->urut_masuk + 1 : $urut_masuk;
            }

            // Simpan ke tabel kunjungan
            $dataKunjungan = [
                'kd_pasien' => $finalNoRm,
                'kd_unit' => 3,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'jam_masuk' => $jam_masuk,
                'asal_pasien' => 0,
                'cara_penerimaan' => 99,
                'kd_rujukan' => 0,
                'no_surat' => '',
                'kd_dokter' => $dokter_triase,
                'baru' => 1,
                'kd_customer' => '0000000001',
                'shift' => 0,
                'kontrol' => 0,
                'antrian' => $no_antrian,
                'tgl_surat' => $tgl_masuk,
                'jasa_raharja' => 0,
                'catatan' => '',
                'kd_triase' => $kode_triase,
                'is_rujukan' => $rujukan,
                'rujukan_ket' => $rujukan_ket,
                'triase_id' => $triase->id,
            ];

            Kunjungan::create($dataKunjungan);

            // Hapus rujukan_kunjungan
            RujukanKunjungan::where('kd_pasien', $finalNoRm)
                ->where('kd_unit', 3)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->delete();

            // Simpan transaksi
            $lastTransaction = Transaksi::select('no_transaksi')
                ->where('kd_unit', 3)
                ->where('kd_kasir', '06')
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
                'kd_kasir' => '06',
                'no_transaksi' => $formattedTransactionNumber,
                'kd_pasien' => $finalNoRm,
                'kd_unit' => 3,
                'tgl_transaksi' => $tgl_masuk,
                'app' => 0,
                'ispay' => 0,
                'co_status' => 0,
                'urut_masuk' => $urut_masuk,
                'kd_user' => $dokter_triase,
                'lunas' => 0,
            ];

            Transaksi::create($dataTransaksi);

            // Simpan vital sign menggunakan service
            $vitalSignData = [
                'sistole' => $request->sistole ? (int) $request->sistole : null,
                'diastole' => $request->diastole ? (int) $request->diastole : null,
                'nadi' => $request->nadi ? (int) $request->nadi : null,
                'respiration' => $request->respiration ? (int) $request->respiration : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
                'spo2_tanpa_o2' => $request->sao2 ? (int) $request->sao2 : null,
                'tinggi_badan' => $request->tinggi_badan ? (int) $request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int) $request->berat_badan : null,
            ];

            $this->asesmenService->store($vitalSignData, $finalNoRm, '06', $formattedTransactionNumber);

            // Simpan detail_transaksi
            $dataDetailTransaksi = [
                'no_transaksi' => $formattedTransactionNumber,
                'kd_kasir' => '06',
                'tgl_transaksi' => $tgl_masuk,
                'urut' => 1,
                'kd_tarif' => 'TU',
                'kd_produk' => 3634,
                'kd_unit' => 3,
                'kd_unit_tr' => 3,
                'tgl_berlaku' => '2019-07-01',
                'kd_user' => $dokter_triase,
                'shift' => 0,
                'harga' => 15000,
                'qty' => 1,
                'flag' => 0,
                'jns_trans' => 0,
            ];

            DetailTransaksi::create($dataDetailTransaksi);

            // Simpan detail_prsh
            $dataDetailPrsh = [
                'kd_kasir' => '06',
                'no_transaksi' => $formattedTransactionNumber,
                'urut' => 1,
                'tgl_transaksi' => $tgl_masuk,
                'hak' => 15000,
                'selisih' => 0,
                'disc' => 0,
            ];

            DetailPrsh::create($dataDetailPrsh);

            // Hapus detail_component
            DetailComponent::where('kd_kasir', '06')
                ->where('no_transaksi', $formattedTransactionNumber)
                ->where('urut', 1)
                ->delete();

            // Simpan detail_component
            $dataDetailComponent = [
                'kd_kasir' => '06',
                'no_transaksi' => $formattedTransactionNumber,
                'tgl_transaksi' => $tgl_masuk,
                'urut' => 1,
                'kd_component' => '30',
                'tarif' => 15000,
                'disc' => 0,
            ];

            DetailComponent::create($dataDetailComponent);

            // Simpan sjp_kunjungan
            $sjpKunjunganData = [
                'kd_pasien' => $finalNoRm,
                'kd_unit' => 3,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'no_sjp' => '',
                'penjamin_laka' => 0,
                'katarak' => 0,
                'dpjp' => $dokter_triase,
                'cob' => 0,
            ];

            SjpKunjungan::create($sjpKunjunganData);

            DB::commit();

            return to_route('gawat-darurat.index')->with('success', 'Data triase berhasil ditambah');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function getPatientByNikAjax(Request $request)
    {
        try {
            $pasien = Pasien::where(function ($q) use ($request) {
                $q->where('no_pengenal', $request->nik)
                    ->orWhere('kd_pasien', $request->nik);
            })
                ->first();

            if (empty($pasien)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                    'data' => [],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data ditemukan',
                    'data' => $pasien,
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ]. 500);
        }
    }

    public function getPatientByNamaAjax(Request $request)
    {

        try {
            $pasien = Pasien::where('nama', 'LIKE', "%$request->nama%")
                ->get();

            if (empty($pasien)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                    'data' => [],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data ditemukan',
                    'data' => $pasien,
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ]. 500);
        }
    }

    public function getPatientByAlamatAjax(Request $request)
    {

        try {
            $pasien = Pasien::where('alamat', 'LIKE', "%$request->alamat%")
                ->get();

            if (empty($pasien)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                    'data' => [],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data ditemukan',
                    'data' => $pasien,
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ]. 500);
        }
    }

    public function serahTerimaPasien($kd_pasien, $tgl_masuk, $urut_masuk)
    {

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (! $dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $serahTerimaData = RmeSerahTerima::with(['unitAsal', 'unitTujuan', 'petugasAsal', 'petugasTerima'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit_asal', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (empty($serahTerimaData)) {
            abort(404, 'Data serah terima tidak ditemukan !');
        }

        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_bagian', 1)->where('aktif', 1)->get();

        $petugasIGD = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('kd_ruangan', 36)
            ->where('status_peg', 1)
            ->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.serah-terima-pasien.index', compact('dataMedis', 'serahTerimaData', 'unit', 'unitTujuan', 'petugasIGD'));
    }

    public function getPetugasByUnit(Request $request)
    {
        // dd($request);
        $kdUnit = $request->kd_unit;

        if (! $kdUnit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode unit tidak ditemukan!',
                'data' => [],
            ]);
        }

        $users = User::join('hrd_karyawan', 'rme_users.kd_karyawan', '=', 'hrd_karyawan.kd_karyawan')
            ->join('hrd_ruangan', 'hrd_karyawan.kd_ruangan', '=', 'hrd_ruangan.kd_ruangan')
            ->select('rme_users.id', 'rme_users.name')
            ->where('hrd_ruangan.kd_unit', $kdUnit)
            ->get();

        // if ($users->isEmpty()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Tidak ada petugas di unit ini!',
        //         'data' => []
        //     ]);
        // }

        $petugasOptions = '<option value="">--pilih petugas--</option>';
        foreach ($users as $user) {
            $petugasOptions .= "<option value='{$user->id}'>{$user->name}</option>";
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data petugas berhasil diambil.',
            'data' => [
                'petugasOption' => $petugasOptions,
            ],
        ]);
    }

    public function serahTerimaPasienCreate($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {

            // validasi
            $request->validate([
                'subjective' => 'required',
                'background' => 'required',
                'assessment' => 'required',
                'recomendation' => 'required',
                'petugas_menyerahkan' => 'required',
                'tanggal_menyerahkan' => 'required|date_format:Y-m-d',
                'jam_menyerahkan' => 'required|date_format:H:i',
            ]);

            // data
            $data = [
                'subjective' => $request->subjective,
                'background' => $request->background,
                'assessment' => $request->assessment,
                'recomendation' => $request->recomendation,
                'petugas_menyerahkan' => $request->petugas_menyerahkan,
                'tanggal_menyerahkan' => $request->tanggal_menyerahkan,
                'jam_menyerahkan' => $request->jam_menyerahkan,
                'status' => 1,
            ];

            $id = decrypt($idEncrypt);
            RmeSerahTerima::where('id', $id)->update($data);

            DB::commit();

            return to_route('gawat-darurat.index')->with('success', 'Pasien berhasil diserahkan ke rawat inap!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}

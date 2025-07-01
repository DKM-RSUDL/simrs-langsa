<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\HrdKaryawan;
use App\Models\RmeHdFormulirEdukasiPasien;
use App\Models\RmeHdFormulirEdukasiPasienDetail;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HDEdukasiController extends Controller
{
    private $kdUnitDef_;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();

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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $hdFormulirEdukasiPasien = RmeHdFormulirEdukasiPasien::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', 72)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal_create', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.hemodialisa.pelayanan.edukasi.index', compact(
            'dataMedis',
            'hdFormulirEdukasiPasien'
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $perawat = HrdKaryawan::where('status_peg', 1)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.edukasi.create', compact(
            'dataMedis',
            'perawat'
        ));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
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

            // === SIMPAN DATA UTAMA (SATU RECORD) ===
            $HdFormulirEdukasiPasien = new RmeHdFormulirEdukasiPasien();
            $HdFormulirEdukasiPasien->kd_pasien = $kd_pasien;
            $HdFormulirEdukasiPasien->kd_unit = $this->kdUnitDef_;
            $HdFormulirEdukasiPasien->tgl_masuk = $tgl_masuk;
            $HdFormulirEdukasiPasien->urut_masuk = $urut_masuk;
            $HdFormulirEdukasiPasien->user_create = Auth::id();
            $HdFormulirEdukasiPasien->tanggal_create = Carbon::now();

            // Handle kemampuan bahasa dengan detail
            $kemampuanBahasaData = [];
            if ($request->kemampuan_bahasa) {
                foreach ($request->kemampuan_bahasa as $bahasa) {
                    $bahasaItem = ['bahasa' => $bahasa];

                    if ($bahasa === 'Daerah' && $request->bahasa_daerah_detail) {
                        $bahasaItem['detail'] = $request->bahasa_daerah_detail;
                    } elseif ($bahasa === 'Asing' && $request->bahasa_asing_detail) {
                        $bahasaItem['detail'] = $request->bahasa_asing_detail;
                    }

                    $kemampuanBahasaData[] = $bahasaItem;
                }
            }

            // Data section 1 & 2 (JSON) - HANYA DATA INI DI TABEL UTAMA
            $HdFormulirEdukasiPasien->tinggal_bersama = $request->tinggal_bersama ? json_encode($request->tinggal_bersama) : null;
            $HdFormulirEdukasiPasien->kemampuan_bahasa = !empty($kemampuanBahasaData) ? json_encode($kemampuanBahasaData) : null;
            $HdFormulirEdukasiPasien->cara_edukasi = $request->cara_edukasi ? json_encode($request->cara_edukasi) : null;
            $HdFormulirEdukasiPasien->hambatan = $request->hambatan ? json_encode($request->hambatan) : null;
            $HdFormulirEdukasiPasien->kebutuhan_edukasi = $request->kebutuhan_edukasi ? json_encode($request->kebutuhan_edukasi) : null;

            // Field radio button
            $HdFormulirEdukasiPasien->perlu_penerjemah = (int)($request->perlu_penerjemah ?? 0);
            $HdFormulirEdukasiPasien->baca_tulis = (int)($request->baca_tulis ?? 0);
            $HdFormulirEdukasiPasien->hambatan_status = (int)($request->hambatan_status ?? 0);
            $HdFormulirEdukasiPasien->ketersediaan_edukasi = (int)($request->ketersediaan_edukasi ?? 0);

            $HdFormulirEdukasiPasien->save();

            // === SIMPAN DATA EDUKASI DETAIL MENGGUNAKAN MODEL ===
            if ($request->edukasi) {
                foreach ($request->edukasi as $topikKey => $data) {
                    if (!isset($data['tgl_jam']) || empty($data['tgl_jam'])) {
                        continue;
                    }

                    $edukatorNama = $data['edukator_nama'] ?? null;
                    if (empty($edukatorNama) && !empty($data['edukator_kd'])) {
                        $edukator = HrdKaryawan::where('kd_karyawan', $data['edukator_kd'])->first();
                        if ($edukator) {
                            $edukatorNama = trim(($edukator->gelar_depan ?? '') . ' ' . $edukator->nama . ' ' . ($edukator->gelar_belakang ?? ''));
                        }
                    }

                    RmeHdFormulirEdukasiPasienDetail::create([
                        'formulir_edukasi_id' => $HdFormulirEdukasiPasien->id,
                        'topik_edukasi' => $topikKey,
                        'tgl_jam' => $data['tgl_jam'] ? Carbon::parse($data['tgl_jam']) : null,
                        'hasil_verifikasi' => $data['hasil_verifikasi'] ?? null,
                        'tgl_reedukasi' => $data['tgl_reedukasi'] ? Carbon::parse($data['tgl_reedukasi'])->format('Y-m-d') : null,
                        'edukator_kd' => $data['edukator_kd'] ?? null,
                        'edukator_nama' => $edukatorNama ?? null,
                        'pasien_nama' => $data['pasien_nama'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return to_route('hemodialisa.pelayanan.edukasi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Formulir edukasi berhasil disimpan!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $perawat = HrdKaryawan::where('status_peg', 1)->get();

        // Load asesmen dengan relasi edukasiDetails
        $hdFormulirEdukasiPasien = RmeHdFormulirEdukasiPasien::findOrFail($id);

        // Parse JSON data untuk form (Section 1 & 2)
        $formData = [
            'tinggal_bersama' => json_decode($hdFormulirEdukasiPasien->tinggal_bersama, true) ?? [],
            'kemampuan_bahasa' => json_decode($hdFormulirEdukasiPasien->kemampuan_bahasa, true) ?? [],
            'cara_edukasi' => json_decode($hdFormulirEdukasiPasien->cara_edukasi, true) ?? [],
            'hambatan' => json_decode($hdFormulirEdukasiPasien->hambatan, true) ?? [],
            'kebutuhan_edukasi' => json_decode($hdFormulirEdukasiPasien->kebutuhan_edukasi, true) ?? [],
            'perlu_penerjemah' => $hdFormulirEdukasiPasien->perlu_penerjemah,
            'baca_tulis' => $hdFormulirEdukasiPasien->baca_tulis,
            'hambatan_status' => $hdFormulirEdukasiPasien->hambatan_status,
            'ketersediaan_edukasi' => $hdFormulirEdukasiPasien->ketersediaan_edukasi,
        ];

        // Extract detail bahasa
        $bahasaDetails = [
            'bahasa_daerah_detail' => '',
            'bahasa_asing_detail' => ''
        ];

        foreach ($formData['kemampuan_bahasa'] as $item) {
            if (is_array($item) && isset($item['bahasa'], $item['detail'])) {
                if ($item['bahasa'] === 'Daerah') {
                    $bahasaDetails['bahasa_daerah_detail'] = $item['detail'];
                } elseif ($item['bahasa'] === 'Asing') {
                    $bahasaDetails['bahasa_asing_detail'] = $item['detail'];
                }
            }
        }

        // Flatten kemampuan bahasa untuk checkbox
        $selectedBahasa = [];
        foreach ($formData['kemampuan_bahasa'] as $item) {
            if (is_array($item) && isset($item['bahasa'])) {
                $selectedBahasa[] = $item['bahasa'];
            } else if (is_string($item)) {
                $selectedBahasa[] = $item;
            }
        }
        $formData['kemampuan_bahasa'] = $selectedBahasa;

        // === LOAD DATA EDUKASI DETAIL DARI TABEL TERPISAH (Section 3) ===
        // $edukasiDetails = RmeHdFormulirEdukasiPasienDetail::where('formulir_edukasi_id', $id)->get();

        // // Daftar lengkap topik edukasi yang tersedia (sesuai dengan yang di blade)
        $topikEdukasiList = [
            'hak_kewajiban_pasien' => 'Hak dan Kewajiban pasien dan Keluarga',
            'identitas_pasien_gelang' => 'Identitas pasien (gelang warna hijau, merah muda, kuning, merah, ungu)',
            'penyebab_gagal_ginjal' => 'Penyebab gagal ginjal',
            'arti_kegunaan_hemodialisis' => 'Arti dan Kegunaan Hemodialisis',
            'jumlah_jam_hemodialisis' => 'Jumlah/jam hemodialisis dan frekuensi hemodialisi',
            'kepatuhan_intake_cairan' => 'Meningkatkan Kepatuhan intake cairan pasien',
            'makanan_tidak_boleh' => 'Makanan yang tidak boleh dimakan',
            'cara_konsumsi_buah' => 'Cara mengkonsumsi buah-buahan dan sayur-sayuran',
            'komplikasi_hemodialisis' => 'Komplikasi hemodialisis',
            'penyebab_anemis' => 'Penyebab anemis pada pasien gagal ginjal',
            'monitor_tekanan_darah' => 'Monitor tekanan darah',
            'kepatuhan_proses_hd' => 'Kepatuhan pasien dalam menjalani proses hemodialisis',
            'kenaikan_bb_pasien' => 'Kenaikan BB pasien',
            'kualitas_hidup_pasien' => 'Kualitas hidup pasien',
            'kegunaan_cimino_femoral' => 'Kegunaan cimino, femoral, double lumen catheter',
            'cara_perawatan_cimino' => 'Cara perawatan cimino dan kateter double lumen',
            'kepatuhan_minum_obat' => 'Kepatuhan minum obat',
            'cara_cuci_tangan' => 'Cara cuci tangan yang benar',
            'kepatuhan_membawa_rujukan' => 'Kepatuhan dalam membawa rujukan'
        ];

        // // Convert ke format yang mudah digunakan di blade
        // $edukasiData = [];

        // foreach ($edukasiDetails as $detail) {
        //     $data = [
        //         'id' => $detail->id,
        //         'tgl_jam' => $detail->tgl_jam ? \Carbon\Carbon::parse($detail->tgl_jam)->format('Y-m-d\TH:i') : '',
        //         'hasil_verifikasi' => $detail->hasil_verifikasi,
        //         'tgl_reedukasi' => $detail->tgl_reedukasi ? \Carbon\Carbon::parse($detail->tgl_reedukasi)->format('Y-m-d') : '',
        //         'edukator_kd' => $detail->edukator_kd,
        //         'edukator_nama' => $detail->edukator_nama,
        //         'pasien_nama' => $detail->pasien_nama,
        //         'topik_edukasi' => $detail->topik_edukasi
        //     ];

        //     if (array_key_exists($detail->topik_edukasi, $topikEdukasiList)) {
        //         $edukasiData[$detail->topik_edukasi] = $data;
        //     } else {
        //         $foundKey = array_search($detail->topik_edukasi, $topikEdukasiList);
        //         if ($foundKey !== false) {
        //             $edukasiData[$foundKey] = $data;
        //         } else {
        //             foreach ($topikEdukasiList as $key => $value) {
        //                 if (!isset($edukasiData[$key])) {
        //                     $edukasiData[$key] = $data;
        //                     break;
        //                 }
        //             }
        //         }
        //     }
        // }


        return view('unit-pelayanan.hemodialisa.pelayanan.edukasi.edit', compact(
            'dataMedis',
            'perawat',
            'hdFormulirEdukasiPasien',
            'formData',
            'bahasaDetails',
            // 'edukasiData',
            'topikEdukasiList'
        ));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        DB::beginTransaction();

        try {
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

            // Find existing record
            $HdFormulirEdukasiPasien = RmeHdFormulirEdukasiPasien::findOrFail($id);

            $HdFormulirEdukasiPasien->user_edit = Auth::id();

            // Handle kemampuan bahasa dengan detail (sama seperti store)
            $kemampuanBahasaData = [];
            if ($request->kemampuan_bahasa) {
                foreach ($request->kemampuan_bahasa as $bahasa) {
                    $bahasaItem = ['bahasa' => $bahasa];

                    if ($bahasa === 'Daerah' && $request->bahasa_daerah_detail) {
                        $bahasaItem['detail'] = $request->bahasa_daerah_detail;
                    } elseif ($bahasa === 'Asing' && $request->bahasa_asing_detail) {
                        $bahasaItem['detail'] = $request->bahasa_asing_detail;
                    }

                    $kemampuanBahasaData[] = $bahasaItem;
                }
            }

            // Update array fields to JSON (Section 1 & 2) - sama seperti store
            $HdFormulirEdukasiPasien->tinggal_bersama = $request->tinggal_bersama ? json_encode($request->tinggal_bersama) : null;
            $HdFormulirEdukasiPasien->kemampuan_bahasa = !empty($kemampuanBahasaData) ? json_encode($kemampuanBahasaData) : null;
            $HdFormulirEdukasiPasien->cara_edukasi = $request->cara_edukasi ? json_encode($request->cara_edukasi) : null;
            $HdFormulirEdukasiPasien->hambatan = $request->hambatan ? json_encode($request->hambatan) : null;
            $HdFormulirEdukasiPasien->kebutuhan_edukasi = $request->kebutuhan_edukasi ? json_encode($request->kebutuhan_edukasi) : null;

            // Update radio button fields (tinyint - 0 atau 1) - sama seperti store
            $HdFormulirEdukasiPasien->perlu_penerjemah = (int)($request->perlu_penerjemah ?? 0);
            $HdFormulirEdukasiPasien->baca_tulis = (int)($request->baca_tulis ?? 0);
            $HdFormulirEdukasiPasien->hambatan_status = (int)($request->hambatan_status ?? 0);
            $HdFormulirEdukasiPasien->ketersediaan_edukasi = (int)($request->ketersediaan_edukasi ?? 0);

            // Save main record
            $HdFormulirEdukasiPasien->save();

            // === UPDATE EDUKASI DETAIL (Section 3) ===
            // Hapus data edukasi detail lama (approach ini sudah benar untuk update)
            RmeHdFormulirEdukasiPasienDetail::where('formulir_edukasi_id', $HdFormulirEdukasiPasien->id)->delete();

            // Insert data edukasi detail baru - PERBAIKAN: tambah logic edukator_nama
            if ($request->edukasi) {
                foreach ($request->edukasi as $topik => $data) {
                    // Skip jika tidak ada tgl_jam (wajib)
                    if (!isset($data['tgl_jam']) || empty($data['tgl_jam'])) {
                        continue;
                    }

                    // PERBAIKAN: Auto-generate edukator_nama jika tidak ada
                    $edukatorNama = $data['edukator_nama'] ?? null;
                    if (empty($edukatorNama) && !empty($data['edukator_kd'])) {
                        $edukator = HrdKaryawan::where('kd_karyawan', $data['edukator_kd'])->first();
                        if ($edukator) {
                            $edukatorNama = trim(($edukator->gelar_depan ?? '') . ' ' . $edukator->nama . ' ' . ($edukator->gelar_belakang ?? ''));
                        }
                    }

                    // Insert ke tabel detail - sesuai dengan store
                    RmeHdFormulirEdukasiPasienDetail::create([
                        'formulir_edukasi_id' => $HdFormulirEdukasiPasien->id,
                        'topik_edukasi' => $data['topik_edukasi'] ?? $topik, // Tambah fallback seperti store
                        'tgl_jam' => $data['tgl_jam'] ? Carbon::parse($data['tgl_jam']) : null,
                        'hasil_verifikasi' => $data['hasil_verifikasi'] ?? null,
                        'tgl_reedukasi' => $data['tgl_reedukasi'] ? Carbon::parse($data['tgl_reedukasi'])->format('Y-m-d') : null,
                        'edukator_kd' => $data['edukator_kd'] ?? null,
                        'edukator_nama' => $edukatorNama, // Gunakan yang sudah di-generate
                        'pasien_nama' => $data['pasien_nama'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return to_route('hemodialisa.pelayanan.edukasi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Formulir edukasi berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $perawat = HrdKaryawan::where('status_peg', 1)->get();

        // Load asesmen dengan relasi edukasiDetails
        $hdFormulirEdukasiPasien = RmeHdFormulirEdukasiPasien::findOrFail($id);

        // Parse JSON data untuk form (Section 1 & 2)
        $formData = [
            'tinggal_bersama' => json_decode($hdFormulirEdukasiPasien->tinggal_bersama, true) ?? [],
            'kemampuan_bahasa' => json_decode($hdFormulirEdukasiPasien->kemampuan_bahasa, true) ?? [],
            'cara_edukasi' => json_decode($hdFormulirEdukasiPasien->cara_edukasi, true) ?? [],
            'hambatan' => json_decode($hdFormulirEdukasiPasien->hambatan, true) ?? [],
            'kebutuhan_edukasi' => json_decode($hdFormulirEdukasiPasien->kebutuhan_edukasi, true) ?? [],
            'perlu_penerjemah' => $hdFormulirEdukasiPasien->perlu_penerjemah,
            'baca_tulis' => $hdFormulirEdukasiPasien->baca_tulis,
            'hambatan_status' => $hdFormulirEdukasiPasien->hambatan_status,
            'ketersediaan_edukasi' => $hdFormulirEdukasiPasien->ketersediaan_edukasi,
        ];

        // Extract detail bahasa
        $bahasaDetails = [
            'bahasa_daerah_detail' => '',
            'bahasa_asing_detail' => ''
        ];

        foreach ($formData['kemampuan_bahasa'] as $item) {
            if (is_array($item) && isset($item['bahasa'], $item['detail'])) {
                if ($item['bahasa'] === 'Daerah') {
                    $bahasaDetails['bahasa_daerah_detail'] = $item['detail'];
                } elseif ($item['bahasa'] === 'Asing') {
                    $bahasaDetails['bahasa_asing_detail'] = $item['detail'];
                }
            }
        }

        // Flatten kemampuan bahasa untuk checkbox
        $selectedBahasa = [];
        foreach ($formData['kemampuan_bahasa'] as $item) {
            if (is_array($item) && isset($item['bahasa'])) {
                $selectedBahasa[] = $item['bahasa'];
            } else if (is_string($item)) {
                $selectedBahasa[] = $item;
            }
        }
        $formData['kemampuan_bahasa'] = $selectedBahasa;

        // === LOAD DATA EDUKASI DETAIL DARI TABEL TERPISAH (Section 3) ===
        $edukasiDetails = RmeHdFormulirEdukasiPasienDetail::where('formulir_edukasi_id', $id)->get();

        // Daftar lengkap topik edukasi yang tersedia (sesuai dengan yang di blade)
        $topikEdukasiList = [
            'hak_kewajiban_pasien' => 'Hak dan Kewajiban pasien dan Keluarga',
            'identitas_pasien_gelang' => 'Identitas pasien (gelang warna hijau, merah muda, kuning, merah, ungu)',
            'penyebab_gagal_ginjal' => 'Penyebab gagal ginjal',
            'arti_kegunaan_hemodialisis' => 'Arti dan Kegunaan Hemodialisis',
            'jumlah_jam_hemodialisis' => 'Jumlah/jam hemodialisis dan frekuensi hemodialisi',
            'kepatuhan_intake_cairan' => 'Meningkatkan Kepatuhan intake cairan pasien',
            'makanan_tidak_boleh' => 'Makanan yang tidak boleh dimakan',
            'cara_konsumsi_buah' => 'Cara mengkonsumsi buah-buahan dan sayur-sayuran',
            'komplikasi_hemodialisis' => 'Komplikasi hemodialisis',
            'penyebab_anemis' => 'Penyebab anemis pada pasien gagal ginjal',
            'monitor_tekanan_darah' => 'Monitor tekanan darah',
            'kepatuhan_proses_hd' => 'Kepatuhan pasien dalam menjalani proses hemodialisis',
            'kenaikan_bb_pasien' => 'Kenaikan BB pasien',
            'kualitas_hidup_pasien' => 'Kualitas hidup pasien',
            'kegunaan_cimino_femoral' => 'Kegunaan cimino, femoral, double lumen catheter',
            'cara_perawatan_cimino' => 'Cara perawatan cimino dan kateter double lumen',
            'kepatuhan_minum_obat' => 'Kepatuhan minum obat',
            'cara_cuci_tangan' => 'Cara cuci tangan yang benar',
            'kepatuhan_membawa_rujukan' => 'Kepatuhan dalam membawa rujukan'
        ];

        $edukasiData = [];

        foreach ($edukasiDetails as $detail) {
            $data = [
                'id' => $detail->id,
                'tgl_jam' => $detail->tgl_jam ? \Carbon\Carbon::parse($detail->tgl_jam)->format('Y-m-d\TH:i') : '',
                'hasil_verifikasi' => $detail->hasil_verifikasi,
                'tgl_reedukasi' => $detail->tgl_reedukasi ? \Carbon\Carbon::parse($detail->tgl_reedukasi)->format('Y-m-d') : '',
                'edukator_kd' => $detail->edukator_kd,
                'edukator_nama' => $detail->edukator_nama,
                'pasien_nama' => $detail->pasien_nama,
                'topik_edukasi' => $detail->topik_edukasi
            ];

            if (!empty($detail->topik_edukasi) && in_array($detail->topik_edukasi, $topikEdukasiList)) {
                $edukasiData[$detail->topik_edukasi] = $data;
            } else {
                // Data dengan topik kosong - assign ke topik pertama yang belum terisi
                foreach ($topikEdukasiList as $availableTopic) {
                    if (!isset($edukasiData[$availableTopic])) {
                        $edukasiData[$availableTopic] = $data;
                        break;
                    }
                }
            }
        }

        $emptyTopicData = [];

        return view('unit-pelayanan.hemodialisa.pelayanan.edukasi.show', compact(
            'dataMedis',
            'perawat',
            'hdFormulirEdukasiPasien',
            'formData',
            'bahasaDetails',
            'edukasiData',
            'emptyTopicData',
            'topikEdukasiList'
        ));
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {

            // Find existing record
            $hdFormulirEdukasiPasien = RmeHdFormulirEdukasiPasien::findOrFail($id);

            // Hapus data edukasi detail terlebih dahulu (foreign key constraint)
            RmeHdFormulirEdukasiPasienDetail::where('formulir_edukasi_id', $hdFormulirEdukasiPasien->id)->delete();

            // Hapus data formulir utama
            $hdFormulirEdukasiPasien->delete();

            DB::commit();

            return redirect()
                ->route('hemodialisa.pelayanan.edukasi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Formulir edukasi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('hemodialisa.pelayanan.edukasi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenMedisAwal;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenAwalController extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();

        // Mengambil data kunjungan dan tanggal triase terkait
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view('unit-pelayanan.rawat-jalan.pelayanan.asesmen-awal.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'alergiPasien',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'user'
        ));
    }


    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Mengambil data kunjungan dan tanggal triase terkait
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->select('kunjungan.*', 't.*')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            $tanggal = $request->waktu_asesmen;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // 1. record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = $waktu_asesmen;
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 1; // Umum/Dewasa
            $asesmen->save();

            // Decode diagnosis array
            $diagnosisData = json_decode($request->diagnosis, true) ?: [];

            // Create asesmen awal record
            $dataAsesmen = new RmeAsesmenMedisAwal();
            $dataAsesmen->id_asesmen = $asesmen->id;
            $dataAsesmen->keluhan_utama = $request->keluhan_utama;
            $dataAsesmen->pemeriksaan_fisik = $request->pemeriksaan_fisik;
            $dataAsesmen->diagnosis = $diagnosisData;
            $dataAsesmen->planning = $request->planning;
            $dataAsesmen->edukasi = $request->edukasi;
            $dataAsesmen->save();

            // Validasi dan simpan data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    // Skip data yang sudah ada di database (is_existing = true)
                    // kecuali jika ingin update
                    if (!isset($alergi['is_existing']) || !$alergi['is_existing']) {
                        RmeAlergiPasien::create([
                            'kd_pasien' => $kd_pasien,
                            'jenis_alergi' => $alergi['jenis_alergi'],
                            'nama_alergi' => $alergi['alergen'],
                            'reaksi' => $alergi['reaksi'],
                            'tingkat_keparahan' => $alergi['tingkat_keparahan']
                        ]);
                    }
                }
            }

            DB::commit();

            return to_route('rawat-jalan.asesmen.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil di sim  pan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $user = auth()->user();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $rmeAsesmen = RmeAsesmen::with('asesmenMedisAwal')->where('id', $id)
            ->first();

        if (!$rmeAsesmen) {
            abort(404, 'Data asesmen medis awal tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.asesmen-awal.edit', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'id',
            'dataMedis',
            'alergiPasien',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'user',
            'rmeAsesmen'
        ));
    }


    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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
                ->select('kunjungan.*', 't.*')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            $asesmenAwal = RmeAsesmenMedisAwal::where('id_asesmen', $id)
                ->first();

            if (!$asesmenAwal) {
                throw new \Exception('Data asesmen medis awal tidak ditemukan');
            }

            $diagnosisData = json_decode($request->diagnosis_banding, true) ?: [];

            $asesmenAwal->keluhan_utama = $request->keluhan_utama;
            $asesmenAwal->pemeriksaan_fisik = $request->pemeriksaan_fisik;
            $asesmenAwal->diagnosis = $diagnosisData;
            $asesmenAwal->planning = $request->planning;
            $asesmenAwal->edukasi = $request->edukasi;
            $asesmenAwal->save();

            // Update data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();
                foreach ($alergiData as $alergi) {
                    if (!isset($alergi['is_existing']) || !$alergi['is_existing']) {
                        RmeAlergiPasien::create([
                            'kd_pasien' => $kd_pasien,
                            'jenis_alergi' => $alergi['jenis_alergi'],
                            'nama_alergi' => $alergi['alergen'],
                            'reaksi' => $alergi['reaksi'],
                            'tingkat_keparahan' => $alergi['tingkat_keparahan']
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('rawat-jalan.asesmen.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupdate data asesmen: ' . $e->getMessage())->withInput();
        }
    }

     public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $user = auth()->user();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $rmeAsesmen = RmeAsesmen::with('asesmenMedisAwal')->where('id', $id)
            ->first();

        if (!$rmeAsesmen) {
            abort(404, 'Data asesmen medis awal tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.asesmen-awal.show', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'id',
            'dataMedis',
            'alergiPasien',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'user',
            'rmeAsesmen'
        ));
    }
}

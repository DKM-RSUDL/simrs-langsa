<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeSurveilansA1;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveilansA1Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        // Ambil data surveilans dengan filter
        $query = RmeSurveilansA1::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->with(['userCreated', 'userUpdated']);

        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cara_dirawat', 'like', "%{$search}%")
                    ->orWhere('asal_masuk', 'like', "%{$search}%")
                    ->orWhereHas('userCreated', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        $surveilansData = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('unit-pelayanan.rawat-inap.pelayanan.surveilans-a1.index', compact(
            'dataMedis',
            'surveilansData'
        ));
    }


    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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


        return view('unit-pelayanan.rawat-inap.pelayanan.surveilans-a1.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Simpan data Surveilans A1
            $surveilansA1 = new RmeSurveilansA1();
            $surveilansA1->kd_pasien = $kd_pasien;
            $surveilansA1->tgl_masuk = $tgl_masuk;
            $surveilansA1->kd_unit = $kd_unit;
            $surveilansA1->urut_masuk = $urut_masuk;

            // Data dasar
            $surveilansA1->tanggal_implementasi = $request->tanggal_implementasi;
            $surveilansA1->jam_implementasi = $request->jam_implementasi;
            $surveilansA1->cara_dirawat = $request->cara_dirawat;
            $surveilansA1->asal_masuk = $request->asal_masuk;

            // Pindah ke ruangan (multiple)
            if ($request->pindah_ke_ruangan) {
                $roomTransfers = [];
                foreach ($request->pindah_ke_ruangan as $index => $ruangan) {
                    if (!empty($ruangan)) {
                        $roomTransfers[] = [
                            'ruangan' => $ruangan,
                            'tanggal' => $request->tanggal_pindah_ruangan[$index] ?? null
                        ];
                    }
                }
                $surveilansA1->pindah_ke_ruangan = json_encode($roomTransfers);
            }

            // 1. Intra Vena Kateter
            $intraVenaKateter = [];

            // a. Vena Sentral
            if ($request->lokasi_vena_sentral || $request->tgl_mulai_vena_sentral) {
                $intraVenaKateter['vena_sentral'] = [
                    'lokasi' => $request->lokasi_vena_sentral,
                    'tgl_mulai' => $request->tgl_mulai_vena_sentral,
                    'tgl_selesai' => $request->tgl_selesai_vena_sentral,
                    'total_hari' => $request->total_hari_vena_sentral,
                    'tgl_infeksi' => $request->tgl_infeksi_vena_sentral,
                    'catatan' => $request->catatan_vena_sentral
                ];
            }

            // b. Vena Perifer
            if ($request->lokasi_vena_perifer || $request->tgl_mulai_vena_perifer) {
                $intraVenaKateter['vena_perifer'] = [
                    'lokasi' => $request->lokasi_vena_perifer,
                    'tgl_mulai' => $request->tgl_mulai_vena_perifer,
                    'tgl_selesai' => $request->tgl_selesai_vena_perifer,
                    'total_hari' => $request->total_hari_vena_perifer,
                    'tgl_infeksi' => $request->tgl_infeksi_vena_perifer,
                    'catatan' => $request->catatan_vena_perifer
                ];
            }

            // c. Heparin Log
            if ($request->lokasi_heparin_log || $request->tgl_mulai_heparin_log) {
                $intraVenaKateter['heparin_log'] = [
                    'lokasi' => $request->lokasi_heparin_log,
                    'tgl_mulai' => $request->tgl_mulai_heparin_log,
                    'tgl_selesai' => $request->tgl_selesai_heparin_log,
                    'total_hari' => $request->total_hari_heparin_log,
                    'tgl_infeksi' => $request->tgl_infeksi_heparin_log,
                    'catatan' => $request->catatan_heparin_log
                ];
            }

            // d. Umbilikal
            if ($request->lokasi_umbilikal || $request->tgl_mulai_umbilikal) {
                $intraVenaKateter['umbilikal'] = [
                    'lokasi' => $request->lokasi_umbilikal,
                    'tgl_mulai' => $request->tgl_mulai_umbilikal,
                    'tgl_selesai' => $request->tgl_selesai_umbilikal,
                    'total_hari' => $request->total_hari_umbilikal,
                    'tgl_infeksi' => $request->tgl_infeksi_umbilikal,
                    'catatan' => $request->catatan_umbilikal
                ];
            }

            $surveilansA1->intra_vena_kateter = !empty($intraVenaKateter) ? json_encode($intraVenaKateter) : null;

            // 2. Kateter
            $kateter = [];

            // a. Kateter Urine
            if ($request->lokasi_kateter_urine || $request->tgl_mulai_kateter_urine) {
                $kateter['kateter_urine'] = [
                    'lokasi' => $request->lokasi_kateter_urine,
                    'tgl_mulai' => $request->tgl_mulai_kateter_urine,
                    'tgl_selesai' => $request->tgl_selesai_kateter_urine,
                    'total_hari' => $request->total_hari_kateter_urine,
                    'tgl_infeksi' => $request->tgl_infeksi_kateter_urine,
                    'catatan' => $request->catatan_kateter_urine
                ];
            }

            // b. Kateter Custom
            if ($request->nama_kateter_custom || $request->lokasi_kateter_b || $request->tgl_mulai_kateter_b) {
                $kateter['kateter_custom'] = [
                    'nama' => $request->nama_kateter_custom,
                    'lokasi' => $request->lokasi_kateter_b,
                    'tgl_mulai' => $request->tgl_mulai_kateter_b,
                    'tgl_selesai' => $request->tgl_selesai_kateter_b,
                    'total_hari' => $request->total_hari_kateter_b,
                    'tgl_infeksi' => $request->tgl_infeksi_kateter_b,
                    'catatan' => $request->catatan_kateter_b
                ];
            }

            $surveilansA1->kateter = !empty($kateter) ? json_encode($kateter) : null;

            // 3. Ventilasi Mekanik - Simpan sebagai JSON
            $ventilasiMekanik = [];

            // a. Endotrakeal Tube
            if ($request->lokasi_endotrakeal || $request->tgl_mulai_endotrakeal) {
                $ventilasiMekanik['endotrakeal'] = [
                    'lokasi' => $request->lokasi_endotrakeal,
                    'tgl_mulai' => $request->tgl_mulai_endotrakeal,
                    'tgl_selesai' => $request->tgl_selesai_endotrakeal,
                    'total_hari' => $request->total_hari_endotrakeal,
                    'tgl_infeksi' => $request->tgl_infeksi_endotrakeal,
                    'catatan' => $request->catatan_endotrakeal
                ];
            }

            // b. Trakeostomi
            if ($request->lokasi_trakeostomi || $request->tgl_mulai_trakeostomi) {
                $ventilasiMekanik['trakeostomi'] = [
                    'lokasi' => $request->lokasi_trakeostomi,
                    'tgl_mulai' => $request->tgl_mulai_trakeostomi,
                    'tgl_selesai' => $request->tgl_selesai_trakeostomi,
                    'total_hari' => $request->total_hari_trakeostomi,
                    'tgl_infeksi' => $request->tgl_infeksi_trakeostomi,
                    'catatan' => $request->catatan_trakeostomi
                ];
            }

            // c. T. Piece
            if ($request->lokasi_tpiece || $request->tgl_mulai_tpiece) {
                $ventilasiMekanik['tpiece'] = [
                    'lokasi' => $request->lokasi_tpiece,
                    'tgl_mulai' => $request->tgl_mulai_tpiece,
                    'tgl_selesai' => $request->tgl_selesai_tpiece,
                    'total_hari' => $request->total_hari_tpiece,
                    'tgl_infeksi' => $request->tgl_infeksi_tpiece,
                    'catatan' => $request->catatan_tpiece
                ];
            }

            $surveilansA1->ventilasi_mekanik = !empty($ventilasiMekanik) ? json_encode($ventilasiMekanik) : null;

            // 4. Lain-lain - Simpan sebagai JSON
            if ($request->nama_lain_lain || $request->lokasi_lain_lain || $request->tgl_mulai_lain_lain) {
                $lainLain = [
                    'nama' => $request->nama_lain_lain,
                    'lokasi' => $request->lokasi_lain_lain,
                    'tgl_mulai' => $request->tgl_mulai_lain_lain,
                    'tgl_selesai' => $request->tgl_selesai_lain_lain,
                    'total_hari' => $request->total_hari_lain_lain,
                    'tgl_infeksi' => $request->tgl_infeksi_lain_lain,
                    'catatan' => $request->catatan_lain_lain
                ];
                $surveilansA1->lain_lain = json_encode($lainLain);
            }

            $surveilansA1->user_created = Auth::id();
            $surveilansA1->save();

            DB::commit();

            return redirect()->route('rawat-inap.surveilans-ppi.a1.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Data Surveilans A1 berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.urut_masuk', $urut_masuk)
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

            // Ambil data surveilans A1
            $surveilans = RmeSurveilansA1::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$surveilans) {
                return redirect()->back()->with('error', 'Data surveilans tidak ditemukan');
            }

            // Parse JSON data untuk form
            $intraVenaKateter = json_decode($surveilans->intra_vena_kateter, true) ?? [];
            $kateter = json_decode($surveilans->kateter, true) ?? [];
            $ventilasiMekanik = json_decode($surveilans->ventilasi_mekanik, true) ?? [];
            $lainLain = json_decode($surveilans->lain_lain, true) ?? [];
            $pindahKeRuangan = json_decode($surveilans->pindah_ke_ruangan, true) ?? [];

            return view('unit-pelayanan.rawat-inap.pelayanan.surveilans-a1.edit', compact(
                'dataMedis',
                'surveilans',
                'intraVenaKateter',
                'kateter',
                'ventilasiMekanik',
                'lainLain',
                'pindahKeRuangan'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data surveilans A1
            $surveilansA1 = RmeSurveilansA1::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$surveilansA1) {
                return redirect()->back()->with('error', 'Data surveilans tidak ditemukan');
            }

            // Update data dasar
            $surveilansA1->tanggal_implementasi = $request->tanggal_implementasi;
            $surveilansA1->jam_implementasi = $request->jam_implementasi;
            $surveilansA1->cara_dirawat = $request->cara_dirawat;
            $surveilansA1->asal_masuk = $request->asal_masuk;

            // Pindah ke ruangan (multiple) - simpan sebagai JSON
            if ($request->pindah_ke_ruangan) {
                $roomTransfers = [];
                foreach ($request->pindah_ke_ruangan as $index => $ruangan) {
                    if (!empty($ruangan)) {
                        $roomTransfers[] = [
                            'ruangan' => $ruangan,
                            'tanggal' => $request->tanggal_pindah_ruangan[$index] ?? null
                        ];
                    }
                }
                $surveilansA1->pindah_ke_ruangan = json_encode($roomTransfers);
            } else {
                $surveilansA1->pindah_ke_ruangan = null;
            }

            // 1. Intra Vena Kateter - Update sebagai JSON
            $intraVenaKateter = [];

            // a. Vena Sentral
            if ($request->lokasi_vena_sentral || $request->tgl_mulai_vena_sentral) {
                $intraVenaKateter['vena_sentral'] = [
                    'lokasi' => $request->lokasi_vena_sentral,
                    'tgl_mulai' => $request->tgl_mulai_vena_sentral,
                    'tgl_selesai' => $request->tgl_selesai_vena_sentral,
                    'total_hari' => $request->total_hari_vena_sentral,
                    'tgl_infeksi' => $request->tgl_infeksi_vena_sentral,
                    'catatan' => $request->catatan_vena_sentral
                ];
            }

            // b. Vena Perifer
            if ($request->lokasi_vena_perifer || $request->tgl_mulai_vena_perifer) {
                $intraVenaKateter['vena_perifer'] = [
                    'lokasi' => $request->lokasi_vena_perifer,
                    'tgl_mulai' => $request->tgl_mulai_vena_perifer,
                    'tgl_selesai' => $request->tgl_selesai_vena_perifer,
                    'total_hari' => $request->total_hari_vena_perifer,
                    'tgl_infeksi' => $request->tgl_infeksi_vena_perifer,
                    'catatan' => $request->catatan_vena_perifer
                ];
            }

            // c. Heparin Log
            if ($request->lokasi_heparin_log || $request->tgl_mulai_heparin_log) {
                $intraVenaKateter['heparin_log'] = [
                    'lokasi' => $request->lokasi_heparin_log,
                    'tgl_mulai' => $request->tgl_mulai_heparin_log,
                    'tgl_selesai' => $request->tgl_selesai_heparin_log,
                    'total_hari' => $request->total_hari_heparin_log,
                    'tgl_infeksi' => $request->tgl_infeksi_heparin_log,
                    'catatan' => $request->catatan_heparin_log
                ];
            }

            // d. Umbilikal
            if ($request->lokasi_umbilikal || $request->tgl_mulai_umbilikal) {
                $intraVenaKateter['umbilikal'] = [
                    'lokasi' => $request->lokasi_umbilikal,
                    'tgl_mulai' => $request->tgl_mulai_umbilikal,
                    'tgl_selesai' => $request->tgl_selesai_umbilikal,
                    'total_hari' => $request->total_hari_umbilikal,
                    'tgl_infeksi' => $request->tgl_infeksi_umbilikal,
                    'catatan' => $request->catatan_umbilikal
                ];
            }

            $surveilansA1->intra_vena_kateter = !empty($intraVenaKateter) ? json_encode($intraVenaKateter) : null;

            // 2. Kateter - Update sebagai JSON
            $kateter = [];

            // a. Kateter Urine
            if ($request->lokasi_kateter_urine || $request->tgl_mulai_kateter_urine) {
                $kateter['kateter_urine'] = [
                    'lokasi' => $request->lokasi_kateter_urine,
                    'tgl_mulai' => $request->tgl_mulai_kateter_urine,
                    'tgl_selesai' => $request->tgl_selesai_kateter_urine,
                    'total_hari' => $request->total_hari_kateter_urine,
                    'tgl_infeksi' => $request->tgl_infeksi_kateter_urine,
                    'catatan' => $request->catatan_kateter_urine
                ];
            }

            // b. Kateter Custom
            if ($request->nama_kateter_custom || $request->lokasi_kateter_b || $request->tgl_mulai_kateter_b) {
                $kateter['kateter_custom'] = [
                    'nama' => $request->nama_kateter_custom,
                    'lokasi' => $request->lokasi_kateter_b,
                    'tgl_mulai' => $request->tgl_mulai_kateter_b,
                    'tgl_selesai' => $request->tgl_selesai_kateter_b,
                    'total_hari' => $request->total_hari_kateter_b,
                    'tgl_infeksi' => $request->tgl_infeksi_kateter_b,
                    'catatan' => $request->catatan_kateter_b
                ];
            }

            $surveilansA1->kateter = !empty($kateter) ? json_encode($kateter) : null;

            // 3. Ventilasi Mekanik - Update sebagai JSON
            $ventilasiMekanik = [];

            // a. Endotrakeal Tube
            if ($request->lokasi_endotrakeal || $request->tgl_mulai_endotrakeal) {
                $ventilasiMekanik['endotrakeal'] = [
                    'lokasi' => $request->lokasi_endotrakeal,
                    'tgl_mulai' => $request->tgl_mulai_endotrakeal,
                    'tgl_selesai' => $request->tgl_selesai_endotrakeal,
                    'total_hari' => $request->total_hari_endotrakeal,
                    'tgl_infeksi' => $request->tgl_infeksi_endotrakeal,
                    'catatan' => $request->catatan_endotrakeal
                ];
            }

            // b. Trakeostomi
            if ($request->lokasi_trakeostomi || $request->tgl_mulai_trakeostomi) {
                $ventilasiMekanik['trakeostomi'] = [
                    'lokasi' => $request->lokasi_trakeostomi,
                    'tgl_mulai' => $request->tgl_mulai_trakeostomi,
                    'tgl_selesai' => $request->tgl_selesai_trakeostomi,
                    'total_hari' => $request->total_hari_trakeostomi,
                    'tgl_infeksi' => $request->tgl_infeksi_trakeostomi,
                    'catatan' => $request->catatan_trakeostomi
                ];
            }

            // c. T. Piece
            if ($request->lokasi_tpiece || $request->tgl_mulai_tpiece) {
                $ventilasiMekanik['tpiece'] = [
                    'lokasi' => $request->lokasi_tpiece,
                    'tgl_mulai' => $request->tgl_mulai_tpiece,
                    'tgl_selesai' => $request->tgl_selesai_tpiece,
                    'total_hari' => $request->total_hari_tpiece,
                    'tgl_infeksi' => $request->tgl_infeksi_tpiece,
                    'catatan' => $request->catatan_tpiece
                ];
            }

            $surveilansA1->ventilasi_mekanik = !empty($ventilasiMekanik) ? json_encode($ventilasiMekanik) : null;

            // 4. Lain-lain - Update sebagai JSON
            if ($request->nama_lain_lain || $request->lokasi_lain_lain || $request->tgl_mulai_lain_lain) {
                $lainLain = [
                    'nama' => $request->nama_lain_lain,
                    'lokasi' => $request->lokasi_lain_lain,
                    'tgl_mulai' => $request->tgl_mulai_lain_lain,
                    'tgl_selesai' => $request->tgl_selesai_lain_lain,
                    'total_hari' => $request->total_hari_lain_lain,
                    'tgl_infeksi' => $request->tgl_infeksi_lain_lain,
                    'catatan' => $request->catatan_lain_lain
                ];
                $surveilansA1->lain_lain = json_encode($lainLain);
            } else {
                $surveilansA1->lain_lain = null;
            }

            $surveilansA1->user_updated = Auth::id();
            $surveilansA1->save();

            DB::commit();

            return redirect()->route('rawat-inap.surveilans-ppi.a1.index', [$kd_unit, $kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Data Surveilans A1 berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data surveilans A1
            $surveilansA1 = RmeSurveilansA1::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$surveilansA1) {
                return redirect()->back()->with('error', 'Data surveilans tidak ditemukan');
            }

            $surveilansA1->delete();

            DB::commit();

            return redirect()->route('rawat-inap.surveilans-ppi.a1.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Surveilans A1 berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data medis pasien
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.urut_masuk', $urut_masuk)
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

            // Ambil data surveilans A1
            $surveilans = RmeSurveilansA1::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->with(['userCreated', 'userUpdated'])
                ->first();

            if (!$surveilans) {
                return redirect()->back()->with('error', 'Data surveilans tidak ditemukan');
            }

            // Parse JSON data untuk tampilan
            $intraVenaKateter = json_decode($surveilans->intra_vena_kateter, true) ?? [];
            $kateter = json_decode($surveilans->kateter, true) ?? [];
            $ventilasiMekanik = json_decode($surveilans->ventilasi_mekanik, true) ?? [];
            $lainLain = json_decode($surveilans->lain_lain, true) ?? [];
            $pindahKeRuangan = json_decode($surveilans->pindah_ke_ruangan, true) ?? [];

            return view('unit-pelayanan.rawat-inap.pelayanan.surveilans-a1.show', compact(
                'dataMedis',
                'surveilans',
                'intraVenaKateter',
                'kateter',
                'ventilasiMekanik',
                'lainLain',
                'pindahKeRuangan'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
}

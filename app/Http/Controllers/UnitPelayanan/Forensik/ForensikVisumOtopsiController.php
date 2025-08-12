<?php

namespace App\Http\Controllers\UnitPelayanan\Forensik;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeVisumOtopsi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForensikVisumOtopsiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/forensik');
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
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        // Query untuk mendapatkan data visum otopsi
        $query = RmeVisumOtopsi::with(['userCreated'])
            ->where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi);

        // Filter berdasarkan tanggal jika ada
        if ($request->start_date) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        // Filter berdasarkan pencarian dokter
        if ($request->search) {
            $query->whereHas('userCreated', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        $visumOtopsiData = $query->orderBy('user_created', 'desc')->paginate(10);

        return view('unit-pelayanan.forensik.pelayanan.visum-otopsi.index', compact('dataMedis', 'visumOtopsiData'));
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
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        return view('unit-pelayanan.forensik.pelayanan.visum-otopsi.create', compact('dataMedis'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            // Store visum otopsi
            $visumOtopsi = new RmeVisumOtopsi();
            $visumOtopsi->kd_kasir = $dataMedis->kd_kasir;
            $visumOtopsi->no_transaksi = $dataMedis->no_transaksi;

            // Data dasar
            $visumOtopsi->tanggal = $request->tanggal;
            $visumOtopsi->jam = $request->jam;
            $visumOtopsi->nomor = $request->nomor;
            $visumOtopsi->perihal = $request->perihal;
            $visumOtopsi->lampiran = $request->lampiran;

            // Visum et repertum
            $visumOtopsi->visum_et_repertum = $request->visum_et_repertum;
            $visumOtopsi->wawancara = $request->wawancara;

            // Pemeriksaan luar
            $visumOtopsi->penutup_mayat = $request->penutup_mayat;
            $visumOtopsi->label_mayat = $request->label_mayat;
            $visumOtopsi->pakaian_mayat = $request->pakaian_mayat;
            $visumOtopsi->benda_disamping = $request->benda_disamping;
            $visumOtopsi->aksesoris = $request->aksesoris;

            // Identifikasi
            $visumOtopsi->identifikasi_umum_keterangan = $request->identifikasi_umum_keterangan;
            $visumOtopsi->tanda_kematian = $request->tanda_kematian;
            $visumOtopsi->identifikasi_khusus_keterangan = $request->identifikasi_khusus_keterangan;

            // Hasil pemeriksaan luar
            $visumOtopsi->kepala_luar = $request->kepala_luar;
            $visumOtopsi->wajah = $request->wajah;
            $visumOtopsi->mata = $request->mata;
            $visumOtopsi->mulut = $request->mulut;
            $visumOtopsi->leher_luar = $request->leher_luar;
            $visumOtopsi->dada_luar = $request->dada_luar;
            $visumOtopsi->punggung = $request->punggung;
            $visumOtopsi->perut_luar = $request->perut_luar;
            $visumOtopsi->anggota_gerak_atas = $request->anggota_gerak_atas;
            $visumOtopsi->anggota_gerak_bawah = $request->anggota_gerak_bawah;
            $visumOtopsi->kemaluan = $request->kemaluan;
            $visumOtopsi->anus = $request->anus;

            // Hasil pemeriksaan dalam
            $visumOtopsi->kepala_dalam = $request->kepala_dalam;
            $visumOtopsi->leher_dalam = $request->leher_dalam;
            $visumOtopsi->dada_dalam = $request->dada_dalam;
            $visumOtopsi->perut_dalam = $request->perut_dalam;

            // Kesimpulan
            $visumOtopsi->kesimpulan = $request->kesimpulan;

            $visumOtopsi->user_created = Auth::id();
            $visumOtopsi->save();

            DB::commit();
            return redirect()->route('forensik.unit.pelayanan.visum-otopsi.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('success', 'Data Visum Otopsi berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        $visumOtopsi = RmeVisumOtopsi::with(['userCreated'])
            ->where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->findOrFail($id);

        return view('unit-pelayanan.forensik.pelayanan.visum-otopsi.show', compact('dataMedis', 'visumOtopsi'));
    }


    public function print(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien.agama', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            if ($dataMedis && $dataMedis->pasien) {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }
        }

        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan');
        }

        $visumOtopsi = RmeVisumOtopsi::with(['userCreated'])
            ->where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->findOrFail($id);

        // Generate PDF
        $pdf = Pdf::loadView('unit-pelayanan.forensik.pelayanan.visum-otopsi.print', compact('dataMedis', 'visumOtopsi'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'sans-serif'
        ]);

        // Stream PDF untuk preview di browser (tab baru)
        return $pdf->stream('Visum_Otopsi_' . ($dataMedis->pasien->nama ?? 'Unknown') . '_' . date('Y-m-d_H-i-s') . '.pdf');
    }

}

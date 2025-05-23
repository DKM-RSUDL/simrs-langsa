<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\PernyataanDPJP;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RanapPernyataandpjpController extends Controller
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
            ->leftJoin('dokter', 'kunjungan.kd_dokter', '=', 'dokter.kd_dokter')
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

        $pernyataanDPJP = PernyataanDPJP::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Ambil semua dokter aktif
        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.pernyataan-bpjp.index', compact(
            'dataMedis',
            'pernyataanDPJP',
            'dokter'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'kd_dokter' => 'required|string',
        ]);

        try {
            $pernyataanDPJP = new PernyataanDPJP();
            $pernyataanDPJP->kd_pasien = $request->kd_pasien;
            $pernyataanDPJP->kd_unit = $request->kd_unit;
            $pernyataanDPJP->tgl_masuk = $request->tgl_masuk;
            $pernyataanDPJP->urut_masuk = $request->urut_masuk;
            $pernyataanDPJP->tanggal = $request->tanggal;
            $pernyataanDPJP->bidang_kewenangan_klinis = $request->bidang_kewenangan_klinis;
            $pernyataanDPJP->smf = $request->smf;
            $pernyataanDPJP->kd_dokter = $request->kd_dokter;
            $pernyataanDPJP->diagnosis = $request->diagnosis;
            $pernyataanDPJP->user_create = Auth::id();
            $pernyataanDPJP->save();

            return redirect()->route('rawat-inap.pernyataan-dpjp.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Pernyataan BPJP berhasil ditambahkan');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
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
            ->leftJoin('dokter', 'kunjungan.kd_dokter', '=', 'dokter.kd_dokter')
            ->select('kunjungan.*', 't.*', 'dokter.nama as nama_dokter')
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

        $pernyataanDPJP = PernyataanDPJP::with(['creator', 'editor'])
            ->where('id', $id)
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        $dokter = Dokter::where('kd_dokter', $pernyataanDPJP->kd_dokter)
            ->select('kd_dokter', 'nama')
            ->first();

        // If it's an AJAX request, return JSON for the modal
        if ($request->ajax()) {
            return response()->json([
                'data' => $pernyataanDPJP,
                'dokter' => $dokter ? $dokter->nama : 'Tidak ada data'
            ]);
        }

        // Otherwise return the standard view
        return view('unit-pelayanan.rawat-inap.pelayanan.pernyataan-bpjp.show', compact(
            'dataMedis',
            'pernyataanDPJP',
            'dokter'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'kd_dokter' => 'required|string',
        ]);

        try {
            $pernyataanDPJP = PernyataanDPJP::where('id', $data)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $pernyataanDPJP->diagnosis = $request->diagnosis;
            $pernyataanDPJP->kd_dokter = $request->kd_dokter;
            $pernyataanDPJP->user_edit = Auth::id();
            $pernyataanDPJP->save();

            return redirect()->route('rawat-inap.pernyataan-dpjp.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Pernyataan BPJP berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $pernyataanDPJP = PernyataanDPJP::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $pernyataanDPJP->delete();

            return redirect()->route('rawat-inap.pernyataan-bpjp.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Pernyataan BPJP berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // try {
        // Ambil data pernyataan BPJP
        $pernyataanDPJP = PernyataanDPJP::where('id', $id)->firstOrFail();

        // Ambil data pasien
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->TGL_LAHIR) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->TGL_LAHIR)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $qrCode = base64_encode(QrCode::format('png')->size(200)->errorCorrection('H')->generate($pernyataanDPJP->dokter->nama_lengkap));

        // Generate tanggal dalam format Indonesia (misalnya: 15 Juni 2025)
        $tglSekarang = Carbon::now()->locale('id');
        $tglSekarang->settings(['formatFunction' => 'translatedFormat']);
        $tanggalLengkap = $tglSekarang->format('d F Y');

        // Load view PDF dengan template DPJP RSUD Langsa
        $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.pernyataan-bpjp.print', [
            'pernyataanDPJP' => $pernyataanDPJP,
            'dataMedis' => $dataMedis,
            'tanggalLengkap' => $tanggalLengkap,
            'qrCode' => $qrCode,
        ]);

        // Konfigurasi PDF
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
            'defaultFont'          => 'sans-serif'
        ]);

        // Generate dan download PDF
        return $pdf->stream("surat-pernyataan-dpjp-{$id}.pdf");
        // } catch (\Exception $e) {
        //     return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        // }
    }
}
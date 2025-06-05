<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\PermintaanSecondOpinion;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PermintaanSecondOpinionController extends Controller
{
    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
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

        $permintaanSecondOpinion = PermintaanSecondOpinion::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-second-opinion.index', compact(
            'dataMedis',
            'permintaanSecondOpinion'
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
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-second-opinion.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            // $request->validate([
            //     'informasi_tanggal' => 'required|date',
            //     'informasi_jam' => 'required',
            //     'nama_saksi' => 'required|string|max:255',
            //     'rs_second_opinion' => 'required|string|max:255',
            //     'tanggal_pengembalian' => 'nullable|date',
            //     'peminjam_nama' => 'required|string|max:255',
            //     'jenis_kelamin' => 'required|in:0,1',
            //     'tgl_lahir' => 'required|date',
            //     'no_kartu_identitas' => 'required|string|max:255',
            //     'alamat' => 'required|string',
            //     'hubungan' => 'required|string|max:255',
            //     'nama_dokumen' => 'required|array|min:1',
            //     'nama_dokumen.*' => 'required|string|max:255',
            // ]);

            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();

            // Prepare data array for insertion
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => 3,
                'tgl_masuk' => Carbon::parse($tgl_masuk)->toDateString(),
                'urut_masuk' => $urut_masuk,
                'tanggal' => Carbon::parse($request->informasi_tanggal . ' ' . $request->informasi_jam),
                'user_create' => Auth::user()->id,
                'informasi_tanggal' => Carbon::parse($request->informasi_tanggal),
                'informasi_jam' => $request->informasi_jam,
                'nama_saksi' => $request->nama_saksi,
                'rs_second_opinion' => $request->rs_second_opinion,
                'tanggal_pengembalian' => $request->tanggal_pengembalian ? Carbon::parse($request->tanggal_pengembalian) : null,
                'peminjam_nama' => $request->status_peminjam == '1' ? $pasien->nama : $request->peminjam_nama,
                'jenis_kelamin' => $request->status_peminjam == '1' ? $pasien->jenis_kelamin : $request->jenis_kelamin,
                'tgl_lahir' => $request->status_peminjam == '1' ? date('Y-m-d', strtotime($pasien->tgl_lahir)) : Carbon::parse($request->tgl_lahir),
                'no_kartu_identitas' => $request->status_peminjam == '1' ? $pasien->no_pengenal : $request->no_kartu_identitas,
                'alamat' => $request->status_peminjam == '1' ? $pasien->alamat : $request->alamat,
                'hubungan' => $request->status_peminjam == '1' ? 'Diri Sendiri' : $request->hubungan,
                'nama_dokumen' => json_encode($request->nama_dokumen),
                'is_rujuk' => $request->is_rujuk,
                'status_peminjam' => $request->status_peminjam,
            ];

            // Create the record
            PermintaanSecondOpinion::create($data);
            DB::commit();

            return redirect()->route('permintaan-second-opinion.index', [
                'kd_unit' => 3,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $secondOpinion = PermintaanSecondOpinion::findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-second-opinion.show', compact(
            'dataMedis',
            'secondOpinion'
        ));
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $secondOpinion = PermintaanSecondOpinion::findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-second-opinion.edit', compact(
            'dataMedis',
            'secondOpinion'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            // $request->validate([
            //     'informasi_tanggal' => 'required|date',
            //     'informasi_jam' => 'required',
            //     'nama_saksi' => 'required|string|max:255',
            //     'rs_second_opinion' => 'required|string|max:255',
            //     'tanggal_pengembalian' => 'nullable|date',
            //     'peminjam_nama' => 'required|string|max:255',
            //     'jenis_kelamin' => 'required|in:0,1',
            //     'tgl_lahir' => 'required|date',
            //     'no_kartu_identitas' => 'required|string|max:255',
            //     'alamat' => 'required|string',
            //     'hubungan' => 'required|string|max:255',
            //     'nama_dokumen' => 'required|array|min:1',
            //     'nama_dokumen.*' => 'required|string|max:255',
            // ]);

            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            $secondOpinion = PermintaanSecondOpinion::findOrFail($id);

            // Prepare data array for update
            $data = [
                'tanggal' => Carbon::parse($request->informasi_tanggal . ' ' . $request->informasi_jam),
                'user_edit' => Auth::user()->id,
                'informasi_tanggal' => Carbon::parse($request->informasi_tanggal),
                'informasi_jam' => $request->informasi_jam,
                'nama_saksi' => $request->nama_saksi,
                'rs_second_opinion' => $request->rs_second_opinion,
                'tanggal_pengembalian' => $request->tanggal_pengembalian ? Carbon::parse($request->tanggal_pengembalian) : null,
                'peminjam_nama' => $request->status_peminjam == '1' ? $pasien->nama : $request->peminjam_nama,
                'jenis_kelamin' => $request->status_peminjam == '1' ? $pasien->jenis_kelamin : $request->jenis_kelamin,
                'tgl_lahir' => $request->status_peminjam == '1' ? date('Y-m-d', strtotime($pasien->tgl_lahir)) : Carbon::parse($request->tgl_lahir),
                'no_kartu_identitas' => $request->status_peminjam == '1' ? $pasien->no_pengenal : $request->no_kartu_identitas,
                'alamat' => $request->status_peminjam == '1' ? $pasien->alamat : $request->alamat,
                'hubungan' => $request->status_peminjam == '1' ? 'Diri Sendiri' : $request->hubungan,
                'nama_dokumen' => json_encode($request->nama_dokumen),
                'is_rujuk' => $request->is_rujuk,
                'status_peminjam' => $request->status_peminjam,
            ];

            // Update the record
            $secondOpinion->update($data);
            DB::commit();

            return redirect()->route('permintaan-second-opinion.index', [
                'kd_unit' => 3,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil diupdate');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $secondOpinion = PermintaanSecondOpinion::findOrFail($id);
            $secondOpinion->delete();

            DB::commit();

            // Check if request is AJAX
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil dihapus'
                ]);
            }

            return redirect()->route('permintaan-second-opinion.index', [
                'kd_unit' => 3,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();

            // Check if request is AJAX
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    public function generatePDF($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Fetch medical data with related models
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

        // Check if data exists
        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan.');
        }

        // Calculate patient age
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Fetch second opinion data
        $secondOpinion = PermintaanSecondOpinion::findOrFail($id);

        // Load the Blade view and pass data
        $pdf = PDF::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-second-opinion.print', compact(
            'dataMedis',
            'secondOpinion'
        ));

        // Stream the PDF
        return $pdf->stream('permintaan-second-opinion-' . $id . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmePrmrj;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RajalPRMRJController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $prmrjs = RmePrmrj::where('kd_pasien', $kd_pasien)
        ->where('kd_unit', $kd_unit)
        ->where('tgl_masuk', $tgl_masuk)
        ->where('urut_masuk', $urut_masuk)
        ->orderBy('tanggal', 'desc')
        ->paginate(10);


        return view('unit-pelayanan.rawat-jalan.pelayanan.prmrj.index', compact(
            'dataMedis',
            'prmrjs',
            'alergiPasien'
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }


        return view('unit-pelayanan.rawat-jalan.pelayanan.prmrj.create', compact(
            'dataMedis',
            'alergiPasien'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'diagnosis' => 'nullable|string|max:255',
                'riwayat_rawat' => 'nullable|string|max:255',
                'pemeriksaan_penunjang' => 'nullable|string|max:255',
                'tindakan_prosedur' => 'nullable|string|max:255',
                'nama_tanda_tangan' => 'nullable|string|max:255',
                'tanggal' => 'nullable|date',
                'jam' => 'nullable',
            ]);

            RmePrmrj::create([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_create' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'diagnosis' => $request->diagnosis,
                'riwayat_rawat' => $request->riwayat_rawat,
                'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
                'tindakan_prosedur' => $request->tindakan_prosedur,
                'nama_tanda_tangan' => $request->nama_tanda_tangan,
            ]);

            // Validasi data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    // Skip data yang sudah ada di database (is_existing = true) 
                    // kecuali jika ingin update
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('rawat-jalan.prmrj.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $prmrj = RmePrmrj::with('rmeAlergiPasien')->findOrFail($id);

        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        if (!$dataMedis || !$prmrj) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.prmrj.show', compact('dataMedis', 'prmrj', 'alergiPasien'));
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }
        
        $prmrj = RmePrmrj::with('rmeAlergiPasien')->findOrFail($id);

        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        if (!$dataMedis || !$prmrj) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.prmrj.edit', compact('dataMedis', 'prmrj', 'alergiPasien'));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'diagnosis' => 'nullable|string|max:255',
                'riwayat_rawat' => 'nullable|string|max:255',
                'pemeriksaan_penunjang' => 'nullable|string|max:255',
                'tindakan_prosedur' => 'nullable|string|max:255',
                'nama_tanda_tangan' => 'nullable|string|max:255',
                'tanggal' => 'nullable|date',
                'jam' => 'nullable',
            ]);

            $prmrj = RmePrmrj::findOrFail($id);

            $prmrj->update([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_edit' => $prmrj->user_edit ?? Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'diagnosis' => $request->diagnosis,
                'riwayat_rawat' => $request->riwayat_rawat,
                'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
                'tindakan_prosedur' => $request->tindakan_prosedur,
                'nama_tanda_tangan' => $request->nama_tanda_tangan,
            ]);

            // Update data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            } else {
                // Jika tidak ada data alergi baru, hapus yang lama
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();
            }

            DB::commit();

            return redirect()->route('rawat-jalan.prmrj.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $prmrj = RmePrmrj::findOrFail($id);

        if (!$prmrj) {
            abort(404, 'Data not found');
        }

        $prmrj->delete();

        return redirect()->route('rawat-jalan.prmrj.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
            ->with('success', 'Data berhasil dihapus.');
    }
}

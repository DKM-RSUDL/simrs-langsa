<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeHdBeratBadanKering;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BeratBadanKeringController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Mengambil data kunjungan
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

        // Ambil data berat badan kering dengan accessor yang sudah dibuat
        $beratBadanKeringData = RmeHdBeratBadanKering::where('kd_pasien', $kd_pasien)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get()
            ->map(function ($item) {
                // Pastikan accessor dimuat dengan benar
                $item->append(['nama_bulan', 'status_imt', 'warna_imt', 'warna_selisih']);
                return $item;
            });

        return view('unit-pelayanan.hemodialisa.pelayanan.berat-badan-kering.index', compact(
            'dataMedis',
            'beratBadanKeringData'
        ));
    }

    private function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $namaBulan[$bulan] ?? 'Tidak Diketahui';
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

        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.berat-badan-kering.create', compact(
            'dataMedis',
            'dokter',
            'alergiPasien'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            
            // Cek duplikasi periode
            $existing = RmeHdBeratBadanKering::where('kd_pasien', $kd_pasien)
                ->where('tahun', $request->periode_tahun)
                ->where('bulan', $request->periode_bulan)
                ->first();

            if ($existing) {
                return back()->with('error', 'Data periode ini sudah ada!')->withInput();
            }

            // Hitung selisih BBK
            $selisih = $request->berat_badan - $request->bbk;

            // Simpan data
            RmeHdBeratBadanKering::create([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tahun' => $request->periode_tahun,
                'bulan' => $request->periode_bulan,
                'mulai_hd' => $request->mulai_hd,
                'bbk' => $request->bbk,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'imt' => $request->imt,
                'selisih_bbk' => $selisih,
                'catatan' => $request->catatan,
                'user_created' => auth()->id()
            ]);
            

            return redirect()->route('hemodialisa.pelayanan.berat-badan-kering.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Cari data berdasarkan ID dan kd_pasien untuk security
            $data = RmeHdBeratBadanKering::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->first();

            if (!$data) {
                return redirect()
                    ->route('hemodialisa.pelayanan.berat-badan-kering.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                    ->with('error', 'Data tidak ditemukan!');
            }

            // Simpan info untuk pesan sukses
            $periode = $data->nama_bulan . ' ' . $data->tahun;

            // Hapus data
            $data->delete();

            return redirect()
                ->route('hemodialisa.pelayanan.berat-badan-kering.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', "Data periode {$periode} berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()
                ->route('hemodialisa.pelayanan.berat-badan-kering.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('error', 'Gagal menghapus data!');
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Mengambil data kunjungan
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

        // Cari data berat badan kering yang akan diedit
        $beratBadanKering = RmeHdBeratBadanKering::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->first();

        if (!$beratBadanKering) {
            return redirect()
                ->route('hemodialisa.pelayanan.berat-badan-kering.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('error', 'Data tidak ditemukan!');
        }

        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.berat-badan-kering.edit', compact(
            'dataMedis',
            'beratBadanKering',
            'dokter',
            'alergiPasien'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'bbk' => 'required|numeric|min:0.1|max:200',
                'berat_badan' => 'required|numeric|min:0.1|max:200',
                'tinggi_badan' => 'required|numeric|min:50|max:250',
                'imt' => 'required|numeric|min:0',
                'catatan' => 'nullable|string|max:1000',
            ], [
                'bbk.required' => 'Berat Badan Kering harus diisi',
                'bbk.numeric' => 'Berat Badan Kering harus berupa angka',
                'bbk.min' => 'Berat Badan Kering minimal 0.1 kg',
                'bbk.max' => 'Berat Badan Kering maksimal 200 kg',
                'berat_badan.required' => 'Berat Badan harus diisi',
                'berat_badan.numeric' => 'Berat Badan harus berupa angka',
                'berat_badan.min' => 'Berat Badan minimal 0.1 kg',
                'berat_badan.max' => 'Berat Badan maksimal 200 kg',
                'tinggi_badan.required' => 'Tinggi Badan harus diisi',
                'tinggi_badan.numeric' => 'Tinggi Badan harus berupa angka',
                'tinggi_badan.min' => 'Tinggi Badan minimal 50 cm',
                'tinggi_badan.max' => 'Tinggi Badan maksimal 250 cm',
                'imt.required' => 'IMT harus dihitung',
                'imt.numeric' => 'IMT harus berupa angka',
                'catatan.max' => 'Catatan maksimal 1000 karakter',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Cari data yang akan diupdate
            $beratBadanKering = RmeHdBeratBadanKering::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->first();

            if (!$beratBadanKering) {
                return redirect()
                    ->route('hemodialisa.pelayanan.berat-badan-kering.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                    ->with('error', 'Data tidak ditemukan!');
            }

            // Hitung selisih BBK
            $selisih = $request->berat_badan - $request->bbk;

            // Update data
            $beratBadanKering->update([
                'bbk' => $request->bbk,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'imt' => $request->imt,
                'selisih_bbk' => $selisih,
                'catatan' => $request->catatan,
                'user_updated' => auth()->id(),
                'updated_at' => now()
            ]);

            return redirect()
                ->route('hemodialisa.pelayanan.berat-badan-kering.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }

}

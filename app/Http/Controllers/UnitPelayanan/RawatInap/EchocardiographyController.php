<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeEchocardiography;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EchocardiographyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    /**
     * Helper method untuk mendapatkan data medis
     */
    private function getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
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

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else if ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return $dataMedis;
    }

    private function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return Transaksi::select('kd_kasir', 'no_transaksi')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_transaksi', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$transaksi) {
            $echocardiographyData = collect();
        } else {
            $query = RmeEchocardiography::with(['dokter', 'userCreate'])
                ->where('no_transaksi', $transaksi->no_transaksi)
                ->where('kd_kasir', $transaksi->kd_kasir);

            // Filter berdasarkan tanggal
            if ($request->filled('start_date')) {
                $query->whereDate('tanggal', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('tanggal', '<=', $request->end_date);
            }

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('diagnosa_klinik', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%")
                        ->orWhere('kesimpulan', 'like', "%{$search}%")
                        ->orWhereHas('dokter', function ($dq) use ($search) {
                            $dq->where('nama_lengkap', 'like', "%{$search}%");
                        });
                });
            }

            $echocardiographyData = $query->orderBy('tanggal', 'desc')
                ->where('kd_kasir', $transaksi->kd_kasir)
                ->where('no_transaksi', $transaksi->no_transaksi)
                ->orderBy('jam', 'desc')
                ->paginate(10)
                ->withQueryString();
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.echocardiography.index', compact(
            'dataMedis',
            'echocardiographyData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.echocardiography.create', compact(
            'dataMedis',
            'dokter'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'dokter_pemeriksa' => 'required|string|max:255',
            'diagnosa_klinik' => 'nullable|string|max:255',

            // M-Mode fields
            'ao' => 'nullable|numeric',
            'la' => 'nullable|numeric',
            'rvdd' => 'nullable|numeric',
            'ivsd' => 'nullable|numeric',
            'lvidd' => 'nullable|numeric',
            'lvpwd' => 'nullable|numeric',
            'ivss' => 'nullable|numeric',
            'lvids' => 'nullable|numeric',
            'lvpws' => 'nullable|numeric',
            'lvef_teich' => 'nullable|numeric',
            'lvfs' => 'nullable|numeric',
            'rwt' => 'nullable|string|max:255',
            'lvmi' => 'nullable|numeric',
            'epss' => 'nullable|numeric',
            'tapse' => 'nullable|numeric',

            // 2 Dimensions fields
            'a4ch_edv' => 'nullable|numeric',
            'a4ch_esv' => 'nullable|numeric',
            'ef_a4ch' => 'nullable|numeric',
            'a2ch_edv' => 'nullable|numeric',
            'a2ch_esv' => 'nullable|numeric',
            'ef_a2ch' => 'nullable|numeric',
            'ef_biplane' => 'nullable|numeric',
            'lavi' => 'nullable|numeric',
            'lvot_diameter' => 'nullable|numeric',
            'lvot_area' => 'nullable|numeric',
            'rv_ann_diameter' => 'nullable|numeric',
            'rv_mid_cavity' => 'nullable|numeric',
            'ra_major_axis' => 'nullable|numeric',

            // Doppler fields
            'pv_acct' => 'nullable|numeric',
            'rvot_vmax' => 'nullable|numeric',
            'e_velocity' => 'nullable|numeric',
            'a_velocity' => 'nullable|numeric',
            'e_a_ratio' => 'nullable|numeric',
            'e_prime' => 'nullable|numeric',
            'e_e_prime_ratio' => 'nullable|numeric',
            'e_desc_time' => 'nullable|numeric',
            'lvot_vmax' => 'nullable|numeric',

            // Description fields
            'deskripsi' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Get transaksi data untuk ambil kd_kasir dan no_transaksi
            $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksi) {
                throw new \Exception('Data transaksi tidak ditemukan');
            }

            RmeEchocardiography::create([
                'kd_kasir' => $transaksi->kd_kasir,
                'no_transaksi' => $transaksi->no_transaksi,
                'user_create' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'diagnosa_klinik' => $request->diagnosa_klinik,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,

                // M-Mode measurements
                'ao' => $request->ao,
                'la' => $request->la,
                'rvdd' => $request->rvdd,
                'ivsd' => $request->ivsd,
                'lvidd' => $request->lvidd,
                'lvpwd' => $request->lvpwd,
                'ivss' => $request->ivss,
                'lvids' => $request->lvids,
                'lvpws' => $request->lvpws,
                'lvef_teich' => $request->lvef_teich,
                'lvfs' => $request->lvfs,
                'rwt' => $request->rwt,
                'lvmi' => $request->lvmi,
                'epss' => $request->epss,
                'tapse' => $request->tapse,

                // 2 Dimensions measurements
                'a4ch_edv' => $request->a4ch_edv,
                'a4ch_esv' => $request->a4ch_esv,
                'ef_a4ch' => $request->ef_a4ch,
                'a2ch_edv' => $request->a2ch_edv,
                'a2ch_esv' => $request->a2ch_esv,
                'ef_a2ch' => $request->ef_a2ch,
                'ef_biplane' => $request->ef_biplane,
                'lavi' => $request->lavi,
                'lvot_diameter' => $request->lvot_diameter,
                'lvot_area' => $request->lvot_area,
                'rv_ann_diameter' => $request->rv_ann_diameter,
                'rv_mid_cavity' => $request->rv_mid_cavity,
                'ra_major_axis' => $request->ra_major_axis,

                // Doppler measurements
                'pv_acct' => $request->pv_acct,
                'rvot_vmax' => $request->rvot_vmax,
                'e_velocity' => $request->e_velocity,
                'a_velocity' => $request->a_velocity,
                'e_a_ratio' => $request->e_a_ratio,
                'e_prime' => $request->e_prime,
                'e_e_prime_ratio' => $request->e_e_prime_ratio,
                'e_desc_time' => $request->e_desc_time,
                'lvot_vmax' => $request->lvot_vmax,

                // Description and conclusion
                'deskripsi' => $request->deskripsi,
                'kesimpulan' => $request->kesimpulan,
            ]);

            DB::commit();

            return redirect()->route('rawat-inap.echocardiography.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data echocardiography berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();
        $echocardiography = RmeEchocardiography::with(['dokter', 'userCreate'])->findOrFail($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.echocardiography.show', compact(
            'dataMedis',
            'echocardiography',
            'dokter'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);
        $echocardiography = RmeEchocardiography::findOrFail($id);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.echocardiography.edit', compact(
            'dataMedis',
            'echocardiography',
            'dokter'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'dokter_pemeriksa' => 'required|string|max:255',
            'diagnosa_klinik' => 'nullable|string|max:255',

            // M-Mode fields
            'ao' => 'nullable|numeric',
            'la' => 'nullable|numeric',
            'rvdd' => 'nullable|numeric',
            'ivsd' => 'nullable|numeric',
            'lvidd' => 'nullable|numeric',
            'lvpwd' => 'nullable|numeric',
            'ivss' => 'nullable|numeric',
            'lvids' => 'nullable|numeric',
            'lvpws' => 'nullable|numeric',
            'lvef_teich' => 'nullable|numeric',
            'lvfs' => 'nullable|numeric',
            'rwt' => 'nullable|string|max:255',
            'lvmi' => 'nullable|numeric',
            'epss' => 'nullable|numeric',
            'tapse' => 'nullable|numeric',

            // 2 Dimensions fields
            'a4ch_edv' => 'nullable|numeric',
            'a4ch_esv' => 'nullable|numeric',
            'ef_a4ch' => 'nullable|numeric',
            'a2ch_edv' => 'nullable|numeric',
            'a2ch_esv' => 'nullable|numeric',
            'ef_a2ch' => 'nullable|numeric',
            'ef_biplane' => 'nullable|numeric',
            'lavi' => 'nullable|numeric',
            'lvot_diameter' => 'nullable|numeric',
            'lvot_area' => 'nullable|numeric',
            'rv_ann_diameter' => 'nullable|numeric',
            'rv_mid_cavity' => 'nullable|numeric',
            'ra_major_axis' => 'nullable|numeric',

            // Doppler fields
            'pv_acct' => 'nullable|numeric',
            'rvot_vmax' => 'nullable|numeric',
            'e_velocity' => 'nullable|numeric',
            'a_velocity' => 'nullable|numeric',
            'e_a_ratio' => 'nullable|numeric',
            'e_prime' => 'nullable|numeric',
            'e_e_prime_ratio' => 'nullable|numeric',
            'e_desc_time' => 'nullable|numeric',
            'lvot_vmax' => 'nullable|numeric',

            // Description fields
            'deskripsi' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $echocardiography = RmeEchocardiography::findOrFail($id);

            $echocardiography->update([
                'user_edit' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'diagnosa_klinik' => $request->diagnosa_klinik,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,

                // M-Mode measurements
                'ao' => $request->ao,
                'la' => $request->la,
                'rvdd' => $request->rvdd,
                'ivsd' => $request->ivsd,
                'lvidd' => $request->lvidd,
                'lvpwd' => $request->lvpwd,
                'ivss' => $request->ivss,
                'lvids' => $request->lvids,
                'lvpws' => $request->lvpws,
                'lvef_teich' => $request->lvef_teich,
                'lvfs' => $request->lvfs,
                'rwt' => $request->rwt,
                'lvmi' => $request->lvmi,
                'epss' => $request->epss,
                'tapse' => $request->tapse,

                // 2 Dimensions measurements
                'a4ch_edv' => $request->a4ch_edv,
                'a4ch_esv' => $request->a4ch_esv,
                'ef_a4ch' => $request->ef_a4ch,
                'a2ch_edv' => $request->a2ch_edv,
                'a2ch_esv' => $request->a2ch_esv,
                'ef_a2ch' => $request->ef_a2ch,
                'ef_biplane' => $request->ef_biplane,
                'lavi' => $request->lavi,
                'lvot_diameter' => $request->lvot_diameter,
                'lvot_area' => $request->lvot_area,
                'rv_ann_diameter' => $request->rv_ann_diameter,
                'rv_mid_cavity' => $request->rv_mid_cavity,
                'ra_major_axis' => $request->ra_major_axis,

                // Doppler measurements
                'pv_acct' => $request->pv_acct,
                'rvot_vmax' => $request->rvot_vmax,
                'e_velocity' => $request->e_velocity,
                'a_velocity' => $request->a_velocity,
                'e_a_ratio' => $request->e_a_ratio,
                'e_prime' => $request->e_prime,
                'e_e_prime_ratio' => $request->e_e_prime_ratio,
                'e_desc_time' => $request->e_desc_time,
                'lvot_vmax' => $request->lvot_vmax,

                // Description and conclusion
                'deskripsi' => $request->deskripsi,
                'kesimpulan' => $request->kesimpulan,
            ]);

            DB::commit();

            return redirect()->route('rawat-inap.echocardiography.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data echocardiography berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $echocardiography = RmeEchocardiography::findOrFail($id);
            $echocardiography->delete();

            DB::commit();

            return redirect()->route('rawat-inap.echocardiography.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data echocardiography berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

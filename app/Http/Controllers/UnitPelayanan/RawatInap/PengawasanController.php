<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmePengawasanPerinatology;
use App\Models\RmePengawasanPerinatologyDtl;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengawasanController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Ambil data pengawasan perinatology dengan detail
        $perinatologyData = RmePengawasanPerinatology::with('detail')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_implementasi', 'desc')
            ->get();

        // Format numeric data untuk display
        $perinatologyData->transform(function ($item) {
            // Format data pada main record
            $item->bbl_formatted = $item->bbl ? number_format($item->bbl, 1, '.', '') : null;
            $item->bbs_formatted = $item->bbs ? number_format($item->bbs, 1, '.', '') : null;

            // Format data pada detail record jika ada
            if ($item->detail) {
                $item->detail->suhu_formatted = $item->detail->suhu ? number_format($item->detail->suhu, 1, '.', '') : null;
                $item->detail->pep_formatted = $item->detail->pep ? number_format($item->detail->pep, 2, '.', '') : null;
                $item->detail->fi_o2_formatted = $item->detail->fi_o2 ? number_format($item->detail->fi_o2, 2, '.', '') : null;
                $item->detail->flow_formatted = $item->detail->flow ? number_format($item->detail->flow, 2, '.', '') : null;
                $item->detail->suhu_ventilator_formatted = $item->detail->suhu_ventilator ? number_format($item->detail->suhu_ventilator, 1, '.', '') : null;
            }

            return $item;
        });

        // Get min and max dates from the data
        $minDate = null;
        $maxDate = null;

        if ($perinatologyData->count() > 0) {
            $minDate = $perinatologyData->min('tgl_implementasi');
            $maxDate = $perinatologyData->max('tgl_implementasi');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.pengawasan.index', [
            'dataMedis' => $dataMedis,
            'perinatologyData' => $perinatologyData,
            'minDate' => $minDate,
            'maxDate' => $maxDate,
        ]);
    }

    public function createPengawasanPerinatology($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Ambil data perinatology terakhir untuk pasien ini
        $lastPerinatologyData = RmePengawasanPerinatology::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->orderBy('tgl_implementasi', 'desc')
            ->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.pengawasan.p-perinatology.create', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'dataMedis' => $dataMedis,
            'lastPerinatologyData' => $lastPerinatologyData
        ]);
    }

    public function storePengawasanPerinatology(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Parse waktu implementasi
            $tglImplementasi = $request->tgl_implementasi . ' 00:00:00';
            $jamImplementasi = '1900-01-01 ' . $request->jam_implementasi . ':00';
            $waktuImplementasi = $request->tgl_implementasi . ' ' . $request->jam_implementasi . ':00';

            // 1. Simpan ke RmePengawasanPerinatology (tabel utama)
            $perinatologyData = [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tgl_implementasi' => $tglImplementasi,
                'jam_implementasi' => $jamImplementasi,
                'waktu_implementasi' => $waktuImplementasi,

                // Informasi Pasien
                'bbl' => $request->bbl,
                'bbs' => $request->bb_saat_ini,
                'gestasi' => $request->gestasi,

                // Metadata
                'user_create' => Auth::user()->id,
                'user_update' => Auth::user()->id
            ];

            $perinatology = RmePengawasanPerinatology::create($perinatologyData);

            // 2. Simpan ke RmePengawasanPerinatologyDtl (tabel detail)
            $perinatologyDtlData = [
                'id_pengawasan_perinatology' => $perinatology->id,

                // Observasi
                'kesadaran' => $request->kesadaran,
                'td_crt' => $request->td_crt,
                'nadi' => $request->nadi,
                'nafas' => $request->nafas,
                'suhu' => $request->suhu,

                // Ventilasi
                'modus' => $request->modus,
                'pep' => $request->pep,
                'bubble' => $request->bubble,
                'fi_o2' => $request->fi_o2,
                'flow' => $request->flow,
                'spo2' => $request->spo2,
                'air' => $request->air,
                'suhu_ventilator' => $request->suhu_ventilator,

                // Metadata
                'user_create' => Auth::user()->id,
                'user_update' => Auth::user()->id,
            ];

            RmePengawasanPerinatologyDtl::create($perinatologyDtlData);

            // Commit transaction jika semua berhasil
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('rawat-inap.pengawasan.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data pengawasan perinatology berhasil disimpan');
        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            DB::rollback();

            // Redirect dengan pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function destroyPengawasanPerinatology($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Find the perinatology record
            $perinatology = RmePengawasanPerinatology::findOrFail($id);

            // Verify the record belongs to the correct patient
            if (
                $perinatology->kd_unit != $kd_unit ||
                $perinatology->kd_pasien != $kd_pasien ||
                date('Y-m-d', strtotime($perinatology->tgl_masuk)) != $tgl_masuk ||
                $perinatology->urut_masuk != $urut_masuk
            ) {
                abort(403, 'Unauthorized access to this data');
            }

            // Delete detail first (foreign key constraint)
            RmePengawasanPerinatologyDtl::where('id_pengawasan_perinatology', $id)->delete();

            // Delete main record
            $perinatology->delete();

            DB::commit();

            return redirect()
                ->route('rawat-inap.pengawasan.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data pengawasan perinatology berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function editPengawasanPerinatology($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Get patient data
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

        // Get perinatology data with detail
        $perinatologyData = RmePengawasanPerinatology::with('detail')
            ->findOrFail($id);

        // Verify the record belongs to the correct patient
        if (
            $perinatologyData->kd_unit != $kd_unit ||
            $perinatologyData->kd_pasien != $kd_pasien ||
            date('Y-m-d', strtotime($perinatologyData->tgl_masuk)) != $tgl_masuk ||
            $perinatologyData->urut_masuk != $urut_masuk
        ) {
            abort(403, 'Unauthorized access to this data');
        }

        // Get last perinatology data (except current one) for reference
        $lastPerinatologyData = RmePengawasanPerinatology::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('id', '!=', $id)
            ->orderBy('waktu_implementasi', 'desc')
            ->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.pengawasan.p-perinatology.edit', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'dataMedis' => $dataMedis,
            'perinatologyData' => $perinatologyData,
            'lastPerinatologyData' => $lastPerinatologyData
        ]);
    }

    public function updatePengawasanPerinatology(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Find the perinatology record
            $perinatology = RmePengawasanPerinatology::findOrFail($id);

            // Verify the record belongs to the correct patient
            if (
                $perinatology->kd_unit != $kd_unit ||
                $perinatology->kd_pasien != $kd_pasien ||
                date('Y-m-d', strtotime($perinatology->tgl_masuk)) != $tgl_masuk ||
                $perinatology->urut_masuk != $urut_masuk
            ) {
                abort(403, 'Unauthorized access to this data');
            }

            // Parse datetime for implementation
            $tglImplementasi = $request->tgl_implementasi . ' 00:00:00';
            $jamImplementasi = '1900-01-01 ' . $request->jam_implementasi . ':00';
            $waktuImplementasi = $request->tgl_implementasi . ' ' . $request->jam_implementasi . ':00';

            // Update main record
            $perinatology->update([
                'tgl_implementasi' => $tglImplementasi,
                'jam_implementasi' => $jamImplementasi,
                'waktu_implementasi' => $waktuImplementasi,

                // Patient Information
                'bbl' => $request->bbl,
                'bbs' => $request->bb_saat_ini,
                'gestasi' => $request->gestasi,

                // Metadata
                'user_update' => Auth::user()->id,
            ]);

            // Update detail record
            if ($perinatology->detail) {
                $perinatology->detail->update([
                    // Observation
                    'kesadaran' => $request->kesadaran,
                    'td_crt' => $request->td_crt,
                    'nadi' => $request->nadi,
                    'nafas' => $request->nafas,
                    'suhu' => $request->suhu,

                    // Ventilation
                    'modus' => $request->modus,
                    'pep' => $request->pep,
                    'bubble' => $request->bubble,
                    'fi_o2' => $request->fi_o2,
                    'flow' => $request->flow,
                    'spo2' => $request->spo2,
                    'air' => $request->air,
                    'suhu_ventilator' => $request->suhu_ventilator,

                    // Metadata
                    'user_update' => Auth::user()->id,
                ]);
            } else {
                // Create detail if it doesn't exist
                RmePengawasanPerinatologyDtl::create([
                    'id_pengawasan_perinatology' => $perinatology->id,

                    // Observation
                    'kesadaran' => $request->kesadaran,
                    'td_crt' => $request->td_crt,
                    'nadi' => $request->nadi,
                    'nafas' => $request->nafas,
                    'suhu' => $request->suhu,

                    // Ventilation
                    'modus' => $request->modus,
                    'pep' => $request->pep,
                    'bubble' => $request->bubble,
                    'fi_o2' => $request->fi_o2,
                    'flow' => $request->flow,
                    'spo2' => $request->spo2,
                    'air' => $request->air,
                    'suhu_ventilator' => $request->suhu_ventilator,

                    // Metadata
                    'user_create' => Auth::user()->id,
                    'user_update' => Auth::user()->id,
                ]);
            }

            // Commit transaction if all successful
            DB::commit();

            // Redirect with success message
            return redirect()
                ->route('rawat-inap.pengawasan.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data pengawasan perinatology berhasil diperbarui');
        } catch (\Exception $e) {
            // Rollback transaction if error occurs
            DB::rollback();

            // Redirect with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }


    public function printPengawasanPerinatology(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        $perinatologyData = RmePengawasanPerinatology::with('detail')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_implementasi', '>=', $tanggal_mulai)
            ->whereDate('tgl_implementasi', '<=', $tanggal_selesai)
            ->orderBy('waktu_implementasi', 'asc')
            ->get();

        $perinatologyData->transform(function ($item) {
            $item->bbl_formatted = $item->bbl ? number_format($item->bbl, 1, '.', '') : null;
            $item->bbs_formatted = $item->bbs ? number_format($item->bbs, 1, '.', '') : null;

            if ($item->detail) {
                $item->detail->suhu_formatted = $item->detail->suhu ? number_format($item->detail->suhu, 1, '.', '') : null;
                $item->detail->pep_formatted = $item->detail->pep ? number_format($item->detail->pep, 2, '.', '') : null;
                $item->detail->fi_o2_formatted = $item->detail->fi_o2 ? number_format($item->detail->fi_o2, 2, '.', '') : null;
                $item->detail->flow_formatted = $item->detail->flow ? number_format($item->detail->flow, 2, '.', '') : null;
                $item->detail->suhu_ventilator_formatted = $item->detail->suhu_ventilator ? number_format($item->detail->suhu_ventilator, 1, '.', '') : null;
            }

            return $item;
        });

        return view('unit-pelayanan.rawat-inap.pelayanan.pengawasan.p-perinatology.print', [
            'dataMedis' => $dataMedis,
            'perinatologyData' => $perinatologyData,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
        ]);
    }
}

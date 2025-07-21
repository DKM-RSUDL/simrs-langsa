<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\RmePersetujuanTindakanHd;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersetujuanTindakanHDController extends Controller
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

        // Query untuk data persetujuan tindakan HD
        $dataPersetujuan = RmePersetujuanTindakanHd::with(['dokter', 'userCreated'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->whereHas('dokter', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%');
                })->orWhere('tipe_penerima', 'like', '%' . $search . '%')
                    ->orWhere('nama_keluarga', 'like', '%' . $search . '%');
            })
            ->when(request('dari_tanggal'), function ($query) {
                $query->whereDate('tanggal_implementasi', '>=', request('dari_tanggal'));
            })
            ->when(request('sampai_tanggal'), function ($query) {
                $query->whereDate('tanggal_implementasi', '<=', request('sampai_tanggal'));
            })
            ->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.hemodialisa.pelayanan.persetujuan.tindakan-hd.index', compact(
            'dataMedis',
            'dataPersetujuan'
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

        $dokter = Dokter::where('status', 1)->get();
        $karyawan = HrdKaryawan::where('status_peg', 1)->get();


        return view('unit-pelayanan.hemodialisa.pelayanan.persetujuan.tindakan-hd.create', compact(
            'dataMedis',
            'dokter',
            'karyawan',
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $dataHasilLab = new RmePersetujuanTindakanHd();
            $dataHasilLab->kd_pasien = $kd_pasien;
            $dataHasilLab->kd_unit = $this->kdUnitDef_;
            $dataHasilLab->tgl_masuk = $tgl_masuk;
            $dataHasilLab->urut_masuk = $urut_masuk;

            // Basic Information
            $dataHasilLab->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHasilLab->jam_implementasi = $request->jam_implementasi;
            $dataHasilLab->kd_dokter = $request->dpjp;
            $dataHasilLab->kd_karyawan = $request->pemberi_informasi;
            $dataHasilLab->tipe_penerima = $request->tipe_penerima;

            // Data Keluarga (hanya jika keluarga yang menerima informasi)
            if ($request->tipe_penerima == 'keluarga') {
                $dataHasilLab->nama_keluarga = $request->nama_keluarga;
                $dataHasilLab->umur_keluarga = $request->umur_keluarga;
                $dataHasilLab->jk_keluarga = $request->jk_keluarga;
                $dataHasilLab->status_keluarga = $request->status_keluarga;
                $dataHasilLab->alamat_keluarga = $request->alamat_keluarga;
            }

            // Catatan: Data pasien tidak perlu disimpan karena sudah tersedia di dataMedis

            // Informasi yang dijelaskan (checkbox)
            $dataHasilLab->info_diagnosis = $request->has('info_diagnosis') ? 1 : 0;
            $dataHasilLab->info_dasar_diagnosis = $request->has('info_dasar_diagnosis') ? 1 : 0;
            $dataHasilLab->info_tindakan = $request->has('info_tindakan') ? 1 : 0;
            $dataHasilLab->info_indikasi = $request->has('info_indikasi') ? 1 : 0;
            $dataHasilLab->info_tata_cara = $request->has('info_tata_cara') ? 1 : 0;
            $dataHasilLab->info_tujuan = $request->has('info_tujuan') ? 1 : 0;
            $dataHasilLab->info_resiko = $request->has('info_resiko') ? 1 : 0;
            $dataHasilLab->info_prognosis = $request->has('info_prognosis') ? 1 : 0;
            $dataHasilLab->info_alternatif = $request->has('info_alternatif') ? 1 : 0;
            $dataHasilLab->info_lain_lain = $request->info_lain_lain;
            $dataHasilLab->info_lain_lain_check = $request->has('info_lain_lain_check') ? 1 : 0;

            // Keputusan persetujuan/penolakan
            $dataHasilLab->keputusan = $request->keputusan;

            // User audit
            $dataHasilLab->user_created = Auth::id();

            $dataHasilLab->save();

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.persetujuan.tindakan-hd.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Persetujuan Tindakan HD berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
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

        // Ambil data persetujuan yang akan diedit
        $dataPersetujuan = RmePersetujuanTindakanHd::findOrFail($id);

        $dokter = Dokter::where('status', 1)->get();
        $karyawan = HrdKaryawan::where('status_peg', 1)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.persetujuan.tindakan-hd.edit', compact(
            'dataMedis',
            'dataPersetujuan',
            'dokter',
            'karyawan'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataHasilLab = RmePersetujuanTindakanHd::findOrFail($id);

            // Basic Information
            $dataHasilLab->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHasilLab->jam_implementasi = $request->jam_implementasi;
            $dataHasilLab->kd_dokter = $request->dpjp;
            $dataHasilLab->kd_karyawan = $request->pemberi_informasi;
            $dataHasilLab->tipe_penerima = $request->tipe_penerima;

            // Reset data keluarga jika tidak dipilih
            if ($request->tipe_penerima != 'keluarga') {
                $dataHasilLab->nama_keluarga = null;
                $dataHasilLab->umur_keluarga = null;
                $dataHasilLab->jk_keluarga = null;
                $dataHasilLab->status_keluarga = null;
                $dataHasilLab->alamat_keluarga = null;
            } else {
                $dataHasilLab->nama_keluarga = $request->nama_keluarga;
                $dataHasilLab->umur_keluarga = $request->umur_keluarga;
                $dataHasilLab->jk_keluarga = $request->jk_keluarga;
                $dataHasilLab->status_keluarga = $request->status_keluarga;
                $dataHasilLab->alamat_keluarga = $request->alamat_keluarga;
            }

            // Informasi yang dijelaskan (checkbox)
            $dataHasilLab->info_diagnosis = $request->has('info_diagnosis') ? 1 : 0;
            $dataHasilLab->info_dasar_diagnosis = $request->has('info_dasar_diagnosis') ? 1 : 0;
            $dataHasilLab->info_tindakan = $request->has('info_tindakan') ? 1 : 0;
            $dataHasilLab->info_indikasi = $request->has('info_indikasi') ? 1 : 0;
            $dataHasilLab->info_tata_cara = $request->has('info_tata_cara') ? 1 : 0;
            $dataHasilLab->info_tujuan = $request->has('info_tujuan') ? 1 : 0;
            $dataHasilLab->info_resiko = $request->has('info_resiko') ? 1 : 0;
            $dataHasilLab->info_prognosis = $request->has('info_prognosis') ? 1 : 0;
            $dataHasilLab->info_alternatif = $request->has('info_alternatif') ? 1 : 0;
            $dataHasilLab->info_lain_lain = $request->info_lain_lain;
            $dataHasilLab->info_lain_lain_check = $request->has('info_lain_lain_check') ? 1 : 0;

            // Keputusan persetujuan/penolakan
            $dataHasilLab->keputusan = $request->keputusan;

            // User audit untuk update
            $dataHasilLab->user_updated = Auth::id();

            $dataHasilLab->save();

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.persetujuan.tindakan-hd.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Persetujuan Tindakan HD berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $dataPersetujuan = RmePersetujuanTindakanHd::findOrFail($id);
            $dataPersetujuan->delete();

            return redirect()->route('hemodialisa.pelayanan.persetujuan.tindakan-hd.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Persetujuan Tindakan HD berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function generatePDF($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Ambil data persetujuan
        $dataPersetujuan = RmePersetujuanTindakanHd::with(['dokter', 'userCreated'])
            ->findOrFail($id);

        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');

        // Generate PDF (asumsi menggunakan DomPDF atau library lain)
        $pdf = Pdf::loadView('unit-pelayanan.hemodialisa.pelayanan.persetujuan.tindakan-hd.print', compact(
            'dataMedis',
            'dataPersetujuan',
            'logoPath'
        ));

        $filename = 'Persetujuan_HD_' . $kd_pasien . '_' . date('Y-m-d', strtotime($tgl_masuk)) . '_' . $urut_masuk . '.pdf';

        return $pdf->stream($filename);
    }

}

<?php

namespace App\Http\Controllers\UnitPelayanan\Forensik;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\VisumExit;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class VisumExitController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/forensik');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Ambil data transaksi untuk mendapatkan kd_kasir dan no_transaksi
        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$transaksi) {
            // Jika tidak ada transaksi, return empty pagination
            $visumExitList = $this->createEmptyPagination(10);
            return view('unit-pelayanan.forensik.pelayanan.visum-exit.index', compact('dataMedis', 'visumExitList'));
        }

        // Query untuk mengambil data VisumExit berdasarkan no_transaksi atau kd_kasir
        $query = VisumExit::with(['dokter', 'userCreate', 'userEdit', 'transaksi'])
            ->where(function ($q) use ($transaksi) {
                $q->where('no_transaksi', $transaksi->no_transaksi)
                    ->orWhere('kd_kasir', $transaksi->kd_kasir);
            });

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        // Filter berdasarkan nama dokter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('dokter_pemeriksa', 'LIKE', "%{$search}%")
                    ->orWhereHas('dokter', function ($dokterQuery) use ($search) {
                        $dokterQuery->where('nama_lengkap', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Pagination dengan parameter request
        $visumExitList = $query->orderBy('tanggal', 'desc')
            ->where('kd_kasir', $transaksi->kd_kasir)
            ->where('no_transaksi', $transaksi->no_transaksi)
            ->where('registrasi', $kd_pasien)
            ->orderBy('jam', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('unit-pelayanan.forensik.pelayanan.visum-exit.index', compact('dataMedis', 'visumExitList'));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.forensik.pelayanan.visum-exit.create', compact('dataMedis', 'dokter'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nomor_ver' => 'required|string|max:255|unique:RME_VISUM_EXIT,nomor_ver',
            'dokter_pemeriksa' => 'required|string|max:255',
            'permintaan' => 'nullable|string',
            'nomor_surat' => 'nullable|string|max:255',
            'registrasi' => 'nullable|string|max:255',
            'menerangkan' => 'nullable|string',
            'wawancara' => 'nullable|string',
            'label_mayat' => 'nullable|string',
            'pembungkus_mayat' => 'nullable|string',
            'benda_disamping' => 'nullable|string',
            'penutup_mayat' => 'nullable|string',
            'pakaian_mayat' => 'nullable|string',
            'perhiasan_mayat' => 'nullable|string',
            'identifikasi_umum' => 'nullable|string',
            'identifikasi_khusus' => 'nullable|string',
            'tanda_kematian' => 'nullable|string',
            'gigi_geligi' => 'nullable|string',
            'luka_luka' => 'nullable|string',
            'pada_jenazah' => 'nullable|string',
            'pemeriksaan_luar_kesimpulan' => 'nullable|string',
            'dijumpai_kesimpulan' => 'nullable|string',
            'hasil_kesimpulan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Get transaksi data untuk ambil kd_kasir dan no_transaksi
            $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksi) {
                throw new \Exception('Data transaksi tidak ditemukan');
            }

            VisumExit::create([
                'kd_kasir' => $transaksi->kd_kasir,
                'no_transaksi' => $transaksi->no_transaksi,
                'user_create' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'nomor_ver' => $request->nomor_ver,
                'permintaan' => $request->permintaan,
                'nomor_surat' => $request->nomor_surat,
                'registrasi' => $request->registrasi ?: $kd_pasien,
                'menerangkan' => $request->menerangkan,
                'wawancara' => $request->wawancara,
                'label_mayat' => $request->label_mayat,
                'pembungkus_mayat' => $request->pembungkus_mayat,
                'benda_disamping' => $request->benda_disamping,
                'penutup_mayat' => $request->penutup_mayat,
                'pakaian_mayat' => $request->pakaian_mayat,
                'perhiasan_mayat' => $request->perhiasan_mayat,
                'identifikasi_umum' => $request->identifikasi_umum,
                'identifikasi_khusus' => $request->identifikasi_khusus,
                'tanda_kematian' => $request->tanda_kematian,
                'gigi_geligi' => $request->gigi_geligi,
                'luka_luka' => $request->luka_luka,
                'pada_jenazah' => $request->pada_jenazah,
                'pemeriksaan_luar_kesimpulan' => $request->pemeriksaan_luar_kesimpulan,
                'dijumpai_kesimpulan' => $request->dijumpai_kesimpulan,
                'hasil_kesimpulan' => $request->hasil_kesimpulan,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
            ]);

            DB::commit();

            return redirect()->route('forensik.unit.pelayanan.visum-exit.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Visum et Repertum berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan');
        }

        $visumExit = VisumExit::where('id', $id)
            ->where(function ($q) use ($transaksi) {
                $q->where('no_transaksi', $transaksi->no_transaksi)
                    ->orWhere('kd_kasir', $transaksi->kd_kasir);
            })
            ->with(['dokter', 'userCreate', 'userEdit', 'transaksi'])
            ->firstOrFail();

        return view('unit-pelayanan.forensik.pelayanan.visum-exit.show', compact('dataMedis', 'visumExit'));
    }

    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan');
        }

        $visumExit = VisumExit::where('id', $id)
            ->where(function ($q) use ($transaksi) {
                $q->where('no_transaksi', $transaksi->no_transaksi)
                    ->orWhere('kd_kasir', $transaksi->kd_kasir);
            })
            ->with(['dokter', 'userCreate', 'userEdit', 'transaksi'])
            ->firstOrFail();

        return view('unit-pelayanan.forensik.pelayanan.visum-exit.edit', compact('dataMedis', 'visumExit', 'dokter'));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nomor_ver' => 'required|string|max:255|unique:RME_VISUM_EXIT,nomor_ver,' . $id,
            'dokter_pemeriksa' => 'required|string|max:255',
            'permintaan' => 'nullable|string',
            'nomor_surat' => 'nullable|string|max:255',
            'registrasi' => 'nullable|string|max:255',
            'menerangkan' => 'nullable|string',
            'wawancara' => 'nullable|string',
            'label_mayat' => 'nullable|string',
            'pembungkus_mayat' => 'nullable|string',
            'benda_disamping' => 'nullable|string',
            'penutup_mayat' => 'nullable|string',
            'pakaian_mayat' => 'nullable|string',
            'perhiasan_mayat' => 'nullable|string',
            'identifikasi_umum' => 'nullable|string',
            'identifikasi_khusus' => 'nullable|string',
            'tanda_kematian' => 'nullable|string',
            'gigi_geligi' => 'nullable|string',
            'luka_luka' => 'nullable|string',
            'pada_jenazah' => 'nullable|string',
            'pemeriksaan_luar_kesimpulan' => 'nullable|string',
            'dijumpai_kesimpulan' => 'nullable|string',
            'hasil_kesimpulan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksi) {
                throw new \Exception('Data transaksi tidak ditemukan');
            }

            $visumExit = VisumExit::where('id', $id)
                ->where(function ($q) use ($transaksi) {
                    $q->where('no_transaksi', $transaksi->no_transaksi)
                        ->orWhere('kd_kasir', $transaksi->kd_kasir);
                })
                ->firstOrFail();

            $visumExit->update([
                'kd_kasir' => $transaksi->kd_kasir,
                'no_transaksi' => $transaksi->no_transaksi,
                'user_edit' => Auth::id(),
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'nomor_ver' => $request->nomor_ver,
                'permintaan' => $request->permintaan,
                'nomor_surat' => $request->nomor_surat,
                'registrasi' => $request->registrasi ?: $kd_pasien,
                'menerangkan' => $request->menerangkan,
                'wawancara' => $request->wawancara,
                'label_mayat' => $request->label_mayat,
                'pembungkus_mayat' => $request->pembungkus_mayat,
                'benda_disamping' => $request->benda_disamping,
                'penutup_mayat' => $request->penutup_mayat,
                'pakaian_mayat' => $request->pakaian_mayat,
                'perhiasan_mayat' => $request->perhiasan_mayat,
                'identifikasi_umum' => $request->identifikasi_umum,
                'identifikasi_khusus' => $request->identifikasi_khusus,
                'tanda_kematian' => $request->tanda_kematian,
                'gigi_geligi' => $request->gigi_geligi,
                'luka_luka' => $request->luka_luka,
                'pada_jenazah' => $request->pada_jenazah,
                'pemeriksaan_luar_kesimpulan' => $request->pemeriksaan_luar_kesimpulan,
                'dijumpai_kesimpulan' => $request->dijumpai_kesimpulan,
                'hasil_kesimpulan' => $request->hasil_kesimpulan,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
            ]);

            DB::commit();

            return redirect()->route('forensik.unit.pelayanan.visum-exit.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Visum et Repertum berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksi) {
                throw new \Exception('Data transaksi tidak ditemukan');
            }

            $visumExit = VisumExit::where('id', $id)
                ->where(function ($q) use ($transaksi) {
                    $q->where('no_transaksi', $transaksi->no_transaksi)
                        ->orWhere('kd_kasir', $transaksi->kd_kasir);
                })
                ->firstOrFail();

            $visumExit->delete();

            DB::commit();

            return redirect()->route('forensik.unit.pelayanan.visum-exit.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Visum et Repertum berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createEmptyPagination($perPage = 10)
    {
        return new \Illuminate\Pagination\LengthAwarePaginator(
            collect([]),
            0,
            $perPage,
            1,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
    }

    private function getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } elseif ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
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

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Get medical data
            $dataMedis = Kunjungan::with(['pasien.suku', 'pasien.agama', 'pasien.pekerjaan', 'dokter', 'customer', 'unit'])
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
                abort(404, 'Data medis tidak ditemukan.');
            }

            // Calculate age
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Get transaction data
            $transaksi = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksi) {
                abort(404, 'Data transaksi tidak ditemukan');
            }

            // Get VisumExit data
            $visumExit = VisumExit::where('id', $id)
                ->where(function ($q) use ($transaksi) {
                    $q->where('no_transaksi', $transaksi->no_transaksi)
                        ->orWhere('kd_kasir', $transaksi->kd_kasir);
                })
                ->with(['dokter', 'userCreate', 'userEdit', 'transaksi'])
                ->firstOrFail();

            // Set locale for Indonesian date formatting
            Carbon::setLocale('id');

            // Load PDF view
            $pdf = PDF::loadView('unit-pelayanan.forensik.pelayanan.visum-exit.print', compact(
                'dataMedis',
                'visumExit'
            ));

            // Set paper to A4 portrait (as per original document)
            $pdf->setPaper('a4', 'portrait');

            // Set options for better rendering
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'serif',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'debugKeepTemp' => false,
            ]);

            // Generate safe filename - remove all problematic characters
            $safeNomorVer = $this->sanitizeFilename($visumExit->nomor_ver);
            $safeDate = $visumExit->tanggal ? Carbon::parse($visumExit->tanggal)->format('d-m-Y') : date('d-m-Y');
            $safePasienName = $this->sanitizeFilename($dataMedis->pasien->nama ?? 'Unknown');

            $filename = "Visum-et-Repertum-{$safeNomorVer}-{$safePasienName}-{$safeDate}.pdf";

            return $pdf->stream($filename);
        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Sanitize filename by removing problematic characters
     */
    private function sanitizeFilename($filename)
    {
        // Remove or replace problematic characters
        $filename = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|', ' '], '-', $filename);

        // Remove multiple consecutive dashes
        $filename = preg_replace('/-+/', '-', $filename);

        // Remove leading and trailing dashes
        $filename = trim($filename, '-');

        // Ensure filename is not empty
        if (empty($filename)) {
            $filename = 'document';
        }

        return $filename;
    }
}

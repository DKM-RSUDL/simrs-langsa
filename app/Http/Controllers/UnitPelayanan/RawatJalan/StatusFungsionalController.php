<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeStatusFungsional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatusFungsionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $query = RmeStatusFungsional::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->with('userCreate');

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        // Filter pencarian petugas
        if ($request->filled('search')) {
            $query->whereHas('userCreate', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $statusFungsionalData = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Add formatted data untuk tampilan
        $statusFungsionalData->getCollection()->transform(function ($item) {
            $item->tanggal_formatted = Carbon::parse($item->tanggal)->format('d/m/Y');
            $item->jam_formatted = Carbon::parse($item->jam)->format('H:i');

            // Hitung hari ke berapa sejak masuk RS
            $tglMasuk = Carbon::parse($item->tgl_masuk);
            $tglPenilaian = Carbon::parse($item->tanggal);
            $item->hari_ke = $tglMasuk->diffInDays($tglPenilaian) + 1;

            // Format nilai skor
            $nilaiSkorOptions = [
                1 => 'Sebelum Sakit',
                2 => 'Saat Masuk',
                3 => 'Minggu I di RS',
                4 => 'Minggu II di RS',
                5 => 'Minggu III di RS',
                6 => 'Minggu IV di RS',
                7 => 'Saat Pulang'
            ];
            $item->nilai_skor_text = $nilaiSkorOptions[$item->nilai_skor] ?? 'Tidak Diketahui';

            // Format kategori dengan badge
            $item->kategori_with_badge = $this->getKategoriBadge($item->kategori);

            return $item;
        });

        return view('unit-pelayanan.rawat-jalan.pelayanan.status-fungsional.index', compact(
            'dataMedis',
            'statusFungsionalData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        return view('unit-pelayanan.rawat-jalan.pelayanan.status-fungsional.create', compact(
            'dataMedis',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Debug data yang diterima (optional - bisa dihapus setelah testing)
        // dd($request->all(), compact('kd_unit', 'kd_pasien', 'tgl_masuk', 'urut_masuk'));

        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nilai_skor' => 'required|in:1,2,3,4,5,6,7',
            'bab' => 'required|integer|min:0|max:2',
            'bak' => 'required|integer|min:0|max:2',
            'membersihkan_diri' => 'required|integer|min:0|max:1',
            'penggunaan_jamban' => 'required|integer|min:0|max:2',
            'makan' => 'required|integer|min:0|max:2',
            'berubah_sikap' => 'required|integer|min:0|max:3',
            'berpindah' => 'required|integer|min:0|max:3',
            'berpakaian' => 'required|integer|min:0|max:2',
            'naik_turun_tangga' => 'required|integer|min:0|max:2',
            'mandi' => 'required|integer|min:0|max:1',
            'skor_total' => 'required|integer|min:0|max:20',
            'kategori' => 'required|string'
        ]);

        // Cek duplikasi data
        $exists = RmeStatusFungsional::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tanggal', $request->tanggal)
            ->where('nilai_skor', $request->nilai_skor)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data dengan tanggal dan nilai skor yang sama sudah ada!');
        }

        try {
            DB::beginTransaction();

            // Siapkan data yang akan disimpan
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'nilai_skor' => $request->nilai_skor,
                'bab' => $request->bab,
                'bak' => $request->bak,
                'membersihkan_diri' => $request->membersihkan_diri,
                'penggunaan_jamban' => $request->penggunaan_jamban,
                'makan' => $request->makan,
                'berubah_sikap' => $request->berubah_sikap,
                'berpindah' => $request->berpindah,
                'berpakaian' => $request->berpakaian,
                'naik_turun_tangga' => $request->naik_turun_tangga,
                'mandi' => $request->mandi,
                'skor_total' => $request->skor_total,
                'kategori' => $request->kategori,
                'user_create' => Auth::id(),
            ];

            // Simpan data
            $result = RmeStatusFungsional::create($data);
            
            DB::commit();

            return redirect()->route('rawat-jalan.status-fungsional.index', [
                $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk
            ])->with('success', 'Data Status Fungsional berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $statusFungsional = RmeStatusFungsional::with('userCreate')
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Format data untuk tampilan
        $statusFungsional->tanggal_formatted = Carbon::parse($statusFungsional->tanggal)->format('d F Y');
        $statusFungsional->jam_formatted = Carbon::parse($statusFungsional->jam)->format('H:i');

        // Hitung hari ke
        $tglMasuk = Carbon::parse($statusFungsional->tgl_masuk);
        $tglPenilaian = Carbon::parse($statusFungsional->tanggal);
        $statusFungsional->hari_ke = $tglMasuk->diffInDays($tglPenilaian) + 1;

        // Format nilai skor
        $nilaiSkorOptions = [
            1 => 'Sebelum Sakit',
            2 => 'Saat Masuk',
            3 => 'Minggu I di RS',
            4 => 'Minggu II di RS',
            5 => 'Minggu III di RS',
            6 => 'Minggu IV di RS',
            7 => 'Saat Pulang'
        ];
        $statusFungsional->nilai_skor_text = $nilaiSkorOptions[$statusFungsional->nilai_skor] ?? 'Tidak Diketahui';

        return view('unit-pelayanan.rawat-jalan.pelayanan.status-fungsional.show', compact(
            'dataMedis',
            'statusFungsional'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk);

        $statusFungsional = RmeStatusFungsional::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        return view('unit-pelayanan.rawat-jalan.pelayanan.status-fungsional.edit', compact(
            'dataMedis',
            'statusFungsional'
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
            'nilai_skor' => 'required|in:1,2,3,4,5,6,7',
            'bab' => 'required|integer|min:0|max:2',
            'bak' => 'required|integer|min:0|max:2',
            'membersikan_diri' => 'required|integer|min:0|max:1',
            'penggunaan_jamban' => 'required|integer|min:0|max:2',
            'makan' => 'required|integer|min:0|max:2',
            'berubah_sikap' => 'required|integer|min:0|max:3',
            'berpindah' => 'required|integer|min:0|max:3',
            'berpakaian' => 'required|integer|min:0|max:2',
            'naik_turun_tangga' => 'required|integer|min:0|max:2',
            'mandi' => 'required|integer|min:0|max:1',
            'skor_total' => 'required|integer|min:0|max:20',
            'kategori' => 'required|string'
        ]);

        $statusFungsional = RmeStatusFungsional::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Cek duplikasi data (exclude current record)
        $exists = RmeStatusFungsional::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tanggal', $request->tanggal)
            ->where('nilai_skor', $request->nilai_skor)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data dengan tanggal dan nilai skor yang sama sudah ada!');
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['user_edit'] = Auth::id();

            // Perbaikan nama field yang typo
            $data['membersihkan_diri'] = $data['membersikan_diri'];
            unset($data['membersikan_diri']);

            $data['penggunaan_jamban'] = $data['penggunaan_jamban'] ?? $data['penggunaan_jemba'] ?? 0;

            $statusFungsional->update($data);

            DB::commit();

            return redirect()->route('rawat-jalan.status-fungsional.index', [
                $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk
            ])->with('success', 'Data Status Fungsional berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $statusFungsional = RmeStatusFungsional::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $statusFungsional->delete();

            return redirect()->route('rawat-jalan.status-fungsional.index', [
                $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk
            ])->with('success', 'Data Status Fungsional berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Check for duplicate data
     */
    public function checkDuplicate(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $query = RmeStatusFungsional::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tanggal', $request->tanggal)
            ->where('nilai_skor', $request->nilai_skor);

        // Jika ada parameter id (untuk edit), exclude record tersebut
        if ($request->has('id') && $request->id) {
            $query->where('id', '!=', $request->id);
        }

        $exists = $query->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Data dengan tanggal dan nilai skor ini sudah ada!' : 'Data dapat disimpan'
        ]);
    }

    /**
     * Helper method untuk mendapatkan badge kategori
     */
    private function getKategoriBadge($kategori)
    {
        switch ($kategori) {
            case 'Mandiri':
                return '<span class="badge bg-success">' . $kategori . '</span>';
            case 'Ketergantungan Ringan':
                return '<span class="badge bg-info">' . $kategori . '</span>';
            case 'Ketergantungan Sedang':
                return '<span class="badge bg-warning text-dark">' . $kategori . '</span>';
            case 'Ketergantungan Berat':
                return '<span class="badge bg-danger">' . $kategori . '</span>';
            case 'Ketergantungan Total':
                return '<span class="badge bg-danger">' . $kategori . '</span>';
            default:
                return '<span class="badge bg-secondary">' . $kategori . '</span>';
        }
    }
}

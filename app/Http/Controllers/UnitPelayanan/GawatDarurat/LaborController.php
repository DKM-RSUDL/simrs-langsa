<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\LapLisItemPemeriksaan;
use App\Models\SegalaOrder;
use App\Models\SegalaOrderDet;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaborController extends Controller
{
    public function index(Request $request, $kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        $DataLapPemeriksaan = LapLisItemPemeriksaan::select('kategori', 'nama', 'kd_produk')
            ->get()
            ->groupBy('kategori');

        $dataDokter = Dokter::all();

        // foreach data di Labor
        $dataLabor = SegalaOrder::with(['details', 'dokter'])
            ->limit(200)
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.index', compact(
            'dataMedis',
            'DataLapPemeriksaan',
            'dataDokter',
            'dataLabor'
        ));
    }

    public function create($kd_pasien, $tgl_masuk)
    {
        // Logika untuk mendapatkan data yang diperlukan
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        // Mengirim data ke view
        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.modal', compact('kd_pasien', 'tgl_masuk'));
    }
    public function store(Request $request)
    {
        dd('Incoming request data:', $request->all());
        $validatedData = $request->validate([
            // Field untuk SegalaOrder
            'kd_pasien' => 'required|string|max:12',
            'kd_unit' => 'required|string|max:5',
            'tgl_masuk' => 'required|date_format:Y-m-d',
            'urut_masuk' => 'required|integer',
            'tgl_order' => 'required|date_format:Y-m-d\TH:i',
            'dilayani' => 'nullable|integer',
            'kategori' => 'required|string|max:10',
            'no_transaksi' => 'nullable|string|max:20',
            'kd_kasir' => 'nullable|string|max:20',
            'status_order' => 'nullable|string|max:20',
            'transaksi_penunjang' => 'nullable|string|max:255',
            'cyto' => 'required|string|max:2',
            'puasa' => 'required|string|max:2',
            'jadwal_pemeriksaan' => 'nullable|date_format:Y-m-d\TH:i',
            'diagnosis' => 'nullable|string|max:255',

            // Field untuk SegalaOrderDet
            'urut' => 'required|integer',
            'kd_produk' => 'required|string|max:10',
            'jumlah' => 'nullable|integer', // Default jumlah 1
            'status' => 'nullable|integer', // Default status 0
            'kd_dokter' => 'required|string|max:3',
        ]);
        dd('Validated data:', $validatedData);

        // Buat kode order baru
        $tglOrder = \Carbon\Carbon::parse($validatedData['tgl_order'])->format('Ymd');
        $lastOrder = SegalaOrder::where('kd_order', 'like', $tglOrder . '%')
            ->orderBy('kd_order', 'desc')
            ->first();

        // Menentukan nomor order baru
        $newOrderNumber = $lastOrder ? (int)substr($lastOrder->kd_order, -4) + 1 : 1;
        $newOrderNumber = str_pad((string)$newOrderNumber, 4, '0', STR_PAD_LEFT);
        $newKdOrder = $tglOrder . $newOrderNumber;

        // Simpan data ke tabel SegalaOrder
        $segalaOrder = SegalaOrder::create([
            'kd_order' => $newKdOrder,
            'kd_pasien' => $validatedData['kd_pasien'],
            'kd_unit' => $validatedData['kd_unit'],
            'tgl_masuk' => $validatedData['tgl_masuk'],
            'urut_masuk' => $validatedData['urut_masuk'],
            'kd_dokter' => $validatedData['kd_dokter'],
            'tgl_order' => $validatedData['tgl_order'],
            'cyto' => $validatedData['cyto'],
            'puasa' => $validatedData['puasa'],
            'jadwal_pemeriksaan' => $validatedData['jadwal_pemeriksaan'] ?? null,
            'diagnosis' => $validatedData['diagnosis'] ?? null,
            'dilayani' => $validatedData['dilayani'] ?? 0,  // Default dilayani = 0
            'kategori' => $validatedData['kategori'],
            'no_transaksi' => $validatedData['no_transaksi'] ?? null,
            'kd_kasir' => $validatedData['kd_kasir'] ?? null,
            'status_order' => $validatedData['status_order'] ?? null,
            'transaksi_penunjang' => $validatedData['transaksi_penunjang'] ?? null,
        ]);
        dd('SegalaOrder created:', $segalaOrder);

        // Simpan data ke tabel SegalaOrderDet
        $segalaOrder = SegalaOrderDet::create([
            'kd_order' => $newKdOrder,
            'urut' => $validatedData['urut'],
            'kd_produk' => $validatedData['kd_produk'],
            'jumlah' => $validatedData['jumlah'] ?? 1,
            'status' => $validatedData['status'] ?? 0,
            'kd_dokter' => $validatedData['kd_dokter'],
        ]);

        dd('SegalaOrderDet created:', $segalaOrder);

        return redirect()->route('labor.index', [
            'kd_pasien' => $validatedData['kd_pasien'],
            'tgl_masuk' => $validatedData['tgl_masuk']
        ])->with(['success' => 'Order created successfully']);
    }
}

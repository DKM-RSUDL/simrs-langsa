<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\AptObat;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrResep;
use App\Models\MrResepDtl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FarmasiController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
            ->where('kd_pasien', $kd_pasien)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $riwayatObat = $this->getRiwayatObat($kd_pasien);

        // Mengambil daftar dokter
        $dokters = Dokter::all();

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.index',
            compact('dataMedis', 'riwayatObat', 'kd_pasien', 'tgl_masuk', 'dokters')
        );
    }

    public function searchObat(Request $request, $kd_pasien, $tgl_masuk)
    {
        $search = $request->get('term');
        $obats = AptObat::join('APT_PRODUK', 'APT_OBAT.KD_PRD', '=', 'APT_PRODUK.KD_PRD')
            ->join('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->leftJoin(DB::raw('(SELECT KD_PRD, HRG_BELI_OBT
                               FROM DATA_BATCH AS db
                               WHERE TGL_MASUK = (
                                   SELECT MAX(TGL_MASUK)
                                   FROM DATA_BATCH
                                   WHERE KD_PRD = db.KD_PRD
                               )) AS latest_price'), 'APT_OBAT.KD_PRD', '=', 'latest_price.KD_PRD')
            ->where('APT_OBAT.nama_obat', 'LIKE', '%' . $search . '%')
            ->select(
                'APT_OBAT.KD_PRD as id',
                'APT_OBAT.nama_obat as text',
                'latest_price.HRG_BELI_OBT as harga',
                'APT_SATUAN.SATUAN as satuan'
            )
            ->take(10)
            ->get();

        return response()->json($obats);
    }

    private function getRiwayatObat($kd_pasien)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->select(
                'MR_RESEP.TGL_MASUK',
                'MR_RESEP.KD_DOKTER',
                'DOKTER.NAMA as NAMA_DOKTER',
                'MR_RESEP.ID_MRRESEP as ID_MRRESEP',
                'MR_RESEP.CAT_RACIKAN',
                'MR_RESEP.TGL_ORDER',
                'MR_RESEP.STATUS',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH',
                'APT_OBAT.NAMA_OBAT'
            )
            ->orderBy('MR_RESEP.TGL_MASUK', 'desc')
            ->get();
    }


    public function store(Request $request, $kd_pasien, $tgl_masuk)
    {
        DB::beginTransaction();

        try {

            // Validasi data
            $validatedData = $request->validate([
                'kd_dokter' => 'required|exists:dokters,id', // Pastikan dokter ada
                'kd_unit' => 'required|string',
                'tgl_order' => 'required|date',
                'jam_order' => 'required|string',
                'cat_racikan' => 'nullable|string',
                'obat' => 'required|array', // Pastikan obat adalah array
                'obat.*.id' => 'required|string',
                'obat.*.nama' => 'required|string',
                'obat.*.dosis' => 'required|string',
                'obat.*.frekuensi' => 'required|string',
                'obat.*.jumlah' => 'required|integer',
            ]);


            // Generate ID_MRRESEP
            $today = Carbon::now();
            $count = MrResep::whereDate('TGL_MASUK', $today)->count() + 1;
            $id_mrresep = $today->format('Ymd') . str_pad($count, 4, '0', STR_PAD_LEFT);

            // Simpan ke MR_RESEP
            $mrResep = new MrResep();
            $mrResep->KD_PASIEN = $kd_pasien;
            $mrResep->KD_UNIT = $validatedData['kd_unit'];
            $mrResep->TGL_MASUK = $today;
            $mrResep->KD_DOKTER = $validatedData['kd_dokter'];
            $mrResep->ID_MRRESEP = $id_mrresep;
            $mrResep->CAT_RACIKAN = $validatedData['cat_racikan'];
            $mrResep->TGL_ORDER = $validatedData['tgl_order'] . ' ' . $validatedData['jam_order'];
            $mrResep->save();

            // Simpan detail resep ke MR_RESEPDTL
            foreach ($request->obat as $index => $obat) {
                $mrResepDtl = new MrResepDtl();
                $mrResepDtl->ID_MRRESEP = $id_mrresep;
                $mrResepDtl->URUT = $index + 1;
                $mrResepDtl->KD_PRD = $obat['id'];
                $mrResepDtl->CARA_PAKAI = $obat['frekuensi'];
                $mrResepDtl->JUMLAH = $obat['jumlah'];
                $mrResepDtl->KD_DOKTER = $request->kd_dokter;
                $mrResepDtl->save();
            }

            DB::commit();

            return response()->json(['message' => 'Resep berhasil disimpan', 'id_mrresep' => $id_mrresep]);
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollback();
            Log::error('Error saving prescription: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}

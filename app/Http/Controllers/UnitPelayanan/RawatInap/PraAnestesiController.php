<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAsesmenPraAnestesi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class PraAnestesiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();

        // Mengambil data kunjungan dan tanggal triase terkait
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
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

        // Mengambil nama alergen dari riwayat_alergi
        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        $asesmenPraAnestesi = RmeAsesmenPraAnestesi::where('kd_unit', $kd_unit)
                            ->where('kd_pasien', $kd_pasien)
                            ->whereDate('tgl_masuk', $tgl_masuk)
                            ->where('urut_masuk', $urut_masuk)
                            ->orderBy('tanggal_create', 'desc')
                            ->paginate(10);

        return view('unit-pelayanan.rawat-inap.pelayanan.pra-anestesi.index', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'user',
            'asesmenPraAnestesi'
        ));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }


        return view('unit-pelayanan.rawat-inap.pelayanan.pra-anestesi.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            $asesmenPraAnestesi = new RmeAsesmenPraAnestesi();

            // parameter dari method signature, bukan dari request
            $asesmenPraAnestesi->kd_pasien = $kd_pasien;
            $asesmenPraAnestesi->kd_unit = $kd_unit;
            $asesmenPraAnestesi->tgl_masuk = $tgl_masuk;
            $asesmenPraAnestesi->urut_masuk = $urut_masuk;

            $asesmenPraAnestesi->user_create = Auth::id();
            $asesmenPraAnestesi->tanggal_create = now();

            // Data dari form
            $asesmenPraAnestesi->umur = $request->umur;
            $asesmenPraAnestesi->jenis_kelamin = $request->jenis_kelamin;
            $asesmenPraAnestesi->menikah = $request->menikah;
            $asesmenPraAnestesi->pekerjaan = $request->pekerjaan;
            $asesmenPraAnestesi->merokok = $request->merokok;
            $asesmenPraAnestesi->alkohol = $request->alkohol;
            $asesmenPraAnestesi->obat_resep = $request->obat_resep;
            $asesmenPraAnestesi->obat_bebas = $request->obat_bebas;
            $asesmenPraAnestesi->aspirin_rutin = $request->aspirin_rutin;
            $asesmenPraAnestesi->aspirin_dosis = $request->aspirin_dosis;
            $asesmenPraAnestesi->obat_anti_sakit = $request->obat_anti_sakit;
            $asesmenPraAnestesi->anti_sakit_dosis = $request->anti_sakit_dosis;
            $asesmenPraAnestesi->injeksi_steroid = $request->injeksi_steroid;
            $asesmenPraAnestesi->steroid_lokasi = $request->steroid_lokasi;
            $asesmenPraAnestesi->alergi_obat = $request->alergi_obat;
            $asesmenPraAnestesi->alergi_obat_detail = $request->alergi_obat_detail;
            $asesmenPraAnestesi->alergi_lateks = $request->alergi_lateks;
            $asesmenPraAnestesi->alergi_plester = $request->alergi_plester;
            $asesmenPraAnestesi->alergi_makanan = $request->alergi_makanan;

            $asesmenPraAnestesi->save();

            DB::commit();

            return to_route('rawat-inap.pra-anestesi.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])
                ->with('success', 'Data pra Anestesi dan Sedasi berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

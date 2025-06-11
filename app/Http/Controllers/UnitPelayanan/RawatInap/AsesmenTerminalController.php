<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenGinekologik;
use App\Models\RmeAsesmenGinekologikDiagnosisImplementasi;
use App\Models\RmeAsesmenGinekologikEkstremitasGinekologik;
use App\Models\RmeAsesmenGinekologikPemeriksaanDischarge;
use App\Models\RmeAsesmenGinekologikTandaVital;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeAsesmenTerminal;
use App\Models\RmeEfekNyeri;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\RmeMenjalar;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsesmenTerminalController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $jenisnyeri = RmeJenisNyeri::all();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();

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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-terminal.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'itemFisik',
            'menjalar',
            'frekuensinyeri',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'jenisnyeri',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {

            // 1. record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 2;
            $asesmen->sub_kategori = 13; // Asesmen Terminal
            $asesmen->save();

            // 2. RmeAsesmen terminal
            $asesmenTerminal = new RmeAsesmenTerminal();
            $asesmenTerminal->id_asesmen = $asesmen->id;
            $asesmenTerminal->user_create = Auth::id();
            $asesmenTerminal->tanggal = Carbon::parse($request->tanggal);
            $asesmenTerminal->jam_masuk = $request->jam_masuk;
            // Kegawatan pernafasan
            $asesmenTerminal->dyspnoe = $request->dyspnoe ? 1 : 0;
            $asesmenTerminal->nafas_tak_teratur = $request->nafas_tak_teratur ? 1 : 0;
            $asesmenTerminal->nafas_tak_teratur = $request->nafas_tak_teratur ? 1 : 0;
            $asesmenTerminal->ada_sekret = $request->ada_sekret ? 1 : 0;
            $asesmenTerminal->nafas_cepat_dangkal = $request->nafas_cepat_dangkal ? 1 : 0;
            $asesmenTerminal->nafas_melalui_mulut = $request->nafas_melalui_mulut ? 1 : 0;
            $asesmenTerminal->spo2_normal = $request->spo2_normal ? 1 : 0;
            $asesmenTerminal->nafas_lambat = $request->nafas_lambat ? 1 : 0;
            $asesmenTerminal->mukosa_oral_kering = $request->mukosa_oral_kering ? 1 : 0;
            $asesmenTerminal->tak = $request->tak ? 1 : 0;
            // Kegawatan Tikus otot
            $asesmenTerminal->mual = $request->mual ? 1 : 0;
            $asesmenTerminal->sulit_menelan = $request->sulit_menelan ? 1 : 0;
            $asesmenTerminal->inkontinensia_alvi = $request->inkontinensia_alvi ? 1 : 0;
            $asesmenTerminal->penurunan_pergerakan = $request->penurunan_pergerakan ? 1 : 0;
            $asesmenTerminal->distensi_abdomen = $request->distensi_abdomen ? 1 : 0;
            $asesmenTerminal->tak2 = $request->tak2 ? 1 : 0;
            $asesmenTerminal->sulit_berbicara = $request->sulit_berbicara ? 1 : 0;
            $asesmenTerminal->inkontinensia_urine = $request->inkontinensia_urine ? 1 : 0;
            // Nyeri
            $asesmenTerminal->nyeri = $request->nyeri;
            $asesmenTerminal->nyeri_keterangan = $request->nyeri_keterangan;
            // Perlambatan Sirkulasi
            $asesmenTerminal->bercerak_sianosis = $request->bercerak_sianosis ? 1 : 0;
            $asesmenTerminal->gelisah = $request->gelisah ? 1 : 0;
            $asesmenTerminal->lemas = $request->lemas ? 1 : 0;
            $asesmenTerminal->kulit_dingin = $request->kulit_dingin ? 1 : 0;
            $asesmenTerminal->tekanan_darah = $request->tekanan_darah ? 1 : 0;
            $asesmenTerminal->nadi_lambat = $request->nadi_lambat;
            $asesmenTerminal->tak3 = $request->tak3 ? 1 : 0;
            $asesmenTerminal->save();

        return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }
}

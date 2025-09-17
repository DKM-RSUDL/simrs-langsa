<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\DokterSpesial;
use App\Models\Konsultasi;
use App\Models\KonsultasiIGD;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmeAsesmen;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\Transaksi;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KonsultasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
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

        $dokterPengirim = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        $unit = Unit::where('aktif', 2)->get();

        $dokterSpesialis = DokterSpesial::with('dokter')
            ->whereRelation('dokter', 'status', 1)
            ->whereNot('kd_spesial', 1)
            ->get()
            ->unique('kd_dokter');


        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        $konsultasi = KonsultasiIGD::with(['dokterAsal', 'dokterTujuan'])
            // filter data per periode to anas
            ->when($periode && $periode !== 'semua', function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_konsul', $now->year)
                            ->whereMonth('tgl_konsul', $now->month);
                    case 'option2':
                        return $query->where('tgl_konsul', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_konsul', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_konsul', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_konsul', '>=', $now->subMonths(9));
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_konsul', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_konsul', '<=', $endDate);
            })
            // end filter data
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', 3)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            // Filter pencarian to anas
            ->when($search, function ($query, $search) {
                $search = strtolower($search);

                if (is_numeric($search) && strlen($search) > 3) {
                    return $query->where('tgl_konsul', $search);
                }
                return $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(tgl_konsul) like ?', ["%$search%"])
                        ->orWhereHas('dokterAsal', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                        });
                });
            })
            ->get();


        // get asesmen data
        $asesmen = RmeAsesmen::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('id', 'DESC')
            ->first();

        $diagnosis = json_decode($asesmen->diagnosis, true);
        $asesmenCreate = implode(',', $diagnosis ?? []);

        $subjectiveCreate = $asesmen->anamnesis;

        $vitalSign = json_decode($asesmen->vital_sign ?? '{}', true);

        $backgroundCreate = '';

        foreach ($vitalSign as $key => $value) {
            $backgroundCreate .= "$key: $value, ";
        }

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.index',
            compact(
                'dataMedis',
                'dokterPengirim',
                'dokterSpesialis',
                'unit',
                'konsultasi',
                'asesmenCreate',
                'subjectiveCreate',
                'backgroundCreate'
            )
        );
    }

    public function storeKonsultasi($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            // Validation
            $msgErr = [
                'dokter_pengirim.required'      => 'Dokter pengirim harus dipilih!',
                'tgl_konsul.required'           => 'Tanggal konsul harus dipilih!',
                'tgl_konsul.date_format'        => 'Tanggal konsul harus format yang benar!',
                'jam_konsul.required'           => 'Jam konsul harus dipilih!',
                'jam_konsul.date_format'        => 'Jam konsul harus format yang benar!',
                'dokter_tujuan.required'        => 'Dokter tujuan harus dipilih!',
                'konsultasi.required'            => 'Konsultasi harus di isi!'
            ];

            $request->validate([
                'dokter_pengirim'       => 'required',
                'dokter_tujuan'         => 'required',
                'tgl_konsul'            => 'required|date_format:Y-m-d',
                'jam_konsul'            => 'required|date_format:H:i',
                'konsultasi'            => 'required',
            ], $msgErr);


            // get kunjungan
            $kunjungan = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.kd_unit', 3)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();


            if (empty($kunjungan)) return back()->with('error', 'Kunjungan gagal terdeteksi sistem!');


            // store konsultasi
            $dataKonsul = [
                'kd_pasien'         => $kd_pasien,
                'kd_unit'           => 3,
                'tgl_masuk'         => $tgl_masuk,
                'urut_masuk'        => $urut_masuk,
                'kd_dokter'         => $request->dokter_pengirim,
                'kd_dokter_tujuan'  => $request->dokter_tujuan,
                'tgl_konsul'        => $request->tgl_konsul,
                'jam_konsul'        => $request->jam_konsul,
                'subjective'        => $request->subjective,
                'background'        => $request->background,
                'assesment'         => $request->assesment,
                'recomendation'     => $request->recomendation,
                'konsultasi'        => $request->konsultasi,
                'instruksi'         => $request->instruksi,
                'user_create'       => Auth::id()
            ];

            KonsultasiIGD::create($dataKonsul);

            DB::commit();
            return back()->with('success', 'Konsultasi berhasil di tambah!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function getKonsulAjax($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            $konsulId = decrypt($request->data_konsul);
            $konsultasi = KonsultasiIGD::find($konsulId);

            if (empty($konsultasi)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data konsultasi tidak ditemukan!',
                    'data'      => []
                ], 200);
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => [
                    "konsultasi" => $konsultasi,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }

    public function updateKonsultasi($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {

            // Validation
            $msgErr = [
                'dokter_pengirim.required'      => 'Dokter pengirim harus dipilih!',
                'tgl_konsul.required'           => 'Tanggal konsul harus dipilih!',
                'tgl_konsul.date_format'        => 'Tanggal konsul harus format yang benar!',
                'jam_konsul.required'           => 'Jam konsul harus dipilih!',
                'jam_konsul.date_format'        => 'Jam konsul harus format yang benar!',
                'dokter_tujuan.required'        => 'Dokter tujuan harus dipilih!',
                'konsultasi.required'            => 'Konsultasi harus di isi!'
            ];

            $request->validate([
                'id_konsul'             => 'required',
                'dokter_pengirim'       => 'required',
                'dokter_tujuan'         => 'required',
                'tgl_konsul'            => 'required|date_format:Y-m-d',
                'jam_konsul'            => 'required',
                'konsultasi'            => 'required',
            ], $msgErr);


            // update konsul
            KonsultasiIGD::where('id', $request->id_konsul)
                ->update([
                    'kd_dokter'         => $request->dokter_pengirim,
                    'kd_dokter_tujuan'  => $request->dokter_tujuan,
                    'tgl_konsul'        => $request->tgl_konsul,
                    'jam_konsul'        => $request->jam_konsul,
                    'subjective'        => $request->subjective,
                    'background'        => $request->background,
                    'assesment'         => $request->assesment,
                    'recomendation'     => $request->recomendation,
                    'konsultasi'        => $request->konsultasi,
                    'instruksi'         => $request->instruksi,
                    'user_edit'       => Auth::id()
                ]);

            DB::commit();
            return back()->with('success', 'Konsultasi berhasil di ubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteKonsultasi($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            // get konsultasi
            $idKonsul = decrypt($request->data_konsul);
            $konsultasi = KonsultasiIGD::where('id', $idKonsul)->first();

            if (empty($konsultasi)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data konsultasi tidak ditemukan',
                    'data'      => []
                ], 200);
            }

            $konsultasi->delete();

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Konsultasi berhasil dihapus',
                'data'      => []
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }

    public function pdf($kd_pasien, $tgl_masuk, $urut_amsuk, $konsul)
    {
        $idKonsul = decrypt($konsul);
        $konsultasi = KonsultasiIGD::with(['pasien', 'dokterAsal', 'dokterTujuan'])->find($idKonsul);

        if (empty($konsultasi)) return back()->with('error', 'Gagal menemukan data konsultasi !');

        $pdf = Pdf::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.print', compact('konsultasi'))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('konsultasi_' . $konsultasi->kd_pasien . '_' . $konsultasi->tgl_konsul . '.pdf');
    }

    public function getDokterbyUnit(Request $request)
    {
        try {
            $dokter = DokterKlinik::with(['dokter', 'unit'])
                ->where('kd_unit', $request->kd_unit)
                ->whereRelation('dokter', 'status', 1)
                ->get();

            if (count($dokter) > 0) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data ditemukan',
                    'data'      => $dokter
                ]);
            } else {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan',
                    'data'      => []
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }
}

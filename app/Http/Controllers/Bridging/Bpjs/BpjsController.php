<?php

namespace App\Http\Controllers\Bridging\Bpjs;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\SjpKunjungan;
use App\Services\BaseService;
use App\Services\Bpjs\BpjsService;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BpjsController extends Controller
{
    private $baseService;
    private $bpjsService;

    public function __construct()
    {
        $this->baseService = new BaseService();
        $this->bpjsService = new BpjsService();
    }

    public function icare(Request $request)
    {
        try {
            $kd_unit = $request->kd_unit ?? '0000000000000';
            $kd_pasien = $request->kd_pasien ?? '0000000000000';
            $tgl_masuk = $request->tgl_masuk ?? '0000000000000';
            $urut_masuk = $request->urut_masuk ?? '0000000000000';

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) throw new Exception('Data medis tidak ditemukan.');

            $icare = $this->bpjsService->icare($dataMedis->pasien->no_asuransi ?? null, $dataMedis->dokter->kd_user ?? null);
            if ($icare['status'] == 'error') throw new Exception($icare['message']);

            $url = $icare['data'];

            // update status_triase pada sjp_kunjungan
            SjpKunjungan::where('kd_unit', $dataMedis->kd_unit)
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
                ->update([
                    'status_icare'  => 1
                ]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    function vclaim($identifier)
    {
        try {
            $pasien = Pasien::query()
                ->select(['nama', 'alamat', 'tgl_lahir', 'no_asuransi', 'jenis_kelamin', 'kd_pasien'])
                ->where('no_pengenal', $identifier)
                ->orWhere('kd_pasien', $identifier)
                ->first();

            if (!$pasien) {
                return response()->json([
                    'status'    => 'success',
                    'metaData' => ['code' => 404, 'message' => "Pasien Tidak Ditemukan"],
                ], 404);
            }

            $umur = null;
            $tgl_lahir = null;
            $jenis_kelamin = $pasien->jenis_kelamin;  // === "0" ? 'Perempuan' : 'Laki-laki';

            if ($pasien->tgl_lahir) {
                $umur = Carbon::parse($pasien->tgl_lahir)->age;
                $tgl_lahir = Carbon::parse($pasien->tgl_lahir)->toDateString();
            }

            // If no_asuransi(bpjs) doesn't exist
            if (!$pasien->no_asuransi) {
                return response()->json([
                    'status'    => 'success',
                    'metaData' => ['code' => 200, 'message' => "Data Pasien ada Tetapi tidak memiliki Asuransi"],
                    'data' => [
                        'nama'          => $pasien->nama,
                        'alamat'        => $pasien->alamat,
                        'tgl_lahir'     => $tgl_lahir,
                        'umur'          => $umur,
                        'jenis_kelamin' => $jenis_kelamin,
                        'bpjs'          => null,
                    ],
                ]);
            }

            $vclaim = $this->bpjsService->vclaim($pasien->no_asuransi);
            $vclaim['metaData']['message'] = 'Data ditemukan';
            $response = $vclaim['response'];
            return response()->json([
                'status'    => 'success',
                'metaData'  => $vclaim['metaData'],
                'data' => [
                    'kd_pasien'     => $pasien->kd_pasien,
                    'nama'          => $pasien->nama,
                    'alamat'        => $pasien->alamat,
                    'tgl_lahir'     => $tgl_lahir,
                    'umur'          => $umur,
                    'jenis_kelamin' => $jenis_kelamin,
                    "jenis_peserta"     => $response['jenisPeserta'],
                    "kelas_tanggung"    => $response['hakKelas'],
                    "status_peserta"    => $response['statusPeserta'],
                ],

            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }
}

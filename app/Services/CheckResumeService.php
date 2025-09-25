<?php

namespace App\Services;

use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Illuminate\Support\Facades\DB;

class CheckResumeService
{
    public function checkAndCreateResume($data)
    {
        try {
            // Cek apakah resume sudah ada
            $resume = RMEResume::where('kd_pasien', $data['kd_pasien'])
                ->where('kd_unit', $data['kd_unit'])
                ->where('tgl_masuk', $data['tgl_masuk'])
                ->where('urut_masuk', $data['urut_masuk'])
                ->first();

            if (!$resume) {
                // Jika belum ada
                $resume = RMEResume::create([
                    'kd_pasien' => $data['kd_pasien'],
                    'kd_unit' => $data['kd_unit'],
                    'tgl_masuk' => $data['tgl_masuk'],
                    'urut_masuk' => $data['urut_masuk'],
                    'status' => 0,
                ]);

                $resume = RMEResume::where('kd_pasien', $data['kd_pasien'])
                    ->where('kd_unit', $data['kd_unit'])
                    ->where('tgl_masuk', $data['tgl_masuk'])
                    ->where('urut_masuk', $data['urut_masuk'])
                    ->first();
            }

            // Entri di RMEResumeDtl
            if ($resume) {
                $resumeDetail = RmeResumeDtl::where('id_resume', $resume->id)->first();

                if (!$resumeDetail) {
                    DB::table('RME_RESUME_DTL')->insert([
                        'id_resume' => $resume->id
                    ]);
                }

                DB::commit();
                return $resume;
            }
            throw new \Exception('Gagal membuat atau mendapatkan data resume');
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

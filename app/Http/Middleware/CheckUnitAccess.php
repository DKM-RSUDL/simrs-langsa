<?php

namespace App\Http\Middleware;

use App\Models\Dokter;
use App\Models\DokterInap;
use App\Models\DokterKlinik;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckUnitAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $currentUnit = $request->route('kd_unit');

        if($user->hasRole('admin')) return $next($request);

        // jenis tenaga
        $kdJenisTenaga = $user->karyawan->kd_jenis_tenaga;
        $kdDetailJenisTenaga = $user->karyawan->kd_detail_jenis_tenaga;
        $kdUnitRuangan = $user->karyawan->ruangan->kd_unit;

        // DOKTER
        if($kdJenisTenaga == 1) {

            // Dokter Spesialis
            // if(in_array($kdDetailJenisTenaga, [2,3])) {
                $dokter = Dokter::where('kd_karyawan', $user->kd_karyawan)->first();
                
                // get dokter unit RWJ
                $klinikList = DokterKlinik::where('kd_dokter', $dokter->kd_dokter)
                                        ->pluck('kd_unit')
                                        ->toArray();

                // get dokter unit RWI
                $rwiList = DokterInap::where('kd_dokter', $dokter->kd_dokter)
                                    ->pluck('kd_unit')
                                    ->toArray();

                // dokter unit RWJ dan RWI
                $unitList = array_merge($klinikList, $rwiList);


                // Debug untuk melihat nilai array
                // Log::info('Current Unit: ' . $currentUnit);
                // Log::info('Unit List: ', $unitList);

                // Check if user's unit matches the requested unit
                if (!in_array($currentUnit, $unitList)) {
                    abort(403, 'Unauthorized access to this unit.');
                }

                return $next($request);
            // }
        }

        // PERAWAT
        if($kdJenisTenaga == 2 && $kdDetailJenisTenaga == 1 && $kdUnitRuangan == $currentUnit) return $next($request);

        abort(403, 'Unauthorized access to this unit.');

    }

}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGawatDaruratAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if($user->hasRole('admin')) return $next($request);

        // jenis tenaga
        $kdJenisTenaga = $user->karyawan->kd_jenis_tenaga;
        $kdDetailJenisTenaga = $user->karyawan->kd_detail_jenis_tenaga;
        $kdRuangan = $user->karyawan->kd_ruangan;

        // DOKTER
        if($kdJenisTenaga == 1 && $kdDetailJenisTenaga == 1) return $next($request);
        // PERAWAT
        if($kdJenisTenaga == 2 && $kdDetailJenisTenaga == 1 && $kdRuangan == 36) return $next($request);
        // BIDAN
        if($kdJenisTenaga == 2 && $kdDetailJenisTenaga == 2 && $kdRuangan == 36) return $next($request);

        abort(403, 'Unauthorized access to this unit.');
    }
}

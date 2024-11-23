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

        // jenis tenaga
        $kdJenisTenaga = $user->karyawan->kd_jenis_tenaga;
        $kdDetailJenisTenaga = $user->karyawan->kd_detail_jenis_tenaga;

        // DOKTER
        if($kdJenisTenaga == 1 && $kdDetailJenisTenaga != 1) {
            abort(403, 'Unauthorized access to this unit.');
        }

        return $next($request);
    }
}

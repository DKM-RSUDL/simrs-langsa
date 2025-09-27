<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Dokter;
use App\Models\DokterInap;
use App\Models\DokterKlinik;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-unit', function ($user, $kd_unit) {

            if($user->hasRole('admin')) return true;

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


                    return in_array($kd_unit, $unitList);

                // }
            }

            // PERAWAT
            if($kdJenisTenaga == 2 && $kdDetailJenisTenaga == 1 && $kdUnitRuangan == $kd_unit) return true;
            // BIDAN
            if($kdJenisTenaga == 2 && $kdDetailJenisTenaga == 2 && $kdUnitRuangan == $kd_unit) return true;

            return false;
        });

        Gate::define('is-admin', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('is-dokter-umum', function($user) {
            // jenis tenaga
            $kdJenisTenaga = $user->karyawan->kd_jenis_tenaga;
            $kdDetailJenisTenaga = $user->karyawan->kd_detail_jenis_tenaga;

            return $kdJenisTenaga == 1 && $kdDetailJenisTenaga == 1;
        });

        Gate::define('is-dokter-spesialis', function($user) {
            // jenis tenaga
            $kdJenisTenaga = $user->karyawan->kd_jenis_tenaga;
            $kdDetailJenisTenaga = $user->karyawan->kd_detail_jenis_tenaga;

            if($kdJenisTenaga == 1 && $kdDetailJenisTenaga == 1) return true;
            if($kdJenisTenaga == 1 && $kdDetailJenisTenaga == 2) return true;
            return false;
        });

        Gate::define('is-perawat', function($user) {
            // jenis tenaga
            $kdJenisTenaga = $user->karyawan->kd_jenis_tenaga;
            $kdDetailJenisTenaga = $user->karyawan->kd_detail_jenis_tenaga;

            return $kdJenisTenaga == 2 && $kdDetailJenisTenaga == 1;
        });

        Gate::define('is-bidan', function($user) {
            // jenis tenaga
            $kdJenisTenaga = $user->karyawan->kd_jenis_tenaga;
            $kdDetailJenisTenaga = $user->karyawan->kd_detail_jenis_tenaga;

            return $kdJenisTenaga == 2 && $kdDetailJenisTenaga == 2;
        });
    }
}

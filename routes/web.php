<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// unit pelanayan
use App\Http\Controllers\UnitPelayanan\RawatJalanController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\BedahController;
use App\Http\Controllers\UnitPelayanan\GawatDaruratController;
use App\Http\Controllers\MedisGawatDaruratController;
use App\Http\Controllers\UnitPelayanan\AsesmenController;
use App\Http\Controllers\UnitPelayanan\CarePlanController;
use App\Http\Controllers\UnitPelayanan\CpptController;
use App\Http\Controllers\UnitPelayanan\EdukasiController;
use App\Http\Controllers\UnitPelayanan\FarmasiController;
use App\Http\Controllers\UnitPelayanan\KonsultasiController;
use App\Http\Controllers\UnitPelayanan\LaborController;
use App\Http\Controllers\UnitPelayanan\RadiologiController;
use App\Http\Controllers\UnitPelayanan\ResumeController;
use App\Http\Controllers\UnitPelayanan\TindakanController;

Auth::routes(['register' => false]); // Nonaktifkan register
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('navigation', NavigationController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);

    // Grup rute untuk Unit Pelayanan
    Route::prefix('unit-pelayanan')->group(function () {
        // Rute untuk Rawat Jalan
        Route::resource('rawat-jalan', RawatJalanController::class);
        // Rute untuk Klinik Bedah di dalam Rawat Jalan
        Route::prefix('ruang-klinik')->group(function () {
            Route::resource('bedah', BedahController::class);
        });

        Route::resource('gawat-darurat', GawatDaruratController::class);

        Route::prefix('gawat-darurat')->group(function () {
            Route::prefix('pelayanan')->group(function () {
                Route::prefix('/{kd_pasien}')->group(function () {
                    Route::resource('/', MedisGawatDaruratController::class);
                    Route::resource('asesmen', AsesmenController::class);
                    Route::resource('cppt', CpptController::class);
                    Route::resource('tindakan', TindakanController::class);
                    Route::resource('konsultasi', KonsultasiController::class);
                    Route::resource('labor', LaborController::class);
                    Route::resource('radiologi', RadiologiController::class);
                    Route::resource('farmasi', FarmasiController::class);
                    Route::resource('edukasi', EdukasiController::class);
                    Route::resource('careplan', CarePlanController::class);
                    Route::resource('resume', ResumeController::class);
                });
            });
        });
    });
});

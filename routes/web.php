<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\CpptController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// unit pelanayan
use App\Http\Controllers\UnitPelayanan\RawatJalanController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\BedahController;
use App\Http\Controllers\UnitPelayanan\GawatDaruratController;
use App\Http\Controllers\MedisGawatDaruratController;

// action gawat darurat
use App\Http\Controllers\UnitPelayanan\GawatDarurat\AsesmenController as GawatDaruratAsesmenController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\CarePlanController as GawatDaruratCarePlanController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\CpptController as GawatDaruratCpptController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\EdukasiController as GawatDaruratEdukasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\FarmasiController as GawatDaruratFarmasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\KonsultasiController as GawatDaruratKonsultasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\LaborController as GawatDaruratLaborController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\RadiologiController as GawatDaruratRadiologiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\ResumeController as GawatDaruratResumeController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\TindakanController as GawatDaruratTindakanController;

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
        Route::prefix('rawat-jalan')->group(function() {
            Route::name('rawat-jalan')->group(function() {
                Route::get('/', [RawatJalanController::class, 'index'])->name('.index');

                Route::prefix('unit/{kd_unit}')->group(function() {
                    Route::name('.unit')->group(function() {
                        Route::get('/', [RawatJalanController::class, 'unitPelayanan']);
                    });

                    // Pelayanan
                    Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function() {
                        Route::name('.pelayanan')->group(function() {
                            Route::get('/', [RawatJalanController::class, 'pelayanan']);
                        });

                        // CPPT
                        Route::prefix('cppt')->group(function() {
                            Route::name('.cppt')->group(function() {
                                Route::controller(CpptController::class)->group(function() {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/get-icd10-ajax', 'getIcdTenAjax')->name('.get-icd10-ajax');
                                    Route::post('/get-cppt-ajax', 'getCpptAjax')->name('.get-cppt-ajax');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                    Route::put('/verifikasi', 'verifikasiCppt')->name('.verifikasi');
                                });
                            });
                        });
                    });
                });
            });
        });

        Route::resource('gawat-darurat', GawatDaruratController::class);

        Route::prefix('gawat-darurat')->group(function () {
            Route::prefix('pelayanan')->group(function () {
                Route::prefix('/{kd_pasien}/{tgl_masuk}')->group(function () {
                    // CPPT
                    Route::prefix('cppt')->group(function() {
                        Route::name('cppt')->group(function() {
                            Route::controller(GawatDaruratCpptController::class)->group(function() {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/get-icd10-ajax', 'getIcdTenAjax')->name('.get-icd10-ajax');
                                Route::post('/get-cppt-ajax', 'getCpptAjax')->name('.get-cppt-ajax');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/', 'update')->name('.update');
                                Route::put('/verifikasi', 'verifikasiCppt')->name('.verifikasi');
                            });
                        });
                    });

                    // Radologi
                    Route::prefix('radiologi')->group(function() {
                        Route::name('radiologi')->group(function() {
                            Route::controller(GawatDaruratRadiologiController::class)->group(function() {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/', 'update')->name('.update');
                                Route::post('/get-rad-detail-ajax', 'getRadDetailAjax')->name('.get-rad-detail-ajax');
                                Route::delete('/', 'delete')->name('.delete');
                            });
                        });
                    });

                    // Route::resource('farmasi', GawatDaruratFarmasiController::class);
                    Route::prefix('farmasi')->group(function () {
                        Route::name('farmasi')->group(function () {
                            Route::controller(GawatDaruratFarmasiController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/search-obat', 'searchObat')->name('.searchObat');
                            });
                        });
                    });

                    Route::resource('/', MedisGawatDaruratController::class);
                    Route::resource('asesmen', GawatDaruratAsesmenController::class);
                    Route::resource('tindakan', GawatDaruratTindakanController::class);
                    Route::resource('konsultasi', GawatDaruratKonsultasiController::class);
                    Route::resource('labor', GawatDaruratLaborController::class);
                    Route::resource('edukasi', GawatDaruratEdukasiController::class);
                    Route::resource('careplan', GawatDaruratCarePlanController::class);
                    Route::resource('resume', GawatDaruratResumeController::class);
                });
            });
        });
    });
});

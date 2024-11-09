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

use App\Http\Controllers\UnitPelayanan\RawatInap\CpptController as RawatInapCpptController;
use App\Http\Controllers\UnitPelayanan\RawatInap\FarmasiController as RawatInapFarmasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\KonsultasiController as RawatInapKonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RadiologiController as RawatInapRadiologiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapLabPatologiKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapResumeController;
use App\Http\Controllers\UnitPelayanan\RawatInap\TindakanController as RawatInapTindakanController;
use App\Http\Controllers\UnitPelayanan\RawatInapController;

use App\Http\Controllers\UnitPelayanan\RawatJalan\FarmasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\KonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\LabPatologiKlinikController as RawatJalanLabPatologiKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RadiologiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RawatJalanResumeController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\TindakanController;

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
        Route::prefix('rawat-jalan')->group(function () {
            Route::name('rawat-jalan')->group(function () {
                Route::get('/', [RawatJalanController::class, 'index'])->name('.index');

                Route::prefix('unit/{kd_unit}')->group(function () {
                    Route::name('.unit')->group(function () {
                        Route::get('/', [RawatJalanController::class, 'unitPelayanan']);
                    });

                    // Pelayanan
                    Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
                        Route::name('.pelayanan')->group(function () {
                            Route::get('/', [RawatJalanController::class, 'pelayanan']);
                        });

                        // CPPT
                        Route::prefix('cppt')->group(function () {
                            Route::name('.cppt')->group(function () {
                                Route::controller(CpptController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/get-icd10-ajax', 'getIcdTenAjax')->name('.get-icd10-ajax');
                                    Route::post('/get-cppt-ajax', 'getCpptAjax')->name('.get-cppt-ajax');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                    Route::put('/verifikasi', 'verifikasiCppt')->name('.verifikasi');
                                    Route::post('/search', 'searchCppt')->name('.search');
                                });
                            });
                        });

                        // Radologi
                        Route::prefix('radiologi')->group(function () {
                            Route::name('.radiologi')->group(function () {
                                Route::controller(RadiologiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                    Route::post('/get-rad-detail-ajax', 'getRadDetailAjax')->name('.get-rad-detail-ajax');
                                    Route::delete('/', 'delete')->name('.delete');
                                });
                            });
                        });

                        // Konsultasi
                        Route::prefix('konsultasi')->group(function() {
                            Route::name('.konsultasi')->group(function() {
                                Route::controller(KonsultasiController::class)->group(function() {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/get-dokter-unit', 'getDokterbyUnit')->name('.get-dokter-unit');
                                    Route::post('/', 'storeKonsultasi')->name('.store');
                                    Route::put('/', 'updateKonsultasi')->name('.update');
                                    Route::delete('/', 'deleteKonsultasi')->name('.delete');
                                    Route::post('/get-konsul-ajax', 'getKonsulAjax')->name('.get-konsul-ajax');
                                });
                            });
                        });

                        // Tindakan
                        Route::prefix('tindakan')->group(function() {
                            Route::name('.tindakan')->group(function() {
                                Route::controller(TindakanController::class)->group(function() {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'storeTindakan')->name('.store');
                                    Route::put('/', 'updateTindakan')->name('.update');
                                    Route::delete('/', 'deleteTindakan')->name('.delete');
                                    Route::post('/get-tindakan-ajax', 'getTindakanAjax')->name('.get-tindakan-ajax');
                                });
                            });
                        });

                        // Route::resource('farmasi', GawatDaruratFarmasiController::class);
                        Route::prefix('farmasi')->group(function () {
                            Route::name('.farmasi')->group(function () {
                                Route::controller(FarmasiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/search-obat', 'searchObat')->name('.searchObat');
                                });
                            });
                        });



                        Route::prefix('radiologi')->group(function () {
                            Route::name('.radiologi')->group(function () {
                                Route::controller(RadiologiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                    Route::post('/get-rad-detail-ajax', 'getRadDetailAjax')->name('.get-rad-detail-ajax');
                                    Route::delete('/', 'delete')->name('.delete');
                                });
                            });
                        });

                        // labor PK
                        Route::prefix('lab-patologi-klinik')->group(function () {
                            Route::name('.lab-patologi-klinik')->group(function () {
                                Route::controller(RawatJalanLabPatologiKlinikController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                    Route::delete('/', 'destroy')->name('.destroy');
                                });
                            });
                        });

                        // Resume
                        Route::prefix('rawat-jalan-resume')->group(function () {
                            Route::name('.rawat-jalan-resume')->group(function () {
                                Route::controller(RawatJalanResumeController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/{id}', 'update')->name('.update');
                                });
                            });
                        });
                    });
                });
            });
        });

        // Rute untuk Rawat Inap
        Route::prefix('rawat-inap')->group(function () {
            Route::name('rawat-inap')->group(function () {
                Route::get('/', [RawatInapController::class, 'index'])->name('.index');

                Route::prefix('unit/{kd_unit}')->group(function () {
                    Route::name('.unit')->group(function () {
                        Route::get('/', [RawatInapController::class, 'unitPelayanan']);
                    });

                    // Pelayanan
                    Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
                        Route::name('.pelayanan')->group(function () {
                            Route::get('/', [RawatInapController::class, 'pelayanan']);
                        });

                        // CPPT
                        Route::prefix('cppt')->group(function () {
                            Route::name('.cppt')->group(function () {
                                Route::controller(RawatInapCpptController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/get-icd10-ajax', 'getIcdTenAjax')->name('.get-icd10-ajax');
                                    Route::post('/get-cppt-ajax', 'getCpptAjax')->name('.get-cppt-ajax');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                    Route::put('/verifikasi', 'verifikasiCppt')->name('.verifikasi');
                                });
                            });
                        });

                        // Radiologi
                        Route::prefix('radiologi')->group(function () {
                            Route::name('.radiologi')->group(function () {
                                Route::controller(RawatInapRadiologiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                    Route::post('/get-rad-detail-ajax', 'getRadDetailAjax')->name('.get-rad-detail-ajax');
                                    Route::delete('/', 'delete')->name('.delete');
                                });
                            });
                        });

                        // Konsultasi
                        Route::prefix('konsultasi')->group(function() {
                            Route::name('.konsultasi')->group(function() {
                                Route::controller(RawatInapKonsultasiController::class)->group(function() {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/get-dokter-unit', 'getDokterbyUnit')->name('.get-dokter-unit');
                                    Route::post('/', 'storeKonsultasi')->name('.store');
                                    Route::put('/', 'updateKonsultasi')->name('.update');
                                    Route::delete('/', 'deleteKonsultasi')->name('.delete');
                                    Route::post('/get-konsul-ajax', 'getKonsulAjax')->name('.get-konsul-ajax');
                                });
                            });
                        });

                        // Tindakan
                        Route::prefix('tindakan')->group(function() {
                            Route::name('.tindakan')->group(function() {
                                Route::controller(RawatInapTindakanController::class)->group(function() {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'storeTindakan')->name('.store');
                                    Route::put('/', 'updateTindakan')->name('.update');
                                    Route::delete('/', 'deleteTindakan')->name('.delete');
                                    Route::post('/get-tindakan-ajax', 'getTindakanAjax')->name('.get-tindakan-ajax');
                                });
                            });
                        });

                        // labor PK
                        Route::prefix('lab-patologi-klinik')->group(function () {
                            Route::name('.lab-patologi-klinik')->group(function () {
                                Route::controller(RawatInapLabPatologiKlinikController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                    Route::delete('/', 'destroy')->name('.destroy');
                                });
                            });
                        });

                        Route::prefix('farmasi')->group(function () {
                            Route::name('.farmasi')->group(function () {
                                Route::controller(RawatInapFarmasiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/search-obat', 'searchObat')->name('.searchObat');
                                });
                            });
                        });

                        // resume
                        Route::prefix('rawat-inap-resume')->group(function () {
                            Route::name('.rawat-inap-resume')->group(function () {
                                Route::controller(RawatInapResumeController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::put('/{id}', 'update')->name('.update');
                                });
                            });
                        });
                    });
                });
            });
        });


        // Rute untuk Gawat Darurat
        Route::prefix('gawat-darurat')->group(function () {
            Route::get('/', [GawatDaruratController::class, 'index'])->name('gawat-darurat.index');
            Route::post('/store-triase', [GawatDaruratController::class, 'storeTriase'])->name('gawat-darurat.store-triase');
            Route::post('/get-patient-bynik-ajax', [GawatDaruratController::class, 'getPatientByNikAjax'])->name('gawat-darurat.get-patient-bynik-ajax');

            Route::prefix('pelayanan')->group(function () {
                Route::prefix('/{kd_pasien}/{tgl_masuk}')->group(function () {
                    // CPPT
                    Route::prefix('cppt')->group(function () {
                        Route::name('cppt')->group(function () {
                            Route::controller(GawatDaruratCpptController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/get-icd10-ajax', 'getIcdTenAjax')->name('.get-icd10-ajax');
                                Route::post('/get-cppt-ajax', 'getCpptAjax')->name('.get-cppt-ajax');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/', 'update')->name('.update');
                                Route::put('/verifikasi', 'verifikasiCppt')->name('.verifikasi');
                                Route::post('/search', 'searchCppt')->name('.search');
                            });
                        });
                    });

                    // Radologi
                    Route::prefix('radiologi')->group(function () {
                        Route::name('radiologi')->group(function () {
                            Route::controller(GawatDaruratRadiologiController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/', 'update')->name('.update');
                                Route::post('/get-rad-detail-ajax', 'getRadDetailAjax')->name('.get-rad-detail-ajax');
                                Route::delete('/', 'delete')->name('.delete');
                            });
                        });
                    });

                    // Tindakan
                    Route::prefix('tindakan')->group(function() {
                        Route::name('tindakan')->group(function() {
                            Route::controller(GawatDaruratTindakanController::class)->group(function() {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'storeTindakan')->name('.store');
                                Route::put('/', 'updateTindakan')->name('.update');
                                Route::delete('/', 'deleteTindakan')->name('.delete');
                                Route::post('/get-tindakan-ajax', 'getTindakanAjax')->name('.get-tindakan-ajax');
                            });
                        });
                    });

                    // Konsultasi
                    Route::prefix('konsultasi')->group(function() {
                        Route::name('konsultasi')->group(function() {
                            Route::controller(GawatDaruratKonsultasiController::class)->group(function() {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/get-dokter-unit', 'getDokterbyUnit')->name('.get-dokter-unit');
                                Route::post('/', 'storeKonsultasi')->name('.store');
                                Route::put('/', 'updateKonsultasi')->name('.update');
                                Route::delete('/', 'deleteKonsultasi')->name('.delete');
                                Route::post('/get-konsul-ajax', 'getKonsulAjax')->name('.get-konsul-ajax');
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


                    Route::prefix('asesmen')->group(function () {
                        Route::name('asesmen')->group(function () {
                            Route::controller(GawatDaruratAsesmenController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/{id}', 'show')->name('.show');
                                Route::put('/{id}', 'update')->name('.update');
                            });
                        });
                    });


                    Route::resource('/', MedisGawatDaruratController::class);
                    // Route::resource('asesmen', GawatDaruratAsesmenController::class);
                    Route::resource('labor', GawatDaruratLaborController::class);
                    Route::resource('edukasi', GawatDaruratEdukasiController::class);
                    Route::resource('careplan', GawatDaruratCarePlanController::class);
                    Route::resource('resume', GawatDaruratResumeController::class);
                });
            });
        });
    });
});

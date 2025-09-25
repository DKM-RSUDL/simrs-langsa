<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UnitPelayanan\Hemodialisa\AsesmenHemodialisaKeperawatanController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\AsesmenMedisController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\BeratBadanKeringController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\DataUmumController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\MalnutritionInflammationScoreController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\HDEdukasiController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\HDTindakanKhususController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\HDHasilEKGController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\HDHasilLabController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\PersetujuanAksesFemoralisController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\PersetujuanImplementasiEvaluasiKeperawatanController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\PersetujuanTindakanHDController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\PersetujuanTindakanMedisController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\TravelingDialysisController;
use App\Http\Controllers\UnitPelayanan\HemodialisaController;

Route::prefix('hemodialisa')->group(function () {
    Route::name('hemodialisa')->group(function () {
        Route::get('/', [HemodialisaController::class, 'index'])->name('.index');

        // Pelayanan
        Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
            Route::name('.pelayanan')->group(function () {
                Route::get('/', [HemodialisaController::class, 'pelayanan']);

                // Asesmen
                Route::prefix('asesmen')->group(function () {
                    Route::name('.asesmen')->group(function () {
                        Route::get('/', [AsesmenMedisController::class, 'index'])->name('.index');

                        //MEDIS
                        Route::prefix('medis')->group(function () {
                            Route::name('.medis')->group(function () {
                                Route::controller(AsesmenMedisController::class)->group(function () {
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::get('/{data}/show', 'show')->name('.show');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/{data}', 'update')->name('.update');
                                });
                            });
                        });

                        Route::prefix('keperawatan')->group(function () {
                            Route::name('.keperawatan')->group(function () {
                                Route::controller(AsesmenHemodialisaKeperawatanController::class)->group(function () {
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::get('/{data}/show', 'show')->name('.show');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/{id}', 'update')->name('.update');
                                });
                            });
                        });
                    });
                });

                // Data Umum
                Route::prefix('data-umum')->group(function () {
                    Route::name('.data-umum')->group(function () {
                        Route::controller(DataUmumController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/{data}', 'show')->name('.show');
                            Route::delete('/', 'delete')->name('.delete');
                        });
                    });
                });

                //Berat Badan Kering (BBK)
                Route::prefix('berat-badan-kering')->group(function () {
                    Route::name('.berat-badan-kering')->group(function () {
                        Route::controller(BeratBadanKeringController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{id}/edit', 'edit')->name('.edit');
                            Route::put('/{id}', 'update')->name('.update');
                            Route::get('/{id}', 'show')->name('.show');
                            Route::delete('/{id}', 'destroy')->name('.destroy');
                        });
                    });
                });

                //Malnutrition Inflammation Score (MIS)
                Route::prefix('malnutrition-inflammation-score')->group(function () {
                    Route::name('.malnutrition-inflammation-score')->group(function () {
                        Route::controller(MalnutritionInflammationScoreController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{id}/edit', 'edit')->name('.edit');
                            Route::put('/{id}', 'update')->name('.update');
                            Route::get('/{id}', 'show')->name('.show');
                            Route::get('/{id}/print', 'print')->name('.print');
                            Route::delete('/{id}', 'destroy')->name('.destroy');
                        });
                    });
                });

                // edukasi
                Route::prefix('edukasi')->group(function () {
                    Route::name('.edukasi')->group(function () {
                        Route::controller(HDEdukasiController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/{data}', 'show')->name('.show');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                            Route::delete('/{data}', 'destroy')->name('.destroy');
                        });
                    });
                });

                // tindakan khusus
                Route::prefix('tindakan-khusus')->group(function () {
                    Route::name('.tindakan-khusus')->group(function () {
                        Route::controller(HDTindakanKhususController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/{data}', 'show')->name('.show');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                            Route::delete('/{data}', 'destroy')->name('.destroy');
                        });
                    });
                });

                // Hasil EKG
                Route::prefix('hasil-ekg')->group(function () {
                    Route::name('.hasil-ekg')->group(function () {
                        Route::controller(HDHasilEKGController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/{data}', 'show')->name('.show');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                            Route::delete('/{data}', 'destroy')->name('.destroy');
                        });
                    });
                });

                //Traveling Dialysis
                Route::prefix('traveling-dialysis')->group(function () {
                    Route::name('.traveling-dialysis')->group(function () {
                        Route::controller(TravelingDialysisController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{id}/edit', 'edit')->name('.edit');
                            Route::put('/{id}', 'update')->name('.update');
                            Route::get('/{id}', 'show')->name('.show');
                            Route::delete('/{id}', 'destroy')->name('.destroy');
                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                        });
                    });
                });

                //Hasil Lab
                Route::prefix('hasil-lab')->group(function () {
                    Route::name('.hasil-lab')->group(function () {
                        Route::controller(HDHasilLabController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/{data}', 'show')->name('.show');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                            Route::delete('/{data}', 'destroy')->name('.destroy');
                        });
                    });
                });

                //PERSETUJUAN
                Route::prefix('persetujuan')->group(function () {
                    Route::name('.persetujuan')->group(function () {

                        //Persetujuan Tindakan HD
                        Route::prefix('tindakan-hd')->group(function () {
                            Route::name('.tindakan-hd')->group(function () {
                                Route::controller(PersetujuanTindakanHDController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                    Route::delete('/{data}', 'destroy')->name('.destroy');
                                });
                            });
                        });

                        //Persetujuan Akses Femoralis
                        Route::prefix('akses-femoralis')->group(function () {
                            Route::name('.akses-femoralis')->group(function () {
                                Route::controller(PersetujuanAksesFemoralisController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                    Route::delete('/{data}', 'destroy')->name('.destroy');
                                });
                            });
                        });

                        //Persetujuan Tindakan Medis
                        Route::prefix('tindakan-medis')->group(function () {
                            Route::name('.tindakan-medis')->group(function () {
                                Route::controller(PersetujuanTindakanMedisController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                    Route::delete('/{data}', 'destroy')->name('.destroy');
                                });
                            });
                        });

                        // Implementasi dan Evaluasi Keperawatan
                        Route::prefix('implementasi-evaluasi-keperawatan')->group(function () {
                            Route::name('.implementasi-evaluasi-keperawatan')->group(function () {
                                Route::controller(PersetujuanImplementasiEvaluasiKeperawatanController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                    Route::delete('/{data}', 'destroy')->name('.destroy');
                                });
                            });
                        });
                    });
                });
            });
        });
    });
});

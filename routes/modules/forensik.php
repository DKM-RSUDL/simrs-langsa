<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UnitPelayanan\Forensik\ForensikKlinikController;
use App\Http\Controllers\UnitPelayanan\Forensik\ForensikPatologiController;
use App\Http\Controllers\UnitPelayanan\Forensik\ForensikVisumOtopsiController;
use App\Http\Controllers\UnitPelayanan\Forensik\VisumExitController as ForensikVisumExitController;
use App\Http\Controllers\UnitPelayanan\Forensik\VisumHidupController as ForensikVisumHidupController;
use App\Http\Controllers\UnitPelayanan\ForensikController;

Route::prefix('forensik')->group(function () {
    Route::name('forensik')->group(function () {
        Route::get('/', [ForensikController::class, 'index'])->name('.index');

        Route::prefix('unit/{kd_unit}')->group(function () {
            Route::name('.unit')->group(function () {
                Route::get('/', [ForensikController::class, 'unitPelayanan']);

                //Pelayanan
                Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
                    Route::name('.pelayanan')->group(function () {
                        Route::get('/', [ForensikController::class, 'pelayanan']);

                        //pemeriksaan

                        Route::prefix('pemeriksaan-klinik')->group(function () {
                            Route::name('.pemeriksaan-klinik')->group(function () {
                                Route::get('/', [ForensikController::class, 'pemeriksaan'])->name('.index');

                                // pemeriksaan-klinik
                                Route::controller(ForensikKlinikController::class)->group(function () {
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/edit/{data}', 'edit')->name('.edit');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::delete('/', 'destroy')->name('.destroy');
                                });
                            });
                        });

                        // patologi
                        Route::prefix('pemeriksaan-patologi')->group(function () {
                            Route::name('.pemeriksaan-patologi')->group(function () {
                                Route::get('/', [ForensikController::class, 'pemeriksaan'])->name('.index');
                                Route::controller(ForensikPatologiController::class)->group(function () {
                                    Route::get('/create', 'index')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/edit/{data}', 'edit')->name('.edit');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::delete('/', 'destroy')->name('.destroy');
                                });
                            });
                        });

                        // Visum Exit
                        Route::prefix('visum-exit')->group(function () {
                            Route::name('.visum-exit')->group(function () {
                                Route::controller(ForensikVisumExitController::class)->group(function () {
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

                        // visum otopsi
                        Route::prefix('visum-otopsi')->group(function () {
                            Route::name('.visum-otopsi')->group(function () {
                                Route::controller(ForensikVisumOtopsiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::get('/{id}/print', 'print')->name('.print');
                                    Route::delete('/{data}', 'destroy')->name('.destroy');
                                });
                            });
                        });


                        // Visum Hidup
                        Route::prefix('visum-hidup')->group(function () {
                            Route::name('.visum-hidup')->group(function () {
                                Route::controller(ForensikVisumHidupController::class)->group(function () {
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

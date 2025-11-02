<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan\LayananController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\PelayananRehabMedisController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\RehabMedisController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan\TindakanController as RehamMedisTindakanController;

Route::prefix('rehab-medis')->group(function () {
    Route::name('rehab-medis')->group(function () {
        Route::get('/', [RehabMedisController::class, 'index'])->name('.index');

        Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
            Route::name('.pelayanan')->group(function () {
                Route::get('/', [RehabMedisController::class, 'pelayanan']);

                // Pelayanan
                Route::prefix('terapi')->group(function () {
                    Route::name('.terapi')->group(function () {
                        Route::controller(LayananController::class)->group(function () {
                            Route::get('/', 'index');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::get('/show/{data}', 'show')->name('.show');
                            Route::get('/print/{data}', 'print')->name('.print');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::delete('/', 'destroy')->name('.destroy');
                        });
                    });
                });

                // Tindakan
                Route::prefix('tindakan')->group(function () {
                    Route::name('.tindakan')->group(function () {
                        Route::controller(RehamMedisTindakanController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/show/{data}', 'show')->name('.show');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::get('/print/{data}', 'print')->name('.print');
                            Route::post('/', 'store')->name('.store');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::delete('/', 'destroy')->name('.destroy');
                        });
                    });
                });
            });
        });
    });
});

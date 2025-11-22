<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UnitPelayanan\Operasi\AsesmenController as OperasiAsesmenController;
use App\Http\Controllers\UnitPelayanan\Operasi\CeklistAnasthesiController;
use App\Http\Controllers\UnitPelayanan\Operasi\PraInduksitController;
use App\Http\Controllers\UnitPelayanan\Operasi\CeklistKeselamatanController;
use App\Http\Controllers\UnitPelayanan\Operasi\EdukasiAnestesiController;
use App\Http\Controllers\UnitPelayanan\Operasi\LaporanAnastesiController;
use App\Http\Controllers\UnitPelayanan\Operasi\LaporanOperatifController;
use App\Http\Controllers\UnitPelayanan\Operasi\PraAnestesiMedisController;
use App\Http\Controllers\UnitPelayanan\Operasi\LaporanOperasiController;
use App\Http\Controllers\UnitPelayanan\Operasi\PraAnestesiPerawatController;
use App\Http\Controllers\UnitPelayanan\Operasi\SiteMarkingController;
use App\Http\Controllers\UnitPelayanan\Operasi\TransferPasienController;
use App\Http\Controllers\UnitPelayanan\OperasiController;


Route::prefix('operasi')->group(function () {
    Route::name('operasi')->group(function () {
        Route::get('/', [OperasiController::class, 'index'])->name('.index');
        Route::get('/pending-order', [OperasiController::class, 'pendingOrder'])->name('.pending-order');
        Route::get('/product-details', [OperasiController::class, 'productDetails'])->name('.product-details');
        Route::prefix('/terima-order/{kd_kasir}/{no_transaksi}/{tgl_op}/{jam_op}')->group(function () {
            Route::get('/', [OperasiController::class, 'terimaOrder'])->name('.terima-order');
            Route::post('/', [OperasiController::class, 'storeTerimaOrder'])->name('.terima-order.store');
        });

        Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
            Route::name('.pelayanan')->group(function () {
                Route::get('/', [OperasiController::class, 'pelayanan']);

                // ASESMEN
                Route::prefix('asesmen')->group(function () {
                    Route::name('.asesmen')->group(function () {
                        Route::controller(OperasiAsesmenController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                        });

                        Route::prefix('pra-anestesi')->group(function () {
                            Route::name('.pra-anestesi')->group(function () {

                                Route::prefix('medis')->group(function () {
                                    Route::name('.medis')->group(function () {
                                        Route::controller(PraAnestesiMedisController::class)->group(function () {
                                            Route::get('/create', 'create')->name('.create');
                                            Route::get('/edit/{data}', 'edit')->name('.edit');
                                            Route::post('/', 'store')->name('.store');
                                            Route::put('/{data}', 'update')->name('.update');
                                            Route::get('/{data}', 'show')->name('.show');
                                        });
                                    });
                                });

                                Route::prefix('perawat')->group(function () {
                                    Route::name('.perawat')->group(function () {
                                        Route::controller(PraAnestesiPerawatController::class)->group(function () {
                                            Route::get('/create', 'create')->name('.create');
                                            Route::post('/', 'store')->name('.store');
                                            Route::get('/edit/{data}', 'edit')->name('.edit');
                                            Route::put('/{data}', 'update')->name('.update');
                                            Route::get('/{data}', 'show')->name('.show');
                                        });
                                    });
                                });

                                Route::prefix('edukasi')->group(function () {
                                    Route::name('.edukasi')->group(function () {
                                        Route::controller(EdukasiAnestesiController::class)->group(function () {
                                            Route::get('/create', 'create')->name('.create');
                                            Route::get('/print/{id}', 'print')->name('.print');
                                            Route::post('/', 'store')->name('.store');
                                            Route::get('/edit/{data}', 'edit')->name('.edit');
                                            Route::put('/{data}', 'update')->name('.update');
                                            Route::get('/{data}', 'show')->name('.show');
                                        });
                                    });
                                });
                            });
                        });

                        Route::prefix('pra-induksi')->group(function () {
                            Route::name('.pra-induksi')->group(function () {
                                Route::controller(PraInduksitController::class)->group(function () {
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/print/{id}', 'print')->name('.print');
                                    Route::get('/search-obat', 'searchObat')->name('.searchObat');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/edit/{data}', 'edit')->name('.edit');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::get('/{data}', 'show')->name('.show');
                                });
                            });
                        });
                    });
                });


                //LAPORAN ANASTESI
                Route::prefix('laporan-anastesi')->group(function () {
                    Route::name('.laporan-anastesi')->group(function () {
                        Route::controller(LaporanAnastesiController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/print/{id}', 'print')->name('.print');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/edit/{data}', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/{data}', 'show')->name('.show');
                        });
                    });
                });

                //LAPORAN ANASTESI
                Route::prefix('ceklist-anasthesi')->group(function () {
                    Route::name('.ceklist-anasthesi')->group(function () {
                        Route::controller(CeklistAnasthesiController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/print/{id}', 'printCheckListKesiapan')->name('.printCheckListKesiapan');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/edit/{data}', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/{data}', 'show')->name('.show');
                        });
                    });
                });



                //LAPORAN OPERASI
                Route::prefix('laporan-operasi')->group(function () {
                    Route::name('.laporan-operasi')->group(callback: function () {
                        Route::controller(LaporanOperasiController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/print/{id}', 'print')->name('.print');
                            Route::get('/edit/{id}', 'edit')->name('.edit');
                            Route::get('/show/{id}', 'show')->name('.show');
                            Route::post('/', 'store')->name('.store');
                            Route::put('/{id}', 'update')->name('.update');
                        });
                    });
                });


                //CEKLIST KESELAMATAN
                Route::prefix('ceklist-keselamatan')->group(function () {
                    Route::name('.ceklist-keselamatan')->group(function () {
                        Route::controller(CeklistKeselamatanController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/print', 'print')->name('.print');

                            Route::get('/create-signin', 'createSignin')->name('.create-signin');
                            Route::post('/store-signin', 'storeSignin')->name('.store-signin');
                            Route::get('/edit-signin/{id}', 'editSignin')->name('.edit-signin');
                            Route::put('/update-signin/{id}', 'updateSignin')->name('.update-signin');
                            Route::delete('/destroy-signin/{id}', 'destroySignin')->name('.destroy-signin');

                            Route::get('/create-timeout', 'createTimeout')->name('.create-timeout');
                            Route::post('/store-timeout', 'storeTimeout')->name('.store-timeout');
                            Route::get('/edit-timeout/{id}', 'editTimeout')->name('.edit-timeout');
                            Route::put('/update-timeout/{id}', 'updateTimeout')->name('.update-timeout');
                            Route::delete('/destroy-timeout/{id}', 'destroyTimeout')->name('.destroy-timeout');

                            Route::get('/create-signout', 'createSignout')->name('.create-signout');
                            Route::post('/store-signout', 'storeSignout')->name('.store-signout');
                            Route::get('/edit-signout/{id}', 'editSignout')->name('.edit-signout');
                            Route::put('/update-signout/{id}', 'updateSignout')->name('.update-signout');
                            Route::delete('/destroy-signout/{id}', 'destroySignout')->name('.destroy-signout');
                        });
                    });
                });


                //SITE MARKING
                Route::prefix('site-marking')->group(function () {
                    Route::name('.site-marking')->group(function () {
                        Route::controller(SiteMarkingController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/store', 'store')->name('.store');
                            Route::get('/show/{id}', 'show')->name('.show');
                            Route::get('/edit/{id}', 'edit')->name('.edit');
                            Route::put('/update/{id}', 'update')->name('.update');
                            Route::delete('/destroy/{id}', 'destroy')->name('.destroy');
                            Route::get('/print/{id}', 'print')->name('.print');
                        });
                    });
                });


                // TRANSFER PASIEN
                Route::prefix('transfer-pasien')->group(function () {
                    Route::name('.transfer-pasien')->group(function () {
                        Route::controller(TransferPasienController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/edit/{data}', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::delete('/{data}', 'destroy')->name('.destroy');
                            Route::get('/{data}', 'show')->name('.show');
                        });
                    });
                });
            });
        });
    });
});

<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitPelayanan\Operasi\PraInduksitController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\CpptController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// unit pelanayan
use App\Http\Controllers\UnitPelayanan\RawatJalanController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\BedahController;
use App\Http\Controllers\UnitPelayanan\GawatDaruratController;
use App\Http\Controllers\MedisGawatDaruratController;
use App\Http\Controllers\UnitPelayanan\Forensik\ForensikKlinikController;
use App\Http\Controllers\UnitPelayanan\Forensik\ForensikPatologiController;
use App\Http\Controllers\UnitPelayanan\ForensikController;
// action gawat darurat
use App\Http\Controllers\UnitPelayanan\GawatDarurat\AsesmenController as GawatDaruratAsesmenController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\AsesmenKeperawatanController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\CarePlanController as GawatDaruratCarePlanController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\CpptController as GawatDaruratCpptController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\EdukasiController as GawatDaruratEdukasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\FarmasiController as GawatDaruratFarmasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\GeneralConsentController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\KonsultasiController as GawatDaruratKonsultasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\LaborController as GawatDaruratLaborController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\RadiologiController as GawatDaruratRadiologiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\ResumeController as GawatDaruratResumeController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\RujukController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\TindakanController as GawatDaruratTindakanController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\TransferPasienController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\AsesmenHemodialisaKeperawatanController;
use App\Http\Controllers\UnitPelayanan\Hemodialisa\AsesmenMedisController;
use App\Http\Controllers\UnitPelayanan\HemodialisaController;
use App\Http\Controllers\UnitPelayanan\Operasi\AsesmenController as OperasiAsesmenController;
use App\Http\Controllers\UnitPelayanan\Operasi\EdukasiAnestesiController;
use App\Http\Controllers\UnitPelayanan\Operasi\LaporanOperatifController;
use App\Http\Controllers\UnitPelayanan\Operasi\PraAnestesiMedisController;
use App\Http\Controllers\UnitPelayanan\Operasi\LaporanOperasiController;
use App\Http\Controllers\UnitPelayanan\Operasi\PraAnestesiPerawatController;
use App\Http\Controllers\UnitPelayanan\OperasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepOpthamologyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepThtController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenObstetriMaternitas;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepPerinatologyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsuhanKeperawatanRawatInapController;
use App\Http\Controllers\UnitPelayanan\RawatInap\CpptController as RawatInapCpptController;
use App\Http\Controllers\UnitPelayanan\RawatInap\FarmasiController as RawatInapFarmasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\InformedConsentController;
use App\Http\Controllers\UnitPelayanan\RawatInap\KonsultasiController as RawatInapKonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\NeurologiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RadiologiController as RawatInapRadiologiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapLabPatologiKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapResumeController;
use App\Http\Controllers\UnitPelayanan\RawatInap\TindakanController as RawatInapTindakanController;
use App\Http\Controllers\UnitPelayanan\RawatInapController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenController as RawatJalanAsesmenController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenKeperawatanRajalController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\FarmasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\KonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\LabPatologiKlinikController as RawatJalanLabPatologiKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RadiologiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RawatJalanResumeController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RujukJalanController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\TindakanController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan\LayananController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\PelayananRehabMedisController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\RehabMedisController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan\TindakanController as RehamMedisTindakanController;
use App\Http\Middleware\CheckUnitAccess;

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

                Route::middleware(['check.unit'])->group(function () {

                    Route::prefix('unit/{kd_unit}')->group(function () {
                        Route::name('.unit')->group(function () {
                            Route::get('/', [RawatJalanController::class, 'unitPelayanan']);
                            Route::get('/belum-selesai', [RawatJalanController::class, 'belumSelesai'])->name('.belum-selesai');
                            Route::get('/selesai', [RawatJalanController::class, 'selesai'])->name('.selesai');
                        });

                        // Pelayanan
                        Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
                            Route::name('.pelayanan')->group(function () {
                                Route::get('/', [RawatJalanController::class, 'pelayanan']);
                            });

                            // rujuk route
                            Route::prefix('rujuk-antar-rs')->group(function () {
                                Route::name('.rujuk-antar-rs')->group(function () {
                                    Route::controller(RujukJalanController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/{id}', 'show')->name('.show');
                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                        Route::put('/{id}', 'update')->name('.update');
                                        Route::delete('/{id}', 'destroy')->name('.destroy');
                                    });
                                });
                            });

                            // rujuk route
                            // Route::prefix('rujuk-antar-rs')->group(function () {
                            //     Route::name('.rujuk-antar-rs')->group(function () {
                            //         Route::controller(RawatJalanController::class)->group(function () {
                            //             Route::get('/', 'rujukAntarRs');
                            //         });
                            //     });
                            // });

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
                            Route::prefix('konsultasi')->group(function () {
                                Route::name('.konsultasi')->group(function () {
                                    Route::controller(KonsultasiController::class)->group(function () {
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
                            Route::prefix('tindakan')->group(function () {
                                Route::name('.tindakan')->group(function () {
                                    Route::controller(TindakanController::class)->group(function () {
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

                            Route::prefix('asesmen')->group(function () {
                                Route::name('.asesmen')->group(function () {
                                    Route::controller(RawatJalanAsesmenController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/{id}', 'show')->name('.show');
                                        Route::put('/{id}', 'update')->name('.update');
                                    });
                                });
                            });

                            Route::prefix('asesmen-keperawatan')->group(function () {
                                Route::name('.asesmen-keperawatan')->group(function () {
                                    Route::controller(AsesmenKeperawatanRajalController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/{id}', 'show')->name('.show');
                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                        Route::put('/{id}', 'update')->name('.update');
                                        Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                    });
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

                Route::middleware(['check.unit'])->group(function () {

                    Route::prefix('unit/{kd_unit}')->group(function () {
                        Route::name('.unit')->group(function () {
                            Route::get('/', [RawatInapController::class, 'unitPelayanan']);
                            Route::get('/aktif', [RawatInapController::class, 'unitPelayanan'])->name('.aktif');
                            Route::get('/pending', [RawatInapController::class, 'pending'])->name('.pending');
                        });

                        // Pelayanan
                        Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
                            Route::name('.pelayanan')->group(function () {
                                Route::get('/', [RawatInapController::class, 'pelayanan']);
                            });

                            // Informed Consent
                            Route::prefix('informed-consent')->group(function () {
                                Route::name('.informed-consent')->group(function () {
                                    Route::controller(InformedConsentController::class)->group(function () {
                                        Route::get('/', 'index');
                                        Route::post('/show', 'show')->name('.show');
                                        Route::post('/', 'store')->name('.store');
                                        Route::delete('/{data}', 'delete')->name('.delete');
                                    });
                                });
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
                            Route::prefix('konsultasi')->group(function () {
                                Route::name('.konsultasi')->group(function () {
                                    Route::controller(RawatInapKonsultasiController::class)->group(function () {
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
                            Route::prefix('tindakan')->group(function () {
                                Route::name('.tindakan')->group(function () {
                                    Route::controller(RawatInapTindakanController::class)->group(function () {
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

                            Route::prefix('asesmen')->group(function () {
                                Route::name('.asesmen')->group(function () {

                                    Route::prefix('medis')->group(function () {
                                        Route::name('.medis')->group(function () {

                                            Route::prefix('umum')->group(function () {
                                                Route::name('.umum')->group(function () {
                                                    Route::controller(AsesmenController::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::get('/{id}', 'show')->name('.show');
                                                        Route::put('/{id}', 'update')->name('.update');
                                                        Route::get('/{id}/print', 'print')->name('.print');
                                                    });
                                                });
                                            });

                                            Route::prefix('tht')->group(function () {
                                                Route::name('.tht')->group(function () {
                                                    Route::controller(AsesmenKepThtController::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::get('/{id}', 'show')->name('.show');
                                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                                        Route::put('/{id}', 'update')->name('.update');
                                                        Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                                    });
                                                });
                                            });

                                            Route::prefix('obstetri-maternitas')->group(function () {
                                                Route::name('.obstetri-maternitas')->group(function () {
                                                    Route::controller(AsesmenObstetriMaternitas::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::get('/{id}', 'show')->name('.show');
                                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                                        Route::put('/{id}', 'update')->name('.update');
                                                        Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                                    });
                                                });
                                            });

                                            // neurologi
                                            Route::prefix('neurologi')->group(function () {
                                                Route::name('.neurologi')->group(function () {
                                                    Route::controller(NeurologiController::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::get('/{id}', 'show')->name('.show');
                                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                                        Route::put('/{id}', 'update')->name('.update');
                                                        Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                                    });
                                                });
                                            });
                                        });
                                    });

                                    Route::prefix('keperawatan')->group(function () {
                                        Route::name('.keperawatan')->group(function () {

                                            Route::prefix('anak')->group(function () {
                                                Route::name('.anak')->group(function () {
                                                    Route::controller(AsesmenKepAnakController::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::get('/{id}', 'show')->name('.show');
                                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                                        Route::put('/{id}', 'update')->name('.update');
                                                    });
                                                });
                                            });

                                            Route::prefix('opthamology')->group(function () {
                                                Route::name('.opthamology')->group(function () {
                                                    Route::controller(AsesmenKepOpthamologyController::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::put('/', 'update')->name('.update');
                                                        Route::get('/{id}', 'show')->name('.show');
                                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                                        Route::put('/{id}', 'update')->name('.update');
                                                    });
                                                });
                                            });

                                            Route::prefix('perinatology')->group(function () {
                                                Route::name('.perinatology')->group(function () {
                                                    Route::controller(AsesmenKepPerinatologyController::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::get('/{id}', 'show')->name('.show');
                                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                                        Route::put('/{id}', 'update')->name('.update');
                                                    });
                                                });
                                            });


                                            Route::prefix('perinatology')->group(function () {
                                                Route::name('.perinatology')->group(function () {
                                                    Route::controller(AsesmenKepPerinatologyController::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::put('/', 'update')->name('.update');
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });

                            // asuran keperawatan
                            Route::prefix('asuhan-keperawatan')->group(function () {
                                Route::name('.asuhan-keperawatan')->group(function () {
                                    Route::controller(AsuhanKeperawatanRawatInapController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::get('/{data}/show', 'show')->name('.show');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::get('/edit/{data}', 'edit')->name('.edit');
                                        Route::post('/', 'store')->name('.store');
                                        Route::delete('/', 'destroy')->name('.destroy');
                                        Route::put('/{data}', 'update')->name('.update');
                                    });
                                });
                            });

                            Route::prefix('serah-terima')->group(function () {
                                Route::name('.serah-terima')->group(function () {
                                    Route::controller(RawatInapController::class)->group(function () {
                                        Route::get('/', 'serahTerimaPasien');
                                        Route::put('/{data}', 'serahTerimaPasienCreate')->name('.store');
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });

        // Rute untuk Gawat Darurat
        Route::middleware(['check.igd'])->group(function () {

            Route::prefix('gawat-darurat')->group(function () {
                Route::get('/', [GawatDaruratController::class, 'index'])->name('gawat-darurat.index');
                Route::post('/store-triase', [GawatDaruratController::class, 'storeTriase'])->name('gawat-darurat.store-triase');
                Route::post('/get-patient-bynik-ajax', [GawatDaruratController::class, 'getPatientByNikAjax'])->name('gawat-darurat.get-patient-bynik-ajax');

                Route::prefix('pelayanan')->group(function () {
                    Route::prefix('/{kd_pasien}/{tgl_masuk}')->group(function () {

                        // general consent
                        Route::prefix('{urut_masuk}/general-consent')->group(function () {
                            Route::name('general-consent')->group(function () {
                                Route::controller(GeneralConsentController::class)->group(function () {
                                    Route::get('/', 'index');
                                    Route::post('/show', 'show')->name('.show');
                                    Route::post('/', 'store')->name('.store');
                                    Route::delete('/{data}', 'delete')->name('.delete');
                                });
                            });
                        });

                        // rujuk route
                        Route::prefix('{urut_masuk}/rujuk-antar-rs')->group(function () {
                            Route::name('rujuk-antar-rs')->group(function () {
                                Route::controller(RujukController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/{id}', 'show')->name('.show');
                                    Route::get('/{id}/edit', 'edit')->name('.edit');
                                    Route::put('/{id}', 'update')->name('.update');
                                    Route::delete('/{id}', 'destroy')->name('.destroy');
                                });
                            });
                        });
                        // serah terima route
                        Route::prefix('{urut_masuk}/serah-terima-pasien')->group(function () {
                            Route::name('serah-terima-pasien')->group(function () {
                                Route::controller(GawatDaruratController::class)->group(function () {
                                    Route::get('/', 'serahTerimaPasien');
                                    Route::put('/{data}', 'serahTerimaPasienCreate')->name('.store');
                                });
                            });
                        });

                        // transfer ke RWI
                        Route::prefix('{urut_masuk}/transfer-rwi')->group(function () {
                            Route::name('transfer-rwi')->group(function () {
                                Route::controller(TransferPasienController::class)->group(function () {
                                    Route::get('/', 'index');
                                    Route::post('/', 'storeTransferInap')->name('.store');
                                    Route::post('/get-dokter-spesial-ajax', 'getDokterBySpesial')->name('.get-dokter-spesial-ajax');
                                    Route::post('/get-ruang-kelas-ajax', 'getRuanganByKelas')->name('.get-ruang-kelas-ajax');
                                    Route::post('/get-kamar-ruang-ajax', 'getKamarByRuang')->name('.get-kamar-ruang-ajax');
                                    Route::post('/get-sisa-bed-ajax', 'getSisaBedByKamar')->name('.get-sisa-bed-ajax');
                                });
                            });
                        });

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
                        Route::prefix('tindakan')->group(function () {
                            Route::name('tindakan')->group(function () {
                                Route::controller(GawatDaruratTindakanController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'storeTindakan')->name('.store');
                                    Route::put('/', 'updateTindakan')->name('.update');
                                    Route::delete('/', 'deleteTindakan')->name('.delete');
                                    Route::post('/get-tindakan-ajax', 'getTindakanAjax')->name('.get-tindakan-ajax');
                                });
                            });
                        });

                        // Konsultasi
                        Route::prefix('{urut_masuk}/konsultasi')->group(function () {
                            Route::name('konsultasi')->group(function () {
                                Route::controller(GawatDaruratKonsultasiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'storeKonsultasi')->name('.store');
                                    Route::put('/', 'updateKonsultasi')->name('.update');
                                    Route::delete('/', 'deleteKonsultasi')->name('.delete');
                                    Route::post('/get-konsul-ajax', 'getKonsulAjax')->name('.get-konsul-ajax');
                                    Route::get('/pdf/{data}', 'pdf')->name('.pdf');
                                    Route::post('/get-dokter-unit', 'getDokterbyUnit')->name('.get-dokter-unit');
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
                                    Route::get('/{id}/print', 'print')->name('.print');
                                });
                            });
                        });

                        Route::prefix('asesmen-keperawatan')->group(function () {
                            Route::name('asesmen-keperawatan')->group(function () {
                                Route::controller(AsesmenKeperawatanController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/{id}', 'show')->name('.show');
                                    Route::get('/{id}/edit', 'edit')->name('.edit');
                                    Route::put('/{id}', 'update')->name('.update');
                                    Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                });
                            });
                        });

                        // edukasi
                        Route::prefix('{urut_masuk}/edukasi')->group(function () {
                            Route::name('edukasi')->group(function () {
                                Route::controller(GawatDaruratEdukasiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::delete('/', 'delete')->name('.delete');
                                });
                            });
                        });

                        Route::resource('/', MedisGawatDaruratController::class);
                        // Route::resource('asesmen', GawatDaruratAsesmenController::class);
                        Route::resource('labor', GawatDaruratLaborController::class);
                        Route::post('cetak', [GawatDaruratLaborController::class, 'cetak']);
                        Route::resource('careplan', GawatDaruratCarePlanController::class);
                        Route::resource('resume', GawatDaruratResumeController::class);

                        Route::controller(GawatDaruratResumeController::class)->group(function () {
                            Route::name('resume')->group(function () {
                                Route::prefix('/{urut_masuk}/resume')->group(function () {
                                    Route::post('/validasi', 'validasiResume')->name('.validasi');
                                    Route::get('/{data}/pdf', 'pdf')->name('.pdf');
                                });
                            });
                        });
                    });
                });
            });
        });

        // Rute Untuk Forensik
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
                                // klinik
                                Route::controller(ForensikKlinikController::class)->group(function () {
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/edit/{data}', 'edit')->name('.edit');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::delete('/', 'destroy')->name('.destroy');
                                });

                                // patologi
                                Route::prefix('patologi')->group(function () {
                                    Route::name('.patologi')->group(function () {
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
                            });
                        });
                    });
                });
            });
        });


        // REHAB MEDIK
        Route::prefix('rehab-medis')->group(function () {
            Route::name('rehab-medis')->group(function () {
                Route::get('/', [RehabMedisController::class, 'index'])->name('.index');

                Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
                    Route::name('.pelayanan')->group(function () {
                        Route::get('/', [RehabMedisController::class, 'pelayanan']);

                        // Pelayanan
                        Route::prefix('layanan')->group(function () {
                            Route::name('.layanan')->group(function () {
                                Route::controller(LayananController::class)->group(function () {
                                    Route::get('/', 'index');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::get('/show/{data}', 'show')->name('.show');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::delete('/', 'destroy')->name('.destroy');

                                    // PROGRAM
                                    Route::prefix('program')->group(function () {
                                        Route::name('.program')->group(function () {
                                            Route::get('/create', 'createProgram')->name('.create');
                                            Route::get('/{data}/edit', 'editProgram')->name('.edit');
                                            Route::post('/', 'storeProgram')->name('.store');
                                            Route::put('/{data}', 'updateProgram')->name('.update');
                                            Route::delete('/', 'destroyProgram')->name('.destroy');
                                        });
                                    });
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

        // BEDAH SENTRAL (OPERASI)
        Route::prefix('operasi')->group(function () {
            Route::name('operasi')->group(function () {
                Route::get('/', [OperasiController::class, 'index'])->name('.index');

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
                                            Route::post('/', 'store')->name('.store');
                                            Route::get('/edit/{data}', 'edit')->name('.edit');
                                            Route::put('/{data}', 'update')->name('.update');
                                            Route::get('/{data}', 'show')->name('.show');
                                        });
                                    });
                                });
                            });
                        });


                        //LAPORAN OPERASI
                        Route::prefix('laporan-operasi')->group(function () {
                            Route::name('.laporan-operasi')->group(function () {
                                Route::controller(LaporanOperasiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/edit', 'edit')->name('.edit');
                                    Route::get('/show', 'show')->name('.show');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
                                });
                            });
                        });
                    });
                });
            });
        });


        // HEMODIALISA
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
                    });
                });
            });
        });
    });
});

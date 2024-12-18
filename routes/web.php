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
use App\Http\Controllers\UnitPelayanan\GawatDarurat\KonsultasiController as GawatDaruratKonsultasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\LaborController as GawatDaruratLaborController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\RadiologiController as GawatDaruratRadiologiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\ResumeController as GawatDaruratResumeController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\TindakanController as GawatDaruratTindakanController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsuhanKeperawatanRawatInapController;
use App\Http\Controllers\UnitPelayanan\RawatInap\CpptController as RawatInapCpptController;
use App\Http\Controllers\UnitPelayanan\RawatInap\FarmasiController as RawatInapFarmasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\KonsultasiController as RawatInapKonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\NeurologiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RadiologiController as RawatInapRadiologiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapLabPatologiKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapResumeController;
use App\Http\Controllers\UnitPelayanan\RawatInap\TindakanController as RawatInapTindakanController;
use App\Http\Controllers\UnitPelayanan\RawatInapController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenController as RawatJalanAsesmenController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\FarmasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\KonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\LabPatologiKlinikController as RawatJalanLabPatologiKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RadiologiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RawatJalanResumeController;
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
                            Route::get('/belum-selesai', [RawatJalanController::class, 'unitPelayanan'])->name('.belum-selesai');
                            Route::get('/selesai', [RawatJalanController::class, 'unitPelayanan'])->name('.selesai');
                        });

                        // Pelayanan
                        Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
                            Route::name('.pelayanan')->group(function () {
                                Route::get('/', [RawatJalanController::class, 'pelayanan']);
                            });

                            // rujuk route
                            Route::prefix('rujuk-antar-rs')->group(function () {
                                Route::name('.rujuk-antar-rs')->group(function () {
                                    Route::controller(RawatJalanController::class)->group(function () {
                                        Route::get('/', 'rujukAntarRs');
                                    });
                                });
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
                            Route::get('/pending', [RawatInapController::class, 'unitPelayanan'])->name('.pending');
                        });

                        // Pelayanan
                        Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
                            Route::name('.pelayanan')->group(function () {
                                Route::get('/', [RawatInapController::class, 'pelayanan']);
                            });

                            // Informed Consent
                            Route::prefix('informed-consent')->group(function () {
                                Route::name('.informed-consent')->group(function () {
                                    Route::controller(RawatInapController::class)->group(function () {
                                        Route::get('/', 'informedConsent');
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
                                    Route::controller(AsesmenController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/{id}', 'show')->name('.show');
                                        Route::put('/{id}', 'update')->name('.update');
                                    });
                                });
                            });

                            Route::prefix('asesmen-anak')->group(function () {
                                Route::name('.asesmen-anak')->group(function () {
                                    Route::controller(AsesmenAnakController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::put('/', 'update')->name('.update');
                                    });
                                });
                            });

                            // neurologi
                            Route::prefix('neurologi')->group(function () {
                                Route::name('.neurologi')->group(function () {
                                    Route::controller(NeurologiController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::put('/', 'update')->name('.update');
                                    });
                                });
                            });

                            // asuran keperawatan
                            Route::prefix('asuran-keperawatan')->group(function () {
                                Route::name('.asuran-keperawatan')->group(function () {
                                    Route::controller(AsuhanKeperawatanRawatInapController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::put('/', 'update')->name('.update');
                                    });
                                });
                            });
                        });
                    });
                });

                // sementara dari anas
                Route::get('asuhan-keperawatan', [AsuhanKeperawatanRawatInapController::class, 'index'])->name('asuhan-keperawatan.index');
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
                                Route::controller(GawatDaruratController::class)->group(function () {
                                    Route::get('/', 'generalConsent');
                                });
                            });
                        });

                        // rujuk route
                        Route::prefix('{urut_masuk}/rujuk-antar-rs')->group(function () {
                            Route::name('rujuk-antar-rs')->group(function () {
                                Route::controller(GawatDaruratController::class)->group(function () {
                                    Route::get('/', 'rujukAntarRs');
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
                        Route::prefix('konsultasi')->group(function () {
                            Route::name('konsultasi')->group(function () {
                                Route::controller(GawatDaruratKonsultasiController::class)->group(function () {
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

                        Route::prefix('asesmen-keperawatan')->group(function () {
                            Route::name('asesmen-keperawatan')->group(function () {
                                Route::controller(AsesmenKeperawatanController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::put('/', 'update')->name('.update');
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
                                Route::get('/create', [ForensikKlinikController::class, 'create'])->name('.create');
                                Route::get('/create-patologi', [ForensikPatologiController::class, 'createpatologi'])->name('.create-patologi');
                            });
                        });
                    });
                });
            });
        });

        Route::prefix('rehab-medis')->group(function () {
            Route::name('rehab-medis')->group(function () {
                Route::get('/', [RehabMedisController::class, 'index'])->name('.index');

                Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}')->group(function () {
                    Route::name('.pelayanan')->group(function () {
                        Route::get('/', [RehabMedisController::class, 'pelayanan']);

                        // Pelayanan
                        Route::get('layanan', [LayananController::class, 'index'])->name('.layanan');

                        // Tindakan
                        Route::prefix('tindakan')->group(function () {
                            Route::name('.tindakan')->group(function () {
                                Route::controller(RehamMedisTindakanController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'storeTindakan')->name('.store');
                                    Route::put('/', 'updateTindakan')->name('.update');
                                    Route::delete('/', 'deleteTindakan')->name('.delete');
                                    Route::post('/get-tindakan-ajax', 'getTindakanAjax')->name('.get-tindakan-ajax');
                                });
                            });
                        });
                    });
                });
            });
        });
    });
});

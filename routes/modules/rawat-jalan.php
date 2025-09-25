<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UnitPelayanan\RawatJalanController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\BedahController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\CpptController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\ResikoJatuh\SkalaGeriatriController as RawatJalanSkalaGeriatriController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\ResikoJatuh\SkalaHumptyDumptyController as RawatJalanSkalaHumptyDumptyController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\ResikoJatuh\SkalaMorseController as RawatJalanSkalaMorseController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenController as RawatJalanAsesmenController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenGeriatriController as RawatJalanAsesmenGeriatriController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenAwalController as RawatJalanAsesmenAwalController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenKeperawatanRajalController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenKulitKelaminController as RawatJalanAsesmenKulitKelaminController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenPsikiatriController as RawatJalanAsesmenPsikiatriController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\FarmasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\KonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\LabPatologiKlinikController as RawatJalanLabPatologiKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\PenundaanPelayananController as RawatJalanPenundaanPelayananController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\PersetujuanAnestesiController as RawatJalanPersetujuanAnestesiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RadiologiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RajalKonselingHIVController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RajalPermintaanDarahController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RajalPermintaanSecondOpinionController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RawatJalanEdukasiController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RawatJalanResumeController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RujukJalanController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\TindakanController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RajalPRMRJController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RajalHivArtController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RajalHivArtAkhirFollowUpController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\RajalPernyataandpjpController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenParuController as RajalAsesmenParuController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenGinekologikController as RajalAsesmenGinekologikController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AudiometriController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\GiziAnakController as RawatJalanGiziAnakController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\GiziDewasaController as RawatJalanGiziDewasaController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\GiziMonitoringController as RawatJalanGiziMonitoringController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\MppAController as RawatJalanMppAController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\MppBController as RawatJalanMppBController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\PengawasanDarahController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\EWSPasienAnakController as RajalEWSPasienAnakController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\EWSPasienDewasaController as RajalEWSPasienDewasaController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\EWSPasienObstetrikController as RajalEWSPasienObstetrikController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\CatatanPoliKlinikController as RajalCatatanPoliKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\ResikoDecubitusController as RawatJalanResikoDecubitusController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\StatusFungsionalController as RawatJalanStatusFungsionalController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\StatusNyeri\SkalaNumerikController as StatusNyeriSkalaNumerikController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\PersetujuanTransfusiDarahController as RawatJalanPersetujuanTransfusiDarahController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\Covid19Controller as RawatJalanCovid19Controller;
use App\Http\Controllers\UnitPelayanan\RawatJalan\EchocardiographyController as RawatJalanEchocardiographyController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\Rehab\LayananController as RehabLayananController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\Rehab\TindakanController as RehabTindakanController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\StatusNyeri\SkalaCriesController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\StatusNyeri\SkalaFlaccController;

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
                                Route::get('/order-obat', 'orderObat')->name('.order-obat');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/search-obat', 'searchObat')->name('.searchObat');
                                Route::post('/rekonsiliasiObat', 'rekonsiliasiObat')->name('.rekonsiliasiObat');
                                Route::delete('/deleteRekonsiliasiObat', 'deleteRekonsiliasiObat')->name('.rekonsiliasiObatDelete');
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

                    // edukasi
                    Route::prefix('edukasi')->group(function () {
                        Route::name('.edukasi')->group(function () {
                            Route::controller(RawatJalanEdukasiController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::get('/create', 'create')->name('.create');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    // Permintaan darah
                    Route::prefix('permintaan-darah')->group(function () {
                        Route::name('.permintaan-darah')->group(function () {
                            Route::controller(RajalPermintaanDarahController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::get('/create', 'create')->name('.create');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    // pernyataan bpjp
                    Route::prefix('pernyataan-dpjp')->group(function () {
                        Route::name('.pernyataan-dpjp')->group(function () {
                            Route::controller(RajalPernyataandpjpController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                            });
                        });
                    });

                    // Orientasi Second Opinion
                    Route::prefix('permintaan-second-opinion')->group(function () {
                        Route::name('.permintaan-second-opinion')->group(function () {
                            Route::controller(RajalPermintaanSecondOpinionController::class)->group(function () {
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

                            Route::prefix('medis')->group(function () {
                                Route::name('.medis')->group(function () {

                                    //Kulit dan kelamin
                                    Route::prefix('kulit-kelamin')->group(function () {
                                        Route::name('.kulit-kelamin')->group(function () {
                                            Route::controller(RawatJalanAsesmenKulitKelaminController::class)->group(function () {
                                                Route::get('/', 'index')->name('.index');
                                                Route::post('/', 'store')->name('.store');
                                                Route::get('/{id}', 'show')->name('.show');
                                                Route::get('/{id}/edit', 'edit')->name('.edit');
                                                Route::put('/{id}', 'update')->name('.update');
                                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                            });
                                        });
                                    });

                                    //Psikiatri
                                    Route::prefix('psikiatri')->group(function () {
                                        Route::name('.psikiatri')->group(function () {
                                            Route::controller(RawatJalanAsesmenPsikiatriController::class)->group(function () {
                                                Route::get('/', 'index')->name('.index');
                                                Route::post('/', 'store')->name('.store');
                                                Route::get('/{id}', 'show')->name('.show');
                                                Route::get('/{id}/edit', 'edit')->name('.edit');
                                                Route::put('/{id}', 'update')->name('.update');
                                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                            });
                                        });
                                    });

                                    // paru
                                    Route::prefix('paru')->group(function () {
                                        Route::name('.paru')->group(callback: function () {
                                            Route::controller(RajalAsesmenParuController::class)->group(function () {
                                                Route::get('/', 'index')->name('.index');
                                                Route::post('/', 'store')->name('.store');
                                                Route::get('/{id}', 'show')->name('.show');
                                                Route::get('/{id}/edit', 'edit')->name('.edit');
                                                Route::put('/{id}', 'update')->name('.update');
                                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                            });
                                        });
                                    });

                                    //Ginekologik
                                    Route::prefix('ginekologik')->group(function () {
                                        Route::name('.ginekologik')->group(function () {
                                            Route::controller(RajalAsesmenGinekologikController::class)->group(function () {
                                                Route::get('/', 'index')->name('.index');
                                                Route::post('/', 'store')->name('.store');
                                                Route::get('/{id}', 'show')->name('.show');
                                                Route::get('/{id}/edit', 'edit')->name('.edit');
                                                Route::put('/{id}', 'update')->name('.update');
                                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                            });
                                        });
                                    });

                                    //Geriatri
                                    Route::prefix('geriatri')->group(function () {
                                        Route::name('.geriatri')->group(function () {
                                            Route::controller(RawatJalanAsesmenGeriatriController::class)->group(function () {
                                                Route::get('/', 'index')->name('.index');
                                                Route::post('/', 'store')->name('.store');
                                                Route::get('/{id}', 'show')->name('.show');
                                                Route::get('/{id}/edit', 'edit')->name('.edit');
                                                Route::put('/{id}', 'update')->name('.update');
                                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                            });
                                        });
                                    });

                                    // Awal
                                    Route::prefix('awal')->group(function () {
                                        Route::name('.awal')->group(function () {
                                            Route::controller(RawatJalanAsesmenAwalController::class)->group(function () {
                                                Route::get('/', 'index')->name('.index');
                                                Route::post('/', 'store')->name('.store');
                                                Route::get('/{id}', 'show')->name('.show');
                                                Route::get('/{id}/edit', 'edit')->name('.edit');
                                                Route::put('/{id}', 'update')->name('.update');
                                            });
                                        });
                                    });
                                });
                            });

                            Route::prefix('keperawatan')->group(function () {
                                Route::name('.keperawatan')->group(function () {

                                    // Route::prefix('anak')->group(function () {
                                    //     Route::name('.anak')->group(function () {
                                    //         Route::controller(AsesmenKepAnakController::class)->group(function () {
                                    //             Route::get('/', 'index')->name('.index');
                                    //             Route::post('/', 'store')->name('.store');
                                    //             Route::get('/{id}', 'show')->name('.show');
                                    //             Route::get('/{id}/edit', 'edit')->name('.edit');
                                    //             Route::put('/{id}', 'update')->name('.update');
                                    //         });
                                    //     });
                                    // });

                                });
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

                    // Penundaan Pelayanan
                    Route::prefix('penundaan')->group(function () {
                        Route::name('.penundaan')->group(function () {
                            Route::controller(RawatJalanPenundaanPelayananController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::get('/create', 'create')->name('.create');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::get('/show/{data}', 'show')->name('.show');
                                Route::delete('/', 'delete')->name('.delete');
                                Route::get('/pdf/{data}', 'pdf')->name('.pdf');
                            });
                        });
                    });

                    // Persetujuan Anestesi dan sedasi
                    Route::prefix('anestesi-sedasi')->group(function () {
                        Route::name('.anestesi-sedasi')->group(function () {
                            Route::controller(RawatJalanPersetujuanAnestesiController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::get('/create', 'create')->name('.create');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::get('/show/{data}', 'show')->name('.show');
                                Route::delete('/', 'delete')->name('.delete');
                                Route::get('/pdf/{data}', 'pdf')->name('.pdf');
                            });
                        });
                    });

                    // prmrj
                    Route::prefix('prmrj')->group(function () {
                        Route::name('.prmrj')->group(function () {
                            Route::controller(RajalPRMRJController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::get('/create', 'create')->name('.create');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    // Hiv Art
                    Route::prefix('hiv_art')->group(function () {
                        Route::name('.hiv_art')->group(function () {
                            Route::controller(RajalHivArtController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::get('/create', 'create')->name('.create');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    // Hiv Art akhir follow-up
                    Route::prefix('hiv_art_akhir_follow_up')->group(function () {
                        Route::name('.hiv_art_akhir_follow_up')->group(function () {
                            Route::controller(RajalHivArtAkhirFollowUpController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::get('/create', 'create')->name('.create');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    //konseling hiv
                    Route::prefix('konseling-hiv')->group(function () {
                        Route::name('.konseling-hiv')->group(function () {
                            Route::controller(RajalKonselingHIVController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::get('/create', 'create')->name('.create');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::post('/', 'store')->name('.store');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                            });
                        });
                    });

                    Route::prefix('mpp')->group(function () {
                        Route::name('.mpp')->group(function () {
                            //FORM A
                            Route::prefix('form-a')->group(function () {
                                Route::name('.form-a')->group(function () {
                                    Route::controller(RawatJalanMppAController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                        Route::put('/{id}', 'update')->name('.update');
                                        Route::get('/show/{id}', 'show')->name('.show');
                                        Route::delete('/{id}', 'destroy')->name('.destroy');
                                        Route::get('/print/{id}', 'print')->name('.print');
                                    });
                                });
                            });

                            //FORM B
                            Route::prefix('form-b')->group(function () {
                                Route::name('.form-b')->group(function () {
                                    Route::controller(RawatJalanMppBController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                        Route::put('/{id}', 'update')->name('.update');
                                        Route::get('/show/{id}', 'show')->name('.show');
                                        Route::delete('/{id}', 'destroy')->name('.destroy');
                                        Route::get('/print/{id}', 'print')->name('.print');
                                    });
                                });
                            });
                        });
                    });

                    // EWS Pasien Dewasa
                    Route::prefix('ews-pasien-dewasa')->group(function () {
                        Route::name('.ews-pasien-dewasa')->group(function () {
                            Route::controller(RajalEWSPasienDewasaController::class)->group(function () {
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

                    // EWS Pasien Anak
                    Route::prefix('ews-pasien-anak')->group(function () {
                        Route::name('.ews-pasien-anak')->group(function () {
                            Route::controller(RajalEWSPasienAnakController::class)->group(function () {
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

                    //pengawasan darah
                    Route::prefix('pengawasan-darah')->group(function () {
                        Route::name('.pengawasan-darah')->group(function () {
                            Route::controller(PengawasanDarahController::class)->group(function () {
                                // Route utama index
                                Route::get('/', 'index')->name('.index');

                                // Routes untuk MONITORING
                                Route::prefix('monitoring')->group(function () {
                                    Route::get('/create', 'createMonitoring')->name('.monitoring.create');
                                    Route::post('/', 'storeMonitoring')->name('.monitoring.store');
                                    Route::get('/{id}', 'showMonitoring')->name('.monitoring.show');
                                    Route::get('/{id}/edit', 'editMonitoring')->name('.monitoring.edit');
                                    Route::put('/{id}', 'updateMonitoring')->name('.monitoring.update');
                                    Route::delete('/{id}', 'destroyMonitoring')->name('.monitoring.destroy');
                                });

                                // Routes untuk PENGELOLAAN
                                Route::prefix('pengelolaan')->group(function () {
                                    Route::get('/create', 'createPengelolaan')->name('.pengelolaan.create');
                                    Route::post('/', 'storePengelolaan')->name('.pengelolaan.store');
                                    Route::get('/{id}', 'showPengelolaan')->name('.pengelolaan.show');
                                    Route::get('/{id}/edit', 'editPengelolaan')->name('.pengelolaan.edit');
                                    Route::put('/{id}', 'updatePengelolaan')->name('.pengelolaan.update');
                                    Route::delete('/{id}', 'destroyPengelolaan')->name('.pengelolaan.destroy');
                                });
                                Route::get('/print', 'printPengawasanDarah')->name('.print');
                            });
                        });
                    });

                    //Gizi
                    Route::prefix('gizi')->group(function () {
                        Route::name('.gizi')->group(function () {

                            Route::prefix('anak')->group(function () {
                                Route::name('.anak')->group(function () {
                                    Route::controller(RawatJalanGiziAnakController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                        Route::put('/{id}', 'update')->name('.update');
                                        Route::get('/show/{id}', 'show')->name('.show');
                                        Route::get('/grafik{id}', 'grafik')->name('.grafik');
                                        Route::delete('/{id}', 'destroy')->name('.destroy');
                                        Route::get('/pdf/{id}', 'pdf')->name('.pdf');
                                    });
                                });
                            });

                            Route::prefix('dewasa')->group(function () {
                                Route::name('.dewasa')->group(function () {
                                    Route::controller(RawatJalanGiziDewasaController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                        Route::put('/{id}', 'update')->name('.update');
                                        Route::get('/show/{id}', 'show')->name('.show');
                                        Route::delete('/{id}', 'destroy')->name('.destroy');
                                        Route::get('/pdf/{id}', 'pdf')->name('.pdf');
                                    });
                                });
                            });

                            Route::prefix('monitoring')->group(function () {
                                Route::name('.monitoring')->group(function () {
                                    Route::controller(RawatJalanGiziMonitoringController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::post('/', 'store')->name('.store');
                                        Route::put('/{id}', 'update')->name('.update');
                                        Route::delete('/', 'destroy')->name('.destroy');
                                    });
                                });
                            });
                        });
                    });

                    // EWS Pasien Obstetrik
                    Route::prefix('ews-pasien-obstetrik')->group(function () {
                        Route::name('.ews-pasien-obstetrik')->group(function () {
                            Route::controller(RajalEWSPasienObstetrikController::class)->group(function () {
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

                    // Catatan Poliklinik
                    Route::prefix('catatan-poliklinik')->group(function () {
                        Route::name('.catatan-poliklinik')->group(function () {
                            Route::controller(RajalCatatanPoliKlinikController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/create', 'create')->name('.create');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                            });
                        });
                    });

                    // Resiko Jatuh
                    Route::prefix('resiko-jatuh')->group(function () {
                        Route::name('.resiko-jatuh')->group(function () {

                            //Skala Morse
                            Route::prefix('morse')->group(function () {
                                Route::name('.morse')->group(function () {
                                    Route::controller(RawatJalanSkalaMorseController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                                        Route::get('/{data}', 'show')->name('.show');
                                        Route::get('/{data}/edit', 'edit')->name('.edit');
                                        Route::put('/{data}', 'update')->name('.update');
                                        Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                        Route::delete('/{data}', 'destroy')->name('.destroy');
                                    });
                                });
                            });

                            //Skala Humpty Dumpty
                            Route::prefix('humpty-dumpty')->group(function () {
                                Route::name('.humpty-dumpty')->group(function () {
                                    Route::controller(RawatJalanSkalaHumptyDumptyController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                                        Route::get('/{data}', 'show')->name('.show');
                                        Route::get('/{data}/edit', 'edit')->name('.edit');
                                        Route::put('/{data}', 'update')->name('.update');
                                        Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                        Route::delete('/{data}', 'destroy')->name('.destroy');
                                    });
                                });
                            });

                            //Risiko Jatuh Geriatri
                            Route::prefix('geriatri')->group(function () {
                                Route::name('.geriatri')->group(function () {
                                    Route::controller(RawatJalanSkalaGeriatriController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                                        Route::get('/{data}', 'show')->name('.show');
                                        Route::get('/{data}/edit', 'edit')->name('.edit');
                                        Route::put('/{data}', 'update')->name('.update');
                                        Route::delete('/{data}', 'destroy')->name('.destroy');
                                    });
                                });
                            });
                        });
                    });

                    //Status Nyeri
                    Route::prefix('status-nyeri')->group(function () {
                        Route::name('.status-nyeri')->group(function () {

                            //Status Nyeri Lanjutan Skala Numerik Dan Wong Baker
                            Route::prefix('skala-numerik')->group(function () {
                                Route::name('.skala-numerik')->group(function () {
                                    Route::controller(StatusNyeriSkalaNumerikController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::get('/{data}', 'show')->name('.show');
                                        Route::get('/{data}/edit', 'edit')->name('.edit');
                                        Route::put('/{data}', 'update')->name('.update');
                                        Route::delete('/{data}', 'destroy')->name('.destroy');
                                    });
                                });
                            });

                            //Status Nyeri Skala Cries (Neonatus 0 Sd 1 Bln)
                            Route::prefix('skala-cries')->group(function () {
                                Route::name('.skala-cries')->group(function () {
                                    Route::controller(SkalaCriesController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::get('/{data}', 'show')->name('.show');
                                        Route::get('/{data}/edit', 'edit')->name('.edit');
                                        Route::put('/{data}', 'update')->name('.update');
                                        Route::delete('/{data}', 'destroy')->name('.destroy');
                                    });
                                });
                            });

                            //Status Nyeri Lanjutan Skala Flacc (Anak  2 Bln Sd 7 Thn)
                            Route::prefix('skala-flacc')->group(function () {
                                Route::name('.skala-flacc')->group(function () {
                                    Route::controller(SkalaFlaccController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/', 'store')->name('.store');
                                        Route::get('/create', 'create')->name('.create');
                                        Route::get('/{data}', 'show')->name('.show');
                                        Route::get('/{data}/edit', 'edit')->name('.edit');
                                        Route::put('/{data}', 'update')->name('.update');
                                        Route::delete('/{data}', 'destroy')->name('.destroy');
                                    });
                                });
                            });
                        });
                    });

                    //status fungsional
                    Route::prefix('status-fungsional')->group(function () {
                        Route::name('.status-fungsional')->group(function () {
                            Route::controller(RawatJalanStatusFungsionalController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/create', 'create')->name('.create');
                                Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    //Resiko Decubitus
                    Route::prefix('resiko-decubitus')->group(function () {
                        Route::name('.resiko-decubitus')->group(function () {
                            Route::controller(RawatJalanResikoDecubitusController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/create', 'create')->name('.create');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    // persetujuan transfusi darah
                    Route::prefix('persetujuan-transfusi-darah')->group(function () {
                        Route::name('.persetujuan-transfusi-darah')->group(function () {
                            Route::controller(RawatJalanPersetujuanTransfusiDarahController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/create', 'create')->name('.create');
                                Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    // Covid 19
                    Route::prefix('covid-19')->group(function () {
                        Route::name('.covid-19')->group(function () {
                            Route::controller(RawatJalanCovid19Controller::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/create', 'create')->name('.create');
                                Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });

                    // Echocardiography
                    Route::prefix('echocardiography')->group(function () {
                        Route::name('.echocardiography')->group(function () {
                            Route::controller(RawatJalanEchocardiographyController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
                                Route::post('/', 'store')->name('.store');
                                Route::get('/create', 'create')->name('.create');
                                Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                                Route::get('/{data}', 'show')->name('.show');
                                Route::get('/{data}/edit', 'edit')->name('.edit');
                                Route::put('/{data}', 'update')->name('.update');
                                Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                Route::delete('/{data}', 'destroy')->name('.destroy');
                            });
                        });
                    });


                    //Audiometri
                    Route::prefix('audiometri')->group(function () {
                        Route::name('.audiometri')->group(function () {
                            Route::controller(AudiometriController::class)->group(function () {
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

                    // REHAB MEDIK
                    // Pelayanan
                    Route::prefix('layanan-rehab-medik')->group(function () {
                        Route::name('.layanan-rehab-medik')->group(function () {
                            Route::controller(RehabLayananController::class)->group(function () {
                                Route::get('/', 'index')->name('.index');
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
                    Route::prefix('tindakan-rehab-medik')->group(function () {
                        Route::name('.tindakan-rehab-medik')->group(function () {
                            Route::controller(RehabTindakanController::class)->group(function () {
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
});
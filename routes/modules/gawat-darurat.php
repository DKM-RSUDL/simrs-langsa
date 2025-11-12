<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UnitPelayanan\GawatDaruratController;
use App\Http\Controllers\MedisGawatDaruratController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\AsesmenController as GawatDaruratAsesmenController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\AsesmenKeperawatanController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\AudiometriController as GawatDaruratAudiometriController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\CarePlanController as GawatDaruratCarePlanController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\CpptController as GawatDaruratCpptController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\EdukasiController as GawatDaruratEdukasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\FarmasiController as GawatDaruratFarmasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\GeneralConsentController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\KonsultasiController as GawatDaruratKonsultasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\LaborController as GawatDaruratLaborController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\MppAController as GawatDaruratMppAController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\MppBController as GawatDaruratMppBController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\PapsController as GawatDaruratPapsController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\PengawasanDarahController as GawatDaruratPengawasanDarahController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\PenolakanResusitasiController as GawatDaruratPenolakanResusitasiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\PenundaanPelayananController as GawatDaruratPenundaanPelayananController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\PermintaanDarahController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\PermintaanSecondOpinionController as GawatDaruratPermintaanSecondOpinionController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\PersetujuanAnestesiController as GawatDaruratPersetujuanAnestesiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\RadiologiController as GawatDaruratRadiologiController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\ResumeController as GawatDaruratResumeController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\RujukController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\SuratKematianController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\TindakanController as GawatDaruratTindakanController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\TransferPasienController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\EWSPasienAnakController as GawatDaruratEWSPasienAnakController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\EWSPasienDewasaController as GawatDaruratEWSPasienDewasaController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\EWSPasienObstetrikController as GawatDaruratEWSPasienObstetrikController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\ResikoDecubitusController as GawatDaruratResikoDecubitusController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\ResikoJatuh\SkalaGeriatriController as GawatDaruratSkalaGeriatriController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\ResikoJatuh\SkalaHumptyDumptyController as GawatDaruratSkalaHumptyDumptyController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\ResikoJatuh\SkalaMorseController as GawatDaruratSkalaMorseController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\StatusNyeri\SkalaCriesController as StatusNyeriSkalaCriesController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\StatusNyeri\SkalaFlaccController as StatusNyeriSkalaFlaccController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\StatusNyeri\SkalaNumerikController as GawatDaruratStatusNyeriSkalaNumerikController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\StatusFungsionalController as GawatDaruratStatusFungsionalController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\PersetujuanTransfusiDarahController as GawatDaruratPersetujuanTransfusiDarahController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\Covid19Controller as GawatDaruratCovid19Controller;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\EchocardiographyController as GawatDaruratEchocardiographyController;
use App\Http\Controllers\UnitPelayanan\GawatDarurat\UpdatePasienController;

// Route::middleware(['check.igd'])->group(function () {

Route::prefix('gawat-darurat')->group(function () {
    Route::get('/', [GawatDaruratController::class, 'index'])->name('gawat-darurat.index');
    Route::get('/triase', [GawatDaruratController::class, 'triaseIndex'])->name('gawat-darurat.triase');
    Route::post('/store-triase', [GawatDaruratController::class, 'storeTriase'])->name('gawat-darurat.store-triase');
    Route::post('/get-patient-bynik-ajax', [GawatDaruratController::class, 'getPatientByNikAjax'])->name('gawat-darurat.get-patient-bynik-ajax');
    Route::post('/get-patient-bynama-ajax', [GawatDaruratController::class, 'getPatientByNamaAjax'])->name('gawat-darurat.get-patient-bynama-ajax');
    Route::post('/get-patient-byalamat-ajax', [GawatDaruratController::class, 'getPatientByAlamatAjax'])->name('gawat-darurat.get-patient-byalamat-ajax');
    Route::post('/get-triase-data', [GawatDaruratController::class, 'getTriaseData'])->name('gawat-darurat.get-triase-data');
    Route::put('/ubah-foto-triase/{kdKasir}/{noTrx}', [GawatDaruratController::class, 'updateFotoTriase'])->name('gawat-darurat.ubah-foto-triase');
    Route::get('/triase/{kd_pasien}/{tgl_masuk}/print-pdf', [GawatDaruratController::class, 'generatePDF'])
        ->name('gawat-darurat.triase.printPDF');

    Route::prefix('pelayanan')->group(function () {
        Route::prefix('/{kd_pasien}/{tgl_masuk}')->group(function () {

            // Update Pasien
            Route::prefix('{urut_masuk}/ubah-pasien')->group(function () {
                Route::name('ubah-pasien')->group(function () {
                    Route::controller(UpdatePasienController::class)->group(function () {
                        Route::get('/', 'index');
                        Route::post('/ubah-pasien', 'UbahPasien')->name('.ubah-pasien');
                    });
                });
            });

            // general consent
            Route::prefix('{urut_masuk}/general-consent')->group(function () {
                Route::name('general-consent')->group(function () {
                    Route::controller(GeneralConsentController::class)->group(function () {
                        Route::get('/', 'index');
                        Route::post('/show', 'show')->name('.show');
                        Route::post('/', 'store')->name('.store');
                        Route::delete('/{data}', 'delete')->name('.delete');
                        Route::get('/print/{data}', 'print')->name('.print');
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
                        Route::post('/simpan-temp', 'storeDataTemp')->name('.store-temp');
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
            Route::prefix('{urut_masuk}/tindakan')->group(function () {
                Route::name('tindakan')->group(function () {
                    Route::controller(GawatDaruratTindakanController::class)->group(function () {
                        Route::get('/', 'index')->name('.index');
                        Route::get('/print-pdf', 'printPDF')->name('.print-pdf');
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

                        // E-Resep Pulang
                        Route::post('/e-resep-pulang', 'storeEResepPulang')->name('.storeEResepPulang');
                        Route::get('/order-obat-e-resep-pulang', 'orderObatEResepPulang')->name('.order-obat-e-resep-pulang');

                        Route::get('/search-obat', 'searchObat')->name('.searchObat');
                        Route::post('/rekonsiliasiObat', 'rekonsiliasiObat')->name('.rekonsiliasiObat');
                        Route::delete('/rekonsiliasi-obat-delete', 'rekonsiliasiObatDelete')->name('.rekonsiliasiObatDelete');
                    });
                });
            });


            // Route::prefix('{urut_masuk}/asesmen')->group(function () {
            Route::prefix('{urut_masuk}/asesmen')->group(function () {
                Route::name('asesmen')->group(function () {
                    Route::controller(GawatDaruratAsesmenController::class)->group(function () {
                        Route::get('/', 'index')->name('.index');
                        Route::get('/create', 'create')->name('.create');
                        Route::post('/', 'store')->name('.store');
                        Route::get('/{id}', 'show')->name('.show');
                        Route::get('/{id}/edit', 'edit')->name('.edit');
                        Route::put('/{id}', 'update')->name('.update');
                        Route::get('/{id}/print', 'print')->name('.print');
                    });
                });
            });

            Route::prefix('asesmen-keperawatan')->group(function () {
                Route::name('asesmen-keperawatan')->group(callback: function () {
                    Route::controller(AsesmenKeperawatanController::class)->group(function () {
                        Route::get('/{urut_masuk}/', 'index')->name('.index');
                        Route::post('/{urut_masuk}/', 'store')->name('.store');
                        Route::get('{urut_masuk}/{id}', 'show')->name('.show');
                        Route::get('/{urut_masuk}/{id}/edit', 'edit')->name('.edit');
                        Route::put('/{urut_masuk}/{id}', 'update')->name('.update');
                        Route::get('/{urut_masuk}/{id}/print-pdf', 'generatePDF')->name('.print-pdf-keperawatan');
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
                        Route::delete('/{data}', 'destroy')->name('.destroy');
                    });
                });
            });

            // permintaan darah
            Route::prefix('{urut_masuk}/permintaan-darah')->group(function () {
                Route::name('permintaan-darah')->group(function () {
                    Route::controller(PermintaanDarahController::class)->group(function () {
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

            //Surat Kematian
            Route::prefix('{urut_masuk}/surat-kematian')->group(function () {
                Route::name('surat-kematian')->group(function () {
                    Route::controller(SuratKematianController::class)->group(function () {
                        Route::get('/', 'index')->name('.index');
                        Route::get('/create', 'create')->name('.create');
                        Route::get('/{data}', 'show')->name('.show');
                        Route::get('/{data}/edit', 'edit')->name('.edit');
                        Route::post('/', 'store')->name('.store');
                        Route::put('/{data}', 'update')->name('.update');
                        Route::delete('/{data}', 'destroy')->name('.destroy');
                        Route::get('/print/{data}', 'print')->name('.print');
                    });
                });
            });

            //paps
            Route::prefix('{urut_masuk}/paps')->group(function () {
                Route::name('paps')->group(function () {
                    Route::controller(GawatDaruratPapsController::class)->group(function () {
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

            // Penundaan Pelayanan
            Route::prefix('{urut_masuk}/penundaan')->group(function () {
                Route::name('penundaan')->group(function () {
                    Route::controller(GawatDaruratPenundaanPelayananController::class)->group(function () {
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

            // Penolakan Resusitasi
            Route::prefix('{urut_masuk}/dnr')->group(function () {
                Route::name('dnr')->group(function () {
                    Route::controller(GawatDaruratPenolakanResusitasiController::class)->group(function () {
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
            Route::prefix('{urut_masuk}/anestesi-sedasi')->group(function () {
                Route::name('anestesi-sedasi')->group(function () {
                    Route::controller(GawatDaruratPersetujuanAnestesiController::class)->group(function () {
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

            // Orientasi Second Opinion
            Route::prefix('{urut_masuk}/permintaan-second-opinion')->group(function () {
                Route::name('permintaan-second-opinion')->group(function () {
                    Route::controller(GawatDaruratPermintaanSecondOpinionController::class)->group(function () {
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

            //MPP
            Route::prefix('{urut_masuk}/mpp')->group(function () {
                Route::name('mpp')->group(function () {
                    //FORM A
                    Route::prefix('form-a')->group(function () {
                        Route::name('.form-a')->group(function () {
                            Route::controller(GawatDaruratMppAController::class)->group(function () {
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
                            Route::controller(GawatDaruratMppBController::class)->group(function () {
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

            // EWS Pasien Anak
            Route::prefix('{urut_masuk}/ews-pasien-anak')->group(function () {
                Route::name('ews-pasien-anak')->group(function () {
                    Route::controller(GawatDaruratEWSPasienAnakController::class)->group(function () {
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

            // EWS Pasien Dewasa
            Route::prefix('{urut_masuk}/ews-pasien-dewasa')->group(function () {
                Route::name('ews-pasien-dewasa')->group(function () {
                    Route::controller(GawatDaruratEWSPasienDewasaController::class)->group(function () {
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

            // EWS Pasien Obstetrik
            Route::prefix('{urut_masuk}/ews-pasien-obstetrik')->group(function () {
                Route::name('ews-pasien-obstetrik')->group(function () {
                    Route::controller(GawatDaruratEWSPasienObstetrikController::class)->group(function () {
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

            //pengawasan darah
            Route::prefix('{urut_masuk}/pengawasan-darah')->group(function () {
                Route::name('pengawasan-darah')->group(function () {
                    Route::controller(GawatDaruratPengawasanDarahController::class)->group(function () {
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

            // Resiko Jatuh
            Route::prefix('{urut_masuk}/resiko-jatuh')->group(function () {
                Route::name('resiko-jatuh')->group(function () {

                    //Skala Morse
                    Route::prefix('morse')->group(function () {
                        Route::name('.morse')->group(function () {
                            Route::controller(GawatDaruratSkalaMorseController::class)->group(function () {
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
                            Route::controller(GawatDaruratSkalaHumptyDumptyController::class)->group(function () {
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
                            Route::controller(GawatDaruratSkalaGeriatriController::class)->group(function () {
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
            Route::prefix('{urut_masuk}/status-nyeri')->group(function () {
                Route::name('status-nyeri')->group(function () {

                    //Status Nyeri Lanjutan Skala Numerik Dan Wong Baker
                    Route::prefix('skala-numerik')->group(function () {
                        Route::name('.skala-numerik')->group(function () {
                            Route::controller(GawatDaruratStatusNyeriSkalaNumerikController::class)->group(function () {
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
                            Route::controller(StatusNyeriSkalaCriesController::class)->group(function () {
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
                            Route::controller(StatusNyeriSkalaFlaccController::class)->group(function () {
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
            Route::prefix('{urut_masuk}/status-fungsional')->group(function () {
                Route::name('status-fungsional')->group(function () {
                    Route::controller(GawatDaruratStatusFungsionalController::class)->group(function () {
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
            Route::prefix('{urut_masuk}/resiko-decubitus')->group(function () {
                Route::name('resiko-decubitus')->group(function () {
                    Route::controller(GawatDaruratResikoDecubitusController::class)->group(function () {
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
            Route::prefix('{urut_masuk}/persetujuan-transfusi-darah')->group(function () {
                Route::name('persetujuan-transfusi-darah')->group(function () {
                    Route::controller(GawatDaruratPersetujuanTransfusiDarahController::class)->group(function () {
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
            Route::prefix('{urut_masuk}/covid-19')->group(function () {
                Route::name('covid-19')->group(function () {
                    Route::controller(GawatDaruratCovid19Controller::class)->group(function () {
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
            Route::prefix('{urut_masuk}/echocardiography')->group(function () {
                Route::name('echocardiography')->group(function () {
                    Route::controller(GawatDaruratEchocardiographyController::class)->group(function () {
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
            Route::prefix('{urut_masuk}/audiometri')->group(function () {
                Route::name('audiometri')->group(function () {
                    Route::controller(GawatDaruratAudiometriController::class)->group(function () {
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

            Route::resource('/', MedisGawatDaruratController::class);
            // Route::resource('asesmen', GawatDaruratAsesmenController::class);
            Route::resource('labor', GawatDaruratLaborController::class);
            Route::post('cetak', [GawatDaruratLaborController::class, 'cetak']);
            Route::resource('careplan', GawatDaruratCarePlanController::class);
            Route::resource('resume', GawatDaruratResumeController::class);

            Route::controller(GawatDaruratResumeController::class)->group(function () {
                Route::name('resume')->group(function () {
                    Route::prefix('/{urut_masuk}/resume')->group(function () {
                        Route::get('/{data}/detail', 'detail')->name('.detail');
                        Route::put('/{data}', 'update')->name('.update');
                        Route::post('/validasi', 'validasiResume')->name('.validasi');
                        Route::get('/{data}/pdf', 'pdf')->name('.pdf');
                    });
                });
            });
        });
    });
});
// });
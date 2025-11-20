<?php

use App\Http\Controllers\KonsultasiSpesialisController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenGeriatriController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenGinekologikController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepOpthamologyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepThtController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenObstetriMaternitas;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepPerinatologyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKetDewasaRanapController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKulitKelaminController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenParuController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenPsikiatriController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenTerminalController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsuhanKeperawatanRawatInapController;
use App\Http\Controllers\UnitPelayanan\RawatInap\CpptController as RawatInapCpptController;
use App\Http\Controllers\UnitPelayanan\RawatInap\EWSPasienAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\EWSPasienDewasaController;
use App\Http\Controllers\UnitPelayanan\RawatInap\EWSPasienObstetrikController;
use App\Http\Controllers\UnitPelayanan\RawatInap\FarmasiController as RawatInapFarmasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\GiziAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\GiziDewasaController;
use App\Http\Controllers\UnitPelayanan\RawatInap\GiziMonitoringController;
use App\Http\Controllers\UnitPelayanan\RawatInap\InformedConsentController;
use App\Http\Controllers\UnitPelayanan\RawatInap\IntakeCairanController;
use App\Http\Controllers\UnitPelayanan\RawatInap\KonsultasiController as RawatInapKonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\KontrolIstimewaController;
use App\Http\Controllers\UnitPelayanan\RawatInap\KontrolIstimewaJamController;
use App\Http\Controllers\UnitPelayanan\RawatInap\MasukKeluarIccuController;
use App\Http\Controllers\UnitPelayanan\RawatInap\MasukKeluarIcuController;
use App\Http\Controllers\UnitPelayanan\RawatInap\MasukKeluarNicuController;
use App\Http\Controllers\UnitPelayanan\RawatInap\MasukKeluarPicuController;
use App\Http\Controllers\UnitPelayanan\RawatInap\MeninggalkanPerawatanController;
use App\Http\Controllers\UnitPelayanan\RawatInap\MonitoringController;
use App\Http\Controllers\UnitPelayanan\RawatInap\MppAController;
use App\Http\Controllers\UnitPelayanan\RawatInap\MppBController;
use App\Http\Controllers\UnitPelayanan\RawatInap\NeurologiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PapsController;
use App\Http\Controllers\UnitPelayanan\RawatInap\OrientasiPasienBaruController;
use App\Http\Controllers\UnitPelayanan\RawatInap\ObservasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PelayananRohaniController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PengawasanTransportasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PenolakanResusitasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PenundaanPelayananController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PermintaanPrivasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PersetujuanAnestesiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PermintaanSecondOpinionController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PengawasanController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenPraAnestesiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AudiometriController as RawatInapAudiometriController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RadiologiController as RawatInapRadiologiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RanapPengawasanDarahController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RanapPermintaanDarahController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RanapPermintaanSecondOpinionController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RanapPernyataandpjpController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapEdukasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapLabPatologiKlinikController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RawatInapResumeController;
use App\Http\Controllers\UnitPelayanan\RawatInap\ResikoDecubitusController;
use App\Http\Controllers\UnitPelayanan\RawatInap\ResikoJatuh\SkalaGeriatriController;
use App\Http\Controllers\UnitPelayanan\RawatInap\ResikoJatuh\SkalaHumptyDumptyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\ResikoJatuh\SkalaMorseController as RawatInapSkalaMorseController;
use App\Http\Controllers\UnitPelayanan\RawatInap\StatusNyeri\SkalaCriesController;
use App\Http\Controllers\UnitPelayanan\RawatInap\StatusNyeri\SkalaFlaccController;
use App\Http\Controllers\UnitPelayanan\RawatInap\StatusNyeri\SkalaNumerikController;
use App\Http\Controllers\UnitPelayanan\RawatInap\SuratKematianController as RawatInapSuratKematianController;
use App\Http\Controllers\UnitPelayanan\RawatInap\TindakanController as RawatInapTindakanController;
use App\Http\Controllers\UnitPelayanan\RawatInap\StatusFungsionalController as RawatInapStatusFungsionalController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PersetujuanTransfusiDarahController as RawatInapPersetujuanTransfusiDarahController;
use App\Http\Controllers\UnitPelayanan\RawatInap\Covid19Controller as RawatInapCovid19Controller;
use App\Http\Controllers\UnitPelayanan\RawatInap\TransferPasienAntarRuang as RawatInapTransferPasienAntarRuang;
use App\Http\Controllers\UnitPelayanan\RawatInap\EchocardiographyController as RawatInapEchocardiographyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenPengkajianAwalMedis as RawatInapAsesmenPengkajianAwalMedis;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenMedisAnakController as RawatInapAsesmenMedisAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenMedisNeonatologiController as RawatInapAsesmenMedisNeonatologiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenPraOperatifPerawatController;
use App\Http\Controllers\UnitPelayanan\RawatInap\OperasiIBSController;
use App\Http\Controllers\UnitPelayanan\RawatInap\OrderHemodialisaController;
use App\Http\Controllers\UnitPelayanan\RawatInap\OrderOKController;
use App\Http\Controllers\UnitPelayanan\RawatInap\PneumoniaCurb65Controller;
use App\Http\Controllers\UnitPelayanan\RawatInap\PneumoniaPsiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RincianEchocardiographyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\RincianKonsultasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\SiteMarkingController;
use App\Http\Controllers\UnitPelayanan\RawatInap\SurveilansA1Controller;
use App\Http\Controllers\UnitPelayanan\RawatInap\SurveilansA2Controller;
use App\Http\Controllers\UnitPelayanan\RawatInap\TriaseController;
use App\Http\Controllers\UnitPelayanan\RawatInapController;

Route::prefix('rawat-inap')->group(function () {
    Route::name('rawat-inap')->group(function () {
        Route::get('/', [RawatInapController::class, 'index'])->name('.index');

        // Route::middleware(['check.unit'])->group(function () {

        Route::prefix('unit/{kd_unit}')->group(function () {
            Route::name('.unit')->group(function () {
                Route::get('/', [RawatInapController::class, 'unitPelayanan']);
                Route::get('/aktif', [RawatInapController::class, 'unitPelayanan'])->name('.aktif');
                Route::get('/selesai', [RawatInapController::class, 'selesai'])->name('.selesai');
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
                            Route::get('/print/{data}', 'print')->name('.print');
                        });
                    });
                });


                // CPPT
                Route::prefix('cppt')->group(function () {
                    Route::name('.cppt')->group(function () {
                        Route::controller(RawatInapCpptController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::put('/', 'update')->name('.update');
                            Route::post('/get-icd10-ajax', 'getIcdTenAjax')->name('.get-icd10-ajax');
                            Route::post('/get-cppt-ajax', 'getCpptAjax')->name('.get-cppt-ajax');
                            Route::get('/get-cppt-adime', 'getCpptAdime')->name('.get-cppt-adime');
                            Route::post('/get-instruksi-ppa', 'getInstruksiPpaByUrutTotal')->name('.get-instruksi-ppa');
                            Route::post('/get-last-diagnoses', 'getLastDiagnosesAjax')->name('.get-last-diagnoses');
                            Route::put('/verifikasi', 'verifikasiCppt')->name('.verifikasi');
                            Route::get('/gizi', 'cpptGizi')->name('.cppt-gizi');
                            Route::get('/print-pdf', 'printPDF')->name('.print-pdf');
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

                // EWS Pasien Dewasa
                Route::prefix('ews-pasien-dewasa')->group(function () {
                    Route::name('.ews-pasien-dewasa')->group(function () {
                        Route::controller(EWSPasienDewasaController::class)->group(function () {
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
                        Route::controller(EWSPasienAnakController::class)->group(function () {
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

                // EWS Pasien Obstetrik
                Route::prefix('ews-pasien-obstetrik')->group(function () {
                    Route::name('.ews-pasien-obstetrik')->group(function () {
                        Route::controller(EWSPasienObstetrikController::class)->group(function () {
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

                // pra-anestesi
                Route::prefix('asesmen-pra-anestesi')->group(function () {
                    Route::name('.asesmen-pra-anestesi')->group(function () {
                        Route::controller(AsesmenPraAnestesiController::class)->group(function () {
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

                        Route::prefix('rincian/{urut_konsul}')->group(function () {
                            Route::name('.rincian')->group(function () {
                                Route::controller(RawatInapKonsultasiController::class)->group(function () {
                                    Route::get('/', 'show')->name('.show');
                                });

                                // Rincian Konsultasi Rajal
                                Route::prefix('tindakan')->group(function () {
                                    Route::name('.tindakan')->group(function () {
                                        Route::controller(RincianKonsultasiController::class)->group(function () {
                                            Route::get('/', 'indexTindakan')->name('.indexTindakan');
                                        });
                                    });
                                });

                                Route::prefix('echocardiography')->group(function () {
                                    Route::name('.echocardiography')->group(function () {
                                        Route::controller(RincianKonsultasiController::class)->group(function () {
                                            Route::get('/', 'indexEchocardiography')->name('.indexEchocardiography');
                                            Route::get('/{id}', 'showEchocardiography')->name('.showEchocardiography');
                                        });
                                    });
                                });
                            });
                        });
                    });
                });

                //Konsultasi-Spesialis
                Route::prefix('konsultasi-spesialis')->group(function () {
                    Route::name('.konsultasi-spesialis')->group(function () {
                        Route::controller(KonsultasiSpesialisController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::put('/', 'update')->name('.update');
                            Route::delete('/', 'delete')->name('.delete');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/edit/{id}', 'edit')->name('.edit');
                            Route::get('/igd/print/{data}', 'printKonsulIGD')->name('.igd.print');
                            Route::get('/getDokterBySpesial', 'getDokterBySpesial')->name('.getDokterBySpesial');
                        });
                    });
                });

                // Tindakan
                Route::prefix('tindakan')->group(function () {
                    Route::name('.tindakan')->group(function () {
                        Route::controller(RawatInapTindakanController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/print-pdf', 'printPDF')->name('.print-pdf');
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
                            Route::post('print', 'print')->name('.print');
                            Route::post('print-all', 'printAll')->name('.print-all');
                        });
                    });
                });

                // edukasi
                Route::prefix('edukasi')->group(function () {
                    Route::name('.edukasi')->group(function () {
                        Route::controller(RawatInapEdukasiController::class)->group(function () {
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
                Route::prefix('permintaan-darah')->group(function () {
                    Route::name('.permintaan-darah')->group(function () {
                        Route::controller(RanapPermintaanDarahController::class)->group(function () {
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

                //pengawasan darah
                Route::prefix('pengawasan-darah')->group(function () {
                    Route::name('.pengawasan-darah')->group(function () {
                        Route::controller(RanapPengawasanDarahController::class)->group(function () {
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


                // pernyataan bpjp
                Route::prefix('pernyataan-dpjp')->group(function () {
                    Route::name('.pernyataan-dpjp')->group(function () {
                        Route::controller(RanapPernyataandpjpController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{data}', 'show')->name('.show');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::delete('/{data}', 'destroy')->name('.destroy');
                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                        });
                    });
                });

                // Orientasi Pasien Baru
                Route::prefix('orientasi-pasien-baru')->group(function () {
                    Route::name('.orientasi-pasien-baru')->group(function () {
                        Route::controller(OrientasiPasienBaruController::class)->group(function () {
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

                // Orientasi Second Opinion
                Route::prefix('permintaan-second-opinion')->group(function () {
                    Route::name('.permintaan-second-opinion')->group(function () {
                        Route::controller(RanapPermintaanSecondOpinionController::class)->group(function () {
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

                Route::prefix('farmasi')->group(function () {
                    Route::name('.farmasi')->group(function () {
                        Route::controller(RawatInapFarmasiController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/order-obat', 'orderObat')->name('.order-obat');

                            // E-Resep Pulang
                            Route::post('/e-resep-pulang', 'storeEResepPulang')->name('.storeEResepPulang');
                            Route::get('/order-obat-e-resep-pulang', 'orderObatEResepPulang')->name('.order-obat-e-resep-pulang');

                            Route::get('/search-obat', 'searchObat')->name('.searchObat');
                            Route::post('/catatanObat', 'catatanObat')->name('.catatanObat');
                            Route::put('/catatanObat/validasi', 'validasiCatatanObat')->name('.catatanObat.validasi');
                            Route::delete('/catatanObat/{id}', 'hapusCatatanObat')->name('.hapusCatatanObat');
                            Route::post('/rekonsiliasiObat', 'rekonsiliasiObat')->name('.rekonsiliasiObat');
                            Route::post('/copy-cpo', 'copyCPO')->name('.copy-cpo');
                            Route::delete('/deleteRekonsiliasiObat', 'deleteRekonsiliasiObat')->name('.rekonsiliasiObatDelete');
                            // Rekonsiliasi Obat transfer
                            Route::post('/rekonsiliasiObatTransfer', 'rekonsiliasiObatTransfer')->name('.rekonsiliasiObatTransfer');
                            Route::get('/rekonsiliasiObatTransfer/{id}/edit', 'editRekonsiliasiObatTransfer')->name('.editRekonsiliasiObatTransfer');
                            Route::put('/rekonsiliasiObatTransfer/{id}', 'updateRekonsiliasiObatTransfer')->name('.updateRekonsiliasiObatTransfer');
                            Route::delete('/rekonsiliasiObatTransfer/{id}', 'deleteRekonsiliasiObatTransfer')->name('.deleteRekonsiliasiObatTransfer');
                        });
                    });
                });

                // resume
                Route::prefix('rawat-inap-resume')->group(function () {
                    Route::name('.rawat-inap-resume')->group(function () {
                        Route::controller(RawatInapResumeController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/{data}/detail', 'detail')->name('.detail');
                            Route::post('/validasi', 'validasiResume')->name('.validasi');
                            Route::put('/{id}', 'update')->name('.update');
                            Route::get('/{data}/pdf', 'pdf')->name('.pdf');
                        });
                    });
                });

                // Asesmen
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
                                            Route::get('/igd/{id}', 'showMedisIGD')->name('.medis-igd');
                                        });
                                    });
                                });

                                // tht
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

                                // paru
                                Route::prefix('paru')->group(function () {
                                    Route::name('.paru')->group(function () {
                                        Route::controller(AsesmenParuController::class)->group(function () {
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

                                //Kulit dan kelamin
                                Route::prefix('kulit-kelamin')->group(function () {
                                    Route::name('.kulit-kelamin')->group(function () {
                                        Route::controller(AsesmenKulitKelaminController::class)->group(function () {
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
                                        Route::controller(AsesmenGinekologikController::class)->group(function () {
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
                                        Route::controller(AsesmenPsikiatriController::class)->group(function () {
                                            Route::get('/', 'index')->name('.index');
                                            Route::post('/', 'store')->name('.store');
                                            Route::get('/{id}', 'show')->name('.show');
                                            Route::get('/{id}/edit', 'edit')->name('.edit');
                                            Route::put('/{id}', 'update')->name('.update');
                                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                        });
                                    });
                                });


                                //geriatri
                                Route::prefix('geriatri')->group(function () {
                                    Route::name('.geriatri')->group(function () {
                                        Route::controller(AsesmenGeriatriController::class)->group(function () {
                                            Route::get('/', 'index')->name('.index');
                                            Route::post('/', 'store')->name('.store');
                                            Route::get('/{id}', 'show')->name('.show');
                                            Route::get('/{id}/edit', 'edit')->name('.edit');
                                            Route::put('/{id}', 'update')->name('.update');
                                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                                        });
                                    });
                                });

                                // Pengkajian Awal Medis
                                Route::prefix('pengkajian-awal-medis')->group(function () {
                                    Route::name('.pengkajian-awal-medis')->group(function () {
                                        Route::controller(RawatInapAsesmenPengkajianAwalMedis::class)->group(function () {
                                            Route::get('/', 'index')->name('.index');
                                            Route::post('/', 'store')->name('.store');
                                            Route::get('/{id}', 'show')->name('.show');
                                            Route::get('/{id}/edit', 'edit')->name('.edit');
                                            Route::put('/{id}', 'update')->name('.update');
                                        });
                                    });
                                });

                                // Medis Anak
                                Route::prefix('medis-anak')->group(function () {
                                    Route::name('.medis-anak')->group(function () {
                                        Route::controller(RawatInapAsesmenMedisAnakController::class)->group(function () {
                                            Route::get('/', 'index')->name('.index');
                                            Route::post('/', 'store')->name('.store');
                                            Route::get('/{id}', 'show')->name('.show');
                                            Route::get('/{id}/edit', 'edit')->name('.edit');
                                            Route::put('/{id}', 'update')->name('.update');
                                        });
                                    });
                                });

                                // medis neonatologi
                                Route::prefix('medis-neonatologi')->group(function () {
                                    Route::name('.medis-neonatologi')->group(function () {
                                        Route::controller(RawatInapAsesmenMedisNeonatologiController::class)->group(function () {
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


                                Route::prefix('umum')->group(function () {
                                    Route::name('.umum')->group(callback: function () {
                                        Route::controller(AsesmenKetDewasaRanapController::class)->group(function () {
                                            Route::get('/', 'create')->name('.create');
                                            Route::post('/', 'store')->name('.store');
                                            Route::get('/{id}', 'show')->name('.show');
                                            Route::get('/{id}/edit', 'edit')->name('.edit');
                                            Route::put('/{id}', 'update')->name('.update');
                                            Route::get('/igd/{id}', 'showKepIGD')->name('.keperawatan-igd');
                                        });
                                    });
                                });

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

                                Route::prefix('terminal')->group(function () {
                                    Route::name('.terminal')->group(function () {
                                        Route::controller(AsesmenTerminalController::class)->group(function () {
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


                //Monitoring
                Route::prefix('monitoring')->group(function () {
                    Route::name('.monitoring')->group(function () {
                        Route::controller(MonitoringController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{id}/show', 'show')->name('.show');
                            Route::get('/{id}/edit', 'edit')->name('.edit');
                            Route::put('/{id}', 'update')->name('.update');
                            Route::delete('/{id}', 'destroy')->name('.destroy');
                            Route::get('/print', 'printMonitoring')->name('.print');
                            Route::get('/create-therapy', 'createTherapy')->name('.create-therapy');
                            Route::post('/store-therapy', 'storeTherapy')->name('.store-therapy');
                            Route::delete('/destroy-therapy/{id}', 'destroyTherapy')->name('.destroy-therapy');
                            Route::get('/filter-data', 'getFilteredData')->name('.filter-data');
                            Route::get('/{id}/detail', 'getMonitoringDetail')->name('.detail');
                            Route::get('/available-days', 'getAvailableDays')->name('.available-days');
                            Route::get('/filter-by-day', 'getFilteredDataByDay')->name('.filter-by-day');
                            Route::get('all-data', 'getAllMonitoringData')->name('.all-data');
                        });
                    });
                });

                // Hand Over Pasien
                Route::prefix('serah-terima')->group(function () {
                    Route::name('.serah-terima')->group(function () {
                        Route::controller(RawatInapController::class)->group(function () {
                            Route::get('/', 'serahTerimaPasien');
                            Route::put('/{data}', 'serahTerimaPasienCreate')->name('.store');
                        });
                    });
                });

                // Intake Output Cairan
                Route::prefix('intake-cairan')->group(function () {
                    Route::name('.intake-cairan')->group(function () {
                        Route::controller(IntakeCairanController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                            Route::get('/show/{data}', 'show')->name('.show');
                            Route::delete('/', 'delete')->name('.delete');
                            Route::get('/pdf', 'pdf')->name('.pdf');
                        });
                    });
                });

                //Observasi
                Route::prefix('observasi')->group(function () {
                    Route::name('.observasi')->group(function () {
                        Route::controller(ObservasiController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/show/{data}', 'show')->name('.show');
                            Route::delete('/{id}', 'destroy')->name('.destroy');
                            // Route::get('/print', 'print')->name('.print');
                            Route::get('/print-html', 'print')->name('.print');
                        });
                    });
                });


                //Pengawasan
                Route::prefix('pengawasan-perinatology')->group(function () {
                    Route::name('.pengawasan-perinatology')->group(function () {
                        Route::controller(PengawasanController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create-pengawasan-perinatology', 'createPengawasanPerinatology')->name('.create-pengawasan-perinatology');
                            Route::post('/store-pengawasan-perinatology', 'storePengawasanPerinatology')->name('.store-pengawasan-perinatology');
                            Route::get('/edit-pengawasan-perinatology/{id}', 'editPengawasanPerinatology')->name('.edit-pengawasan-perinatology');
                            Route::put('/update-pengawasan-perinatology/{id}', 'updatePengawasanPerinatology')->name('.update-pengawasan-perinatology');
                            Route::delete('/destroy-pengawasan-perinatology/{id}', 'destroyPengawasanPerinatology')->name('.destroy-pengawasan-perinatology');
                            Route::get('/print-pengawasan-perinatology', 'printPengawasanPerinatology')->name('.print-pengawasan-perinatology');
                        });
                    });
                });

                // PAPS
                Route::prefix('paps')->group(function () {
                    Route::name('.paps')->group(function () {
                        Route::controller(PapsController::class)->group(function () {
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

                // Meninggalkan Perawatan
                Route::prefix('meninggalkan-perawatan')->group(function () {
                    Route::name('.meninggalkan-perawatan')->group(function () {
                        Route::controller(MeninggalkanPerawatanController::class)->group(function () {
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

                // Rohani
                Route::prefix('rohani')->group(function () {
                    Route::name('.rohani')->group(function () {
                        Route::controller(PelayananRohaniController::class)->group(function () {
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

                // Privasi dan Keamanan
                Route::prefix('privasi')->group(function () {
                    Route::name('.privasi')->group(function () {
                        Route::controller(PermintaanPrivasiController::class)->group(function () {
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
                Route::prefix('penundaan')->group(function () {
                    Route::name('.penundaan')->group(function () {
                        Route::controller(PenundaanPelayananController::class)->group(function () {
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
                Route::prefix('dnr')->group(function () {
                    Route::name('.dnr')->group(function () {
                        Route::controller(PenolakanResusitasiController::class)->group(function () {
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
                        Route::controller(PersetujuanAnestesiController::class)->group(function () {
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

                // Kontrol Istimewwa
                Route::prefix('kontrol-istimewa')->group(function () {
                    Route::name('.kontrol-istimewa')->group(function () {
                        Route::controller(KontrolIstimewaController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/show/{data}', 'show')->name('.show');
                            Route::delete('/', 'delete')->name('.delete');
                            Route::post('/pdf', 'pdf')->name('.pdf');
                        });
                    });
                });

                Route::prefix('kontrol-istimewa-jam')->group(function () {
                    Route::name('.kontrol-istimewa-jam')->group(function () {
                        Route::controller(KontrolIstimewaJamController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/show/{data}', 'show')->name('.show');
                            Route::delete('/', 'delete')->name('.delete');
                            Route::post('/pdf', 'pdf')->name('.pdf');
                        });
                    });
                });

                // Pengawasan Transportasi
                Route::prefix('pengawasan-transportasi')->group(function () {
                    Route::name('.pengawasan-transportasi')->group(function () {
                        Route::controller(PengawasanTransportasiController::class)->group(function () {
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

                //Kriteria Masuk/Keluar Intensive
                Route::prefix('kriteria-masuk-keluar')->group(function () {
                    Route::name('.kriteria-masuk-keluar')->group(function () {

                        //ICU
                        Route::prefix('icu')->group(function () {
                            Route::name('.icu')->group(function () {
                                Route::controller(MasukKeluarIcuController::class)->group(function () {
                                    //masuk
                                    Route::prefix('masuk')->group(function () {
                                        Route::name('.masuk')->group(function () {
                                            Route::get('/', 'index')->name('.index');
                                            Route::get('/create', 'createMasuk')->name('.create');
                                            Route::post('/', 'storeMasuk')->name('.store');
                                            Route::get('/{data}/edit', 'editMasuk')->name('.edit');
                                            Route::put('/{data}', 'updateMasuk')->name('.update');
                                            Route::get('/show/{data}', 'showMasuk')->name('.show');
                                            Route::delete('/{data}', 'destroyMasuk')->name('.destroy');
                                            Route::get('/print/{data}', 'printMasuk')->name('.print');
                                        });
                                    });

                                    //keluar
                                    Route::prefix('keluar')->group(function () {
                                        Route::name('.keluar')->group(function () {
                                            Route::get('/', 'index')->name('.index');
                                            Route::get('/create', 'createKeluar')->name('.create');
                                            Route::post('/', 'storeKeluar')->name('.store');
                                            Route::get('/{data}/edit', 'editKeluar')->name('.edit');
                                            Route::put('/{data}', 'updateKeluar')->name('.update');
                                            Route::get('/show/{data}', 'showKeluar')->name('.show');
                                            Route::delete('/{data}', 'destroyKeluar')->name('.destroy');
                                            Route::get('/print/{data}', 'printKeluar')->name('.print');
                                        });
                                    });
                                });
                            });
                        });

                        //ICCU
                        Route::prefix('iccu')->group(function () {
                            Route::name('.iccu')->group(function () {
                                Route::controller(MasukKeluarIccuController::class)->group(function () {
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

                        //PICU
                        Route::prefix('picu')->group(function () {
                            Route::name('.picu')->group(function () {
                                Route::controller(MasukKeluarPicuController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/detail', 'show')->name('.show'); // Changed to '/detail'
                                    Route::get('/edit', 'edit')->name('.edit'); // Changed to '/edit'
                                    Route::put('/', 'update')->name('.update'); // Kept as '/' to match 'store'
                                    Route::get('/print', 'printPdf')->name('.print');
                                    Route::delete('/', 'destroy')->name('.destroy'); // Kept as '/'
                                });
                            });
                        });

                        //NICU
                        Route::prefix('nicu')->group(function () {
                            Route::name('.nicu')->group(function () {
                                Route::controller(MasukKeluarNicuController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::get('/detail', 'show')->name('.show'); // Changed to '/detail'
                                    Route::get('/edit', 'edit')->name('.edit'); // Changed to '/edit'
                                    Route::put('/', 'update')->name('.update'); // Kept as '/' to match 'store'
                                    Route::get('/print', 'printPdf')->name('.print');
                                    Route::delete('/', 'destroy')->name('.destroy'); // Kept as '/'
                                });
                            });
                        });
                    });
                });

                // MPP
                Route::prefix('mpp')->group(function () {
                    Route::name('.mpp')->group(function () {
                        //FORM A
                        Route::prefix('form-a')->group(function () {
                            Route::name('.form-a')->group(function () {
                                Route::controller(MppAController::class)->group(function () {
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
                                Route::controller(MppBController::class)->group(function () {
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

                //Surat Kematian
                Route::prefix('surat-kematian')->group(function () {
                    Route::name('.surat-kematian')->group(function () {
                        Route::controller(RawatInapSuratKematianController::class)->group(function () {
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


                //Gizi
                Route::prefix('gizi')->group(function () {
                    Route::name('.gizi')->group(function () {

                        Route::prefix('anak')->group(function () {
                            Route::name('.anak')->group(function () {
                                Route::controller(GiziAnakController::class)->group(function () {
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
                                Route::controller(GiziDewasaController::class)->group(function () {
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
                                Route::controller(GiziMonitoringController::class)->group(function () {
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

                // Resiko Jatuh
                Route::prefix('resiko-jatuh')->group(function () {
                    Route::name('.resiko-jatuh')->group(function () {

                        //Skala Morse
                        Route::prefix('morse')->group(function () {
                            Route::name('.morse')->group(function () {
                                Route::controller(RawatInapSkalaMorseController::class)->group(function () {
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
                                Route::controller(SkalaHumptyDumptyController::class)->group(function () {
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
                                Route::controller(SkalaGeriatriController::class)->group(function () {
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
                                Route::controller(SkalaNumerikController::class)->group(function () {
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
                        Route::controller(RawatInapStatusFungsionalController::class)->group(function () {
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
                        Route::controller(ResikoDecubitusController::class)->group(function () {
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
                        Route::controller(RawatInapPersetujuanTransfusiDarahController::class)->group(function () {
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
                        Route::controller(RawatInapCovid19Controller::class)->group(function () {
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

                // Form Transfer Pasien Antar Ruang
                Route::prefix('transfer-pasien-antar-ruang')->group(function () {
                    Route::name('.transfer-pasien-antar-ruang')->group(function () {
                        Route::controller(RawatInapTransferPasienAntarRuang::class)->group(function () {

                            //transfer to penunjang
                            Route::prefix('penunjang')->group(function () {
                                Route::name('.penunjang')->group(function () {
                                    Route::get('/', 'transferPenunjang')->name('.index');
                                    Route::post('/', 'storeTransferPenunjang')->name('.store');
                                });
                            });


                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                            Route::get('/create', 'create')->name('.create');
                            Route::post('/check-duplicate', 'checkDuplicate')->name('.check-duplicate');
                            Route::post('/get-kamar-ruang-ajax', 'getKamarByRuang')->name('.get-kamar-ruang-ajax');
                            Route::post('/get-sisa-bed-ajax', 'getSisaBedByKamar')->name('.get-sisa-bed-ajax');
                            Route::get('/{data}', 'show')->name('.show');
                            Route::get('/{data}/edit', 'edit')->name('.edit');
                            Route::put('/{data}', 'update')->name('.update');
                            Route::get('/{id}/print-pdf', 'generatePDF')->name('.print-pdf');
                            Route::delete('/{data}', 'destroy')->name('.destroy');
                        });
                    });
                });

                //Surveilans ppi
                Route::prefix('surveilans-ppi')->group(function () {
                    Route::name('.surveilans-ppi')->group(function () {

                        //A1
                        Route::prefix('a1')->group(function () {
                            Route::name('.a1')->group(function () {
                                Route::controller(SurveilansA1Controller::class)->group(function () {
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

                        //A2
                        Route::prefix('a2')->group(function () {
                            Route::name('.a2')->group(function () {
                                Route::controller(SurveilansA2Controller::class)->group(function () {
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

                //pneumonia
                Route::prefix('pneumonia')->group(function () {
                    Route::name('.pneumonia')->group(function () {

                        Route::prefix('psi')->group(function () {
                            Route::name('.psi')->group(function () {
                                Route::controller(PneumoniaPsiController::class)->group(function () {
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


                        Route::prefix('curb-65')->group(function () {
                            Route::name('.curb-65')->group(function () {
                                Route::controller(PneumoniaCurb65Controller::class)->group(function () {
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

                // Echocardiography
                Route::prefix('echocardiography')->group(function () {
                    Route::name('.echocardiography')->group(function () {
                        Route::controller(RawatInapEchocardiographyController::class)->group(function () {
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
                        Route::controller(RawatInapAudiometriController::class)->group(function () {
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

                // Order Hemodialisa
                Route::prefix('order-hd')->group(function () {
                    Route::name('.order-hd')->group(function () {
                        Route::controller(OrderHemodialisaController::class)->group(function () {
                            Route::get('/', 'index')->name('.index');
                            Route::post('/', 'store')->name('.store');
                        });
                    });
                });

                // Informed Consent
                Route::prefix('operasi-ibs')->group(function () {
                    Route::name('.operasi-ibs')->group(function () {
                        Route::controller(OperasiIBSController::class)->group(function () {
                            Route::get('/product-details', 'productDetails')
                                ->name('.product-details');
                            Route::get('/', 'index')->name('.index');
                            Route::get('/create', 'create')->name('.create');
                            Route::get('/{tgl_op}/{jam_op}/edit', 'edit')->name('.edit');
                            Route::get('/{tgl_op}/{jam_op}/show', 'show')->name('.show');
                            Route::post('/', 'store')->name('.store');
                            Route::put('/{tgl_op}/{jam_op}', 'update')->name('.update');
                            Route::delete('/{tgl_op}/{jam_op}', 'delete')->name('.delete');
                        });
                    });
                });

                Route::prefix('operasi/{tgl_op}/{jam_op}')->group(function () {
                    Route::name('.operasi')->group(function () {
                        Route::controller(OrderOKController::class)->group(function () {
                            Route::get('/show', 'show')->name('.show');
                        });
                        Route::prefix('pra-operatif-perawat')->group(function () {
                            Route::name('.asesmen.pra-operatif-perawat')->group(function () {
                                Route::controller(AsesmenPraOperatifPerawatController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/{data}', 'show')->name('.show');
                                    Route::get('/{data}/edit', 'edit')->name('.edit');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::delete('/{data}', 'destroy')->name('.destroy');
                                });
                            });
                        });
                        Route::prefix('site-marking')->group(function () {
                            Route::name('.site-marking')->group(function () {
                                Route::controller(SiteMarkingController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::get('/create', 'create')->name('.create');
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/{id}', 'show')->name('.show');
                                    Route::get('/{id}/edit', 'edit')->name('.edit');
                                    Route::put('/{id}', 'update')->name('.update');
                                    Route::delete('/{id}', 'destroy')->name('.destroy');
                                    Route::get('/print/{id}', 'print')->name('.print');
                                });
                            });
                        });
                    });
                });

                // TRIASE IGD
                Route::prefix('triase')->group(function () {
                    Route::name('.triase')->group(function () {
                        Route::controller(TriaseController::class)->group(function () {
                            Route::get('/show', 'show')->name('.show');
                            Route::get('/print-pdf', 'printPDF')->name('.print-pdf');
                        });
                    });
                });
            });
        });
    });
});

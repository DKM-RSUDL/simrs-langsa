<?php

use App\Http\Controllers\Auth\SsoController;
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
use App\Http\Controllers\TransfusiDarah\PermintaanController;
use App\Http\Controllers\UnitPelayanan\Forensik\ForensikKlinikController;
use App\Http\Controllers\UnitPelayanan\Forensik\ForensikPatologiController;
use App\Http\Controllers\UnitPelayanan\Forensik\ForensikVisumOtopsiController;
use App\Http\Controllers\UnitPelayanan\Forensik\VisumExitController as ForensikVisumExitController;
use App\Http\Controllers\UnitPelayanan\Forensik\VisumHidupController as ForensikVisumHidupController;
use App\Http\Controllers\UnitPelayanan\ForensikController;
// action gawat darurat
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
use App\Http\Controllers\UnitPelayanan\Operasi\AsesmenController as OperasiAsesmenController;
use App\Http\Controllers\UnitPelayanan\Operasi\CeklistAnasthesiController;
use App\Http\Controllers\UnitPelayanan\Operasi\CeklistKeselamatanController;
use App\Http\Controllers\UnitPelayanan\Operasi\EdukasiAnestesiController;
use App\Http\Controllers\UnitPelayanan\Operasi\LaporanAnastesiController;
use App\Http\Controllers\UnitPelayanan\Operasi\LaporanOperatifController;
use App\Http\Controllers\UnitPelayanan\Operasi\PraAnestesiMedisController;
use App\Http\Controllers\UnitPelayanan\Operasi\LaporanOperasiController;
use App\Http\Controllers\UnitPelayanan\Operasi\PraAnestesiPerawatController;
use App\Http\Controllers\UnitPelayanan\Operasi\SiteMarkingController;
use App\Http\Controllers\UnitPelayanan\OperasiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenGeriatriController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenGinekologikController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepAnakController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepOpthamologyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepThtController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenObstetriMaternitas;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepPerinatologyController;
use App\Http\Controllers\UnitPelayanan\RawatInap\AsesmenKepUmumController;
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
use App\Http\Controllers\UnitPelayanan\RawatInap\PneumoniaCurb65Controller;
use App\Http\Controllers\UnitPelayanan\RawatInap\PneumoniaPsiController;
use App\Http\Controllers\UnitPelayanan\RawatInap\SurveilansA1Controller;
use App\Http\Controllers\UnitPelayanan\RawatInap\SurveilansA2Controller;
use App\Http\Controllers\UnitPelayanan\RawatInapController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\ResikoJatuh\SkalaGeriatriController as RawatJalanSkalaGeriatriController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\ResikoJatuh\SkalaHumptyDumptyController as RawatJalanSkalaHumptyDumptyController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\ResikoJatuh\SkalaMorseController as RawatJalanSkalaMorseController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenController as RawatJalanAsesmenController;
use App\Http\Controllers\UnitPelayanan\RawatJalan\AsesmenGeriatriController as RawatJalanAsesmenGeriatriController;
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
use App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan\LayananController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\PelayananRehabMedisController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\RehabMedisController;
use App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan\TindakanController as RehamMedisTindakanController;
use App\Http\Middleware\AssignAdminPermissions;
use App\Http\Middleware\CheckUnitAccess;

Auth::routes(['register' => false]); // Nonaktifkan register



// Auth::routes();



Auth::routes();
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });

    Route::get('/login', [SsoController::class, 'redirectToSso'])->name('login');
    Route::get('/callback', [SsoController::class, 'handleCallback'])->name('callback');
});


Route::middleware('ssoToken')->group(function () {

    // Route::middleware('auth')->group(function () {

    Route::get('/user-sso', [SsoController::class, 'getUser']);
    Route::get('/logout', [SsoController::class, 'logout'])->name('logout');

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
                                        Route::get('/search-obat', 'searchObat')->name('.searchObat');
                                        Route::post('/catatanObat', 'catatanObat')->name('.catatanObat');
                                        Route::put('/catatanObat/validasi', 'validasiCatatanObat')->name('.catatanObat.validasi');
                                        Route::delete('/catatanObat/{id}', 'hapusCatatanObat')->name('.hapusCatatanObat');
                                        Route::post('/rekonsiliasiObat', 'rekonsiliasiObat')->name('.rekonsiliasiObat');
                                        Route::delete('/deleteRekonsiliasiObat', 'deleteRekonsiliasiObat')->name('.rekonsiliasiObatDelete');
                                    });
                                });
                            });

                            // resume
                            Route::prefix('rawat-inap-resume')->group(function () {
                                Route::name('.rawat-inap-resume')->group(function () {
                                    Route::controller(RawatInapResumeController::class)->group(function () {
                                        Route::get('/', 'index')->name('.index');
                                        Route::post('/validasi', 'validasiResume')->name('.validasi');
                                        Route::put('/{id}', 'update')->name('.update');
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

                                        });
                                    });

                                    Route::prefix('keperawatan')->group(function () {
                                        Route::name('.keperawatan')->group(function () {


                                            Route::prefix('umum')->group(function () {
                                                Route::name('.umum')->group(function () {
                                                    Route::controller(AsesmenKepUmumController::class)->group(function () {
                                                        Route::get('/', 'index')->name('.index');
                                                        Route::post('/', 'store')->name('.store');
                                                        Route::get('/{id}', 'show')->name('.show');
                                                        Route::get('/{id}/edit', 'edit')->name('.edit');
                                                        Route::put('/{id}', 'update')->name('.update');
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
                        });
                    });
                });
            });
        });

        // Rute untuk Gawat Darurat
        Route::middleware(['check.igd'])->group(function () {

            Route::prefix('gawat-darurat')->group(function () {
                Route::get('/', [GawatDaruratController::class, 'index'])->name('gawat-darurat.index');
                Route::get('/triase', [GawatDaruratController::class, 'triaseIndex'])->name('gawat-darurat.triase');
                Route::post('/store-triase', [GawatDaruratController::class, 'storeTriase'])->name('gawat-darurat.store-triase');
                Route::post('/get-patient-bynik-ajax', [GawatDaruratController::class, 'getPatientByNikAjax'])->name('gawat-darurat.get-patient-bynik-ajax');
                Route::post('/get-patient-bynama-ajax', [GawatDaruratController::class, 'getPatientByNamaAjax'])->name('gawat-darurat.get-patient-bynama-ajax');
                Route::post('/get-patient-byalamat-ajax', [GawatDaruratController::class, 'getPatientByAlamatAjax'])->name('gawat-darurat.get-patient-byalamat-ajax');
                Route::post('/get-triase-data', [GawatDaruratController::class, 'getTriaseData'])->name('gawat-darurat.get-triase-data');
                Route::put('/ubah-foto-triase/{kdKasir}/{noTrx}', [GawatDaruratController::class, 'updateFotoTriase'])->name('gawat-darurat.ubah-foto-triase');

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
                                    Route::post('/validasi', 'validasiResume')->name('.validasi');
                                    Route::get('/{data}/pdf', 'pdf')->name('.pdf');
                                });
                            });
                        });
                    });
                });
            });
        });

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



        // // Rute Untuk Forensik
        // Route::prefix('forensik')->group(function () {
        //     Route::name('forensik')->group(function () {
        //         Route::get('/', [ForensikController::class, 'index'])->name('.index');

        //         Route::prefix('unit/{kd_unit}')->group(function () {
        //             Route::name('.unit')->group(function () {
        //                 Route::get('/', [ForensikController::class, 'unitPelayanan']);

        //                 //Pelayanan
        //                 Route::prefix('pelayanan/{kd_pasien}/{tgl_masuk}/{urut_masuk}')->group(function () {
        //                     Route::name('.pelayanan')->group(function () {
        //                         Route::get('/', [ForensikController::class, 'pelayanan']);
        //                         // klinik
        //                         Route::controller(ForensikKlinikController::class)->group(function () {
        //                             Route::get('/create', 'create')->name('.create');
        //                             Route::get('/{data}', 'show')->name('.show');
        //                             Route::get('/edit/{data}', 'edit')->name('.edit');
        //                             Route::post('/', 'store')->name('.store');
        //                             Route::put('/{data}', 'update')->name('.update');
        //                             Route::delete('/', 'destroy')->name('.destroy');
        //                         });

        //                         // patologi
        //                         Route::prefix('patologi')->group(function () {
        //                             Route::name('.patologi')->group(function () {
        //                                 Route::controller(ForensikPatologiController::class)->group(function () {
        //                                     Route::get('/create', 'index')->name('.create');
        //                                     Route::get('/{data}', 'show')->name('.show');
        //                                     Route::get('/edit/{data}', 'edit')->name('.edit');
        //                                     Route::post('/', 'store')->name('.store');
        //                                     Route::put('/{data}', 'update')->name('.update');
        //                                     Route::delete('/', 'destroy')->name('.destroy');
        //                                 });
        //                             });
        //                         });
        //                     });
        //                 });
        //             });
        //         });
        //     });
        // });


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


                        //LAPORAN ANASTESI
                        Route::prefix('laporan-anastesi')->group(function () {
                            Route::name('.laporan-anastesi')->group(function () {
                                Route::controller(LaporanAnastesiController::class)->group(function () {
                                    Route::get('/', 'index')->name('.index');
                                    Route::get('/create', 'create')->name('.create');
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
                                    Route::post('/', 'store')->name('.store');
                                    Route::get('/edit/{data}', 'edit')->name('.edit');
                                    Route::put('/{data}', 'update')->name('.update');
                                    Route::get('/{data}', 'show')->name('.show');
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
    });

    // TRANSFUSI DARAH
    Route::prefix('transfusi-darah')->group(function () {
        Route::name('transfusi-darah')->group(function () {
            Route::controller(PermintaanController::class)->group(function () {
                // PERMINTAAN
                Route::prefix('permintaan')->group(function () {
                    Route::name('.permintaan')->group(function () {
                        Route::get('/', 'index')->name('.index');
                        Route::get('/datatables', 'datatable')->name('.datatable');
                        Route::get('/show/{data}', 'show')->name('.show');
                        Route::put('/proses/{data}', 'prosesOrder')->name('.proses');
                        Route::put('/pemeriksaan/{data}', 'updatePemeriksaan')->name('.pemeriksaan');
                        Route::post('/handover/{data}', 'handOver')->name('.handover');
                        Route::get('/selesai/{data}', 'completeProcess')->name('.selesai');
                        Route::get('/hapus-darah/{data}', 'deleteDarah')->name('.delete-darah');
                    });
                });
            });
        });
    });
});

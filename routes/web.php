<?php

use App\Http\Controllers\Auth\SsoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// unit pelanayan
use App\Http\Controllers\TransfusiDarah\PermintaanController;

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
        require __DIR__ . '/modules/rawat-jalan.php';

        // Rute untuk Rawat Inap
        require __DIR__ . '/modules/rawat-inap.php';

        // Rute untuk Gawat Darurat
        require __DIR__ . '/modules/gawat-darurat.php';

        // Rute untuk Forensik
        require __DIR__ . '/modules/forensik.php';

        // Rute untuk Rehab Medik
        require __DIR__ . '/modules/rehab-medis.php';

        // Rute untuk Operasi
        require __DIR__ . '/modules/operasi.php';

        // Rute untuk Operasi
        require __DIR__ . '/modules/hemodelisa.php';


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

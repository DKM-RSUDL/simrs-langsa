<?php

use App\Http\Controllers\Auth\SsoController;
use App\Http\Controllers\Bridging\Bpjs\BpjsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanBerkasController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransfusiDarah\PermintaanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
// unit pelanayan
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]); // Nonaktifkan register
// Auth::routes();
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/login', [SsoController::class, 'redirectToSso'])->name('login');
    Route::get('/callback', [SsoController::class, 'handleCallback'])->name('callback');
});

// Keep session alive
Route::get('/keep-alive', function () {
    return response()->json([
        'token' => csrf_token(),
        'status' => 'alive',
        'time' => now()->toDateTimeString(),
    ]);
})->middleware('web');

// Refresh CSRF token
Route::get('/refresh-csrf', function () {
    return response()->json([
        'token' => csrf_token(),
    ]);
})->middleware('web');

Route::middleware('ssoToken')->group(function () {

    // Route::middleware('auth')->group(function () {

    Route::get('/user-sso', [SsoController::class, 'getUser']);
    Route::get('/logout', [SsoController::class, 'logout'])->name('logout');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('navigation', NavigationController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);

    // Grup rute untuk Unit Pelayanan\
    Route::prefix('unit-pelayanan')->group(function () {
        // Rute untuk Rawat Jalan
        require __DIR__.'/modules/rawat-jalan.php';

        // Rute untuk Rawat Inap
        require __DIR__.'/modules/rawat-inap.php';

        // Rute untuk Gawat Darurat
        require __DIR__.'/modules/gawat-darurat.php';

        // Rute untuk Forensik
        require __DIR__.'/modules/forensik.php';

        // Rute untuk Rehab Medik
        require __DIR__.'/modules/rehab-medis.php';

        // Rute untuk Operasi
        require __DIR__.'/modules/operasi.php';

        // Rute untuk Operasi
        require __DIR__.'/modules/hemodelisa.php';
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

    Route::prefix('laporan-berkas')->group(function () {
        Route::name('laporan-berkas')->group(function () {
            Route::controller(LaporanBerkasController::class)->group(function () {
                Route::get('/', 'index')->name('.index');
            });
        });
    });

    // BPJS
    Route::prefix('bpjs')->group(function () {
        Route::name('bpjs')->group(function () {
            Route::controller(BpjsController::class)->group(function () {
                Route::post('/icare', 'icare')->name('.icare');
            });
            Route::controller(BpjsController::class)->group(function () {
                Route::get('/vclaim/{identifier}', 'vclaim')->name('.vclaim');
            });
        });
    });
});

<?php

use App\Http\Controllers\BerkasDigital\BerkasDigitalController;
use App\Http\Controllers\BerkasDigital\MasterBerkasController;
use App\Http\Controllers\BerkasDigital\SettingBerkasController;
use Illuminate\Support\Facades\Route;


// MASTER
Route::prefix('master')->name('master')->group(function () {
    Route::controller(MasterBerkasController::class)->group(function () {
        Route::get('/', 'index')->name('.index');
        Route::post('/store', 'store')->name('.store');
        Route::put('/update/{id}', 'update')->name('.update');
        Route::delete('/destroy/{id}', 'destroy')->name('.destroy');
    });
});


// SETTING
Route::prefix('setting')->name('setting.')->group(function () {
    Route::controller(SettingBerkasController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::put('/update/{id}', 'update')->name('update');
    });
});

// BERKAS DIGITAL
Route::prefix('dokumen')->name('dokumen.')->group(function () {
    Route::controller(BerkasDigitalController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});

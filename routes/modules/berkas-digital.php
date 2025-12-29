<?php

use App\Http\Controllers\BerkasDigital\MasterBerkasController;
use App\Http\Controllers\BerkasDigital\SettingBerkasController;
use Illuminate\Support\Facades\Route;

Route::prefix('master')->name('.master')->group(function () {
    Route::controller(MasterBerkasController::class)->group(function () {
        Route::get('/', 'index')->name('.index');
    });
});


Route::prefix('setting')->name('setting.')->group(function () {
    Route::controller(SettingBerkasController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::put('/update/{id}', 'update')->name('update');
    });
});

<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::controller(OrderController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::patch('/update', 'update')->name('update');
    Route::delete('/delete', 'delete')->name('delete');

    Route::post('/fill-db', 'fillDb')->name('fillDb');
    Route::post('/clear-db', 'clearDb')->name('clearDb');

    Route::post('/clear-google-sheet', 'clearGoogleSheet')->name('clearGoogleSheet');
    Route::get('/write-table', 'writeTable');

    Route::get('/fetch/{count?}', 'fetch')->name('fetch');
});

Route::post('/set-google-sheet-url', [SettingsController::class, 'setGoogleSheetUrl'])->name('setGoogleSheetUrl');

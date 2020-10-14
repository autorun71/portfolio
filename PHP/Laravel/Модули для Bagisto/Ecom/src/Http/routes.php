<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {

        Route::prefix('ecom')->group(function () {
            Route::get('', function () {
                return redirect()->route('admin.ecom.import');
            })->name('admin.ecom.import');

            Route::prefix('imports')->group(function () {
                Route::get('', 'Webkul\Ecom\Http\Controllers\ImportController@index')->defaults('_config', [
                    'view' => 'ecom::import.index'
                ])->name('admin.ecom.import');
            });

            Route::prefix('type')->group(function () {
                Route::get('', 'Webkul\Ecom\Http\Controllers\ImportTypeController@index')->defaults('_config', [
                    'view' => 'ecom::import-type.index'
                ])->name('admin.ecom.type');
            });

            Route::prefix('interval')->group(function () {
                Route::get('', 'Webkul\Ecom\Http\Controllers\ImportIntervalController@index')->defaults('_config', [
                    'view' => 'ecom::interval.index'
                ])->name('admin.ecom.interval');
            });

        });


    });
});

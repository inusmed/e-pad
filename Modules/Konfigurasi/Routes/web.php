<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'language'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'konfigurasi', 'namespace' => 'SKPD'], function () {
            Route::get('skpd/bidang', 'Bidang@index');
            Route::get('skpd/satuan-kerja/{company_id}', 'Satker@index');

            Route::get('kepegawaian', 'Kepegawaian@index');
        });
    });
});
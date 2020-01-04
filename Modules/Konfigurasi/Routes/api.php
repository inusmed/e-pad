<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1/konfigurasi'], function () {
    Route::group(['middleware' => 'auth:api', 'namespace' => 'Api\V1'], function() {
        Route::group(['middleware' => 'auth:api', 'namespace' => 'SKPD'], function() {
            Route::post('skpd/bidang/{company}', 'Bidang@index');
            Route::get('skpd/bidang/{company}/urusan/{urusan}/bidang/{id}', 'Bidang@get');

            Route::post('skpd/satuan-kerja/{company}/urusan/{urusan}/bidang/{bidang}', 'Satker@index');
            Route::get('skpd/satuan-kerja/{company}/urusan/{urusan}/bidang/{bidang_id}/satker/{id}', 'Satker@get');

            Route::post('pegawai/{company}', 'Kepegawaian@index');
        });
    });
});
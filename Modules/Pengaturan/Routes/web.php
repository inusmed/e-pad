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
        Route::group(['prefix' => 'pengaturan'], function () {
            Route::group(['namespace' => 'MataAnggaran'], function () {
                Route::get('mata-anggaran/grup-akun', 'Grup@index');

                Route::get('mata-anggaran/kategori-akun/{company_id}', 'Kategori@index');
                Route::get('mata-anggaran/kategori-akun/create/{company_id}', 'Kategori@create');
                Route::get('mata-anggaran/kategori-akun/edit/{company_id}', 'Kategori@edit');

                Route::get('mata-anggaran/subkategori-akun/{company_id}', 'Subkategori@index');
                Route::get('mata-anggaran/subkategori-akun/create/{company_id}', 'Subkategori@create');
                Route::get('mata-anggaran/subkategori-akun/edit/{company_id}', 'Subkategori@edit');

                Route::get('mata-anggaran/subrekening-akun/{company_id}', 'SubRekening@index');
                Route::get('mata-anggaran/subrekening-akun/create/{company_id}', 'SubRekening@create');
                Route::get('mata-anggaran/subrekening-akun/edit/{company_id}', 'SubRekening@edit');

                Route::get('mata-anggaran/rekening-akun/{company_id}', 'Rekening@index');
                Route::get('mata-anggaran/rekening-akun/create/{company_id}', 'Rekening@create');
                Route::get('mata-anggaran/rekening-akun/edit/{company_id}', 'Rekening@edit');
            });
        });
    });
});
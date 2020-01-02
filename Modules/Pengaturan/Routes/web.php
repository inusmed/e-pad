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

            Route::group(['namespace' => 'JenisPendapatan'], function () {
                Route::get('jenis-pendapatan', 'Pendapatan@index');
                Route::get('jenis-pendapatan/create', 'Pendapatan@create');
                Route::get('jenis-pendapatan/show/{company_id}', 'Pendapatan@show');
                Route::get('jenis-pendapatan/edit/{company_id}', 'Pendapatan@edit');

                Route::get('grup-pendapatan', 'GrupPendapatan@index');

                Route::get('tarif-omzet', 'TarifOmzet@index');
                Route::get('tarif-omzet/create', 'TarifOmzet@create');
                Route::get('tarif-omzet/filter/{company}', 'TarifOmzet@filter');
                Route::get('tarif-omzet/edit/{company}/{uuid}', 'TarifOmzet@edit');

                Route::get('tarif-usaha', 'TarifUsaha@index');
                Route::get('tarif-usaha/create', 'TarifUsaha@create');
                Route::get('tarif-usaha/filter/{company}', 'TarifUsaha@filter');
                Route::get('tarif-usaha/edit/{company}/{uuid}', 'TarifUsaha@edit');
            });
        });
    });
});
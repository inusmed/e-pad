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
Route::group(['prefix' => 'v1/pengaturan'], function () {
    Route::get('mata-anggaran/refreshCaptcha', function() {
        return captcha_src();
    });
    Route::group(['middleware' => 'auth:api', 'namespace' => 'Api\V1'], function() {
        Route::group(['middleware' => 'auth:api'], function() {

            Route::group(['namespace' => 'MataAnggaran'], function() {
                Route::post('mata-anggaran/grup-list', 'Grup@datatable');
                Route::get('mata-anggaran/grup/{company}/{uuid}', 'Grup@get');
                Route::get('mata-anggaran/grup/{company}/grup/{grup}/list-grup', 'Grup@lists');

                Route::post('mata-anggaran/kategori', 'Kategori@store');
                Route::delete('mata-anggaran/kategori', 'Kategori@destroy');
                Route::patch('mata-anggaran/kategori/{company}/{grup}/{uuid}', 'Kategori@update');
                Route::get('mata-anggaran/kategori/{company}/grup/{grup}/uuid/{uuid}', 'Kategori@get');
                Route::get('mata-anggaran/kategori/{company}/grup/{group}/list-kategori', 'Kategori@lists');
                Route::post('mata-anggaran/kategori/{company}/grup/{group}', 'Kategori@datatable');


                Route::post('mata-anggaran/subkategori', 'Subkategori@store');
                Route::delete('mata-anggaran/subkategori', 'Subkategori@destroy');
                Route::patch('mata-anggaran/subkategori/{company}/grup/{grup}/kategori/{kategori}/uuid/{uuid}', 'Subkategori@update');
                Route::get('mata-anggaran/subkategori/{v}/grup/{grup}/kategori/{kategori}/uuid/{uuid}', 'Subkategori@get');
                Route::get('mata-anggaran/subkategori/{company}/grup/{group}/kategori/{kategori}/list-subkategori', 'Subkategori@lists');
                Route::post('mata-anggaran/subkategori/{company}/grup/{group}/kategori/{kategori}', 'Subkategori@datatable');

                Route::post('mata-anggaran/subrekening', 'SubRekening@store');
                Route::delete('mata-anggaran/subrekening', 'SubRekening@destroy');
                Route::patch('mata-anggaran/subrekening/{company}/pajak/{pajak}/grup/{grup}/kategori/{kategori}/subkategori/{subkategori}/uuid/{uuid}', 'SubRekening@update');
                Route::get('mata-anggaran/subrekening/{company}/pajak/{pajak}/grup/{grup}/kategori/{kategori}/subkategori/{subkategori}/uuid/{uuid}', 'SubRekening@get');
                Route::get('mata-anggaran/subrekening/{company}/grup/{group}/kategori/{kategori}/subkategori/{subkategori}/list-subrekening', 'SubRekening@lists');
                Route::get('mata-anggaran/subrekening/{company}/pajak/{pajak}/grup/{group}/kategori/{kategori}/subkategori/{subkategori}/list-subrekening', 'SubRekening@listSubRekening');
                Route::post('mata-anggaran/subrekening/{company}/grup/{group}/kategori/{kategori}/subkategori/{subkategori}', 'SubRekening@datatable');

                Route::post('mata-anggaran/rekening', 'Rekening@store');
                Route::delete('mata-anggaran/rekening', 'Rekening@destroy');
                Route::patch('mata-anggaran/rekening/{company}/pajak/{pajak}/grup/{grup}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}/uuid/{uuid}', 'Rekening@update');
                Route::get('mata-anggaran/rekening/{company}/pajak/{pajak}/grup/{grup}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}/uuid/{uuid}', 'Rekening@get');
                Route::get('mata-anggaran/rekening/{company}/pajak/{pajak}/grup/{group}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}/list-rekening', 'Rekening@listRekening');
                Route::post('mata-anggaran/rekening/rekening-pendapatan-denda', 'Rekening@listRekeningDenda');
                Route::post('mata-anggaran/rekening/{company}/grup/{group}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}', 'Rekening@datatable');
            }); 


            Route::group(['namespace' => 'JenisPendapatan'], function() {
                Route::post('jenis-pendapatan', 'Pendapatan@datatable');
                Route::post('jenis-pendapatan/store', 'Pendapatan@store');
                Route::delete('jenis-pendapatan', 'Pendapatan@destroy');
                Route::patch('jenis-pendapatan/{company}/pajak/{pajak}/ketetapan/{ketetapan_id}/grup/{grup}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}/rekening/{rekening}/pendapatan/{pendapatan}', 'Pendapatan@update');
                Route::get('jenis-pendapatan/{company}/pajak/{pajak}/ketetapan/{ketetapan_id}/grup/{grup}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}/rekening/{rekening}/pendapatan/{pendapatan}', 'Pendapatan@get');
           
                Route::post('grup-pendapatan', 'GrupPendapatan@datatable');
                Route::post('grup-pendapatan/list-pendapatan', 'GrupPendapatan@lists');

                Route::post('tarif-omzet', 'TarifOmzet@datatable');
                Route::post('tarif-omzet/store', 'TarifOmzet@store');
                Route::delete('tarif-omzet', 'TarifOmzet@destroy');
                Route::get('tarif-omzet/{company_id}/{uuid}', 'TarifOmzet@get');
                Route::patch('tarif-omzet/{company_id}/{uuid}', 'TarifOmzet@update');

                Route::post('tarif-usaha', 'TarifUsaha@datatable');
                Route::post('tarif-usaha/store', 'TarifUsaha@store');
                Route::delete('tarif-usaha', 'TarifUsaha@destroy');
                Route::get('tarif-usaha/{company_id}/{uuid}', 'TarifUsaha@get');
                Route::patch('tarif-usaha/{company_id}/{uuid}', 'TarifUsaha@update');
            });
        });
    });
});
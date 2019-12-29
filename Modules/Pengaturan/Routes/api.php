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
                Route::post('mata-anggaran/subrekening/{company}/grup/{group}/kategori/{kategori}/subkategori/{subkategori}', 'SubRekening@datatable');

                Route::post('mata-anggaran/rekening', 'Rekening@store');
                Route::delete('mata-anggaran/rekening', 'Rekening@destroy');
                Route::patch('mata-anggaran/rekening/{company}/pajak/{pajak}/grup/{grup}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}/uuid/{uuid}', 'Rekening@update');
                Route::get('mata-anggaran/rekening/{company}/pajak/{pajak}/grup/{grup}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}/uuid/{uuid}', 'Rekening@get');
                Route::post('mata-anggaran/rekening/{company}/grup/{group}/kategori/{kategori}/subkategori/{subkategori}/subrekening/{subrekening}', 'Rekening@datatable');
            }); 
        });
    });
});
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
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('login', 'LoginController@store')->name('auth.login');
    Route::get('auth/refreshCaptcha', function() {
        return captcha_src();
    });
});

Route::group(['middleware' => 'language'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('logout', 'LoginController@destroy')->name('logout');
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::resource('roles', 'Roles');
    });
});

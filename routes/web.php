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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function(){
    return view('test.index');
});
Route::get('/regx', function(){
    return view('auth.registerx');
});

Auth::routes();
Route::group([
    'middleware'    => ['auth']
    ], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('/home', 'HomeController@store')->name('home.store');
        Route::get('/result', 'HomeController@result')->name('result.index');

        Route::get('/hasil', 'HomeController@hasil')->name('hasil.index');
        Route::get('/hasil/{group}/forecasting', 'HomeController@detail')->name('detail.index');
        
        Route::get('/hasil2/{group}/forecasting', 'HomeController@detail2')->name('detail.index');
        Route::get('/api-hasil', 'HomeController@apiResult')->name('api.result');
        Route::get('/api-hasil-detail', 'HomeController@apiDetail')->name('api.detail');

        Route::delete('/hasil/{group}', 'HomeController@deleteDetail')->name('delete_detail.destroy');

        Route::resource('/items', 'ItemController', ['except' => ['show']]);

        Route::resource('/settings', 'SettingController', ['except' => ['show','store','create','destroy']]);
        Route::post('/settings', 'SettingController@generate')->name('settings.generate');
    }
);

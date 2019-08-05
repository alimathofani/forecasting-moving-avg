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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@store')->name('home.store');
Route::get('/result', 'HomeController@result')->name('result.index');

Route::get('/hasil', 'HomeController@hasil')->name('hasil.index');
Route::get('/hasil/{group}/forecasting', 'HomeController@detail')->name('detail.index');
Route::delete('/hasil/{group}', 'HomeController@deleteDetail')->name('delete_detail.destroy');

Route::resource('/items', 'ItemController', ['except' => ['show']]);

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

Route::get('/', 'FrontController@index')->name('frontend.index');

Auth::routes();

Route::group([
    'middleware'    => ['auth']
    ], function () {
        
        Route::get('/forecasting', 'ForecastingController@index')->name('forecasting.index');
        Route::post('/forecasting', 'ForecastingController@store')->name('forecasting.store');

        Route::get('/results', 'ResultController@index')->name('result.index');
        Route::get('/results/all', 'ResultController@list')->name('result.list');
        Route::get('/results/details', 'ResultController@show')->name('result.show');
        Route::post('/results/{group}', 'ResultController@confirm')->name('result.confirm');
        Route::delete('/results/{group}/delete', 'ResultController@delete')->name('result.destroy');
        Route::get('/sales', 'SaleController@index')->name('sales.index');
        Route::post('/sales', 'SaleController@store')->name('sales.store');
        Route::get('/sales/calculate', 'SaleController@calculate')->name('sales.calculate');
    }
);

Route::group([
    'middleware'    => ['auth', 'role:owner|admin']
    ], function () {
        Route::resource('/settings', 'SettingController', ['except' => ['show','store','create','destroy']]);
        Route::resource('/items', 'ItemController', ['except' => ['show']]);
        Route::resource('users','UserController');
        Route::resource('roles','RoleController');
    }
);

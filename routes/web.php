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
Route::get('/check_files', 'IndexController@check_files');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/get_chart_data', 'HomeController@getChartData');
Route::get('/user/get_all', 'UserController@getAll');
Route::any('/log/index', 'HomeController@logs')->name('log.index');


Route::any('/user/index', 'UserController@index')->name('user.index');
Route::post('/user/create_admin', 'UserController@create_admin')->name('user.create_admin');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

Route::get('/setting/index', 'HomeController@setting')->name('setting.index');
Route::post('/setting/update', 'HomeController@setting_update')->name('setting.update');

Route::get('/notification/index', 'HomeController@notification')->name('notification.index');
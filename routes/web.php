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
Route::get('/trades', 'HomeController@Trades')->name('trades');
Route::get('/telegram/bind', 'HomeController@bindView')->name('tg-bind');
Route::post('/telegram/bind', 'HomeController@bind')->name('tg-bind');
Route::get('/balance', 'HomeController@getBalance')->name('balance');

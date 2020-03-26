<?php

use Illuminate\Http\Request;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'as' => 'api.',
    'namespace' => 'Api',
    'middleware' => 'api.auth'
],
    function () {
        Route::get('/balance', 'HomeController@getBalance')->name('balance');
        Route::post('/open-trade', 'HomeController@openTrade')->name('open-trade');
    }
);

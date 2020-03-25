<?php

use Illuminate\Http\Request;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['as' => 'api.', 'namespace' => 'Api'],
    function () {
        Route::get('/balance', 'HomeController@getBalance');
    }
);

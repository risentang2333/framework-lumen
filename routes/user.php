<?php

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

Route::group(['prefix' => 'user','namespace' => 'User'], function () {
    
    Route::post('/register', 'UserController@register');

    Route::post('/login', 'UserController@login');
});

Route::group(['prefix' => 'user','namespace' => 'User','middleware' => 'user'], function () {
    Route::get('/haha', function () {
        echo "hahah";
    });
});

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
Route::group(['prefix' => 'worker','namespace' => 'Worker'], function () {
    
    Route::post('/register', 'LoginController@register');

    Route::post('/login', 'LoginController@login');
});

Route::group(['prefix' => 'worker','namespace' => 'Worker','middleware' => 'worker'], function () {
    Route::get('/haha', function () {
        return "hahaha";
    });
});


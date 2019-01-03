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
// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });
Route::get('/', function () {
    return "hello world";
});
Route::group(['prefix' => 'permission','namespace' => 'Admin'], function () {
    // 获取菜单
    Route::get('/getMenu', 'PermissionController@getMenu');
    // 获取角色列表
    Route::get('/getRoleList', 'PermissionController@getRoleList');
    // 分配权限
    Route::post('/allotPermission', 'PermissionController@allotPermission');

    Route::get('/editPermission', 'PermissionController@editPermission');
    
});
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
    return "hello world";
});
// 管理员登录
Route::get('/login', 'LoginController@login');
// 刷新token
Route::get('/changeToken', 'LoginController@changeToken');
// 获取菜单
Route::get('/getMenu', 'PermissionController@getMenu');
// 包含中间件，添加permission路由
Route::group(['prefix' => 'permission','middleware' => 'admin'], function () {
    // 获取管理员列表
    Route::get('/getManagerList', 'PermissionController@getManagerList');
    // 编辑管理员角色绑定
    Route::get('/getManagerRole', 'PermissionController@getManagerRole');
    // 分配绑定管理员角色
    Route::post('/editManagerRole', 'PermissionController@editManagerRole');
    // 获取管理员信息
    Route::get('/getManager', 'PermissionController@getManager');

    Route::get('/editManager', 'PermissionController@editManager');
    // 获取角色列表
    Route::get('/getRoleList', 'PermissionController@getRoleList');
    // 分配权限
    Route::post('/allotPermission', 'PermissionController@allotPermission');

    Route::get('/editPermission', 'PermissionController@editPermission');

});
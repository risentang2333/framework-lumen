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
Route::post('/login', 'LoginController@login');
// 刷新token
Route::post('/changeToken', 'LoginController@changeToken');
// 包含中间件，添加permission路由
Route::group(['prefix' => 'permission','middleware' => 'admin'], function () {
    // 获取菜单
    Route::get('/getMenu', 'PermissionController@getMenu');
    // 获取管理员列表
    Route::get('/getManagerList', 'PermissionController@getManagerList');
    // 编辑管理员角色绑定
    Route::get('/getManagerRole', 'PermissionController@getManagerRole');
    // 分配绑定管理员角色
    Route::post('/editManagerRole', 'PermissionController@editManagerRole');
    // 获取管理员信息
    Route::get('/getManager', 'PermissionController@getManager');
    // 编辑管理员信息
    Route::post('/editManager', 'PermissionController@editManager');

    // 获取角色列表
    Route::get('/getRoleList', 'PermissionController@getRoleList');
    // 获取角色信息
    Route::get('/getRole', 'PermissionController@getRole');
    // 编辑角色信息
    Route::post('/editRole', 'PermissionController@editRole');
    // 获取角色权限信息
    Route::get('/getRolePermission', 'PermissionController@getRolePermission');
    // 编辑角色权限信息
    Route::post('/editRolePermission', 'PermissionController@editRolePermission');

    // 获取权限列表
    Route::get('/getPermissionList', 'PermissionController@getPermissionList');
    // 添加权限信息
    Route::get('/addPermission', 'PermissionController@addPermission');
    // 获取权限信息
    Route::get('/getPermission', 'PermissionController@getPermission');
    // 编辑权限信息
    Route::post('/editPermission', 'PermissionController@editPermission');
});
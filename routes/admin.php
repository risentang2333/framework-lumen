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
// 管理员登录
Route::post('/login', 'LoginController@login');
// 刷新token
Route::post('/changeToken', 'LoginController@changeToken');
// 权限模块
Route::group(['prefix' => 'permission', 'middleware' => ['admin']], function () {
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
    // 逻辑删除管理员
    Route::post('/deleteManager', 'PermissionController@deleteManager');
    // 获取角色列表
    Route::get('/getRoleList', 'PermissionController@getRoleList');
    // 获取角色信息
    Route::get('/getRole', 'PermissionController@getRole');
    // 编辑角色信息
    Route::post('/editRole', 'PermissionController@editRole');
    // 逻辑删除角色
    Route::post('/deleteRole', 'PermissionController@deleteRole');
    // 获取角色权限信息
    Route::get('/getRolePermission', 'PermissionController@getRolePermission');
    // 编辑角色权限信息
    Route::post('/editRolePermission', 'PermissionController@editRolePermission');
    // 获取权限列表
    Route::get('/getPermissionList', 'PermissionController@getPermissionList');
    // 获取权限信息
    Route::get('/getPermission', 'PermissionController@getPermission');
    // 编辑权限信息
    Route::post('/editPermission', 'PermissionController@editPermission');
    // 逻辑删除权限
    Route::post('/deletePermission', 'PermissionController@deletePermission');
});
// 服务人员模块
Route::group(['prefix' => 'staff', 'middleware' => ['admin']], function () {
    // 获取服务人员列表
    Route::post('/getStaffList', 'StaffController@getStaffList');
    // 获取服务人员信息
    Route::get('/getStaff', 'StaffController@getStaff');
    // 编辑服务人员信息
    Route::post('/editStaff', 'StaffController@editStaff');
    // 停用/启用服务人员
    Route::post('/changeStaffStatus', 'StaffController@changeStaffStatus');
});
// 服务项目模块
Route::group(['prefix' => 'service', 'middleware' => ['admin']], function () {
    // 获取服务项目列表
    Route::get('/getItemList', 'ServiceController@getItemList');
    // 获取服务信息
    Route::get('/getItem', 'ServiceController@getItem');
    // 编辑服务信息
    Route::post('/editItem', 'ServiceController@editItem');
    // 删除服务项目
    Route::post('/deleteItem', 'ServiceController@deleteItem');
    // 启用/停用服务
    Route::post('/changeItemType', 'ServiceController@changeItemType');
    // 获取服务分类列表
    Route::get('/getCategoryList', 'ServiceController@getCategoryList');
    // 获取服务
    Route::get('/getCategory', 'ServiceController@getCategory');
    // 编辑服务
    Route::post('/editCategory', 'ServiceController@editCategory');
    // 启用/停用服务
    Route::post('/changeCategoryType', 'ServiceController@changeCategoryType');
});
// 能力标签模块
Route::group(['prefix' => 'ability', 'middleware' => ['admin']], function () {
    // 获取能力标签列表
    Route::get('/getAbilityList', 'AbilityController@getAbilityList');
    // 获取能力标签
    Route::get('/getAbility', 'AbilityController@getAbility');
    // 编辑能力标签
    Route::post('/editAbility', 'AbilityController@editAbility');
    // 启用/停用服务
    Route::post('/changeAbilityType', 'AbilityController@changeAbilityType');
    // 删除能力标签
    Route::get('/deleteAbility', 'AbilityController@deleteAbility');
});
// 证件模块
Route::group(['prefix' => 'paper', 'middleware' => ['admin']], function () {
    // 获取能力标签列表
    Route::get('/getPaperList', 'PaperController@getPaperList');
    // 获取能力标签
    Route::get('/getPaper', 'PaperController@getPaper');
    // 编辑能力标签
    Route::post('/editPaper', 'PaperController@editPaper');
    // 启用/停用服务
    Route::post('/changePaperType', 'PaperController@changePaperType');
});
// 订单模块
Route::group(['prefix' => 'order', 'middleware' => ['admin']], function () {
    // 获取订单列表
    Route::get('/getOrderList', 'OrderController@getOrderList');
    // 获取订单
    Route::get('/getOrder', 'OrderController@getOrder');
    // 创建订单
    Route::post('/createOrder', 'OrderController@createOrder');
    // 添加候选人
    Route::post('/createOrderStaff', 'OrderController@createOrderStaff');
    // 删除候选人
    Route::post('/deleteOrderStaff', 'OrderController@deleteOrderStaff');
    // 签约
    Route::post('/sign', 'OrderController@sign');
    // 拒签
    Route::post('/refuse', 'OrderController@refuse');
    // 写普通日志
    Route::post('/writeOrderLog', 'OrderController@writeOrderLog');
    // 取消订单
    Route::post('/cancelOrder', 'OrderController@cancelOrder');
    // 完成订单
    Route::post('/completeOrder', 'OrderController@completeOrder');
    // 分配订单
    Route::post('/assignOrder', 'OrderController@assignOrder');
});
// 通用下拉框数据
Route::group(['prefix' => 'common', 'middleware' => ['admin']], function () {
    // 获取地区树
    Route::get('/getAreaTree', 'CommonController@getAreaTree');
    // 获取服务树
    Route::get('/getServiceTree', 'CommonController@getServiceTree');
    // 获取能力标签树
    Route::get('/getLabelTree', 'CommonController@getLabelTree');
    // 获取证书种类下拉数据
    Route::get('/getPaperSelection', 'CommonController@getPaperSelection');
    // 获取管理员下拉数据
    Route::get('/getManagerSelection', 'CommonController@getManagerSelection');
    // 获取权限标签树
    Route::get('/getPermissionTree', 'CommonController@getPermissionTree');
    // 上传图片
    Route::post('/uploadImage', 'CommonController@uploadImage');
});
// 获取日志模块
Route::group(['prefix' => 'log', 'middleware' => ['admin']], function () {
    // 获取日志列表
    Route::get('/getLogList', 'LogController@getLogList');

    Route::get('/excel', 'LogController@excel');
});
// 配置表单参数模块
Route::group(['prefix' => 'formConfig', 'middleware' => ['admin']], function () {
    // 获取所有可配表单项
    Route::get('/getFormConfig', 'FormConfigController@getFormConfig');
    // 编辑所有可配表单项
    Route::post('/editFormConfig', 'FormConfigController@editFormConfig');
});

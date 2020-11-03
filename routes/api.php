<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//登录退出修改密码
Route::group([
    'prefix' => 'admin'
], function ($router) {
    Route::post('login', 'Api\AuthController@login');
    Route::get('logout', 'Api\AuthController@logout');
    Route::get('refresh', 'Api\AuthController@refresh');
    Route::get('me', 'Api\AuthController@me');
    Route::put('password', 'Api\AuthController@changePassword')->name("password");
});


Route::group([
    'middleware'=>['api.auth','permission']
], function () {

    //Menu菜单
    Route::get('menu','Api\MenuController@getMenuList')->name("menu");


    //User用户
    Route::post('register', 'Api\UserController@register')->name("register");
    Route::get('user', 'Api\UserController@getUserList')->name("userList");
    Route::put('resetPassword', 'Api\UserController@resetPassword')->name("resetPassword");

    //Role角色
    Route::get('role', 'Api\RoleController@getRoleList')->name("getRoleList");
    Route::post('role', 'Api\RoleController@addRole')->name("addRole");
    Route::delete('role', 'Api\RoleController@delRole')->name("delRole");
    Route::get('roleAll', 'Api\RoleController@getAllRole')->name("roleAll");
    Route::put('role', 'Api\RoleController@updateRole')->name("updateRole");
    Route::post('bindRole', 'Api\RoleUserController@bindRoleUser')->name("bindRole");

    //Project项目
    Route::get('project', 'Api\ProjectController@getProjectList')->name("getProjectList");

    //Version版本
    Route::post('version', 'Api\VersionController@addVersion')->name("addVersion");
    Route::get('version', 'Api\VersionController@getVersionList')->name("getVersionList");

    //Node节点
    Route::post('node', 'Api\NodeController@addNode')->name("addNode");
    Route::get('node', 'Api\NodeController@getNodeList')->name("getNodeList");
    Route::put('node', 'Api\NodeController@updateNode')->name("updateNode");
    Route::delete('node', 'Api\NodeController@delNode')->name("delNode");

});









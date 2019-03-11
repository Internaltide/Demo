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
Route::get('/login', 'LoginController@showLoginForm')->name('loginform');
Route::post('/login', 'LoginController@login')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');

// Homepage
Route::get('/', 'LoginController@index')->name('homepage');

// Backend Route
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    // 後台儀錶板
    Route::get('/', function () {
        return view('themes.default.home',['function'=>'Enterprise Cloud', 'description'=>'Here is your management panel']);
    })->name('dashboard');

    // 網域相關管理
    Route::group(['prefix' => 'domain'], function (){
        Route::get('/dashboard', 'Domain\DomainController@landing')->name('domain.dashboard');
        Route::get('/application', 'Domain\ApplicationController@landing')->name('domain.application');
    });

    // 使用者相關管理
    Route::group(['prefix' => 'user'], function (){
        Route::get('/ajxform/{key}/{type}', 'User\RoleController@ajxform')->name('perm.ajxform');
        Route::get('/ajxform/{typename}', 'User\RoleController@ajxRecordElement')->name('component.dataRecord');

        Route::get('/listing', 'User\UserController@landing')->name('user.list');
        Route::get('/permission', 'User\RoleController@landing')->name('user.perm');
        Route::post('/permission/createRoles', 'User\RoleController@createRoles')->name('perm.createRoles');
        Route::post('/permission/assignUsers', 'User\RoleController@assignUsers')->name('perm.assignUsers');
        Route::post('/permission/assignPrivileges', 'User\RoleController@assignPrivileges')->name('perm.assignPrivileges');
        Route::post('/permission/updateRole', 'User\RoleController@updateRole')->name('perm.updateRole');
        Route::post('permission/updatePrivilege', 'User\RoleController@updatePrivilege')->name('perm.updatePrivilege');
        Route::post('/permission/delRoles', 'User\RoleController@deleteRole')->name('perm.delRoles');
    });
});
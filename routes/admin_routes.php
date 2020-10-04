<?php

/* ================== Admin ================== */
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']],function () {

    Route::get('/', function () {
        return redirect('admin/users');
    });
    
    Route::resource('roles', 'RoleController');

    Route::resource('users', 'UserController');

    Route::resource('roleUsers', 'RoleUserController', ['except' => ['show','edit','update']]);

    Route::resource('permissions', 'PermissionController');

    Route::resource('permissionRoles', 'PermissionRoleController',['except' => ['show','edit','update']]);

    Route::resource('appointments', 'AppointmentController');

    Route::get('adminConfig', 'AdminConfigurationController@index')->name('admin.system.index');
    
    Route::post('adminConfig/{section?}', 'AdminConfigurationController@update')->name('admin.system.update');
});

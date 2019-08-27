<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\User\Http\Controllers'], function () {

    Route::resource('user', 'UserController');

    Route::resource('role', 'RoleController');

    Route::resource('permission', 'PermissionController');

});

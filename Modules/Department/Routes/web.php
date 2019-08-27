<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\Department\Http\Controllers'], function () {

    Route::resource('department', 'DepartmentController');
    Route::post('department/storeFromWeb2Lead', 'DepartmentController@saveNew');

    Route::resource('email', 'EmailController');

    Route::resource('document', 'DocumentController');

});

<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\Lead\Http\Controllers'], function () {

    Route::resource('lead', 'LeadController');

    Route::resource('lead-source', 'LeadSourceController');
    Route::post('lead-source/storeFromWeb2Lead', 'LeadSourceController@saveNew');

    Route::resource('lead-status', 'LeadStatusController');

    Route::resource('lead-type', 'LeadTypeController');
    Route::post('lead-type/storeFromWeb2Lead', 'LeadTypeController@saveNew');

    Route::post('lead-field-settings', 'LeadController@leadFieldSetting')->name('lead-field-settings.update');

});

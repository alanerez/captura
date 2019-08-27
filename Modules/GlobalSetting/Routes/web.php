<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\GlobalSetting\Http\Controllers'], function () {

    Route::get('/get-all-webhook-methods', 'WebhookController@getAllMethods');
    Route::get('/get-all-webhook-headers', 'WebhookController@getAllHeaders');
    Route::get('/get-all-webhook-formats', 'WebhookController@getAllFormats');
    Route::get('/get-all-webhook-fields', 'WebhookController@getAllFields');
    Route::get('/get-all-webhook', 'WebhookController@getWebhookData');
    Route::post('/create-webhook/', 'WebhookController@store');
    Route::get('web2lead/form/{fid}/delete/{id}', 'WebhookController@delete');

    // Route::group(['prefix' => '/setup'], function () {

    // Route::post('/setup-save', 'SetupController@saveSetup')->name('setup.save');

    // Route::get('/smtp', 'SetupController@smtp')->name('smtp');
    // });

});

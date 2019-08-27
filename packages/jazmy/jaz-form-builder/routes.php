<?php

Route::middleware('web')
    ->namespace('jazmy\FormBuilder\Controllers')
    ->prefix('web2lead')
    ->group(function () {

        Route::resource('form', 'FormController');

        Route::get('/form-render/{identifier}', 'RenderFormController@render')->name('form.render');
        Route::post('/form-submit/{identifier}', 'RenderFormController@submit')->name('form.submit');
        Route::get('/form-feedback/{identifier}/feedback', 'RenderFormController@feedback')->name('form.feedback');

        Route::name('form.')
            ->prefix('/form/{fid}')
            ->group(function () {
                Route::resource('/submission', 'SubmissionController');
            });

    });

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
    return redirect()->route('dashboard');
});

Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function (){

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');


    Route::resource('/cash-register', 'CashRegisterController');
    Route::get('/sales-projection', 'CashRegisterController@dashboard')->name('cash-register.dashboard');
    Route::get('/sales-projection/month/{month}/{year}', 'CashRegisterController@monthDashboard');
    Route::get('/goals', 'CashRegisterController@goals')->name('cash-register.goals');
    Route::get('/goals/create-goal', 'CashRegisterController@createGoal')->name('create.goals');
    Route::get('/goals/add-goal', 'CashRegisterController@addGoal')->name('add.goals');
    Route::get('/goals/edit-goal/{id}', 'CashRegisterController@editGoal')->name('goal.edit');
    Route::get('/goals/update-goal/', 'CashRegisterController@updateGoal')->name('goal.update');
    Route::delete('/goals/delete-goal/{id}', 'CashRegisterController@deleteGoal')->name('goal.destroy');

    Route::resource('lead-management', 'LeadManagementController');
    Route::get('/lead-management/list/leads', 'LeadManagementController@results');
    Route::get('/lead-management/leads/all', 'LeadManagementController@leadList')->name('lead-management.lead_list');

    Route::prefix('call-tracking')->group(function (){
        Route::get(
            '/', 'LeadController@dashboard'
        )->name('leads.index');

        Route::resource(
            'available_number', 'AvailableNumberController', ['names' => ['index' => 'available_numbers.index']]
        );

        Route::resource(
            'lead_sources', 'LeadSourceController', ['except' => ['index', 'create', 'show']]
        );

        Route::get('{id}', 'LeadController@getNumber')->name('lead_source.number');

        Route::get(
            'summary-by-lead-source',
            ['as' => 'lead.summary_by_lead_source',
                'uses' => 'LeadController@summaryByLeadSource'
            ]
        );

        Route::get(
            'summary-by-city',
            ['as' => 'lead.summary_by_city',
                'uses' => 'LeadController@summaryByCity'
            ]
        );


        Route::resource(
            'leads', 'LeadController', ['only' => ['store']]
        );
    });
});

Route::get('/artisan-migrate', function () {

    \Artisan::call('migrate');
    \Artisan::call('migrate --path=database/migrations/twilio');
    \Artisan::call('migrate --path=database/migrations/cash-register');
    \Artisan::call('migrate --path=database/migrations/call_leads');
});

Route::get('/artisan-cache', function () {

    \Artisan::call('config:clear');

    \Artisan::call('cache:clear');

    \Artisan::call('view:clear');

    \Artisan::call('route:clear');
});


Route::get('/generate_csrf_token', 'ReviewController@generate_csrf_token')->middleware('cors');;
Route::post('/submit-review', 'ReviewController@submit_review')->middleware('cors');

Route::get(
            '/reviews', 'ReviewController@index'
        )->name('reviews.index');




Route::get('/describe_table', 'ReviewController@describe_table');
Route::get('/migrate', 'ReviewController@describe_table');
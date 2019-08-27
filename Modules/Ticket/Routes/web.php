<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\Ticket\Http\Controllers'], function () {

    Route::resource('ticket', 'TicketController');
    Route::resource('ticket-status', 'TicketStatusController');
    Route::resource('ticket-priority', 'TicketPriorityController');
    Route::resource('ticket-service', 'TicketServiceController');

});

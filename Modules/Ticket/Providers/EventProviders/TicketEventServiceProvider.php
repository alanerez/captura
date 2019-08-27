<?php

namespace Modules\Ticket\Providers\EventProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class TicketEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\Ticket\Events\SomeEvent' => [
            'Modules\Ticket\Listeners\EventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}

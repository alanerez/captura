<?php

namespace Modules\User\Providers\EventProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class UserEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\User\Events\SomeEvent' => [
            'Modules\User\Listeners\EventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}

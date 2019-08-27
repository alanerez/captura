<?php

namespace Modules\Department\Providers\EventProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class DepartmentEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\Department\Events\SomeEvent' => [
            'Modules\Department\Listeners\EventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}

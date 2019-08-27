<?php

namespace Modules\Lead\Providers\EventProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class LeadEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\Lead\Events\SomeEvent' => [
            'Modules\Lead\Listeners\EventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}

<?php

namespace Modules\GlobalSetting\Providers\EventProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class GlobalSettingEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\GlobalSetting\Events\SomeEvent' => [
            'Modules\GlobalSetting\Listeners\EventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}

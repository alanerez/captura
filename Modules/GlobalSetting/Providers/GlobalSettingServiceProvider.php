<?php

namespace Modules\GlobalSetting\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\GlobalSetting\Entities\GlobalSetting;
use Modules\GlobalSetting\Repositories\GlobalSettingRepository;

class GlobalSettingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        $this->registerViews();
    }

    public function register()
    {
        $this->providers();
        $this->eventProviders();
    }

    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
    }

    public function registerViews()
    {
        $this->loadViewsFrom(resource_path('views/modules/setup'), 'setup');
    }

    public function providers()
    {
        $this->app->bind('Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface', function ($app) {
            return new GlobalSettingRepository(new GlobalSetting());
        });
    }

    public function eventProviders()
    {
        $this->app->register("Modules\GlobalSetting\Providers\EventProviders\GlobalSettingEventServiceProvider");
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'global-setting'
        );
    }
}

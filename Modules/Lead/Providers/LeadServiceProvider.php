<?php

namespace Modules\Lead\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Lead\Entities\Lead;
use Modules\Lead\Repositories\LeadRepository;

class LeadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        $this->registerViews();
        $this->registerConfig();
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
        $this->loadViewsFrom(resource_path('views/modules/lead'), 'lead');
        $this->loadViewsFrom(resource_path('views/modules/lead_source'), 'lead_source');
        $this->loadViewsFrom(resource_path('views/modules/lead_status'), 'lead_status');
        $this->loadViewsFrom(resource_path('views/modules/lead_type'), 'lead_type');
    }

    public function providers()
    {
        $this->app->bind('Modules\Lead\Interfaces\LeadRepositoryInterface', function ($app) {
            return new LeadRepository(new Lead());
        });
    }

    public function eventProviders()
    {
        $this->app->register("Modules\Lead\Providers\EventProviders\LeadEventServiceProvider");
    }

    public function registerConfig()
    {
        //
    }
}

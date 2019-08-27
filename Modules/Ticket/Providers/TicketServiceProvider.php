<?php

namespace Modules\Ticket\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Ticket\Entities\Ticket;

class TicketServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(resource_path('views/modules/ticket'), 'ticket');
        $this->loadViewsFrom(resource_path('views/modules/ticket_priority'), 'ticket_priority');
        $this->loadViewsFrom(resource_path('views/modules/ticket_service'), 'ticket_service');
        $this->loadViewsFrom(resource_path('views/modules/ticket_status'), 'ticket_status');

    }

    public function providers()
    {
        //
    }

    public function eventProviders()
    {
        //
    }

    public function registerConfig()
    {
        //
    }
}

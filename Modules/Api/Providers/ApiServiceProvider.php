<?php

namespace Modules\Api\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
    }

    public function register()
    {
        //
    }

    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
    }
}

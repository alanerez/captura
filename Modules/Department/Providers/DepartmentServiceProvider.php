<?php

namespace Modules\Department\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Department\Entities\Department;
use Modules\Department\Entities\Email;
use Modules\Department\Repositories\DepartmentRepository;
use Modules\Department\Repositories\EmailRepository;

class DepartmentServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(resource_path('views/modules/department'), 'department');
    }

    public function providers()
    {
        $this->app->bind('Modules\Department\Interfaces\DepartmentRepositoryInterface', function ($app) {
            return new DepartmentRepository(new Department());
        });

        $this->app->bind('Modules\Department\Interfaces\EmailRepositoryInterface', function ($app) {
            return new EmailRepository(new Email());
        });
    }

    public function eventProviders()
    {
        $this->app->register("Modules\Department\Providers\EventProviders\DepartmentEventServiceProvider");
    }

    public function registerConfig()
    {
        //
    }
}

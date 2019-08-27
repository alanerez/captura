<?php

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Entities\Permission;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Modules\User\Entities\UserSetting;
use Modules\User\Repositories\PermissionRepository;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\UserSettingRepository;

class UserServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(resource_path('views/modules/user'), 'user');
        $this->loadViewsFrom(resource_path('views/modules/role'), 'role');
        $this->loadViewsFrom(resource_path('views/modules/permission'), 'permission');
    }

    public function providers()
    {
        $this->app->bind('Modules\User\Interfaces\UserRepositoryInterface', function ($app) {
            return new UserRepository(new User());
        });

        $this->app->bind('Modules\User\Interfaces\UserSettingRepositoryInterface', function ($app) {
            return new UserSettingRepository(new UserSetting());
        });

        $this->app->bind('Modules\User\Interfaces\RoleRepositoryInterface', function ($app) {
            return new RoleRepository(new Role());
        });

        $this->app->bind('Modules\User\Interfaces\PermissionRepositoryInterface', function ($app) {
            return new PermissionRepository(new Permission());
        });
    }

    public function eventProviders()
    {
        $this->app->register("Modules\User\Providers\EventProviders\UserEventServiceProvider");
    }

    public function registerConfig()
    {
        //
    }
}

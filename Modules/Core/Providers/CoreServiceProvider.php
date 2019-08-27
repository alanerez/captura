<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->registerConfig();
    }

    public function register()
    {
        $this->registerProvider();
        $this->registerAlias();
    }

    public function registerProvider()
    {
        $this->app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);
        $this->app->register(\Intervention\Image\ImageServiceProvider::class);
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);
        $this->app->register(\Yajra\DataTables\DataTablesServiceProvider::class);
        // $this->app->register(\jazmy\FormBuilder\FormBuilderServiceProvider::class);
    }

    public function registerAlias()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Image', \Intervention\Image\Facades\Image::class);
        $loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);
        $loader->alias('Datatables', \Yajra\DataTables\Facades\DataTables::class);
        $loader->alias('Uuid', \Webpatser\Uuid\Uuid::class);
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/core.php', 'core'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/user.php', 'user'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/role.php', 'role'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/permission.php', 'permission'
        );
    }
}

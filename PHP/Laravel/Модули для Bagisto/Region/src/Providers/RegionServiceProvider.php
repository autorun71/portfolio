<?php

namespace Webkul\Region\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Webkul\Admin\Exceptions\Handler;
use Webkul\Admin\Providers\EventServiceProvider;

use Webkul\Checkout\Facades\Cart;
use Webkul\Core\Tree;
use Webkul\Region\Service\Region as RegionService;


class RegionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

//        CategoryProxy::observe(CategoryObserver::class);

//        $this->registerEloquentFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'region');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/webkul/admin/assets'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'region');

        $this->composeView();

        $this->registerACL();

        $this->app->register(EventServiceProvider::class);

        $this->app->bind(
            ExceptionHandler::class,
            Handler::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->registerConfig();
        $this->registerFacades();

    }

    protected function composeView() {
//        view()->composer(['admin::layouts.nav-left', 'admin::layouts.nav-aside', 'admin::layouts.tabs'], function ($view) {
//            $tree = Tree::create();
//
//            $permissionType = auth()->guard('admin')->user()->role->permission_type;
//            $allowedPermissions = auth()->guard('admin')->user()->role->permissions;
//
//            foreach (config('menu.region') as $index => $item) {
//                if (! bouncer()->hasPermission($item['key'])) {
//                    continue;
//                }
//
//                if ($index + 1 < count(config('menu.region')) && $permissionType != 'all') {
//                    $permission = config('menu.region')[$index + 1];
//
//                    if (substr_count($permission['key'], '.') == 2 && substr_count($item['key'], '.') == 1) {
//                        foreach ($allowedPermissions as $key => $value) {
//                            if ($item['key'] == $value) {
//                                $neededItem = $allowedPermissions[$key + 1];
//
//                                foreach (config('menu.admin') as $key1 => $findMatced) {
//                                    if ($findMatced['key'] == $neededItem) {
//                                        $item['route'] = $findMatced['route'];
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//
//                $tree->add($item, 'menu');
//            }
////            dd($tree);
//            $tree->items = core()->sortItems($tree->items);
//            $view->with('menu', $tree);
//        });
    }


    public function registerACL()
    {
        $this->app->singleton('acl', function () {
            return $this->createACL();
        });
    }

    /**
     * Create acl tree
     *
     * @return mixed
     */
    public function createACL()
    {
        static $tree;

        if ($tree) {
            return $tree;
        }

        $tree = Tree::create();

        foreach (config('acl') as $item) {
            $tree->add($item, 'acl');
        }

        $tree->items = core()->sortItems($tree->items);

        return $tree;
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );
//
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
//
//        $this->mergeConfigFrom(
//            dirname(__DIR__) . '/Config/system.php', 'core'
//        );
    }

    private function registerFacades()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('region', RegionService::class);

        $this->app->singleton('region', function () {
            return new RegionService();
        });

        $this->app->bind('region', RegionService::class);
    }
}

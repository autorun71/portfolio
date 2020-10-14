<?php

namespace App\Providers;

use App\Custom\CFiles;
use Illuminate\Support\ServiceProvider;

class CFilesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function boot()
    {

//        $configPath = __DIR__ . '/../config/ecom.php';
//        $publishPath = config_path('ecom.php');
//
//        $this->publishes([$configPath => $publishPath], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('c-files', function ($app) {

            return new CFiles();
        });


//        $this->mergeConfigFrom(__DIR__.'/../config/ecom.php', 'ecom');
    }
}

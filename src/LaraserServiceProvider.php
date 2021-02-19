<?php

namespace Cerwyn\Laraser;

use Cerwyn\Laraser\Console\RemoveOldData;
use Illuminate\Support\ServiceProvider;

class LaraserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laraser.php' => config_path('laraser.php'),
            ], 'laraser');

            // Registering package commands.
            $this->commands([
                RemoveOldData::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/laraser.php', 'laraser');

        // Register the main class to use with the facade
        $this->app->singleton('laraser', function () {
            return new Laraser;
        });
    }
}

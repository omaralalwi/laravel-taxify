<?php

namespace Omaralalwi\LaravelTaxify;

use Illuminate\Support\ServiceProvider;
use Omaralalwi\LaravelTaxify\Enums\{TaxifyKeys, TaxTransformKeys};

class LaravelTaxifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path(TaxifyKeys::CONFIG_FILE.'.php'),
            ], TaxifyKeys::CONFIG_FILE.'-config');

//             $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', TaxifyKeys::CONFIG_FILE);

        // Register the main class to use with the facade , Not Used yet
//        $this->app->singleton('laravel-taxify', function () {
//            return new LaravelTaxify;
//        });
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}

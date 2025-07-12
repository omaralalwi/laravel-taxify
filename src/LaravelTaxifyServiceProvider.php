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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path(TaxifyKeys::CONFIG_FILE.'.php'),
            ], TaxifyKeys::CONFIG_FILE);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', TaxifyKeys::CONFIG_FILE);
    }
}

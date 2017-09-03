<?php

namespace Femonofsky\Remita;

use Illuminate\Support\ServiceProvider;

class RemitaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
//        $this->publishes([
//            __DIR__.'/Config/Remita.php' => config_path('Remita.php'),
//        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Config
        $this->mergeConfigFrom( __DIR__.'/Config/Remita.php', 'Remita');

        // View
        $this->loadViewsFrom(__DIR__ . '/Views', 'remita');

        $this->app->singleton('remita', function ($app) {
            return new Remita;
        });
    }

}

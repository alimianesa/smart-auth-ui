<?php

namespace Alimianesa\SmartAuth;

use Illuminate\Support\ServiceProvider;

class SmartAuthServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'alimianesa');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'alimianesa');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/smartauth.php', 'smartauth');
        $this->mergeConfigFrom(__DIR__.'/../config/face-recognition.php', 'face-recognition');
        $this->mergeConfigFrom(__DIR__.'/../config/speech-recognition.php', 'speech-recognition');

        // Register the service the package provides.
        $this->app->singleton('smartauth', function ($app) {
            return new SmartAuth;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['smartauth'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/smartauth.php' => config_path('smartauth.php'),
        ], 'smartauth.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/alimianesa'),
        ], 'smartauth.views');*/

        // Publishing assets.
        $this->publishes([
            __DIR__.'/../resources/js/js/*' => public_path('js'),
        ], 'smartauth.views');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/alimianesa'),
        ], 'smartauth.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

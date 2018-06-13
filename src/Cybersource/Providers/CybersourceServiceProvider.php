<?php

namespace Cybersource\Providers;

use Illuminate\Support\ServiceProvider;
use Cybersource\Cybersource;

class CybersourceServiceProvider extends ServiceProvider{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('itwoc', function () {
            return new Cybersource();
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['cybersource'];
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../../config/cybersource.php' => config_path('cybersource.php'),
        ]);
    }
}

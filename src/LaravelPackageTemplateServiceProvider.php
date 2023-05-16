<?php

namespace OnrampLab\LaravelPackageTemplate;

use Illuminate\Support\ServiceProvider;

class LaravelPackageTemplateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '', '');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '' => config_path(''),
        ], '');
    }
}

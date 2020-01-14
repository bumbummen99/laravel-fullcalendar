<?php

namespace MaddHatter\LaravelFullcalendar;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'laravel-fullcalendar',
            Calendar::class,
        ];
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'fullcalendar');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(
            'laravel-fullcalendar',
            function (Application $app): Calendar {
                return new Calendar(
                    $app->make('view'),
                    new EventCollection()
                );
            }
        );

        $this->app->alias('laravel-fullcalendar', Calendar::class);
    }
}

<?php

namespace MaddHatter\LaravelFullcalendar\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use MaddHatter\LaravelFullcalendar\Calendar;
use MaddHatter\LaravelFullcalendar\EventCollection;

final class FullCalendarServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            'laravel-fullcalendar',
            Calendar::class,
        ];
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'fullcalendar');
    }

    public function register(): void
    {
        $this->app->bind(
            'laravel-fullcalendar',
            static function (Application $app): Calendar {
                return new Calendar(
                    $app->make('view'),
                    new EventCollection()
                );
            }
        );

        $this->app->alias('laravel-fullcalendar', Calendar::class);
    }
}

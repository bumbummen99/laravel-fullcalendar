<?php

namespace MaddHatter\LaravelFullcalendar\Tests\Providers;

use MaddHatter\LaravelFullcalendar\Calendar;
use MaddHatter\LaravelFullcalendar\Providers\FullCalendarServiceProvider;
use Orchestra\Testbench\TestCase;

final class FullCalendarServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            FullCalendarServiceProvider::class,
        ];
    }

    /**
     * @testdox The service provider is registered
     */
    public function testServiceProviderIsRegistered(): void
    {
        $this->assertTrue($this->app->bound('laravel-fullcalendar'));
        $this->assertInstanceOf(Calendar::class, $this->app->make('laravel-fullcalendar'));
    }
}

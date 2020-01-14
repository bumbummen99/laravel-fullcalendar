<?php

namespace MaddHatter\LaravelFullcalendar\Tests;

use MaddHatter\LaravelFullcalendar\Calendar;
use MaddHatter\LaravelFullcalendar\ServiceProvider;
use Orchestra\Testbench\TestCase;

final class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
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

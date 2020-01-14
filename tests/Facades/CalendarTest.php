<?php

namespace MaddHatter\LaravelFullcalendar\Tests\Facades;

use Illuminate\Contracts\View\View;
use MaddHatter\LaravelFullcalendar\Calendar;
use MaddHatter\LaravelFullcalendar\Event;
use MaddHatter\LaravelFullcalendar\Facades\Calendar as CalendarFacade;
use MaddHatter\LaravelFullcalendar\ServiceProvider;
use Orchestra\Testbench\TestCase;

final class CalendarTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Calendar' => CalendarFacade::class,
        ];
    }

    /**
     * @testdox The calendar's `<div>` element is generated
     */
    public function testCalendar(): void
    {
        $this->assertStringMatchesFormat('<div id="calendar-%s"></div>', \Calendar::calendar());
    }

    /**
     * @testdox The calendar is rendered as a view
     */
    public function testScript(): void
    {
        $this->assertInstanceOf(View::class, \Calendar::script());
    }

    /**
     * @testdox The calendar ID can be managed
     */
    public function testSetAndGetId(): void
    {
        $this->assertInstanceOf(Calendar::class, \Calendar::setId('foo'), 'The setId method implements a fluent interface');
        $this->assertSame('foo', \Calendar::getId());
    }

    /**
     * @testdox The calendar generates an ID if necessary
     */
    public function testGetIdGeneratesRandomId(): void
    {
        $this->assertNotEmpty(\Calendar::getId());
    }

    /**
     * @testdox An event is added to the calendar
     */
    public function testAddEvent(): void
    {
        $event = $this->createMock(Event::class);
        $event->expects($this->once())
            ->method('getTitle')
            ->willReturn('Event Title');

        $event->expects($this->once())
            ->method('isAllDay')
            ->willReturn(true);

        $event->expects($this->once())
            ->method('getStart')
            ->willReturn(new \DateTime('yesterday'));

        $event->expects($this->once())
            ->method('getEnd')
            ->willReturn(new \DateTime('tomorrow'));

        $this->assertInstanceOf(Calendar::class, \Calendar::addEvent($event), 'The addEvent method implements a fluent interface');
    }

    /**
     * @testdox Multiple events are added to the calendar
     */
    public function testAddEvents(): void
    {
        $events = [];

        for ($i = 1; $i <= 5; $i++) {
            $event = $this->createMock(Event::class);
            $event->expects($this->once())
                ->method('getTitle')
                ->willReturn('Event Title ' . $i);

            $event->expects($this->once())
                ->method('isAllDay')
                ->willReturn(true);

            $event->expects($this->once())
                ->method('getStart')
                ->willReturn(new \DateTime('yesterday'));

            $event->expects($this->once())
                ->method('getEnd')
                ->willReturn(new \DateTime('tomorrow'));

            $events[] = $event;
        }

        $this->assertInstanceOf(Calendar::class, \Calendar::addEvents($events), 'The addEvents method implements a fluent interface');
    }

    /**
     * @testdox User options can be set for the calendar
     */
    public function testSetOptions(): void
    {
        $this->assertInstanceOf(Calendar::class, \Calendar::setOptions([]), 'The setOptions method implements a fluent interface');
    }

    /**
     * @testdox The calendar options can be retrieved
     */
    public function testGetOptions(): void
    {
        $this->assertIsArray(\Calendar::getOptions());
    }

    /**
     * @testdox User callbacks can be set for the calendar
     */
    public function testSetCallbacks(): void
    {
        $this->assertInstanceOf(Calendar::class, \Calendar::setCallbacks([]), 'The setCallbacks method implements a fluent interface');
    }

    /**
     * @testdox The calendar callbacks can be retrieved
     */
    public function testGetCallbacks(): void
    {
        $this->assertIsArray(\Calendar::getCallbacks());
    }

    /**
     * @testdox The calendar options are retrieved as a JSON string
     */
    public function testGetOptionsJson(): void
    {
        $this->assertJson(\Calendar::getOptionsJson());
    }
}

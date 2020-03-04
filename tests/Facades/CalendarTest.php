<?php

namespace MaddHatter\LaravelFullcalendar\Tests\Facades;

use Illuminate\Contracts\View\View;
use MaddHatter\LaravelFullcalendar\Contracts\Event;
use MaddHatter\LaravelFullcalendar\Facades\Calendar as CalendarFacade;
use MaddHatter\LaravelFullcalendar\Providers\FullCalendarServiceProvider;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

final class CalendarTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            FullCalendarServiceProvider::class,
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
        \Calendar::setId('foo');
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
    public function testAdd(): void
    {
        /** @var Event|MockObject $event */
        $event = $this->createMock(Event::class);
        $event->expects($this->once())
            ->method('title')
            ->willReturn('Event Title');

        $event->expects($this->once())
            ->method('allDay')
            ->willReturn(true);

        $event->expects($this->once())
            ->method('start')
            ->willReturn(new \DateTime('yesterday'));

        $event->expects($this->once())
            ->method('end')
            ->willReturn(new \DateTime('tomorrow'));

        \Calendar::add($event);
    }

    /**
     * @testdox Multiple events are added to the calendar
     */
    public function testAddEvents(): void
    {
        /** @var array<Event|MockObject> $events */
        $events = [];

        for ($i = 1; $i <= 5; $i++) {
            /** @var Event|MockObject $event */
            $event = $this->createMock(Event::class);
            $event->expects($this->once())
                ->method('title')
                ->willReturn('Event Title ' . $i);

            $event->expects($this->once())
                ->method('allDay')
                ->willReturn(true);

            $event->expects($this->once())
                ->method('start')
                ->willReturn(new \DateTime('yesterday'));

            $event->expects($this->once())
                ->method('end')
                ->willReturn(new \DateTime('tomorrow'));

            $events[] = $event;
        }

        \Calendar::addEvents($events);
    }

    /**
     * @testdox The calendar options can be managed
     */
    public function testSetAndGetOptions(): void
    {
        \Calendar::setOptions([]);
        $this->assertIsArray(\Calendar::getOptions());
    }

    /**
     * @testdox User callbacks can be managed
     */
    public function testSetAndGetCallbacks(): void
    {
        \Calendar::setCallbacks([]);
        $this->assertSame([], \Calendar::getCallbacks());
    }

    /**
     * @testdox The calendar options are retrieved as a JSON string
     */
    public function testToJson(): void
    {
        $this->assertJson(\Calendar::toJson());
    }
}

<?php

namespace MaddHatter\LaravelFullcalendar\Tests;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use MaddHatter\LaravelFullcalendar\Calendar;
use MaddHatter\LaravelFullcalendar\Contracts\Event;
use MaddHatter\LaravelFullcalendar\EventCollection;
use PHPUnit\Framework\Constraint\IsType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CalendarTest extends TestCase
{
    /**
     * @var MockObject|Factory
     */
    private $view;

    /**
     * @var Calendar
     */
    private $calendar;

    protected function setUp(): void
    {
        $this->view = $this->createMock(Factory::class);

        $this->calendar = new Calendar($this->view, new EventCollection());
    }

    /**
     * @testdox The calendar's `<div>` element is generated
     */
    public function testCalendar(): void
    {
        $this->assertStringMatchesFormat('<div id="calendar-%s"></div>', $this->calendar->calendar());
    }

    /**
     * @testdox The calendar is rendered as a view
     */
    public function testScript(): void
    {
        $this->view->expects($this->once())
            ->method('make')
            ->with('fullcalendar::script', new IsType(IsType::TYPE_ARRAY))
            ->willReturn($this->createMock(View::class));

        $this->assertInstanceOf(View::class, $this->calendar->script());
    }

    /**
     * @testdox The calendar ID can be managed
     */
    public function testSetAndGetId(): void
    {
        $this->calendar->setId('foo');
        $this->assertSame('foo', $this->calendar->getId());
    }

    /**
     * @testdox The calendar generates an ID if necessary
     */
    public function testGetIdGeneratesRandomId(): void
    {
        $this->assertNotEmpty($this->calendar->getId());
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

        $this->calendar->add($event);
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

        $this->calendar->addEvents($events);
    }

    /**
     * @testdox The calendar options can be managed
     */
    public function testSetAndGetOptions(): void
    {
        $this->calendar->setOptions([]);
        $this->assertIsArray($this->calendar->getOptions());
    }

    /**
     * @testdox User callbacks can be managed
     */
    public function testSetAndGetCallbacks(): void
    {
        $this->calendar->setCallbacks([]);
        $this->assertSame([], $this->calendar->getCallbacks());
    }

    /**
     * @testdox The calendar options are retrieved as a JSON string
     */
    public function testToJson(): void
    {
        $this->assertJson($this->calendar->toJson());
    }
}

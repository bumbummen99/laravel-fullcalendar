<?php

namespace MaddHatter\LaravelFullcalendar\Tests;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use MaddHatter\LaravelFullcalendar\Calendar;
use MaddHatter\LaravelFullcalendar\Event;
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
        $this->assertSame($this->calendar, $this->calendar->setId('foo'), 'The setId method implements a fluent interface');
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

        $this->assertSame($this->calendar, $this->calendar->addEvent($event), 'The addEvent method implements a fluent interface');
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

        $this->assertSame($this->calendar, $this->calendar->addEvents($events), 'The addEvents method implements a fluent interface');
    }

    /**
     * @testdox User options can be set for the calendar
     */
    public function testSetOptions(): void
    {
        $this->assertSame($this->calendar, $this->calendar->setOptions([]), 'The setOptions method implements a fluent interface');
    }

    /**
     * @testdox The calendar options can be retrieved
     */
    public function testGetOptions(): void
    {
        $this->assertIsArray($this->calendar->getOptions());
    }

    /**
     * @testdox User callbacks can be set for the calendar
     */
    public function testSetCallbacks(): void
    {
        $this->assertSame($this->calendar, $this->calendar->setCallbacks([]), 'The setCallbacks method implements a fluent interface');
    }

    /**
     * @testdox The calendar callbacks can be retrieved
     */
    public function testGetCallbacks(): void
    {
        $this->assertIsArray($this->calendar->getCallbacks());
    }

    /**
     * @testdox The calendar options are retrieved as a JSON string
     */
    public function testGetOptionsJson(): void
    {
        $this->assertJson($this->calendar->getOptionsJson());
    }
}

<?php

namespace MaddHatter\LaravelFullcalendar;

use MaddHatter\LaravelFullcalendar\Contracts\IdentifiableEvent;
use MaddHatter\LaravelFullcalendar\Contracts\OptionableEvent;

final class SimpleEvent implements IdentifiableEvent, OptionableEvent
{
    /**
     * @var string|int|null
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var bool
     */
    private $allDay;

    /**
     * @var \DateTimeInterface
     */
    private $start;

    /**
     * @var \DateTimeInterface
     */
    private $end;

    /**
     * @var array
     */
    private $options;

    /**
     * @param string|\DateTimeInterface $start
     * @param string|\DateTimeInterface $end
     * @param string|int|null           $id
     */
    public function __construct(string $title, bool $isAllDay, $start, $end, $id = null, array $options = [])
    {
        $this->title = $title;
        $this->allDay = $isAllDay;
        $this->start = $start instanceof \DateTimeInterface ? $start : new \DateTime($start);
        $this->end = $start instanceof \DateTimeInterface ? $end : new \DateTime($end);
        $this->id = $id;
        $this->options = $options;
    }

    /**
     * @return string|int|null
     */
    public function id()
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function allDay(): bool
    {
        return $this->allDay;
    }

    public function start(): \DateTimeInterface
    {
        return $this->start;
    }

    public function end(): \DateTimeInterface
    {
        return $this->end;
    }

    public function options(): array
    {
        return $this->options;
    }
}

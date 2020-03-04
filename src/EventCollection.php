<?php

namespace MaddHatter\LaravelFullcalendar;

use Illuminate\Support\Collection;
use MaddHatter\LaravelFullcalendar\Contracts\Event;
use MaddHatter\LaravelFullcalendar\Contracts\IdentifiableEvent;
use MaddHatter\LaravelFullcalendar\Contracts\OptionableEvent;

final class EventCollection
{
    /**
     * @var Collection
     */
    private $events;

    public function __construct()
    {
        $this->events = new Collection();
    }

    public function push(Event $event, array $customAttributes = []): void
    {
        $this->events->push($this->convertToArray($event, $customAttributes));
    }

    public function toJson(): string
    {
        return $this->events->toJson();
    }

    public function toArray(): array
    {
        return $this->events->toArray();
    }

    private function convertToArray(Event $event, array $customAttributes = []): array
    {
        return \array_merge(
            [
                'id' => $this->getEventId($event),
                'title' => $event->title(),
                'allDay' => $event->allDay(),
                'start' => $event->start()->format('c'),
                'end' => $event->end()->format('c'),
            ],
            $this->getEventOptions($event),
            $customAttributes
        );
    }

    /**
     * @return string|int|null
     */
    private function getEventId(Event $event)
    {
        return $event instanceof IdentifiableEvent ? $event->id() : null;
    }

    private function getEventOptions(Event $event): array
    {
        return $event instanceof OptionableEvent ? $event->options() : [];
    }
}

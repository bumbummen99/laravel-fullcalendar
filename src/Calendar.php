<?php

namespace MaddHatter\LaravelFullcalendar;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use MaddHatter\LaravelFullcalendar\Contracts\Event;

class Calendar
{
    /**
     * @var Factory
     */
    protected $view;

    /**
     * @var EventCollection
     */
    public $eventCollection;

    /**
     * @var string
     */
    protected $id;

    /**
     * Default options array
     *
     * @var array
     */
    protected $defaultOptions = [
        'header' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'month,agendaWeek,agendaDay',
        ],
        'eventLimit' => true,
    ];

    /**
     * User defined options
     *
     * @var array
     */
    protected $userOptions = [];

    /**
     * User defined callback options
     *
     * @var array
     */
    protected $callbacks = [];

    public function __construct(Factory $view, EventCollection $eventCollection)
    {
        $this->view = $view;
        $this->eventCollection = $eventCollection;
    }

    /**
     * @param string|\DateTimeInterface $start
     * @param string|\DateTimeInterface $end
     * @param string|int|null           $id
     */
    public static function event(string $title, bool $isAllDay, $start, $end, $id = null, array $options = []): SimpleEvent
    {
        return new SimpleEvent($title, $isAllDay, $start, $end, $id, $options);
    }

    public function calendar(): string
    {
        return '<div id="calendar-' . $this->getId() . '"></div>';
    }

    public function script(): View
    {
        $options = $this->toJson();

        return $this->view->make(
            'fullcalendar::script',
            [
                'id' => $this->getId(),
                'options' => $options,
            ]
        );
    }

    /**
     * @param string|int|null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|int
     */
    public function getId()
    {
        if (empty($this->id)) {
            $this->id = Str::random(8);
        }

        return $this->id;
    }

    public function add(Event $event, array $customAttributes = []): void
    {
        $this->eventCollection->push($event, $customAttributes);
    }

    /**
     * @param Event[] $events
     */
    public function addEvents(iterable $events, array $customAttributes = []): void
    {
        foreach ($events as $event) {
            $this->add($event, $customAttributes);
        }
    }

    public function setOptions(array $options): void
    {
        $this->userOptions = $options;
    }

    public function getOptions(): array
    {
        return \array_merge($this->defaultOptions, $this->userOptions);
    }

    public function setCallbacks(array $callbacks): void
    {
        $this->callbacks = $callbacks;
    }

    public function getCallbacks(): array
    {
        return $this->callbacks;
    }

    public function toJson(): string
    {
        $options = $this->getOptions();
        $placeholders = $this->generateCallbackPlaceholders();
        $parameters = \array_merge($options, $placeholders);

        // Allow the user to override the events list with a url
        if (!isset($parameters['events'])) {
            $parameters['events'] = $this->eventCollection->toArray();
        }

        $json = \json_encode($parameters);

        if ($placeholders) {
            return $this->replaceCallbackPlaceholders($json, $placeholders);
        }

        return $json;
    }

    protected function generateCallbackPlaceholders(): array
    {
        $callbacks = $this->getCallbacks();
        $placeholders = [];

        foreach ($callbacks as $name => $callback) {
            $placeholders[$name] = '[' . \md5($callback) . ']';
        }

        return $placeholders;
    }

    protected function replaceCallbackPlaceholders(string $json, array $placeholders): string
    {
        $search = [];
        $replace = [];

        foreach ($placeholders as $name => $placeholder) {
            $search[] = '"' . $placeholder . '"';
            $replace[] = $this->getCallbacks()[$name];
        }

        return \str_replace($search, $replace, $json);
    }
}

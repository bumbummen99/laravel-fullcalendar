<?php

namespace MaddHatter\LaravelFullcalendar;

/**
 * Simple DTO that implements the Event interface
 */
class SimpleEvent implements IdentifiableEvent
{
    /**
     * @var string|int|null
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var bool
     */
    public $isAllDay;

    /**
     * @var \DateTimeInterface
     */
    public $start;

    /**
     * @var \DateTimeInterface
     */
    public $end;

    /**
     * @var array
     */
    private $options;

    /**
     * @param string                    $title
     * @param bool                      $isAllDay
     * @param string|\DateTimeInterface $start
     * @param string|\DateTimeInterface $end
     * @param int|string|null           $id
     * @param array                     $options
     */
    public function __construct($title, $isAllDay, $start, $end, $id = null, $options = [])
    {
        $this->title = $title;
        $this->isAllDay = $isAllDay;
        $this->start = $start instanceof \DateTimeInterface ? $start : new \DateTime($start);
        $this->end = $start instanceof \DateTimeInterface ? $end : new \DateTime($end);
        $this->id = $id;
        $this->options = $options;
    }

    /**
     * Get the event's ID
     *
     * @return int|string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return $this->isAllDay;
    }

    /**
     * Get the start time
     *
     * @return \DateTimeInterface
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return \DateTimeInterface
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get the optional event options
     *
     * @return array
     */
    public function getEventOptions()
    {
        return $this->options;
    }
}

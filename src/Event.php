<?php

namespace MaddHatter\LaravelFullcalendar;

interface Event
{
    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay();

    /**
     * Get the start time
     *
     * @return \DateTimeInterface
     */
    public function getStart();

    /**
     * Get the end time
     *
     * @return \DateTimeInterface
     */
    public function getEnd();
}

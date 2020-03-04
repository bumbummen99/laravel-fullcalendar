<?php

namespace MaddHatter\LaravelFullcalendar\Contracts;

interface IdentifiableEvent extends Event
{
    /**
     * @return string|int|null
     */
    public function id();
}

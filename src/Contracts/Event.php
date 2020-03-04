<?php

namespace MaddHatter\LaravelFullcalendar\Contracts;

interface Event
{
    public function title(): string;

    public function allDay(): bool;

    public function start(): \DateTimeInterface;

    public function end(): \DateTimeInterface;
}

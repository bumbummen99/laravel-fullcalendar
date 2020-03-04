<?php

namespace MaddHatter\LaravelFullcalendar\Contracts;

interface OptionableEvent extends Event
{
    public function options(): array;
}

<?php

namespace MaddHatter\LaravelFullcalendar\Facades;

use Illuminate\Support\Facades\Facade;
use MaddHatter\LaravelFullcalendar\Calendar as RealCalendar;
use MaddHatter\LaravelFullcalendar\Contracts\Event;

/**
 * @method static string calendar()
 * @method static string script()
 * @method static void setId(string $id)
 * @method static string getId()
 * @method static void add(Event $event, array $customAttributes = [])
 * @method static void addEvents(Event[] $events, array $customAttributes = [])
 * @method static void setOptions(array $options)
 * @method static array getOptions()
 * @method static void setCallbacks(array $callbacks)
 * @method static array getCallbacks()
 * @method static string toJson()
 *
 * @see RealCalendar
 */
final class Calendar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-fullcalendar';
    }
}

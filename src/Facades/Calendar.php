<?php

namespace MaddHatter\LaravelFullcalendar\Facades;

use Illuminate\Support\Facades\Facade;
use MaddHatter\LaravelFullcalendar\Calendar as RealCalendar;
use MaddHatter\LaravelFullcalendar\Event;

/**
 * @method static string calendar()
 * @method static string script()
 * @method static RealCalendar setId(string $id)
 * @method static string getId()
 * @method static RealCalendar addEvent(Event $event, array $customAttributes = [])
 * @method static RealCalendar addEvents($events, array $customAttributes = [])
 * @method static RealCalendar setOptions(array $options)
 * @method static array getOptions()
 * @method static RealCalendar setCallbacks(array $callbacks)
 * @method static array getCallbacks()
 * @method static string getOptionsJson()
 *
 * @see RealCalendar
 */
final class Calendar extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-fullcalendar';
    }
}

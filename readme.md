# Laravel FullCalendar

This is an fork of the 1.3 version of the [laravel-fullcalendar](https://github.com/maddhatter/laravel-fullcalendar) package by Shawn Tunney to provide support for Laravel 6+.

# Installation

The package can be installed with composer:
```
composer require skyraptor/laravel-fullcalendar
```

Also you will have to include the JS and CSS of FullCalendar, you can do so by using the official CDN:
```
<link href="https://unpkg.com/@fullcalendar/core/main.min.css" rel="stylesheet">
<link href="https://unpkg.com/@fullcalendar/daygrid/main.min.css" rel="stylesheet">
<link href="https://unpkg.com/@fullcalendar/bootstrap@4.4.0/main.min.css" rel="stylesheet">

<script src="https://unpkg.com/@fullcalendar/core@4.4.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/daygrid/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/bootstrap/main.min.js"></script>

<!-- FullCalendar initialization script -->
{!! $calendar->script() !!}
```
Further CDN addresses can be found on https://fullcalendar.io/docs/plugin-index

The HTML can be displayed as so:
```
{!! $calendar->calendar() !!}
```

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar-{{ $id }}');

        var calendar = new FullCalendar.Calendar(calendarEl, {!! $options !!});

        calendar.render();
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-3">Kalender Kegiatan</h3>
    <div id="calendar"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: @json($events),
        eventClick: function(info) {
            window.location.href = info.event.url;
        }
    });

    calendar.render();
});
</script>

<x-app-layout>
    <div class="min-h-screen bg-stone-50 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

            {{-- Page heading --}}
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <h1 class="text-5xl font-serif font-bold text-gray-900 dark:text-white leading-tight tracking-tight">Calendar</h1>
                    <div class="mt-3 h-px w-16 bg-amber-400"></div>
                </div>
                <a href="{{ route('calendar.create') }}"
                   class="inline-flex items-center gap-2 bg-gray-800 dark:bg-gray-700 text-white text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-gray-700 dark:hover:bg-gray-600 active:scale-95 transition-all duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Event
                </a>
            </div>

            {{-- Calendar card --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 sm:p-8">
                <div id="calendar"></div>
            </div>

        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <style>
        .fc-day { cursor: pointer; }
        .fc-daygrid-day:hover .fc-daygrid-day-frame { background-color: #6d7e8f !important; }
        .dark .fc-daygrid-day:hover .fc-daygrid-day-frame { background-color: #1f2937 !important; }
    </style>

    <script>
        const events = @json($events);
        const createUrl = "{{ route('calendar.create') }}";

        document.addEventListener('DOMContentLoaded', function () {
            const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                timeZone: 'Europe/Riga',
                events: events,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                dateClick: function (info) {
                    window.location.href = createUrl + '?date=' + info.dateStr;
                },
            });
            calendar.render();
        });
    </script>
</x-app-layout>
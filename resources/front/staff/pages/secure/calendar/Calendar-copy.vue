<script setup lang="ts">
import {CalendarOptions, DateSelectArg, EventApi, EventClickArg, EventInput} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import FullCalendar from '@fullcalendar/vue3';
import {useQuery} from '@tanstack/vue-query';
import {onMounted, onUnmounted,ref, watch} from 'vue';
import {useGetAlmanacsRequest} from '@/common/api/requests/modules/almanac/useAlmanacRequest';
import {Almanac} from '@/common/parsers/almanacParser';

// Helper for generating unique event IDs
let eventGuid = 0;
function createEventId() {
    return String(eventGuid++);
}

// Today's date string in YYYY-MM-DD format
const todayStr = new Date().toISOString().replace(/T.*$/, ''); // YYYY-MM-DD of today

// Initial events setup
const INITIAL_EVENTS: EventInput[] = [
    {
        id: createEventId(),
        title: 'All-day event',
        start: todayStr,
    },
    {
        id: createEventId(),
        title: 'Timed event',
        start: todayStr + 'T12:00:00',
    },
];

const calendarOptions = ref<CalendarOptions>({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    initialView: 'dayGridMonth',
    initialEvents: INITIAL_EVENTS,
    editable: true,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    weekends: true,
    select: handleDateSelect,
    eventClick: handleEventClick,
    eventsSet: handleEvents,
});

const currentEvents = ref<EventApi[]>([]);

function handleWeekendsToggle() {
    calendarOptions.value.weekends = !calendarOptions.value.weekends; // update a property
}

function handleDateSelect(selectInfo: DateSelectArg) {
    const title = prompt('Please enter a new title for your event');
    const calendarApi = selectInfo.view.calendar;

    calendarApi.unselect(); // clear date selection

    if (title) {
        calendarApi.addEvent({
            id: createEventId(),
            title,
            start: selectInfo.startStr,
            end: selectInfo.endStr,
            allDay: selectInfo.allDay,
        });
    }
}

function handleEventClick(clickInfo: EventClickArg) {
    if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
        clickInfo.event.remove();
    }
}

function handleEvents(events: EventApi[]) {
    currentEvents.value = events;
}

onUnmounted(() => {
    // Cleanup or additional teardown logic if needed
});

const getAlmanacs = () => {
    return useQuery({
        queryKey: ['getAlmanacsKey'],
        queryFn: async () => {
            const response = await useGetAlmanacsRequest({paginate: 'false'});
            return response.data.map((almanac: Almanac) => ({
                id: almanac.id,
                title: almanac.type,
                start: almanac.start,
                end: almanac.end,
                description: almanac.purpose,
                color: determineColor(almanac),
            }));
        },
    });
};
//default loading
const {isLoading, data, refetch: fetchAlmanacs} = getAlmanacs();
const determineColor = (almanac: any): string => {
    const now = new Date();
    const startDate = new Date(almanac.start);
    if (startDate < now) return '#777777'; // Grey for past events
    switch (almanac.status) {
        case 'approved': return '#28a745'; // Green for approved
        case 'upcoming': return '#ffc107'; // Yellow for upcoming
        default: return '#dc3545'; // Red for others
    }
};

onMounted(() => {
    fetchAlmanacs();
});

watch(data, (newData) => {
    if (newData) {
        calendarOptions.value.events = newData;
    }
}, {immediate: true});
</script>


<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Calendar</h3>
            <button class="float-right" @click="toggleWeekends">toggle weekends</button>
        </div>
        <div class="card-body p-0">            
            <FullCalendar :options="calendarOptions" >
                <template v-slot:eventContent='arg'>
                    <b>{{ arg.timeText }}</b>
                    <i>{{ arg.event.title }}</i>
                </template>
            </FullCalendar>
        </div>
    </div>
    
</template>
<style lang='css'>

</style>

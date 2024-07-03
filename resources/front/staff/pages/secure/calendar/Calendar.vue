<script setup lang="ts">
import {CalendarOptions} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import multiMonthPlugin from '@fullcalendar/multimonth';
import timeGridPlugin from '@fullcalendar/timegrid';
import FullCalendar from '@fullcalendar/vue3';
import {useQuery} from '@tanstack/vue-query';
import {onMounted, ref, watch} from 'vue';
import {useGetAlmanacsRequest} from '@/common/api/requests/modules/almanac/useAlmanacRequest';
import {useGetSchedulesRequest} from '@/common/api/requests/modules/schedule/useScheduleRequest';
import useAuthStore from '@/common/stores/auth.store';

const authStore = useAuthStore();

const calendarOptions = ref<CalendarOptions>({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, multiMonthPlugin],
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'timeGridDay,timeGridWeek,dayGridMonth,multiMonthYear',
    },
    initialView: 'dayGridMonth',
    editable: true,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    weekends: true,
    events: [],
});

const getAlmanacs = () => {
    return useQuery({
        queryKey: ['getCalendarAlmanacsKey'],
        queryFn: async () => {
            const response = await useGetAlmanacsRequest({paginate: 'false'});
            return response.data.map(formatEvent('almanac'));
        },
    });
};

const {isLoading: isLoadingAlmanacs, data: almanacData, refetch: fetchAlmanacs} = getAlmanacs();

const getSchedules = () => {
    return useQuery({
        queryKey: ['getCalendarMeetingsSchedulesKey'],
        queryFn: async () => {
            const response = await useGetSchedulesRequest({paginate: 'false'});
            return response.data.map(formatEvent('meeting'));
        },
    });
};

const {isLoading: isLoadingMeetings, data: meetingData, refetch: fetchSchedules} = getSchedules();

function formatEvent(type) {
    return (data) => {
        return {
            id: data.id,
            title: type === 'meeting' ? data.meeting?.title : data.type,
            start: type === 'meeting' ? convertToISOFormat(`${data.date} ${data.start_time}`) : convertToISOFormat(`${data.start}`),
            end: type === 'meeting' ? convertToISOFormat(`${data.date} ${data.end_time}`) : convertToISOFormat(`${data.end}`),
            description: type === 'meeting' ? data.meeting?.title : data.purpose,
            color: determineColor(data, type),
            textColor: '#fff',  // Ensure text is visible on dark backgrounds
        };
    };
}

function convertToISOFormat(dateTimeString: string): string {
    const parts = dateTimeString.split(/[- :\.]/);
    if (parts.length === 3) {
        if (parts[0].length === 4) {
            return `${parts[0]}-${parts[1]}-${parts[2]}`;
        } else {
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
    } else if (parts.length >= 5) {
        const [day, month, year, hour, minute] = parts.slice(0, 5).map(Number);
        const amPm = parts[5] ? parts[5].toLowerCase() : '';
        let formattedHour = hour;

        if (amPm === 'pm' && hour < 12) {
            formattedHour += 12;
        } else if (amPm === 'am' && hour === 12) {
            formattedHour = 0;
        }

        if (parts[0].length === 4) {
            return `${parts[0]}-${parts[1]}-${parts[2]}T${String(formattedHour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
        } else {
            return `${parts[2]}-${parts[1]}-${parts[0]}T${String(formattedHour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
        }
    }
    return dateTimeString;
}

function determineColor(data, type) {
    const now = new Date();
    const startDate = new Date(type === 'meeting' ? `${data.date} ${data.start_time}` : data.start);

    const colorConfig = {
        almanac: {
            base: 'bg-warning text-dark', // Yellow
            approved: 'bg-success text-white', // Green
            upcoming: 'bg-primary text-white', // Blue
            past: 'bg-secondary text-white', // Grey
        },
        meeting: {
            base: 'bg-info text-white', // Light Blue
            published: 'bg-success text-white', // Green
            unpublished: 'bg-warning text-dark', // Yellow
            past: 'bg-secondary text-white', // Grey
        },
    };

    const meetingStatusToColorKey = {
        published: 'published',
        unpublished: 'unpublished',
    };

    if (startDate < now) {
        return colorConfig[type].past;
    }
    const statusKey = type === 'meeting' ? meetingStatusToColorKey[data.meeting?.status] : data.status;
    return colorConfig[type][statusKey] || colorConfig[type].base;
}

watch([almanacData, meetingData], ([newAlmanacs, newMeetings]) => {
    if (newAlmanacs && newMeetings) {
        calendarOptions.value.events = [...newAlmanacs, ...newMeetings];
    }
}, {immediate: true});

onMounted(() => {
    fetchAlmanacs();
    fetchSchedules();
});
</script>

<template>
    <div class="container-fluid" v-if="authStore.hasPermission(['view calendar'])">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Calendar</h3>
                <button class="float-right" @click="toggleWeekends">toggle weekends</button>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <!-- Column for Almanac Year Schedule Meetings -->
                        <div class="col-md-6">
                            <h1 class="h3 mb-3">Almanac Year Schedule Meetings</h1>
                            <ul class="list-unstyled">
                                <li class="legend-item">
                                    <span class="badge bg-success">
                                        ●</span> Approved Almanac
                                </li>
                                <li class="legend-item">
                                    <span class="badge bg-primary">
                                        ●</span> Upcoming Almanac
                                </li>
                                <li class="legend-item">
                                    <span class="badge bg-secondary">
                                        ●</span> Past Almanac
                                </li>
                                <li class="legend-item">
                                    <span class="badge bg-warning text-dark">
                                        ●</span> Almanac Base
                                </li>
                            </ul>
                        </div>
            
                        <!-- Column for Actual Meetings -->
                        <div class="col-md-6">
                            <h1 class="h3 mb-3">Actual Meetings</h1>
                            <ul class="list-unstyled">
                                <li class="legend-item">
                                    <span class="badge bg-success">
                                        ●</span> Approved Meeting
                                </li>
                                <li class="legend-item">
                                    <span class="badge bg-warning text-dark">
                                        ●</span> Upcoming Meeting
                                </li>
                                <li class="legend-item">
                                    <span class="badge bg-secondary">
                                        ●</span> Past Meeting
                                </li>
                                <li class="legend-item">
                                    <span class="badge bg-info">
                                        ●</span> Meeting Base
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">            
                <FullCalendar :options="calendarOptions">
                    <template v-slot:eventContent='arg'>
                        <div :class="arg.event.extendedProps.color" class="p-1 rounded">
                            <b>{{ arg.timeText }}</b>
                            <i>{{ arg.event.title }}</i>
                        </div>
                    </template>
                </FullCalendar>
                <div v-if="isLoadingAlmanacs || isLoadingMeetings">Loading...</div>
            </div>
        </div>
    </div>
    <div class="container-fluid" v-else>
        <p class="m-0">
            <span class="h3  text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div> 
</template>

<style scoped>
.legend-item {
    display: flex;
    align-items: center;
    font-size: 14px;
    margin-bottom: 8px; /* consistent spacing */
}

.legend-color {
    font-size: 20px; /* larger to make the dot prominent */
    margin-right: 10px; /* space between the dot and text */
}

.card-header ul {
    padding-left: 20px; /* Adjust if needed */
}
</style>

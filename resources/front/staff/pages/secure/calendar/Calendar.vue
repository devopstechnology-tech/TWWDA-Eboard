<script setup lang="ts">
import {CalendarOptions, DateSelectArg, EventApi, EventClickArg} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import multiMonthPlugin from '@fullcalendar/multimonth';
import timeGridPlugin from '@fullcalendar/timegrid';
import FullCalendar from '@fullcalendar/vue3';
import {useQuery} from '@tanstack/vue-query';
import {onMounted, ref, watch} from 'vue';
import {useGetAlmanacsRequest} from '@/common/api/requests/modules/almanac/useAlmanacRequest';
import {useGetMeetingsRequest} from '@/common/api/requests/modules/meeting/useMeetingRequest';

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

const getMeetings = () => {
    return useQuery({
        queryKey: ['getCalendarMeetingsKey'],
        queryFn: async () => {
            const response = await useGetMeetingsRequest({paginate: 'false'});
            return response.data.map(formatEvent('meeting'));
        },
    });
};
const {isLoading:isLoadingMeetings, data:meetingData, refetch: fetchMeetings} = getMeetings();
const formatEvent = (type) => (data) => ({
    id: data.id,
    title:data.title || data.type,
    start: type === 'meeting' ? data.schedule?.start_time : data.start,
    end: type === 'meeting' ? data.schedule?.end_time : data.end,
    description: data.description || data.purpose,
    color: determineColor(data, type),
});
function determineColor(data, type) {
    const now = new Date();
    const startDate = new Date(type === 'meeting' ? data.schedule?.start_time : data.start);
    
    // Define base and specific colors for each type and status
    const colorConfig = {
        almanac: {
            base: '#DFFF00', // Bright yellow
            approved: '#FFBF00', // Orange for approved
            upcoming: '#FF7F50', // Coral for upcoming
            past: '#DE3163',  // Cerise for past
        },
        meeting: {
            base: '#6495ED', // Cornflower Blue
            published: '#9FE2BF', // Soft Green for published (equivalent to approved)
            unpublished: '#40E0D0', // Turquoise for unpublished (equivalent to upcoming)
            past: '#CCCCFF',  // Light periwinkle for past
        },
    };

    // Mapping meeting statuses to color configurations
    const meetingStatusToColorKey = {
        published: 'published',
        unpublished: 'unpublished',
        // Other statuses can be added here
    };

    if (startDate < now) {
        return colorConfig[type].past;
    }
    // Use the mapping for meetings or default to status directly for almanacs
    const statusKey = type === 'meeting' ? meetingStatusToColorKey[data.status] : data.status;
    return colorConfig[type][statusKey] || colorConfig[type].base;
}




watch([almanacData, meetingData], ([newAlmanacs, newMeetings]) => {
    if (newAlmanacs && newMeetings) {
        calendarOptions.value.events = [...newAlmanacs, ...newMeetings];
    }
}, {immediate: true});

onMounted(() => {
    fetchAlmanacs();
    fetchMeetings();
});

// Event handlers as previously defined
</script>


<template>
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
                            <li class="legend-item"><span class="legend-color" style="color:#FFBF00;">●</span> Approved Almanac</li>
                            <li class="legend-item"><span class="legend-color" style="color:#FF7F50;">●</span> Upcoming Almanac</li>
                            <li class="legend-item"><span class="legend-color" style="color:#DE3163;">●</span> Past Almanac</li>
                            <li class="legend-item"><span class="legend-color" style="color:#DFFF00;">●</span> Almanac Base</li>
                        </ul>
                    </div>
            
                    <!-- Column for Actual Meetings -->
                    <div class="col-md-6">
                        <h1 class="h3 mb-3">Actual Meetings</h1>
                        <ul class="list-unstyled">
                            <li class="legend-item"><span class="legend-color" style="color:#9FE2BF;">●</span> Approved Meeting</li>
                            <li class="legend-item"><span class="legend-color" style="color:#40E0D0;">●</span> Upcoming Meeting</li>
                            <li class="legend-item"><span class="legend-color" style="color:#CCCCFF;">●</span> Past Meeting</li>
                            <li class="legend-item"><span class="legend-color" style="color:#6495ED;">●</span> Meeting Base</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">            
            <FullCalendar :options="calendarOptions" >
                <template v-slot:eventContent='arg'>
                    <b>{{ arg.timeText }}</b>
                    <i>{{ arg.event.title }}</i>
                </template>
            </FullCalendar>
            <div v-if="isLoadingAlmanacs || isLoadingMeetings">Loading...</div>
        </div>
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

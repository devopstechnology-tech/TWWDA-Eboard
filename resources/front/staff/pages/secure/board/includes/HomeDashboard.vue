<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {notify} from '@kyvg/vue3-notification';
import {useQuery} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {formatISO,parseISO} from 'date-fns';
import {v4 as uuidv4} from 'uuid';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref, watch} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {
    useCreateBoardMeetingRequest,
    useDeleteMeetingRequest,
    useGetBoardMeetingsRequest,
    usePublishMeetingRequest,    useUpdateBoardMeetingRequest} from '@/common/api/requests/modules/meeting/useMeetingRequest';
import{useGetStaffsRequest}from '@/common/api/requests/staff/useStaffRequest';
import FormDateInput from '@/common/components/FormDateInput.vue';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormMultiSelect from '@/common/components/FormMultiSelect.vue';
import FormQuillEditor from '@/common/components/FormQuillEditor.vue';
import FormRadioInput from '@/common/components/FormRadioInput.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formatDate,
    FormattedAgo,
    getDayFromDate,
    getMonthAbbreviation,
    // combineDateAndTime,
    // formatDate,
    // formatDateToReadableString,
    getTimeDuration,
    getYearFromDate,
    isPast,
    truncateDescription,  
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Meeting} from '@/common/parsers/meetingParser';
import {Schedule} from '@/common/parsers/scheduleParser';
import useAuthStore from '@/common/stores/auth.store';
import {Meta} from '@/common/types/types';
import Multiselect from '@@/@vueform/multiselect';
import {ScheduleRequestPayload} from '../../../../../common/parsers/scheduleParser';


const authStore = useAuthStore();
// v-if="authStore.hasPermission(['edit board'])"
//constants
const showCreate = ref(false);
const action = ref('create');
const selectedMeeting = ref<Meeting | null>(null);
const MeetingModal = ref<HTMLDialogElement | null>(null);
const ScheduleModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();
const page = ref(1);
const perPage = ref(15);
const meta = ref<Meta>();
const route = useRoute();
const boardId = route.params.boardId as string;
const selectedConferenceType = ref('');

//inputs forms handling
//meeting
const scheduleSchema = yup.object({
    id: yup.string().required(),
    date: yup.string().required(),
    start_time: yup.string().required(),
    end_time: yup.string().required(),
    status:yup.string().nullable(),
    heldstatus:yup.string().nullable(),
    meeting_id: yup.string().nullable(),
});
const schema = yup.object({
    title: yup.string().required(),
    conference: yup.string().required(),
    location: yup.string().required(),
    link: yup.string().nullable(),
    description: yup.string().required(),
    status: yup.string().required(),
    board_id: yup.string().required(),
    type: yup.string().required(),
    //schedules
    schedules: yup.array().of(scheduleSchema).required(),

});
const {
    handleSubmit, setErrors, setFieldValue, values} = useForm<{
    title:string;
    conference:string;
    location:string;
    description:string;
    link:string | null;
    board_id:string;
    status:string;
    type:string;
    //schedule
    schedules:{
        id:string;
        date:string;
        start_time:string;
        end_time:string;
        status:string|null;
        heldstatus:string|null;
        meeting_id:string|null;
    }[] | [];
}>({
    validationSchema: schema,
    initialValues: {
        title:'',
        conference:'',
        location:'',
        description:'',
        link:null,
        board_id: boardId,
        status: 'unpublished',
        //schedule
        type:'single',
        schedules:[
            {
                id: uuidv4(),
                date: '',
                start_time: '',
                end_time: '',
                status: null,
                heldstatus: null,
                meeting_id: null,
            },
        ],        
    },
});

// modals

const openCreateMeetingModal = () => {
    reseting();  
    action.value = 'create';
    showCreate.value = true;
    MeetingModal.value?.showModal();
};
const openEditMeetingModal = (e: Meeting) => {
    reseting();
    selectedMeeting.value = e;
    // Set field values here
    setFieldValue('title', e.title);
    setFieldValue('conference', e.conference);
    setFieldValue('location', e.location);
    setFieldValue('description', e.description);
    setFieldValue('type', e.type);
    setFieldValue('status', e.status);
    setFieldValue('schedules',e.schedules);
    const schedule = {
        id:e.nearestSchedule.id,
        date:e.nearestSchedule.date,
        start_time:e.nearestSchedule.start_time,
        end_time:e.nearestSchedule.end_time,
        status:e.nearestSchedule.status,
        heldstatus:e.nearestSchedule.heldstatus,
        meeting_id:e.nearestSchedule.meeting_id,
    }; 
    setFieldValue('schedules', [...values.schedules, schedule]);
    if (e.conference === 'Custom 3rd party Links') {
        handleConferenceTypeChange(e.conference);
        setFieldValue('link', e.link);
    }    
    console.log('values', values);
    action.value = 'edit';
    showCreate.value = true;
    MeetingModal.value?.showModal();
};
const openEditScheduleMeetingModal = (e: Meeting, schedule:Schedule) => {
    reseting();
    selectedMeeting.value = e;
    // Set field values here
    setFieldValue('title', e.title);
    setFieldValue('conference', e.conference);
    setFieldValue('location', e.location);
    setFieldValue('description', e.description);
    setFieldValue('type', e.type);
    setFieldValue('status', e.status);       
    if (e.conference === 'Custom 3rd party Links') {
        handleConferenceTypeChange(e.conference);
        setFieldValue('link', e.link);
    }  
    const sched = {
        id:schedule.id,
        date:schedule.date,
        start_time:schedule.start_time,
        end_time:schedule.end_time,
        status:schedule.status,
        heldstatus:schedule.heldstatus,
        meeting_id:schedule.meeting_id,
    };  
    setFieldValue('schedules', [sched]);
    console.log('values', values);
    action.value = 'schedule';
    showCreate.value = true;
    MeetingModal.value?.showModal();
};


// data
const conferenceTypes = [
    {name: 'In Person', value: 'No Vedio (Meeting in Person)'},
    // {name: 'Zoom', value: 'Zoom Web Conference'},
    {name: '3rd party', value: 'Custom 3rd party Links'},
];
const meetingschedules = [
    {name: 'Single', value: 'single'},
    // {name: 'Recurring', value: 'recurring'},
    {name: 'Find Date', value: 'manual'},
];

const handleConferenceTypeChange = (selectedValue) => {
    selectedConferenceType.value = selectedValue;
};
// onmount
onMounted(async () => {
    // getUsers();
});
// computed
const Meetings = computed(() => {
    return getMeetings;
});
const ConferenceTypes = computed(() => {
    return conferenceTypes;
});
const Meetingschedules = computed(() => {
    return meetingschedules;
});
// methods/functions
const getMeetings = (boardId: string) => {
    return useQuery({
        queryKey:
            ['getBoardMeetingsKey',
                page.value, perPage.value,
                boardId,
            ], // Include boardId in the queryKey
        queryFn: async () => {
            const response = await useGetBoardMeetingsRequest({
                page: page.value,
                perPage: perPage.value,
                Id:boardId, // Pass boardId to useGetMeetingsRequest
            });
            // Assuming meta and page are reactive variables
            meta.value = response.data.meta;
            return response.data.data;
        },
    });
};
const onSubmit = handleSubmit(async (values) => {
    console.log('values', values);
    console.log('setErrors',setErrors);
    try {
        if (action.value === 'create') {
            await useCreateBoardMeetingRequest(values);
        } else {
            if (selectedMeeting.value?.id) {
                await useUpdateBoardMeetingRequest(values, selectedMeeting.value?.id);
            }
        }
        await fetchMeetings();
        reseting();
        showCreate.value = false;
        MeetingModal.value?.close();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});


function reseting(){
    setFieldValue('title', '');
    setFieldValue('conference', '');
    setFieldValue('location', '');
    setFieldValue('description', '');
    setFieldValue('link', null);
    setFieldValue('type', 'single');
    setFieldValue('status', 'unpublished');
    // schedules
    setFieldValue('schedules', [
        {
            id: uuidv4(), 
            date: '',
            start_time: '',
            end_time: '',
            status: null,
            heldstatus: null,
            meeting_id: null,
        },
    ]);
    
}

const addEmptySchedule = () => {
    if (!Array.isArray(values.schedules)) {
        console.error('Invalid state: values.schedules is not an array.');
        setFieldValue('schedules', []); // Reinitialize to an empty array if necessary
    }
    const newSchedule = {
        id: uuidv4(),
        date: '',
        start_time: '',
        end_time: '',
        status: null,
        heldstatus: null,
        meeting_id: null,
    };    
    setFieldValue('schedules', [...values.schedules, newSchedule]);
};

const removeSchedule = (index: number) => {
       
    if (values.schedules.length === 1) {
        notify({
            title: 'Error',
            text: 'You need at least one date to schedule.',
            type: 'error',
        });
        return;
    }
    const updatedSchedules = values.schedules.filter((_, i) => i !== index); 
    setFieldValue('schedules', updatedSchedules);
};

//delete
const deleteMeeting = async (e: string) => {
    await useDeleteMeetingRequest(e);
    await fetchMeetings();
};

//default loading
const {isLoading, data, refetch: fetchMeetings} = getMeetings(boardId);

const currentStatus = ref('published');

const filteredMeetings = computed(() => {
    if (!data.value) return []; // Check if data is not loaded

    const now = new Date();

    // Filter meetings based on status or created date
    const filtered = data.value.filter(meeting => {
        if (currentStatus.value === 'past') {
            const meetingDate = new Date(meeting.created_at);
            return meetingDate < now;
        } else {
            return meeting.status.toLowerCase() === currentStatus.value;
        }
    });

    // Process each filtered meeting
    return filtered.map(meeting => {
        if (meeting.schedules && meeting.schedules.length > 0) {
            // Sort schedules by date in ascending order
            const sortedSchedules = [...meeting.schedules].sort((a, b) => {
                const dateA = new Date(a.date.split('-').reverse().join('-'));
                const dateB = new Date(b.date.split('-').reverse().join('-'));
                return dateA.getTime() - dateB.getTime();
            });

            // Find the nearest schedule, either future or past
            let nearestSchedule = sortedSchedules[0];
            let smallestDifference = Infinity;

            sortedSchedules.forEach(schedule => {
                const scheduleDate = new Date(schedule.date.split('-').reverse().join('-'));
                const timeDifference = scheduleDate.getTime() - now.getTime();

                if (Math.abs(timeDifference) < Math.abs(smallestDifference)) {
                    smallestDifference = timeDifference;
                    nearestSchedule = schedule;
                }
            });

            // Create a new meeting object with the nearest schedule
            const updatedMeeting = {
                ...meeting,
                nearestSchedule, // Add nearest schedule to meeting
                schedules: sortedSchedules.filter(
                    schedule => schedule.id !== nearestSchedule.id,
                ), // Retain all schedules including past ones
            };

            return updatedMeeting;
        } else {
            // If no schedules, return the meeting as is
            return meeting;
        }
    });
});






const filterMeetings = (status: string) => {
    currentStatus.value = status;
};
const getHeldStatusClass = (status: string) => {
    switch (status) {
        case 'scheduled':
            return 'text-primary';
        case 'held':
            return 'text-success';
        case 'cancelled':
            return 'text-danger';
        case 'postponed':
            return 'text-warning';
        default:
            return '';
    }
};
const onPublish = async (id: string) => {
    await usePublishMeetingRequest(id);
    await fetchMeetings();
};

</script>
<style scoped>
</style>
<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-widget">
                <div class="card-header">
                    <h1 class="h2 mb-2 lg:mb-0">Meetings</h1>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'published' }"
                                @click="filterMeetings('published')">
                            Published
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'unpublished' }"
                                @click="filterMeetings('unpublished')">
                            UnPublished
                        </button>
                        <button type="button" class="btn btn-tool"
                                :class="{ 'btn-info': currentStatus === 'past' }"
                                @click="filterMeetings('past')">
                            Past
                        </button>
                        <button  v-if="authStore.hasPermission(['create meeting'])"
                                 type="button" @click.prevent="openCreateMeetingModal" class="btn btn-tool">
                            <i class="far fa fa-plus mr-2 "></i>
                        </button>
                    </div>
                   
                    <!-- /.card-tools -->
                </div>

             
                <!-- /.card-header -->
                <div class="card-body" v-if="authStore.hasPermission(['view meeting'])">
                    <ul class="products-list product-list-in-card pl-2 pr-2"  v-if="filteredMeetings.length > 0">
                        <li class="item" v-for="meeting in filteredMeetings" :key="meeting.id">
                            <div class="product-img meeting-custom-size mr-2">
                                
                                <div class="calendar-icon w-full flex flex-col items-center 
                                        justify-center mt-1 calendaheight" v-if="meeting?.nearestSchedule">
                                    <div class="month customonth">
                                        {{getMonthAbbreviation(meeting.nearestSchedule.date)}}                                        
                                    </div>
                                    <div class="day font-medium customday">
                                        <span>{{getDayFromDate(meeting.nearestSchedule.date)}}</span>
                                    </div>
                                    <div class="year font-medium customyear">
                                        <span>{{getYearFromDate(meeting.nearestSchedule.date)}}</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-danger font-bold ml-2 mr-2">
                                        Upcoming
                                    </span>
                                </div>
                            </div>
                            <div class="product-info">
                                <!-- {{meeting?.nearestSchedule?.date}} -->
                                <router-link  v-if="authStore.hasPermission(['view meeting'])"
                                              :to="{ name: 'BoardMeetingDetails',
                                                     params: {
                                                         boardId: boardId,
                                                         meetingId: meeting.id,
                                                         scheduleId: meeting.nearestSchedule.id
                                                     }
                                              }"
                                              class="product-title">
                                    Meeting: <span class="text-primary text-bold">{{ meeting.title }}</span>
                                    <span class="badge float-right bg-white" v-if="currentStatus === 'unpublished'">
                                        <a href=""  v-if="authStore.hasPermission(['publish meeting'])"
                                           @click.prevent="onPublish(meeting.id)"
                                           class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                            Publish
                                        </a>
                                    </span>
                                    <span class="badge float-right bg-white">
                                        <router-link  v-if="authStore.hasPermission(['view meeting'])"
                                                      :to="{ name: 'BoardMeetingDetails',
                                                             params: {
                                                                 boardId: boardId,
                                                                 meetingId: meeting.id,
                                                                 scheduleId: meeting.nearestSchedule.id
                                                             }
                                                      }"
                                                      class="text-green-500
                                                hover:text-green-700 transition duration-150 ease-in-out">
                                            <i class="far fa-eye"></i>
                                        </router-link>
                                    </span>
                                    <span class="badge float-right bg-white" >
                                        <a href=""  v-if="authStore.hasPermission(['edit meeting'])"
                                           @click.prevent="openEditMeetingModal(meeting)"
                                           class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </span>
                                </router-link>
                                <span v-if="authStore.hasPermission(['edit meeting'])" 
                                      class="product-description">
                                    Description: 
                                    <span class="text-primary text-bold"
                                          v-html="meeting.description">
                                    </span>
                                </span>
                                <div class="row border-top border-bottom border-warning 
                                d-flex justify-content-between align-items-center bg-warning" 
                                     v-if="meeting?.nearestSchedule">
                                    <div>
                                        <span class="text-primary bg-primary font-bold ml-2 mr-2">
                                            Upcoming {{formatDate(meeting.nearestSchedule.date)}}
                                        </span>
                                        ||
                                        <!-- Start: <span class="text-primary font-bold ml-2 mr-2">
                                            {{meeting.nearestSchedule.start_time}}
                                        </span>
                                        ||
                                        End: <span class="text-primary font-bold ml-2 mr-2">
                                            {{meeting.nearestSchedule.end_time}}
                                        </span>
                                        ||
                                        Duration: <span class="text-primary font-bold ml-2 mr-2">
                                            {{ getTimeDuration(meeting.nearestSchedule.start_time,
                                                               meeting.nearestSchedule.end_time, 'hours') }}
                                        </span>
                                        || -->
                                        When: <span class="text-primary font-bold ml-2 mr-2">
                                            {{ FormattedAgo(meeting.nearestSchedule.date) }}
                                        </span>
                                        ||
                                        Held Status: <span 
                                            :class="getHeldStatusClass(meeting.nearestSchedule.heldstatus)" 
                                            class="font-bold ml-2 mr-2">
                                            {{ meeting.nearestSchedule.heldstatus }}
                                        </span>
                                    </div>
                                    <span v-if="meeting?.nearestSchedule">
                                        <button v-if="meeting.nearestSchedule.heldstatus === 'scheduled'" 
                                                class="btn btn-sm btn-warning 
                                            font-bold ml-2 mr-2 mt-1 mb-1" 
                                                @click.prevent="openEditScheduleMeetingModal(meeting, meeting.nearestSchedule)">
                                            Postpone
                                        </button>
                                    </span>
                               
                                </div>
                                <div class="text-bold text-red" v-if="meeting.schedules.length">Other Schedules</div>
                                <div class="text-bold text-red" v-else>no Other Recuring Schdedules</div>
                                <div :class="['row', 'border-top', 'border-bottom', 'border-warning', 
                                              'd-flex', 'justify-content-between', 'align-items-center', 
                                              isPast(schedule.date) ? 'bg-gray' : '']"
                                     v-for="schedule in meeting.schedules" :key="schedule.id">

                                    <div>
                                        Day: <span class="text-primary font-bold ml-2 mr-2">
                                            {{formatDate(schedule.date)}}
                                        </span>
                                        ||
                                        <!-- Start: <span class="text-primary font-bold ml-2 mr-2">
                                            {{schedule.start_time}}
                                        </span>
                                        ||
                                        End: <span class="text-primary font-bold ml-2 mr-2">
                                            {{schedule.end_time}}
                                        </span>
                                        ||
                                        Duration: <span class="text-primary font-bold ml-2 mr-2">
                                            {{ getTimeDuration(schedule.start_time, schedule.end_time, 'hours') }}
                                        </span>
                                        || -->
                                        When: <span class="text-primary font-bold ml-2 mr-2">
                                            {{ FormattedAgo(schedule.date) }}
                                        </span> 
                                        ||
                                        Held Status: <span :class="getHeldStatusClass(schedule.heldstatus)" 
                                                           class="font-bold ml-2 mr-2">
                                            {{ schedule.heldstatus }}
                                        </span>
                                    </div>
                                    <span>
                                        <button v-if="schedule.heldstatus === 'scheduled' 
                                                    && authStore.hasPermission(['edit meeting'])" 
                                                class="btn btn-sm btn-warning 
                                            font-bold ml-2 mr-2 mt-1 mb-1" 
                                                @click.prevent="openEditScheduleMeetingModal(meeting, schedule)">
                                            Postpone
                                        </button>
                                        <router-link v-if="authStore.hasPermission(['view meeting'])"
                                                     :to="{ name: 'BoardMeetingDetails',
                                                            params: {
                                                                boardId: boardId,
                                                                meetingId: meeting.id,
                                                                scheduleId: schedule.id
                                                            }
                                                     }"
                                                     class="  mr-2
                                                hover:text-info transition duration-150 ease-in-out">
                                            <i class="far fa-eye"></i>
                                        </router-link>
                                    </span>                              
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div v-else>
                        No meetings found for {{ currentStatus }}
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-4">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Recent Activity</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-0"><div class="flex gap-3"><div class="flex-none"><img src="https://app.boardable.com/img/default_user.svg" class="avatar-img avatar-sm rounded-full" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SVG"></div> <div><div class="mb-1">
                            Nyariki Felix
                            commented on
                            <a href="https://app.boardable.com/felix-1/discussions/7f843e-volunteer-team">Volunteer Team</a></div> <div class="text-muted small">
                            1 day ago
                        </div></div></div></div> <div class="list-group-item p-0"><div class="flex gap-3"><div class="flex-none"><img src="https://app.boardable.com/img/default_user.svg" class="avatar-img avatar-sm rounded-full" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SVG"></div> <div><div class="mb-1">
                            Cynthia Muriithi
                            commented on
                            <a href="https://app.boardable.com/felix-1/discussions/7f843e-volunteer-team">Volunteer Team</a></div> <div class="text-muted small">
                            1 day ago
                        </div></div></div></div> <div class="list-group-item p-0"><div class="flex gap-3"><div class="flex-none"><img src="https://app.boardable.com/img/default_user.svg" class="avatar-img avatar-sm rounded-full" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SVG"></div> <div><div class="mb-1">
                            Cynthia Muriithi
                            added a discussion
                            <a href="https://app.boardable.com/felix-1/discussions/7f843e-volunteer-team">Volunteer Team</a></div> <div class="text-muted small">
                            1 day ago
                        </div></div></div></div> <div class="list-group-item p-0"><div class="flex gap-3"><div class="flex-none"><img src="https://app.boardable.com/img/default_user.svg" class="avatar-img avatar-sm rounded-full" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SVG"></div> <div><div class="mb-1">
                            Cynthia Muriithi
                            created a group
                            <a href="https://app.boardable.com/felix-1/groups/ae969a-finance-and-administration-board">Finance and Administration Board</a></div> <div class="text-muted small">
                            1 day ago
                        </div></div></div></div></div>
                </div>
            </div>
        </div> -->
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="meetingmodal" class="modal" ref="MeetingModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{ action == 'create' ? 'Create Meeting' : 'Edit Meeting' }}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="overflow-auto p-4" style="max-height: 80vh;"
                     :style="action == 'schedule' ? 'height:500px;':''">
                    <div class="grid grid-cols-3 md:grid-cols-3 gap-2 p-2">
                        <div class="col-span-3">
                            <form novalidate @submit.prevent="onSubmit" class="">
                                <div class="flex flex-wrap -mx-2 mt-2" 
                                     v-if="action == 'create' || action == 'edit'">
                                    <div class="w-full md:w-1/2 px-1 md:px-2">
                                        <FormInput
                                            :labeled="true"
                                            label="Meeting Title"
                                            name="title"
                                            placeholder="Enter Meeting Title"
                                            type="text"
                                        />
                                    </div>
                                    <div class="w-full md:w-1/2 px-1 md:px-2">
                                        <FormSelect
                                            :labeled="true"
                                            name="conference"
                                            label="Select Meeting Type"
                                            placeholder="Select Meeting Type"
                                            :options="ConferenceTypes"
                                            @selectedItem="handleConferenceTypeChange"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-2 mt-2"
                                     v-if="action == 'create' || action == 'edit'">
                                    <div class="w-full md:w-1/2 px-1 md:px-2">
                                        <FormInput
                                            v-if="selectedConferenceType === 'Custom 3rd party Links'"
                                            :labeled="true"
                                            label="Meeting Link"
                                            name="link"
                                            placeholder="Enter Third Party Link"
                                            type="text"
                                        />
                                    </div>
                                    <div class="w-full  px-1 md:px-2" 
                                         :class="selectedConferenceType === 'Custom 3rd party Links'? 'md:w-1/2':''">
                                        <FormInput
                                            :labeled="true"
                                            label="Meeting Location"
                                            name="location"
                                            placeholder="e.g 'Conference Room 6'"
                                            type="text"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-2 mt-2"
                                     v-if="action == 'create' || action == 'edit'">
                                    <FormQuillEditor 
                                        v-if="action == 'create' || action == 'edit'"
                                        label="Meeting Description"
                                        name="description"
                                        theme="snow"
                                        placeholder="Enter Meeting Description"
                                        toolbar="full"
                                        contentType="html"
                                        class="col-span-3"
                                    />
                                </div>
                                <div class="flex flex-wrap -mx-2 mt-2"
                                     v-if="action == 'create' || action == 'edit'">
                                    <FormRadioInput
                                        name="type"
                                        label="Meeting Schedule Type"
                                        placeholder="Select Meeting Schedule Type"
                                        :inline="true"
                                        :options="Meetingschedules"
                                        :checked="values.type"
                                    />
                                </div>
                                <div class="flex flex-wrap -mx-2 mt-2 relative"
                                     v-for="(schedule, index) in values.schedules" :key="index" 
                                     v-if="values.schedules">
                                    <!-- {{ schedule.start_time }} -->
                                    <div class="w-full md:w-1/3 px-1 md:px-2"> 
                                        <FormDateTimeInput
                                            :label="'Meeting Date ' + (index + 1)"
                                            :name="'schedules[' + index + '].date'"
                                            mode="date-picker"
                                            modeltype="dd-MM-yyyy"
                                            :enabletimepicker="false"
                                            placeholder="Meeting Date"
                                        />
                                    </div>                                    
                                    <div class="w-full md:w-1/3 px-1 md:px-2">
                                        <FormDateTimeInput
                                            :label="'Meeting Start Time ' + (index + 1)"
                                            :name="'schedules[' + index + '].start_time'"
                                            mode="time-picker"
                                            modeltype="h:mm bbbb"
                                            :is24="false"
                                            :enabletimepicker="true"
                                            placeholder="Select Start Time"
                                        />
                                    </div>
                                    <div class="w-full md:w-1/3 px-1 md:px-2">
                                        <FormDateTimeInput
                                            :label="'Meeting End Time ' + (index + 1)"
                                            :name="'schedules[' + index + '].end_time'"
                                            mode="time-picker"
                                            modeltype="h:mm bbbb"
                                            :is24="false"
                                            :enabletimepicker="true"
                                            placeholder="Select End Time"
                                        />
                                    </div> 
                                    <button v-if="action !== 'schedule'"  
                                            type="button" class="absolute top-0 right-0 mt-2 mr-2
                                            text-red-600 font-bold"
                                            @click.prevent="removeSchedule(index)">
                                        ✕
                                    </button>
                                </div>
                                <button v-if="values.type === 'manual' && action !== 'schedule'" 
                                        type="button"
                                        class="btn btn-primary mt-4"
                                        @click="addEmptySchedule">
                                    Add Another Data
                                </button>
                                <button type="submit" class="btn btn-primary btn-md w-full mt-6">
                                    {{ action === 'create' ? 'Create Meeting' : 'Edit Meeting' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
</template>
<style scoped>
.modal-box {
  max-width: 800px;
  width: 100%;
}
.btn-info {
  background-color: #17a2b8;
  color: #fff;
}



</style>

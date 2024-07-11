<script setup lang="ts">
import {useForm} from 'vee-validate';
import {onMounted, ref, watchEffect} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useCreateAttendanceRSVPRequest, useUpdateAttendanceRSVPRequest, useUpdateAttendanceSignatureRequest} from '@/common/api/requests/modules/attendance/useAttendanceRequest';
import {useGetSingleBoadMeetingRequest} from '@/common/api/requests/modules/meeting/useMeetingRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';
import {AttendanceRequestPayload} from '@/common/parsers/attendanceParser';
import {Meeting} from '@/common/parsers/meetingParser';
import useAuthStore from '@/common/stores/auth.store';
import AgendaComponent from './includes/Agenda.vue';
import ApprovedMinutes from './includes/ApprovedMinutes.vue';
import Attendance from './includes/Attendance.vue';
import ConflictofInterest from './includes/ConflictofInterest.vue';
import Documents from './includes/Documents.vue';
import HomeDashBoard from './includes/HomeDashBoard.vue';
import Members from './includes/Members.vue';
import TaskPolls from './includes/TaskPolls.vue';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const currentTab = ref('home');
const previousTab = ref('');

const tabs = [
    {id: 'home', name: 'Meeting Details', component: HomeDashBoard,permissions: ['view meeting']},
    {id: 'agenda', name: 'Agenda', component: AgendaComponent, permissions: ['view agenda']},
    {id: 'minutes', name: 'Minutes', component: ApprovedMinutes, permissions: ['view minutes']},
    {id: 'documents', name: 'Documents', component: Documents, permissions: ['view documents']},
    {id: 'tasks', name: 'Task & Polls', component: TaskPolls, permissions: ['view task', 'view poll']},
    {id: 'members', name: 'Members', component: Members, permissions: ['view meeting memberships']},
    {id: 'conflict-of-interest', name: 'Conflict of Interest', component: ConflictofInterest, permissions: ['view conflict forms']},
    {id: 'attendance', name: 'Attendance', component: Attendance, permissions: ['view attendances']},
];


const setActiveTab = (tabId: string) => {
    previousTab.value = currentTab.value;
    currentTab.value = tabId;
};


watchEffect(() => {
    if (route.query.previousTab) {
        previousTab.value = route.query.previousTab as string;
    }
    if (route.query.currentTab) {
        currentTab.value = route.query.currentTab as string;
    }
});


const committeeId = route.params.committeeId as string;
const meetingId = route.params.meetingId as string;
const scheduleId = route.params.scheduleId as string;
const meeting = ref<Meeting>();
const handleUnexpectedError = useUnexpectedErrorHandler();
const action = ref('create');

const schema = yup.object({
    id: yup.string().required(),
    rsvp_status: yup.string().nullable(),
    attendance_status: yup.string().nullable(),
});

const {
    handleSubmit, setErrors, setFieldValue,
} = useForm<{
    location: string|null;
    meeting_id: string|null;
    membership_id: string|null;
    membership: string|null;
    meeting: string|null;
    id: string;
    rsvp_status: string|null;
    attendance_status: string|null;
}>({
    validationSchema: schema,
    initialValues: {
        id: '',
        rsvp_status: '',
        attendance_status: '',
    },
});

const onSubmit = handleSubmit(async (values) => {
    try {
        const payload: AttendanceRequestPayload = {
            id: values.id,
            rsvp_status: values.rsvp_status,
            location: values.location,
            attendance_status: values.attendance_status,
            meeting_id: values.meeting_id,
            membership_id: values.membership_id,
            membership: values.membership,
            meeting: values.meeting,
        };
        if (action.value === 'create') {
            await useCreateAttendanceRSVPRequest(payload, meetingId);
        } else if(action.value === 'rsvp') {
            await useUpdateAttendanceRSVPRequest(payload, payload.id);
        } else if(action.value === 'attendance') {
            await useUpdateAttendanceSignatureRequest(payload, payload.id);
        }
        await authStore.updateProfile();
        window.dispatchEvent(new CustomEvent('meetingUpdated', {
            detail: {
                meetingId: meetingId,
            },
        }));

        reset();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});

const reset = () => {
    action.value = 'create';
    setFieldValue('id', '');
    setFieldValue('rsvp_status', '');
    setFieldValue('attendance_status', '');
};




onMounted(async () => {
    try {
        const data = await useGetSingleBoadMeetingRequest(meetingId);
        const meetingdata = data.data;
        meeting.value = meetingdata;
    } catch (error) {
        console.error('Error fetching meeting data:', error);
    }
});
</script>
<template>
    <div class="container-fluid" v-if="authStore.hasPermission(['view meeting'])">
        <div class="container-fluid" v-if="meeting">
            <div class="py-6">
                <div class="flex items-center">
                    <div class="lg:inline-flex p-3 mr-4rounded-lg custom-size">
                        <div class="calendar-icon w-full flex flex-col items-center 
                                        justify-center mt-1 calendaheight">
                            <div class="month customonth">{{getMonthAbbreviation(meeting?.schedules[0]?.date)}}</div>
                            <div class="day font-medium customday">
                                <span>{{getDayFromDate(meeting?.schedules[0]?.date)}}</span>
                            </div>
                            <div class="year font-medium customyear">
                                <span>{{getYearFromDate(meeting?.schedules[0]?.date)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="header-pretitle text-xs mb-1">
                            <a href="" @click.prevent="goBack()"
                               class="mb-2 h6 lg:mb-0 text-blue-primary font-bold">
                                <i class="fas fa-chevron-left fa-xs"></i> Meetings
                            </a>
                        </p>
                        <div class="flex items-center space-x-4">
                            <h1 class="header-title leading-10 mb-2 h6 lg:mb-0 
                            text-blue-primary font-bold" >{{ meeting.title }}</h1>
                            <!-- <button class="!hidden lg:!flex text-muted btn btn-icon" data-bs-toggle="tooltip"
                                    title="" data-copy-btn=""
                                    data-copy-text="https://app.committeeable.com/felix-1/meetings/59bfaf-123456"
                                    aria-label="Copy meeting link" data-bs-original-title="Copy meeting link">
                                <i class="fas fa-link"></i>
                            </button> -->
                        </div>
                    </div>
                    <div class="ml-auto flex self-end">
                        <div class="dropdown">
                            <a class="nav-link " href="#" id="navbarDropdown"
                               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu --73" aria-labelledby="navbarDropdown"
                                 style="    left: -73px !important;">
                                <a class="dropdown-item" href="#">Re-send meeting invite</a>
                                <a class="dropdown-item" href="#">Create Follow Up Meeting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Delete Meeting</a>
                            </div>
                        </div>
                        <div class="lg:flex mr-2">
                            <!-- <button data-bs-target="#send-message" data-bs-toggle="modal" class="btn btn-icon text-muted"
                                data-bs-tooltip="" aria-label="Email attendees" data-bs-original-title="" title="">
                            <i class="fas fa-envelope"></i>
                        </button>
                        <a href="" class="btn btn-icon text-muted mx-2" data-bs-toggle="tooltip" title=""
                           aria-label="Edit meeting" data-bs-original-title="Edit meeting">
                            <i class="fas fa-edit"></i>
                        </a> -->
                            <button class="btn btn-secondary" v-if="authStore.hasPermission(
                                        [
                                            'create minutes',
                                            'edit minutes'
                                        ])"
                                    @click.prevent="openMinuteTemplateSelectionModal()">
                                Minutes
                            </button>
                        </div>
                        <div class="flex justify-center btn-sm">
                        <!-- <MeetingRsvp
                            :attendee="Attendee"
                            :disableRemoteRsvp="0"
                            @rsvp-updated="handleRsvpUpdated"
                        /> -->
                        </div>
                    </div>
                </div>
                <div class="card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item" v-for="tab in filteredTabs" :key="tab.id">
                                <a class="nav-link" 
                                   :class="{ 'active': currentTab === tab.id }" 
                                   @click="setActiveTab(tab.id)">
                                    {{ tab.name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div v-for="tab in filteredTabs" 
                                 :key="tab.id" class="tab-pane fade" 
                                 :class="{ 'show active': currentTab === tab.id }" 
                                 :id="tab.id" role="tabpanel">
                                <component 
                                    :is="tab.component" 
                                    @change-tab="setActiveTab" 
                                    @memberships-updated="handleMembershipsUpdated" 
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center col-md-6">
                <dialog id="minutetemplateselectionmodal" class="modal" ref="MinuteTemplateSelectionmodal">
                    <form method="dialog" class="modal-box rounded-xl">
                        <h3 class="font-bold text-lg justify-center flex">
                            Take Minutes
                        </h3>
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        <div class="w-full mt-6 p-2">
                            <div class="font-thin text-sm flex flex-col items-center gap-6">
                                <form class="w-full rounded-xl mx-auto p-1 custom-modal">
                                    <h3 class="text-center text-base font-bold text-primary">
                                        How would you like to start?
                                    </h3>
                                    <div class="flex justify-center space-x-4 py-6">
                                        <router-link :to="{
                                                         name: 'CommitteeMeetingMinutes',
                                                         params: {
                                                             committeeId: committeeId,
                                                             meetingId: meetingId
                                                         },
                                                         query:
                                                             {
                                                                 defaultMinutes: 'false'
                                                             }
                                                     }"
                                                     class="btn btn-secondary h-auto !p-0 p-0 mb-0 card flex-1">
                                            <div class="text-center card-body">
                                                <div class="flex items-center justify-center mx-auto mb-1 -mt-12
                                        bg-white rounded-full shadow w-11 h-11">
                                                    <i class="fa fa-list"></i>
                                                </div>
                                                <h4 class="mb-0 text-gray-900">Start From Scratch</h4>
                                            </div>
                                        </router-link>
                                        <router-link :to="
                                                         {
                                                             name: 'CommitteeMeetingMinutes',
                                                             params: {
                                                                 committeeId: committeeId,
                                                                 meetingId: meetingId
                                                             },
                                                             query:
                                                                 {
                                                                     defaultMinutes: 'true'

                                                                 }
                                                         }"
                                                     class="btn btn-secondary h-auto !p-0 p-0 mb-0 card flex-1">
                                            <div class="text-center card-body">
                                                <div class="flex items-center justify-center mx-auto mb-1 -mt-12
                                        bg-white rounded-full shadow w-11 h-11">
                                                    <i class="far fa-file"></i>
                                                </div>
                                                <h4 class="mb-0 text-gray-900">Start From the Agenda</h4>
                                            </div>
                                        </router-link>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
                </dialog>
            </div>
        </div>
    </div>
    <div class="container-fluid" v-else>
        <p class="m-0">
            <span class="h3  text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div>  
   
</template>



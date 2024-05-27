<script setup lang="ts">
import {useForm} from 'vee-validate';
import {computed, onMounted,ref, watchEffect} from 'vue';
import {useRoute,useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetMeetingAgendasRequest} from '@/common/api/requests/modules/agenda/useAgendaRequest';
import {useCreateAttendanceRSVPRequest, useUpdateAttendanceRSVPRequest, useUpdateAttendanceSignatureRequest} from '@/common/api/requests/modules/attendance/useAttendanceRequest';
import {useGetSingleBoadMeetingRequest} from '@/common/api/requests/modules/meeting/useMeetingRequest'; // Import your API function
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    getDayFromDate,
    getMonthAbbreviation,
    getYearFromDate,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Agenda} from '@/common/parsers/agendaParser';
import {AttendanceRequestPayload} from '@/common/parsers/attendanceParser';
import {Meeting} from '@/common/parsers/meetingParser';
import useAuthStore from '@/common/stores/auth.store';
import AgendaComponent from './includes/Agenda.vue';
import Attendance from './includes/Attendance.vue';
import ConflictofInterest from './includes/ConflictofInterest.vue';
import Documents from './includes/Documents.vue';
import HomeDashBoard from './includes/HomeDashBoard.vue';
import MeetingRsvp from './includes/MeetingRsvp.vue';
import Members from './includes/Members.vue';
import Minutes from './includes/Minute.vue';
import TaskPolls from './includes/TaskPolls.vue';
// Get the route instance
const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();


function goBack() {
    router.back();
}
// Define a reactive reference for storing meeting data
const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const allAgendas = ref<Agenda[]>([]);
const meeting = ref<Meeting>();
const MinuteTemplateSelectionmodal = ref<HTMLDialogElement | null>(null);//constants
const handleUnexpectedError = useUnexpectedErrorHandler();
const action = ref('create');

const schema = yup.object({
    id: yup.string().required(),
    rsvp_status: yup.string().nullable(),
    attendance_status: yup.string().nullable(),
});
const {
    handleSubmit, setErrors, setFieldValue, values} = useForm<{
    location: string|null;
    meeting_id: string|null;
    membership_id: string|null;
    membership: string|null;
    meeting: string|null;
    id:string;
    rsvp_status:string|null;
    attendance_status:string|null;

}>({
    validationSchema: schema,
    initialValues: {
        id:'',
        rsvp_status:'',
        attendance_status:'',
    },
});
const onSubmit = handleSubmit(async (values, {resetForm}) => { 
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
        // await useGetSingleBoadMeetingRequest(meetingId);
        // Dispatch a custom event
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
const reset = ()=>{
    action.value = 'create';
    setFieldValue('id', '');
    setFieldValue('rsvp_status', '');
    setFieldValue('attendance_status', '');
};
const handleRsvpUpdated = (event: { attendeeId: string; status: string }) => {
    reset();
    action.value = 'rsvp';
    setFieldValue('id', event.attendeeId);
    setFieldValue('rsvp_status', event.status);
    onSubmit();
};

const filteredAttendances = ref([]);

watchEffect(() => {
    const attendances = authStore.user.value?.membership?.attendances || [];
    filteredAttendances.value = attendances.filter(attendance => attendance.meeting_id === meetingId);
});

const Attendee = computed(() => {
    return filteredAttendances.value ? filteredAttendances.value[0] : null;
});

const openMinuteTemplateSelectionModal = () => {
    MinuteTemplateSelectionmodal.value?.showModal();
};
// Fetch single meeting data when the component is mounted
onMounted(async () => {
    try {
        // Fetch single meeting data using the API function
        const data = await useGetSingleBoadMeetingRequest(meetingId);
        // Update the meeting data with the fetched data
        const meetingdata = data.data;
        meeting.value = meetingdata;
        // window.dispatchEvent(new CustomEvent('updateTitle', {detail: meetingdata}));
    } catch (error) {
        console.error('Error fetching meeting data:', error);
    }
});

// Define an interface for agenda items
interface AgendaItem {
    id: string;
    title: string;
    children?: AgendaItem[];
}

// Define the initial agenda structure
const defaultAgenda: AgendaItem[] = [
    {id: '1', title: 'Welcome',
     children: [
         {id: '1.1', title: 'Call to Order'},
         {id: '1.2', title: 'Reading of the mission and vision'},
        ],
    },
    {id: '2', title: 'Changes to the Agenda'},
    {id: '3', title: 'Approval of Minutes'},
    {id: '4', title: 'Committee Reports',
     children: [
         {id: '4.1', title: 'Executive Director'},
         {id: '4.2', title: 'Finance'},
         {id: '4.3', title: 'Governance'},
         {id: '4.4', title: 'Marketing'},
         {id: '4.5', title: 'Fundraising'},
         {id: '4.6', title: 'Programs'},
        ],
    },
    {id: '5', title: 'Old Business'},
    {id: '6', title: 'New Business'},
    {id: '7', title: 'Comments, Announcements, and Other Business'},
    {id: '8', title: 'Next Meeting Date'},
    {id: '9', title: 'Adjournment'},
];

// Function to populate the default agenda
function populateDefaultAgenda(): AgendaItem[] {
    return defaultAgenda;
}

const Agendas = computed(() => {
    return allAgendas;
});
const getAgendas = async () => {
    const response = await useGetMeetingAgendasRequest(meetingId, {paginate: 'false'});
    allAgendas.value = response.data;
};

console.log('Agendas', Agendas);
</script>
<template>
    <div class="container-fluid" v-if="meeting">
        <div class="py-6">
            <div class="flex items-center">
                <div class="lg:inline-flex p-3 mr-4rounded-lg custom-size">
                    <div class="calendar-icon w-full flex flex-col items-center 
                                        justify-center mt-1 calendaheight">
                        <div class="month customonth">{{getMonthAbbreviation(meeting.schedule.start_time)}}</div>
                        <div class="day font-medium customday">
                            <span>{{getDayFromDate(meeting.schedule.start_time)}}</span>
                        </div>
                        <div class="year font-medium customyear">
                            <span>{{getYearFromDate(meeting.schedule.start_time)}}</span>
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
                        <button class="!hidden lg:!flex text-muted btn btn-icon" data-bs-toggle="tooltip"
                                title="" data-copy-btn=""
                                data-copy-text="https://app.boardable.com/felix-1/meetings/59bfaf-123456"
                                aria-label="Copy meeting link" data-bs-original-title="Copy meeting link">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
                <div class="ml-auto flex self-end">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
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
                        <button data-bs-target="#send-message" data-bs-toggle="modal" class="btn btn-icon text-muted"
                                data-bs-tooltip="" aria-label="Email attendees" data-bs-original-title="" title="">
                            <i class="fas fa-envelope"></i>
                        </button>
                        <a href="" class="btn btn-icon text-muted mx-2" data-bs-toggle="tooltip" title=""
                           aria-label="Edit meeting" data-bs-original-title="Edit meeting">
                            <i class="fas fa-edit"></i>
                        </a>
                        <!-- <button class="btn btn-secondary" type="button" data-bs-toggle="modal"
                                data-bs-target="#take-minutes">
                            Minutes
                        </button> -->
                        <button class="btn btn-secondary"
                                @click.prevent="openMinuteTemplateSelectionModal()">
                            Minutes
                        </button>
                    </div>
                    <!-- <div action="" class="rsvp-select">
                        <div class="dropdown">
                            <button class="nav-link dropdown-toggle btn whitespace-nowrap btn-secondary"
                                    href="#" id="navbarDropdown"
                                    type="button" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                RSVP
                            </button>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Yes - Remote</a>
                                <a class="dropdown-item" href="#"> Maybe</a>
                                <a class="dropdown-item" href="#"> No</a>
                            </div>
                        </div>
                    </div> -->
                    <div class="flex justify-center btn-sm">
                        <MeetingRsvp
                            :attendee="Attendee"
                            :disableRemoteRsvp="0"
                            @rsvp-updated="handleRsvpUpdated"
                        />
                    </div>
                </div>
            </div>
            <div class="card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                               href="#custom-tabs-four-home" role="tab"
                               aria-controls="custom-tabs-four-home" aria-selected="true">Meeting Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-agenda-tab" data-toggle="pill"
                               href="#custom-tabs-four-agenda" role="tab"
                               aria-controls="custom-tabs-four-agenda" aria-selected="false">
                                Agenda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-minutes-tab" data-toggle="pill"
                               href="#custom-tabs-four-minutes" role="tab"
                               aria-controls="custom-tabs-four-minutes" aria-selected="false">
                                Minutes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-documents-tab" data-toggle="pill"
                               href="#custom-tabs-four-documents" role="tab"
                               aria-controls="custom-tabs-four-documents" aria-selected="false">
                                Documents
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-tasks-tab" data-toggle="pill"
                               href="#custom-tabs-four-tasks" role="tab"
                               aria-controls="custom-tabs-four-tasks" aria-selected="false">
                                Task & Polls
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-members-tab" data-toggle="pill"
                               href="#custom-tabs-four-members" role="tab"
                               aria-controls="custom-tabs-four-members" aria-selected="false">
                                Members
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-conflict-of-interest-tab" data-toggle="pill"
                               href="#custom-tabs-four-conflict-of-interest" role="tab"
                               aria-controls="custom-tabs-four-conflict-of-interest" aria-selected="false">
                                Conflict of Interest
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-attendance-tab" data-toggle="pill"
                               href="#custom-tabs-four-attendance" role="tab"
                               aria-controls="custom-tabs-four-attendance" aria-selected="false">
                                Attendance
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-four-home"
                             role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                            <HomeDashBoard/>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-agenda"
                             role="tabpanel" aria-labelledby="custom-tabs-four-agenda-tab">
                            <AgendaComponent/>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-minutes"
                             role="tabpanel" aria-labelledby="custom-tabs-four-minutes-tab">
                            <Minutes/>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-documents"
                             role="tabpanel" aria-labelledby="custom-tabs-four-documents-tab">
                            <Documents/>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-tasks"
                             role="tabpanel" aria-labelledby="custom-tabs-four-tasks-tab">
                            <TaskPolls/>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-members"
                             role="tabpanel" aria-labelledby="custom-tabs-four-members-tab">
                            <Members/>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-conflict-of-interest"
                             role="tabpanel" aria-labelledby="custom-tabs-four-conflict-of-interest-tab">
                            <ConflictofInterest/>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-attendance"
                             role="tabpanel" aria-labelledby="custom-tabs-four-attendance-tab">
                            <Attendance/>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
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
                                                     name: 'BoardMeetingMinutes',
                                                     params: {
                                                         boardId: boardId,
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
                                    <!-- Start from the Agenda -->
                                    <router-link :to="
                                                     {
                                                         name: 'BoardMeetingMinutes',
                                                         params: {
                                                             boardId: boardId,
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
</template>
<style scoped>

.btn-info {
  background-color: #17a2b8;
  color: #fff;
}
.custom-size{
    width: 137px!important;
}
.calendaheight{
    height: 100px!important;
    margin-bottom: 5px!important;
}
.customonth{
    margin-top: 10px !important;
    font-size: 17px !important;
    color: white !important;
    margin-bottom: 10px !important;
}
.customday{
    font-size: 24px!important;
}
.customyear{
    font-size: 19px!important;
}
</style>
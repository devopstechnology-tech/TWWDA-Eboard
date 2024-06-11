<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import {useForm} from 'vee-validate';
import {onMounted,onUnmounted,ref} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {useCreateAttendanceRSVPRequest, useGetMeetingAttendancesRequest,  useUpdateAttendanceRSVPRequest, useUpdateAttendanceSignatureRequest} from '@/common/api/requests/modules/attendance/useAttendanceRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {loadAvatar} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {AttendanceRequestPayload} from '@/common/parsers/attendanceParser';
import AttendanceToggle from './AttendanceToggle.vue';
import MeetingRsvp from './MeetingRsvp.vue';
//constants
const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const action = ref('create');
const meetingId = route.params.meetingId as string;

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
    invite_status:string|null;
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


const handleAttendanceUpdated = ({attendeeId, newStatus}:string) => {
    reset();
    action.value = 'attendance';
    setFieldValue('id', attendeeId);
    setFieldValue('attendance_status', newStatus);
    onSubmit();
};
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
            invite_status: null,
        };
        if (action.value === 'create') {
            await useCreateAttendanceRSVPRequest(payload, meetingId);
        } else if(action.value === 'rsvp') {
            await useUpdateAttendanceRSVPRequest(payload, payload.id);    
        } else if(action.value === 'attendance') {
            await useUpdateAttendanceSignatureRequest(payload, payload.id);
        }       
        await fetchMeetingAttendances();
        reset();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
const getMeetingAttendances = () => {
    return useQuery({
        queryKey: ['getMeetingAttendancesKey', meetingId],
        queryFn: async () => {
            const response = await useGetMeetingAttendancesRequest(meetingId, {paginate: 'false'});
            return response.data;
        },
    });
};
const {
    isLoading:isLoadingMeetingAttendances, 
    data: Attendances, 
    refetch: fetchMeetingAttendances} = getMeetingAttendances();

onMounted(async () => {
    fetchMeetingAttendances();
});
onMounted(() => {
    window.addEventListener('meetingUpdated', handleMeetingUpdated);
});

onUnmounted(() => {
    window.removeEventListener('meetingUpdated', handleMeetingUpdated);
});

function handleMeetingUpdated(event) {
    if (event.detail.meetingId === meetingId) {
        fetchMeetingAttendances();
    }
}

</script>
<template>
    <div id="members">
        <div class="card">
            <div class="card-header flex items-center">
                <h2 class="card-header-title h3">Attendance</h2>
                <!-- <div class="ml-auto flex items-center space-x-2">
                    <a href="" class="btn btn-secondary btn-sm w-icon">
                        Update Members
                    </a>
                </div> -->
            </div>
            <div class="table-responsive overflow-visible">
                <table class="table card-table table-stacked" v-if="Attendances">
                    <thead>
                        <tr>
                            <th scope="col">
                                <button data-sort="user-name" class="btn btn-link btn-sm list-sort asc">
                                    Name
                                </button>
                            </th>
                            <th scope="col">
                                <button data-sort="role" class="btn btn-link btn-sm list-sort px-0">
                                    Role
                                </button> 
                            </th>
                            <th scope="col" class="text-center">
                                <button data-sort="invited" class="btn btn-link btn-sm list-sort asc">
                                    Invited
                                </button>
                            </th>
                            <th scope="col" class="text-center">
                                <button data-sort="invited" class="btn btn-link btn-sm list-sort asc">
                                    Location
                                </button>
                            </th>
                            <th scope="col" class="text-center">
                                <button data-sort="rsvp" class="btn btn-link btn-sm list-sort">
                                    RSVP
                                </button>
                            </th>
                            <th scope="col" class="text-center">
                                <button data-sort="attendance" class="btn btn-link btn-sm list-sort">
                                    Attendance
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="member-table" class="list">
                        <tr data-id="323280" class="member" v-for="(attendee, idx) in Attendances" :key="idx">
                            <td data-name="Felix Nyariki" class="user-name">
                                <div class="flex items-center">
                                    <div class="avatar avatar-sm mr-3 flex-shrink-0">
                                        <img :src="loadAvatar(attendee.membership.user.profile.avatar)" 
                                             alt="Nyariki Felix profile picture" 
                                             class="avatar-img rounded-full" 
                                             data-uw-rm-alt-original="Nyariki Felix profile picture" 
                                             role="img" data-uw-rm-alt="ALT">
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <p class="mb-0">
                                                <!-- lead to veiw profile and activites -->
                                                <!-- <a href="#" tabindex="0" role="button" 
                                                data-profile_url=""
                                                 data-name="Nyariki Felix" data-pronoun="" 
                                                 data-img="" 
                                                 data-board_role="Administrative Staff" data-company="" 
                                                 data-ptitle="" data-contact_email="" data-contact_phone="" 
                                                 aria-label="Nyariki Felix profile" data-bs-original-title="" 
                                                 title="" class="person-card">.
                                                Nyariki Felix
                                            </a> -->
                                                {{attendee.membership?.user?.full_name}}
                                            </p>
                                        </div>
                                        <p class="text-muted text-sm mb-0">{{attendee?.membership?.user.role}}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-role="meetingOwner" class="role">
                                <span class="text-sm"> {{attendee.membership?.member?.position}}</span>
                            </td>
                            <td class="invited lg:text-center">
                                <span class="cell-label">Invited</span> 
                                <span data-bs-toggle="tooltip" 
                                      title="" data-bs-original-title="User was invited by email"
                                      class="text-muted">
                                </span>
                            </td>
                            <td class="invited lg:text-center">                               
                                <span class="text-sm"> 
                                    {{attendee.location}}
                                </span>
                            </td>
                            <td class="rsvp lg:text-center">
                                <div class="flex justify-center">
                                    <MeetingRsvp
                                        :attendee="attendee"
                                        :disableRemoteRsvp="0"
                                        @rsvp-updated="handleRsvpUpdated"
                                    />
                                </div>
                            </td>
                            <td class="attendance lg:text-center p-0" :data-attendance="attendee.attendance_status">
                                <AttendanceToggle :attendee="attendee" @attendance-updated="handleAttendanceUpdated" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="flex justify-center col-md-6">
       
    </div>
</template>
<style scoped>
.text-success {
  color: green;
}

.text-danger {
  color: red;
}

.btn-icon {
  border: none;
  background: none;
}

.fa-spinner {
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
/* Existing styles */
.btn-info {
    background-color: #17a2b8;
    color: #fff;
}
th button.list-sort {
    background-color: #f9fbfd;
    color: #4b6c92;
    font-size: .8125rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
}
.avatar-sm {
    font-size: .8333333333rem;
    height: 2.5rem;
    width: 2.5rem;
}
.avatar {
    display: inline-block;
    font-size: 1rem;
    height: 3rem;
    position: relative;
    width: 3rem;
}
.rounded-full {
    border-radius: 9999px;
}
.avatar-img {
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    width: 100%;
}
img {
    display: block;
    max-width: 100%;
}
img, svg {
    vertical-align: middle;
}
.dropdown-menu {
  position: absolute;
  top: 100%; /* Ensures it drops down from the button */
  left: 0;
  background-color: white;
  border: 1px solid #ccc;
  z-index: 1000;
}

.btn {
  padding: 0.5rem 1rem;
  border: none;
  color: white;
  cursor: pointer;
}

.btn-success { background-color: #28a745; }
.btn-danger { background-color: #dc3545; }
.btn-warning { background-color: #ffc107; }
.btn-info { background-color: #17a2b8; }
.btn-secondary { background-color: #6c757d; }
</style>



<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import {useForm} from 'vee-validate';
import {onMounted,onUnmounted,ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useCreateAttendanceRSVPRequest, useGetMeetingAttendancesRequest,  useSendAttendancesReminder,  useUpdateAttendanceRSVPRequest, useUpdateAttendanceSignatureRequest} from '@/common/api/requests/modules/attendance/useAttendanceRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {loadAvatar} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {AttendanceRequestPayload} from '@/common/parsers/attendanceParser';
import useAuthStore from '@/common/stores/auth.store';
import MeetingRsvp from './MeetingRsvp.vue';
import Signature from './Signature.vue';
const authStore = useAuthStore();
//constants
const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const router = useRouter();
const action = ref('create');
const meetingId = route.params.meetingId as string;
const scheduleId = route.params.scheduleId as string;

const schema = yup.object({
    id: yup.string().required(),
    rsvp_status: yup.string().nullable(),
    attendance_status: yup.string().nullable(),
    signatureupload: yup.string().nullable(),
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
    signatureupload:string|null;

}>({
    validationSchema: schema,
    initialValues: {
        id:'',
        rsvp_status:'',
        attendance_status:'',
        signatureupload:'',
    },
});
const reset = ()=>{
    action.value = 'create';
    setFieldValue('id', '');
    setFieldValue('rsvp_status', '');
    setFieldValue('attendance_status', '');
    setFieldValue('signatureupload', '');
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
            signatureupload: null,
        };
        if (action.value === 'create') {
            await useCreateAttendanceRSVPRequest(payload, scheduleId);
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
        queryKey: ['getMeetingAttendancesKey', scheduleId],
        queryFn: async () => {
            const response = await useGetMeetingAttendancesRequest(scheduleId, {paginate: 'false'});
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
    if (event.detail.scheduleId === scheduleId) {
        fetchMeetingAttendances();
    }
}
const navigateToSignaturePage = (attendee) => {
    router.push({
        name: 'SignatureAttendance',
        params: {
            boardId: route.params.boardId,
            meetingId: route.params.meetingId,
            scheduleId: route.params.scheduleId,
            attendeeId: attendee.id,
            mediaId: attendee.media[0]?.uuid,
        },
    });
};
const sendReminder = async (id: string) => {
    await useSendAttendancesReminder(id);
    await fetchMeetingAttendances() ;
};
</script>
<template>
    <div class="container-fluid" v-if="authStore.hasPermission(['view attendances'])">
        <div class="card-header flex items-center">
            <h2 class="card-header-title h3">Attendance</h2>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3" v-for="(attendee, idx) in Attendances" :key="idx">
                    <div class="card card-outline card-primary h-100">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <div class="avatar avatar-md mb-3">
                                    <img
                                        :src="loadAvatar(attendee.membership.user.profile.avatar)"
                                        class="profile-user-img img-fluid img-circle"
                                        role="img"
                                        data-uw-rm-alt="ALT"/>
                                </div>
                                <h3 class="profile-username text-center text-primary">
                                    {{ attendee.membership?.user?.full_name }}
                                </h3>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>Invited:</strong>
                                    <span class="cell-label">{{ attendee.invite_status }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>RSVP:</strong>
                                    <div>
                                        <MeetingRsvp
                                            :attendee="attendee"
                                            :disableRemoteRsvp="0"
                                            @rsvp-updated="handleRsvpUpdated"/>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>Attendance:</strong>
                                    <div>
                                        <div v-if="attendee.membership?.user.id === authStore.user.id">
                                            <div v-if="attendee.attendance_status==='Attended'">
                                                <a
                                                    href=""
                                                    @click.prevent="navigateToSignaturePage(attendee)"
                                                    class="text-blue-500 hover:text-blue-700 
                                                    transition duration-150 ease-in-out">
                                                    <i class="far fa-eye"></i> {{ attendee.attendance_status }}
                                                </a>
                                            </div>
                                            <div v-else>
                                                <button
                                                    type="submit"
                                                    class="btn btn-link btn-primary btn-sm text-white"
                                                    @click.prevent="navigateToSignaturePage(attendee)">
                                                    Sign
                                                </button>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div v-if="authStore.hasRole(['Super Admin', 'Admin', 'Company Secretary']) 
                                        && attendee.membership?.user.id !== authStore.user.id">
                                        <button
                                            type="submit"
                                            class="btn btn-link btn-primary btn-sm text-white"
                                            @click.prevent="sendReminder(attendee.id)">
                                            Send Reminder
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

</style>



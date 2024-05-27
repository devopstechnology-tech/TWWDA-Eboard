<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {formatISO,parseISO} from 'date-fns';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {useGetMeetingAttendancesRequest} from '@/common/api/requests/modules/attendance/useAttendanceRequest';
import {
    useGetBoardMembersRequest} from '@/common/api/requests/modules/member/useMemberRequest';
import {
    useCreateMembershipRequest,
    useGetMembershipsRequest,
    useUpdateMembershipRequest} from '@/common/api/requests/modules/membership/useMembershipRequest';
import{useGetStaffsRequest}from '@/common/api/requests/staff/useStaffRequest';
import CustomDropdown from '@/common/components/CustomDropdown.vue';
import FormDateInput from '@/common/components/FormDateInput.vue';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormMultiSelect from '@/common/components/FormMultiSelect.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {loadAvatar} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Member, MemberEditParams,MemberRequestPayload,SelectedResult} from '@/common/parsers/memberParser';
import {MembershipEditParams, MembershipRequestPayload} from '@/common/parsers/membershipParser';
import {Meta} from '@/common/types/types';
import Multiselect from '@@/@vueform/multiselect';

//constants
const handleUnexpectedError = useUnexpectedErrorHandler();
const route = useRoute();
const action = ref('create');
const meetingId = route.params.meetingId as string;

const schema = yup.object({
    rsvp_status: yup.string().nullable(),
});
const {
    handleSubmit, setErrors, setFieldValue, values} = useForm<{
    rsvp_status:string|null;

}>({
    validationSchema: schema,
    initialValues: {
        rsvp_status:'',
    },
});

const rsvplists = [
    {name:'Yes', value:'Yes'},
    {name:'No', value:'No'},
    {name:'Maybe', value:'Maybe'},
    {name:'Online', value:'Online'},
    {name:'Pending', value:'Pending'},
];

const updateStatus = (attendee, newValue) => {
    const index = Attendances.value.indexOf(attendee);
    if (index !== -1) {
        Attendances.value[index].rsvp_status = newValue;
        console.log(`Attendee ${attendee.id} status changed to ${newValue}`);
        // Optionally, you can add logic here to update the status in the backend
        // await axios.put(`/api/attendees/${attendee.id}`, { rsvp_status: newValue });
    }
};
const RSVPLISTS = computed(() => { 
    return rsvplists;
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
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Atendance'}));
    fetchMeetingAttendances();
});

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
                    <!-- {{ Attendances }} -->
                    <!-- location -->
                    <!-- rsvp_status -->
                    <!-- attendance_status -->
                    <!-- meeting_id -->
                    <!-- membership_id -->
                    <!-- membership -->
                    <!-- meeting -->
                    <tbody id="member-table" class="list">
                        <tr data-id="323280" class="member" v-for="(attendee, idx) in Attendances" :key="idx">
                            <td data-name="Felix Nyariki" class="user-name">
                                <div class="flex items-center">
                                    <div class="avatar avatar-sm mr-3 flex-shrink-0">
                                        <img :src="loadAvatar(attendee.membership.user.profile.avatar)" 
                                        :alt="Nyariki Felix profile picture" 
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
                                                {{attendee.membership.user.full_name}}
                                            </p>
                                        </div>
                                        <p class="text-muted text-sm mb-0">{{attendee.membership.user.role}}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-role="meetingOwner" class="role">
                                <span class="text-sm"> {{attendee.membership.member.position}}</span>
                            </td>
                            <td class="invited lg:text-center">9999999
                                <span class="cell-label">Invited</span> 
                                <span data-bs-toggle="tooltip" 
                                      title="" data-bs-original-title="User was invited by email"
                                      class="text-muted">
                                </span>
                            </td>
                            <td class="invited lg:text-center">
                                <span class="text-sm"> {{attendee.location}}</span>
                            </td>
                            <td data-rsvp="" class="rsvp lg:text-center">                                
                                {{ attendee.rsvp_status }}
                            </td>
                            <td data-attendance="" class="attendance">
                                <button data-id="323280" 
                                        data-status="" aria-label="Mark Nyariki Felix as present" 
                                        aria-live="polite" class="btn btn-icon lg:mx-auto attendance-select">
                                    {{ attendee.attendance_status }}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="pollmodal" class="modal w-full max-w-4xl mx-auto p-0" ref="PollModal">
            <form method="dialog" class="modal-box rounded-xl relative bg-white shadow-xl">
                <h3 class="font-bold text-lg text-center">
                    {{ action == 'create' ? 'Create Poll' : 'Edit Poll' }}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" >✕</button>
            
                <div class="overflow-auto p-4" style="max-height: 80vh;">
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-2">
                        <!-- Almanac form -->
                        <div class="col-span-2">
                            <form novalidate @submit.prevent="onSubmit" class="">
                                <FormInput
                                    :labeled="true"
                                    label="Poll Question" 
                                    name="question"
                                    placeholder="Enter Poll Question"
                                    type="text"
                                />
                                <FormTextBox
                                    :labeled="true"
                                    label="Poll description"
                                    name="description"
                                    placeholder="Enter Description"
                                    :rows="2"
                                />
                                <div class="flex flex-wrap -mx-2 mt-2">
                                    <div class="w-full md:w-1/2 px-1 md:px-2">
                                        <FormSelect
                                            :labeled="true"
                                            name="questionoptiontype"
                                            label="Select Allowed Answers On the Question"
                                            placeholder="Select Allowed Answers On the Question"
                                            :options="QuestionOptionTypes"
                                            @selectedItem="handleQuestionOptionTypeChange"
                                        />                                         
                                    </div>
                                    <div class="w-full md:w-1/2 px-1 md:px-2">
                                        <FormDateTimeInput
                                            label="Poll Due Date"
                                            name="duedate"
                                            :flow="['month']"
                                            placeholder="Enter Poll Due Date & Time"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-2 mt-2">
                                    <div class="w-full md:w-1/3 px-1 md:px-2 text-center">
                                        <div >
                                            <h2 class="font-bold text-sm text-center">Click to Add Options</h2>
                                            <button @click.prevent="addEmptyOption" class="btn btn-primary h-10 mt-2">
                                                Add Option
                                            </button>
                                        </div>                                        
                                        <h4 class="text-info font-semibold">Your Options</h4>
                                        <ul v-if="values.options">
                                            <li class="text-primary font-bold text-justify" 
                                                v-for="(option, idx) in values.options" :key="idx">
                                                {{idx+1}}.{{ option?.title }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="w-full md:w-2/3 px-1 md:px-2 flex flex-col" v-if="values.options">
                                        <div class="form-group flex items-center mb-2" 
                                             v-for="(option, index) in values.options" :key="index">
                                            <FormDynamicInput
                                                :labeled="true"
                                                :label="'Title for option ' + (index+1)"
                                                :name="'options[' + index + '].title'"
                                                placeholder="Enter title"
                                                class="flex-grow"
                                                type="text"                                                     
                                            />                                            
                                            <a href="#" class="ml-2 text-red-600 font-bold mt-8" 
                                               @click.prevent="removeOption(option.id)">
                                                ✕
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-2 mt-2">
                                    <div class="w-full md:w-1/2 px-1 md:px-2">
                                        <FormSelect
                                            :labeled="true"
                                            name="assigneetype"
                                            label="Select Assignee Type"
                                            placeholder="Select Assignee Type"
                                            :options="AssigneeTypes"
                                            @selectedItem="handleAssigneeTypeChange"
                                        /> 
                                    </div>
                                    <div class="w-full md:w-1/2 px-1 md:px-2">
                                        <div v-if="assigneestatus === 'all_members'">
                                            <h2 class="font-bold text-primary text-sm text-center">
                                                All Members Will be assiged this Poll
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="selectedMembershipIds && selectedMembershipIds.length || 
                                    assigneestatus === 'all_members'">
                                    <button type="submit" class="btn btn-primary btn-md w-full mt-6">
                                        {{ action == 'create' ? 'Create Poll' : 'Edit Poll' }}
                                    </button>
                                </div>   
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
</template>
<style scoped>

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



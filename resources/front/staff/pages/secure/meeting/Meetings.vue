<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {formatISO,parseISO} from 'date-fns';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {
    useCreateBoardMeetingRequest,
    useDeleteMeetingRequest,
    useGetBoardMeetingsRequest,
    useGetMeetingsRequest,
    usePublishMeetingRequest,    useUpdateBoardMeetingRequest} from '@/common/api/requests/modules/meeting/useMeetingRequest';
import{useGetStaffsRequest}from '@/common/api/requests/staff/useStaffRequest';
import FormDateInput from '@/common/components/FormDateInput.vue';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormMultiSelect from '@/common/components/FormMultiSelect.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formattedDate,loadImage,test,truncateDescription} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Meeting} from '@/common/parsers/meetingParser';
import {Meta} from '@/common/types/types';
import Multiselect from '@@/@vueform/multiselect';

//constants
const showCreate = ref(false);
const action = ref('create');
const dates = ref('');
const selectedMeeting = ref<Meeting | null>(null);
const MeetingModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();
const page = ref(1);
const perPage = ref(15);
const meta = ref<Meta>();
const route = useRoute();
const boardId = ref('');
const committeeId = ref('');
const modeltype = ref('');
const selectedConferenceType = ref('');
//inputs forms handling
//meeting
const schema = yup.object({
    title: yup.string().required(),
    conference: yup.string().required(),
    location: yup.string().required(),
    link: yup.string().nullable(),
    description: yup.string().required(),
    status: yup.string().required(),
    board_id: yup.string().nullable(),
    committee_id: yup.string().nullable(),
    modeltype: yup.string().required(),
    //schedules
    type: yup.string().required(),
    timezone: yup.string().required(),
    start_time: yup.string().required(),
    end_time: yup.string().required(),
    //agenda

});
const {
    handleSubmit, setErrors, setFieldValue, values} = useForm<{
    title:string;
    conference:string;
    location:string;
    description:string;
    link:string | null;
    board_id:string | null;
    committee_id:string | null;
    modeltype:string;
    status:string;
    //schedule
    type:string;
    timezone:string;
    start_time:string;
    end_time:string;

}>({
    validationSchema: schema,
    initialValues: {
        title:'',
        conference:'',
        location:'',
        description:'',
        link:null,
        board_id: null,
        committee_id: null,
        modeltype: '',
        status: 'unpublished',
        //schedule
        type:'',
        timezone:'',
        start_time:'',
        end_time:'',

    },
});

const date = ref(new Date());
// modals
const openCreateMeetingModal = () => {
    reseting();
    action.value = 'create';
    showCreate.value = true;
    MeetingModal.value?.showModal();
};
const openEditMeetingModal = (e: Meeting) => {
    selectedMeeting.value = e;
    if (e.meetingable.type === 'Board') {
        modeltype.value = 'board';
        boardId.value = e.meetingable.details.id;
        setFieldValue('board_id', e.meetingable.details.id);
        setFieldValue('modeltype', e.meetingable.type);
    } else if (e.meetingable.type === 'Committee') {
        // Logic for when the meeting is associated with a Committee
        committeeId.value = e.meetingable.details.id;
        modeltype.value = 'committee';
        setFieldValue('committee_id', e.meetingable.details.id);
        setFieldValue('modeltype', e.meetingable.type);
    }

    // Set field values here
    setFieldValue('title', e.title);
    setFieldValue('conference', e.conference);
    setFieldValue('location', e.location);
    setFieldValue('description', e.description);
    if (e.conference === 'Custom 3rd party Links') {
        // If so, handle it accordingly and set the link
        handleConferenceTypeChange(e.conference);
        setFieldValue('link', e.link);
    }
    // schedules
    setFieldValue('type', e.schedule?.type);
    setFieldValue('timezone', e.schedule?.timezone);
    setFieldValue('start_time', (e.schedule?.start_time));
    setFieldValue('end_time', (e.schedule?.end_time));
    console.log(selectedConferenceType.value, e, e.conference === 'Custom 3rd party Links');
    action.value = 'edit';
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
    {name: 'Single meeting', value: 'Single meeting)'},
    {name: 'Recurring meeting', value: 'Recurring meeting'},
    {name: 'Find a meeting date', value: 'Find a meeting date'},
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

const getMeetings = () => {
    return useQuery({
        queryKey: ['getMeetingsKey'],
        queryFn: async () => {
            const response = await useGetMeetingsRequest({paginate: 'false'});
            return response.data;
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

function handleTimezoneUpdate(newTimezone) {
    const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    setFieldValue('timezone', userTimezone);
}
function reseting(){
    boardId.value = '';
    committeeId.value = '';
    modeltype.value = '';
    setFieldValue('board_id', null);
    setFieldValue('modeltype', '');
    setFieldValue('committee_id', null);

    setFieldValue('title', '');
    setFieldValue('conference', '');
    setFieldValue('location', '');
    setFieldValue('description', '');
    setFieldValue('link', null);
    // schedules
    setFieldValue('type', '');
    setFieldValue('timezone', '');
    setFieldValue('start_time', '');
    setFieldValue('end_time', '');
}

//delete
const deleteMeeting = async (e: string) => {
    await useDeleteMeetingRequest(e);
    await fetchMeetings();
};

//default loading
const {isLoading, data, refetch: fetchMeetings} = getMeetings();

const currentStatus = ref('published');

const filteredMeetings = computed(() => {
    if (!data.value) return []; // Check if data is not loaded
    console.log(JSON.stringify(data.value, null, 2)); // Add this line to inspect the data structure

    if (currentStatus.value === 'past') {
        const now = new Date();
        return data.value.filter(meeting => {
            const meetingDate = new Date(meeting.created_at); // Assuming you have a `date` field in your meetings
            return meetingDate < now;
        });
    } else {
        return data.value.filter(meeting => meeting.status.toLowerCase() === currentStatus.value);
    }
});
const filterMeetings = (status: string) => {
    currentStatus.value = status;
};
const onPublish = async (id: string) => {
    await usePublishMeetingRequest(id);
    await fetchMeetings();
};
onMounted(async() => {
    await fetchMeetings();
});
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
                        <!-- <button type="button" @click.prevent="openCreateMeetingModal" class="btn btn-tool">
                            <i class="far fa fa-plus mr-2 "></i>
                        </button> -->
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" v-if="filteredMeetings">
                    <ul class="products-list product-list-in-card pl-2 pr-2"  v-if="filteredMeetings.length > 0">
                        <li class="item" v-for="meeting in filteredMeetings" :key="meeting.id">
                            <div class="product-img">
                                <div class="calendar-icon w-10 h-10 flex flex-col items-center justify-center mt-1">
                                    <div class="month">Mar</div>
                                    <div class="day font-medium">
                                        <span>27</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">{{ meeting.title }}
                                    <span class="badge float-right bg-white" v-if="currentStatus === 'unpublished'">
                                        <a href="" @click.prevent="onPublish(meeting.id)"
                                           class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                            Publish
                                        </a>
                                    </span>
                                    <span class="badge float-right bg-white">
                                        <!-- <router-link :to="{ name: 'MeetingDetails', params: { id: meeting.id } }"
                                                     class="text-green-500
                                                hover:text-green-700 transition duration-150 ease-in-out">
                                            <i class="far fa-eye"></i>
                                        </router-link> -->
                                        <router-link
                                            :to="{ name: 'BoardMeetingDetails',
                                                   params: {
                                                       boardId: meeting?.meetingable.details.id,
                                                       meetingId: meeting.id
                                                   }
                                            }"
                                            class="text-green-500
                                                hover:text-green-700 transition duration-150 ease-in-out">
                                            <i class="far fa-eye"></i>
                                        </router-link>
                                    </span>
                                    <span class="badge float-right bg-white" >
                                        <a href="" @click.prevent="openEditMeetingModal(meeting)"
                                           class="text-blue-500 hover:text-blue-700
                                                transition duration-150 ease-in-out">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </span>
                                </a>
                                <span class="product-description">
                                    {{ truncateDescription(meeting.description, 80) }}
                                </span>
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
                    {{action == 'create' ? 'Create Meeting' : 'Edit Meeting'}}
                </h3>
                {{ selectedConferenceType}}
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1">
                            <div class="grid grid-cols-3 gap-2">
                                <FormInput
                                    :labeled="true"
                                    label="Meeting Title"
                                    name="title"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Meeting Title"
                                    type="text"
                                />
                                <FormSelect
                                    :labeled="true"
                                    name="conference"
                                    label="Select Conference Type"
                                    placeholder="Select Conference Type"
                                    :options="ConferenceTypes"
                                    @selectedItem="handleConferenceTypeChange"/>

                                <FormInput
                                    v-if="selectedConferenceType === 'Custom 3rd party Links'"
                                    :labeled="true"
                                    label="Meeting Link"
                                    name="link"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Third Party Link'"
                                    type="text"
                                />
                                <FormInput
                                    :labeled="true"
                                    label="Meeting Location"
                                    name="location"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="e.g 'Conference Room 6'"
                                    type="text"
                                />
                                <FormTextBox
                                    :labeled="true"
                                    label="Meeting Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Meeting Description"
                                    :rows="2"
                                />
                                <FormSelect
                                    :labeled="true"
                                    name="type"
                                    label="Meeting Schedule"
                                    placeholder="Select Meeting Schedule"
                                    :options="Meetingschedules"/>
                                <FormInput
                                    :labeled="true"
                                    label="Meeting Timezone"
                                    name="timezone"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Meeting Timezone"
                                    type="text"

                                />
                                <FormDateTimeInput
                                    label="Meeting Start Time"
                                    name="start_time"
                                    :flow="['day']"
                                    placeholder="Select Start Time"
                                    @updateTimezone="handleTimezoneUpdate"
                                />
                                <FormDateTimeInput
                                    label="Meeting End Time"
                                    name="end_time"
                                    :flow="['day']"
                                    placeholder="Enter End Time"
                                    @updateTimezone="handleTimezoneUpdate"
                                />
                            </div>
                            <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{action == 'create' ? 'Create Meeting' : 'Edit Meeting'}}
                            </button>
                        </form>
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
</style>


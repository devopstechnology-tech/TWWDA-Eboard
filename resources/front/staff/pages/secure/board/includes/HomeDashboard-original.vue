<script setup lang="ts">

import '@@/@vueform/multiselect/themes/default.css';
import {useQuery} from '@tanstack/vue-query';
import VueDatePicker from '@vuepic/vue-datepicker';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref} from 'vue';
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
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {loadImage,truncateDescription} from '@/common/customisation/Breadcrumb';
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
const boardId = route.params.id as string;
const test = ref(['month', 'year', 'calendar']);
//inputs forms handling
//meeting
const schema = yup.object({
    title: yup.string().required(),
    conference: yup.string().required(),
    location: yup.string().required(),
    description: yup.string().required(),
    status: yup.string().required(),
    board_id: yup.string().required(),
    //schedules
    type: yup.string().required(),
    timezone: yup.string().required(),
    start_time: yup.string().required(),
    end_time: yup.string().required(),
    //agenda

});
const {
    handleSubmit, setErrors, setFieldValue} = useForm<{
    title:string;
    conference:string;
    location:string;
    description:string;
    board_id:string;
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
        board_id: boardId,
        status: 'unpublished',
        //schedule
        type:'',
        timezone:'',
        start_time:'',
        end_time:'',

    },
});

// modals
const openCreateMeetingModal = () => {
    action.value = 'create';
    showCreate.value = true;
    MeetingModal.value?.showModal();
};
const openEditMeetingModal = (e: Meeting) => {
    selectedMeeting.value = e;
    // Set field values here
    setFieldValue('title', e.title);
    setFieldValue('conference', e.conference);
    setFieldValue('location', e.location);
    setFieldValue('description', e.description);
    // schedules
    setFieldValue('type', e.schedule?.type);
    setFieldValue('timezone', e.schedule?.timezone);
    setFieldValue('start_time', e.schedule?.start_time);
    setFieldValue('end_time', e.schedule?.end_time);

    action.value = 'edit';
    showCreate.value = true;
    MeetingModal.value?.showModal();
};
// data
const conferenceTypes = [
    {name: 'In Person', value: 'No Vedio (Meeting in Person)'},
    {name: 'Zoom', value: 'Zoom Web Conference'},
    {name: '3rd party', value: 'Custom 3rd party Links'},
];
const meetingschedules = [
    {name: 'Single meeting', value: 'Single meeting)'},
    {name: 'Recurring meeting', value: 'Recurring meeting'},
    {name: 'Find a meeting date', value: 'Find a meeting date'},
];
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
const date = ref(new Date());
</script>

<style scoped>
</style>
<template>
    <div class="row">
        <div class="col-md-8">
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
                        <button type="button" @click.prevent="openCreateMeetingModal" class="btn btn-tool">
                            <i class="far fa fa-plus mr-2 "></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
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
                                        <router-link :to="{ name: 'MeetingDetails', params: { id: meeting.id } }"
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
        <div class="col-md-4">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Recent Activity</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
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
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="meetingmodal" class="modal" ref="MeetingModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{action == 'create' ? 'Create Meeting' : 'Edit Meeting'}}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1">
                            <div class="grid grid-cols-3 gap-2">
                                <FormInput
                                    label="Meeting Title"
                                    name="title"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Meeting Title"
                                    type="text"
                                />
                                <FormSelect name="conference"
                                            label="Select Conference Type"
                                            placeholder="Select Conference Type"
                                            :options="ConferenceTypes"/>
                                <FormInput
                                    label="Meeting Location"
                                    name="location"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="e.g 'Conference Room 6'"
                                    type="text"
                                />
                                <FormTextBox
                                    label="Meeting Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Meeting Description"
                                    :rows="2"
                                />
                                <FormSelect name="type"
                                            label="Meeting Schedule"
                                            placeholder="Select Meeting Schedule"
                                            :options="Meetingschedules"/>
                                <FormInput
                                    label="Meeting Timezone"
                                    name="timezone"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Meeting Timezone"
                                    type="text"
                                />
                                <FormDateInput
                                    label="Meeting Start Time"
                                    name="start_time"
                                    class="w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Start Time"
                                    type="text"
                                />
                                <!-- <VueDatePicker v-model="start_time" time-picker /> -->
                                <FormInput
                                    label="Meeting End Time"
                                    name="end_time"
                                    class="w-full text-sm  tracking-wide"
                                    placeholder="Enter End Time"
                                    type="text"
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



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
import FormRadioInput from '@/common/components/FormRadioInput.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    combineDateAndTime,
    formatDate,
    FormattedAgo,
    getDayFromDate,
    getDuration,
    getMonthAbbreviation,
    getYearFromDate,
    truncateDescription,  
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Meeting} from '@/common/parsers/meetingParser';
import {Schedule} from '@/common/parsers/scheduleParser';
import {Meta} from '@/common/types/types';
import Multiselect from '@@/@vueform/multiselect';

//constants
const showCreate = ref(false);
const action = ref('create');
const selectedMeeting = ref<Meeting | null>(null);
const MeetingModal = ref<HTMLDialogElement | null>(null);
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
    // meeting_id: yup.string().nullable(),
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
    // schedules: yup.array().of(scheduleSchema).nullable(),
    // type: yup.string().required(),
    // date: yup.string().required(),
    // start_time: yup.string().required(),
    // end_time: yup.string().required(),
    //agenda

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
        id:string|null;
        date:string;
        start_time:string;
        end_time:string;
        // meeting_id:string;
    }[] | [];
    // type:string;
    // date:string;
    // start_time:string;
    // end_time:string;

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
                date:'',
                start_time:'',
                end_time:'',
                // meeting_id:'',
            },
        ],
        
    },
});
const {errorMessage, value} = useField('schedules');
// modals
const openCreateMeetingModal = () => {
    reseting();
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
    setFieldValue('type', e.type);
    if (e.conference === 'Custom 3rd party Links') {
        // If so, handle it accordingly and set the link
        handleConferenceTypeChange(e.conference);
        setFieldValue('link', e.link);
    }
    // schedules
    setFieldValue('schedules', e.schedules);
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
    // schedules
    setFieldValue('schedules', [
        {
            id: uuidv4(),  // Assuming uuidv4() is imported and used to generate unique IDs
            date:'',
            start_time:'',
            end_time:'',
            // meeting_id:'',
        },
    ]);
    setFieldValue('type', 'single');
    // setFieldValue('date', '');
    // setFieldValue('start_time', '');
    // setFieldValue('end_time', '');
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
        // meeting_id: '',
    };
    // Create a new array with the new option and update the field value
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
    errorMessages.value = errorMessages.value.filter((_, i) => i !== index);
    // const updatedSchedules = values.schedules.filter(schedule => schedule.id !== id);
    // setFieldValue('schedules', updatedSchedules);
};

const errorMessages = ref(
    values.schedules.map(() => ({
        date: '',
        start_time: '',
        end_time: '',
    })),
);
const validateField = (index:number, field:string) => {
    const schedule = values.schedules[index];
    if (!schedule[field]) {
        errorMessages.value[index][field] = `${field.replace('_', ' ')} is required`;
    } else {
        errorMessages.value[index][field] = '';
    }
};

const validateSchedules = () => {
    let isValid = true;
    errorMessages.value = values.schedules.map((schedule, index) => {
        const scheduleErrors = {
            date: !schedule.date ? 'Date is required' : '',
            start_time: !schedule.start_time ? 'Start time is required' : '',
            end_time: !schedule.end_time ? 'End time is required' : '',
        };

        if (!schedule.date || !schedule.start_time || !schedule.end_time) {
            isValid = false;
        }

        return scheduleErrors;
    });
    return isValid;
};

watch(values.schedules, (newSchedules, oldSchedules) => {
    newSchedules.forEach((schedule, index) => {
        if (schedule.date !== oldSchedules[index]?.date) {
            validateField(index, 'date');
        }
        if (schedule.start_time !== oldSchedules[index]?.start_time) {
            validateField(index, 'start_time');
        }
        if (schedule.end_time !== oldSchedules[index]?.end_time) {
            validateField(index, 'end_time');
        }
    });
}, {deep: true});

const canSubmit = computed(() => validateSchedules());
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
                            <div class="product-img custom-size mr-2">
                                <div class="calendar-icon w-full flex flex-col items-center 
                                        justify-center mt-1 calendaheight">
                                    <div class="month customonth">
                                        {{getMonthAbbreviation(meeting.schedules[0].date)}}</div>
                                    <div class="day font-medium customday">
                                        <span>{{getDayFromDate(meeting.schedules[0].date)}}</span>
                                    </div>
                                    <div class="year font-medium customyear">
                                        <span>{{getYearFromDate(meeting.schedules[0].date)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info">
                                <router-link 
                                    :to="{ name: 'BoardMeetingDetails',
                                           params: {
                                               boardId: boardId,
                                               meetingId: meeting.id
                                           }
                                    }"
                                    class="product-title">{{ meeting.title }}
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
                                                       boardId: boardId,
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
                                </router-link>
                                <span class="product-description">
                                    {{ truncateDescription(meeting.description, 80) }}
                                </span>
                                <div class="row border-top border-bottom border-warning 
                                d-flex justify-content-between align-items-center" 
                                     v-for="schedule in meeting.schedules" :key="schedule.id">
                                    <div>
                                        Start: <span class="text-primary font-bold ml-2 mr-2">
                                            {{ formatDate(combineDateAndTime(schedule.date, schedule.start_time)) }}
                                        </span>
                                        ||
                                        End: <span class="text-primary font-bold ml-2 mr-2">
                                            {{ formatDate(combineDateAndTime(schedule.date, schedule.end_time)) }}
                                        </span>
                                        ||
                                        Duration: <span class="text-primary font-bold ml-2 mr-2">
                                            {{ getDuration(combineDateAndTime(schedule.date, schedule.start_time), combineDateAndTime(schedule.date, schedule.end_time), 'hours') }}
                                        </span>
                                        ||
                                        When:<span class="text-primary font-bold ml-2 mr-2">
                                            {{ FormattedAgo(combineDateAndTime(schedule.date, schedule.start_time), combineDateAndTime(schedule.date, schedule.end_time), 'hours') }}
                                        </span>
                                        ||
                                        Held Status:  <span :class="getHeldStatusClass(meeting.heldstatus)" class="font-bold ml-2 mr-2">
                                            {{ meeting.heldstatus }}
                                        </span>
                                    </div>
                                    <span>
                                        <button v-if="meeting.heldstatus === 'scheduled'" class="btn btn-sm btn-warning 
                                        font-bold ml-2 mr-2 mt-1 mb-1" 
                                                @click.prevent="CancelMeeting(meeting.id)">
                                            Cancel
                                        </button>
                                        <button v-if="meeting.heldstatus === 'scheduled'" class="btn btn-sm btn-warning 
                                        font-bold ml-2 mr-2 mt-1 mb-1" 
                                                @click.prevent="PostponeMeeting(meeting.id)">
                                            Postpone
                                        </button>
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
                <div class="overflow-auto p-4" style="max-height: 80vh;">
                    <div class="grid grid-cols-3 md:grid-cols-3 gap-2 p-2">
                        <div class="col-span-3">
                            <form novalidate @submit.prevent="onSubmit" class="">
                                <div class="flex flex-wrap -mx-2 mt-2">
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
                                <div class="flex flex-wrap -mx-2 mt-2">
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
                                <FormTextBox
                                    :labeled="true"
                                    label="Meeting Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Meeting Description"
                                    :rows="2"
                                />
                                <div class="flex flex-wrap -mx-2 mt-2">
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
                                     v-for="(schedule, index) in values.schedules" :key="index">
                                    <div class="w-full md:w-1/3 px-1 md:px-2"> 
                                        <FormDateTimeInput
                                            :label="'Meeting Date ' + (index + 1)"
                                            :name="'schedules[' + index + '].date'"
                                            mode="date-picker"
                                            placeholder="Meeting Date"
                                        />
                                        <div v-if="errorMessages[index]?.date" class="message text-red-600"> 
                                            {{ errorMessages[index].date }} 
                                        </div>
                                    </div>                                    
                                    <div class="w-full md:w-1/3 px-1 md:px-2">
                                        <FormDateTimeInput
                                            :label="'Meeting Start Time ' + (index + 1)"
                                            :name="'schedules[' + index + '].start_time'"
                                            mode="time-picker"
                                            placeholder="Select Start Time"
                                        />
                                        <div v-if="errorMessages[index]?.start_time" class="message text-red-600"> 
                                            {{ errorMessages[index].start_time }} 
                                        </div>
                                    </div>
                                    <div class="w-full md:w-1/3 px-1 md:px-2">
                                        <FormDateTimeInput
                                            :label="'Meeting End Time ' + (index + 1)"
                                            :name="'schedules[' + index + '].end_time'"
                                            mode="time-picker"
                                            placeholder="Select End Time"
                                        />
                                        <div v-if="errorMessages[index]?.end_time" class="message text-red-600"> 
                                            {{ errorMessages[index].end_time }} 
                                        </div>
                                    </div> 
                                    <button type="button" class="absolute top-0 right-0 mt-2 mr-2
                                            text-red-600 font-bold"
                                            @click.prevent="removeSchedule(index)">
                                        ✕
                                    </button>
                                </div>
                                <button v-if="values.type === 'manual'" 
                                        type="button"
                                        class="btn btn-primary mt-4"
                                        @click="addEmptySchedule">
                                    Add Another Data
                                </button>
                                <!-- </div> -->

                                <div v-if="canSubmit">
                                    <button type="submit" class="btn btn-primary btn-md w-full mt-6">
                                        {{ action == 'create' ? 'Create Meeting' : 'Edit Meeting' }}
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
.modal-box {
  max-width: 800px;
  width: 100%;
}
.btn-info {
  background-color: #17a2b8;
  color: #fff;
}
.custom-size{
    width: 105px!important;
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
.products-list .product-info {
    margin-left: 129px!important;
}
</style>


<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import _debounce from 'lodash/debounce';
import {v4 as uuidv4} from 'uuid';
import {useField, useForm} from 'vee-validate';
import {computed, nextTick,onMounted, ref,watch} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {object} from 'yup';
import {useGetMembershipsRequest} from '@/common/api/requests/modules/membership/useMembershipRequest';
import {
    useCreateMeetingPollRequest,
    useGetMeetingPollsRequest,
    useUpdateMeetingPollRequest,
} from '@/common/api/requests/modules/poll/usePollRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormDynamicInput from '@/common/components/FormDynamicInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormQuillEditor from '@/common/components/FormQuillEditor.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';
import {Membership, SelectedResult} from '@/common/parsers/membershipParser';
import {Option} from '@/common/parsers/optionParser';
import {PollAssignee} from '@/common/parsers/pollassigneeParser';
import {Poll, PollRequestPayload} from '@/common/parsers/PollParser';
import useAuthStore from '@/common/stores/auth.store';
import Multiselect from '@@/@vueform/multiselect';

const authStore = useAuthStore();
const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const committeeId = route.params.committeeId as string;
const meetingId = route.params.meetingId as string;
const pollId = ref<string | null>(null);
const selectedMembershipIds = ref<PollAssignee[]>([]);
const PollModal = ref<HTMLDialogElement | null>(null);
// Options handling
const optionstatus = ref('single');
const assigneestatus = ref('individuals');
const options = ref<Option[]>([]);
const savedTitles = ref<string[]>([]);
const selectedAssigneeType = ref('');
const handleUnexpectedError = useUnexpectedErrorHandler();

const {errorMessage:duedateerrorMessage} = useField('duedate');
const {errorMessage:pollassigneeserrorMessage} = useField('pollassignees');

const optionSchema = yup.object({
    id: yup.string().required(),
    title: yup.string().required(),
    poll_id: yup.string().nullable(),
    deleted_at: yup.string().nullable(),
    created_at: yup.string().nullable(),
    updated_at: yup.string().nullable(),
});
const userSchema = yup.object({
    id: yup.string().required(),
    full_name: yup.string().required(),
});
const pollassigneeSchema = yup.object({
    id: yup.string().required(),
    poll_id: yup.string().nullable(),
    membership_id: yup.string().required(),
    user: userSchema,
});
const pollschema = yup.object({
    meeting_id: yup.string().nullable(),
    committee_id: yup.string().nullable(),
    question:yup.string().required(),
    description:yup.string().required(),
    questionoptiontype:yup.string().required(),
    optionstatus:yup.string().required(),
    options: yup.array().of(optionSchema).required(),
    duedate:yup.string().required(),
    assigneetype:yup.string().required(),
    assigneestatus:yup.string().required(),
    pollassignees:yup.array().of(pollassigneeSchema).nullable(),
    status: yup.string().required(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    meeting_id:string| null;
    committee_id:string| null;
    question:string;
    description:string;
    questionoptiontype:string;
    optionstatus:string;
    options: {
        id: string;
        poll_id: string| null;
        title: string;
        deleted_at: string | null;
        created_at: string | null;
        updated_at: string | null;
    }[]| [];
    duedate:string;
    assigneetype:string;
    assigneestatus:string;
    pollassignees:{
        id:string;
        poll_id:string | null;
        membership_id:string;
        user:{
            id:string;
            full_name:string;
        };
    }[] | [];
    status:string;
}>({
    validationSchema: pollschema,
    initialValues: {
        meeting_id:meetingId,
        committee_id:committeeId,
        question:'',
        description:'',
        questionoptiontype:'',
        optionstatus:'',
        options:[
            {
                id: uuidv4(), // Assuming uuidv4() is imported and used to generate unique IDs
                title: '',
                poll_id: null,
                deleted_at: null,
                created_at: null,
                updated_at: null,
            },
        ],
        duedate:'',
        assigneetype:'',
        assigneestatus:'',
        pollassignees:[],
        status:'inactive',
    },
});
// Access each field
const {errorMessage, value} = useField('options');

const openCreatePollModal = () => {
    reset();
    // fetchMemberships();
    action.value = 'create';
    showCreate.value = true;
    PollModal.value?.showModal();
};
const openEditPollModal = (poll:Poll) => {
    reset();
    // fetchMemberships();
    pollId.value = poll.id;
    setFieldValue('question',poll.question);
    setFieldValue('description',poll.description);
    setFieldValue('questionoptiontype',poll.questionoptiontype);
    setFieldValue('optionstatus',poll.optionstatus);    
    setFieldValue('duedate',poll.duedate);
    setFieldValue('assigneetype',poll.assigneetype);
    setFieldValue('assigneestatus',poll.assigneestatus);
    setFieldValue('status',poll.status);
    setFieldValue('options', poll.options);  
    assigneestatus.value = poll.assigneestatus;
    
    // This would be fetched and prepared similarly
    mappollassigneesToReactiveRef(poll.pollassignees);
    // mapPollOptionsToReactiveRef(poll.options);
    // schedules
    action.value = 'edit';
    showCreate.value = true;
    PollModal.value?.showModal();
};

function mappollassigneesToReactiveRef(pollassignees: PollAssignee[]) {
    selectedMembershipIds.value = pollassignees.map(pollassignee => ({
        id: pollassignee.id,// Default value as empty string
        full_name: pollassignee.user.full_name,
        poll_id: pollassignee.poll_id,
        membership_id: pollassignee.membership_id,
        user: pollassignee.user,
    }));
    setFieldValue('pollassignees', selectedMembershipIds.value);
}

const selectedMembers = () => {
    setFieldValue('pollassignees', selectedMembershipIds.value);
};
const removeselectedUsers = () => {
    setFieldValue('pollassignees', selectedMembershipIds.value);
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        console.log('dddd');
        // setFieldValue('pollassignees', selectedMembershipIds.value);
        const payload: PollRequestPayload = {
            meeting_id: values.meeting_id,
            committee_id: values.committee_id,
            question: values.question,
            description: values.description,
            questionoptiontype: values.questionoptiontype,
            optionstatus: values.optionstatus,
            options: values.options,
            duedate: values.duedate,
            assigneetype: values.assigneetype,
            assigneestatus: values.assigneestatus,
            pollassignees: values.pollassignees,
            status: values.status,
        };
        if (action.value === 'create') {
            await useCreateMeetingPollRequest(payload, meetingId);
        } else {
            const poll_id = pollId.value as string;
            await useUpdateMeetingPollRequest(payload, meetingId, poll_id);
        }
        PollModal.value?.close();
        await fetchMeetingPolls();
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
    showCreate.value = false;
    pollId.value = null;
    optionstatus.value = 'single';
    assigneestatus.value = 'all_members';
    selectedMembershipIds.value = [];
    setFieldValue('meeting_id', meetingId);
    setFieldValue('committee_id', committeeId);
    setFieldValue('question', '');
    setFieldValue('description', '');
    setFieldValue('questionoptiontype', 'single');
    setFieldValue('optionstatus', 'single');
    setFieldValue('options', [
        {
            id: uuidv4(),  // Assuming uuidv4() is imported and used to generate unique IDs
            title: '',
            poll_id: null,
            deleted_at: null,
            created_at: null,
            updated_at: null,
        },
    ]);
    setFieldValue('duedate', '');
    setFieldValue('assigneetype', 'all_members');
    setFieldValue('assigneestatus', 'all_members');
    setFieldValue('pollassignees', []);
    setFieldValue('status', 'inactive');// 
};

const formattedDateTime = (dateStr) => {
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
};

const dateBadgeClass = (dueDate) => {
    return hasDueDatePassed(dueDate) ? 'bg-danger' : 'bg-success';
};

const hasDueDatePassed = (dueDate) => {
    const now = new Date();
    const due = new Date(dueDate);
    return now > due;
};

const isDueSoon = (dueDate) => {
    const now = new Date();
    const due = new Date(dueDate);
    const oneDay = 24 * 60 * 60 * 1000; // milliseconds in one day
    return (due - now) < oneDay;
};

const calculateVoteStats = (poll: Poll) => {
    if (!poll.votes || poll.votes.length === 0) {
        return 'No votes yet';
    }

    const totalVotes = poll.votes.length;
    const totalMembers = poll.pollassignees.length;

    if (totalVotes > totalMembers) {
        console.error('Total votes exceed total members, which is unexpected.');
        return 'Voting data error';
    }

    const voteCounts = poll.votes.reduce((acc, vote) => {
        const optionId = JSON.parse(vote.option_id).id;
        acc[optionId] = (acc[optionId] || 0) + 1;
        return acc;
    }, {} as Record<string, number>);

    const mostVotedOptionId = Object.keys(voteCounts).reduce((a, b) => voteCounts[a] > voteCounts[b] ? a : b);
    const mostVotedOption = poll.options.find(option => option.id === mostVotedOptionId);

    if (!mostVotedOption) {
        console.error('Most voted option not found in poll options.');
        return 'Voting data error';
    }

    const notVoted = totalMembers - totalVotes;
    const votePercentage = ((voteCounts[mostVotedOptionId] / totalVotes) * 100).toFixed(1);

    const optionPercentages = poll.options.map(option => {
        const count = voteCounts[option.id] || 0;
        const percentage = ((count / totalVotes) * 100).toFixed(1);
        return `${percentage}% voted for ${option.title}`;
    }).join('<br>');

    return `${optionPercentages}<br>Total votes: ${totalVotes} / ${notVoted} not yet`;
};

const statusClass = (status) => {
    switch (status) {
        case 'Backlog': return 'badge bg-warning';
        case 'Pending': return 'badge bg-info';
        case 'On Progress': return 'badge bg-primary';
        case 'Completed': return 'badge bg-success';
        default: return 'badge';
    }
};

// Data definitions

const questionOptionTypes = [
    {name: 'Single Answer', value: 'single'},
    {name: 'Multiple Answers: More than one', value: 'multiple'},
];
const assigneeTypes = [
    {name: 'Individuals', value: 'individuals'},
    {name: 'Assign All Meeting Members', value: 'all_members'},
];

// Computed properties for dropdowns
const QuestionOptionTypes = computed(() => questionOptionTypes);
const AssigneeTypes = computed(() => assigneeTypes);

// Event handlers

const handleQuestionOptionTypeChange = (selectedQuestionOption: string) => {
    savedTitles.value =[];
    options.value  = []; 
    addEmptyOption();
    optionstatus.value = selectedQuestionOption;
    setFieldValue('questionoptiontype', selectedQuestionOption);
    setFieldValue('optionstatus', selectedQuestionOption);
};
const handleAssigneeTypeChange = (selectedAssignee: string) => {
    selectedMembershipIds.value =[];
    selectedAssigneeType.value = selectedAssignee;
    assigneestatus.value = selectedAssignee;  
    setFieldValue('assigneetype', selectedAssignee);
    setFieldValue('assigneestatus', selectedAssignee);
    setFieldValue('pollassignees', []);
};

// Add an empty option on initialization
const addEmptyOption = () => {
    if (!Array.isArray(values.options)) {
        console.error('Invalid state: values.options is not an array.');
        setFieldValue('options', []); // Reinitialize to an empty array if necessary
    }
    const newOption = {
        id: uuidv4(),  // Assuming uuidv4() is imported and used to generate unique IDs
        title: '',
        poll_id: null,
        deleted_at: null,
        created_at: null,
        updated_at: null,
    };
    // Create a new array with the new option and update the field value
    setFieldValue('options', [...values.options, newOption]);
};

// Call this function when the component is first initialized to start with an empty option
watch(() => values.options, (newOptions) => {
    // console.log('Updated in values:', newOptions.map(opt => opt.id));
});

// Call this function when the component is first initialized to start with an empty option
const removeOption = (id: string) => {
    // console.log('values.options',values.options);
    // console.log('Before remove:', values.options.map(opt => opt.id));
    // Create a new array without the option with the specified id and update the field value
    const updatedOptions = values.options.filter(option => option.id !== id);
    console.log('vv', updatedOptions);
    // Update the field value
    setFieldValue('options', updatedOptions);
    // console.log('Updated in values:', values.options.map(opt => opt.id));
};

const getMemberships = () => {
    return useQuery({
        queryKey: ['getPollMembershisKey'],
        queryFn: async () => {
            const response = await useGetMembershipsRequest(meetingId, {paginate: 'false'});
            return response.data.map(formatEvent());
        },
    });
};
const {isLoading: isLoadingMemberships, data:membershipData, refetch: fetchMemberships} = getMemberships();

const formatEvent = () => (membership:Membership) => ({
    id: membership.id,
    full_name: membership.user.full_name,
    membership_id: membership.id,
    user: membership.user,
});

const Memberships = computed(() => {
    if (!membershipData.value || membershipData.value?.length === 0) {
        return [];
    }
    return membershipData.value;
});

const getMeetingPolls = () => {
    return useQuery({
        queryKey: ['getMeetingPollsKey', meetingId],
        queryFn: async () => {
            const response = await useGetMeetingPollsRequest(meetingId, {paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading:isLoadingMeetingPolls, data: Polls, refetch: fetchMeetingPolls} = getMeetingPolls();
onMounted(async () => {
    // window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Meeting Tasks'}));
    fetchMemberships();
    fetchMeetingPolls();
});

</script>

<style scoped>
</style>
<template>
    <div v-if="authStore.hasPermission(['view poll'])">
        <div class="card h-full">
            <div class="card-header flex items-center">
                <div class="flex items-center flex-1 w-full">
                    <h2 class="card-header-title h3">
                        Meeting Polls
                    </h2>
                </div>
                <div class="flex items-center space-x-2" v-if="authStore.hasPermission(['create poll'])">
                    <button type="button" @click.prevent="openCreatePollModal" class="btn btn-tool">
                        <i class="far fa fa-plus mr-2"></i> <span class="sr-only">Add poll</span>
                    </button>
                </div>
            </div>
            <div class="card-container">
                <div v-if="isLoadingMeetingPolls">Loading Meeting Polls...</div>
                <div v-else>
                    <div class="row overflow-auto p-4" style="max-height: 100vh;">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2" v-for="(poll, idx) in Polls" :key="idx">
                            <div class="card card-outline card-primary h-100">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <button v-if="authStore.hasPermission(['edit poll'])" 
                                                class="btn btn-tool" 
                                                @click.prevent="openEditPollModal(poll)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-primary tex-bold uppercase">
                                        <strong class="text-primary">Question:</strong>
                                        <p  class="mt-2 text-primary text-bold">
                                            {{poll.question}}
                                        </p>
                                        <div class="">
                                            <strong>Answer Options:</strong>
                                            <div class="row">
                                                <div class="col-6">
                                                    <ul class="list-unstyled text-success">
                                                        <li v-for="(option, idx) in 
                                                                poll.options.slice(0, Math.ceil(poll.options.length / 2))" 
                                                            :key="option.id">
                                                            {{ idx + 1 }}. {{ option.title }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="list-unstyled text-success">
                                                        <li v-for="(option, idx) in 
                                                                poll.options.slice(Math.ceil(poll.options.length / 2))" 
                                                            :key="option.id">
                                                            {{ idx + 1 + Math.ceil(poll.options.length / 2) }}. 
                                                            {{ option.title }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>                                                
                                            <strong>Due Date:</strong>
                                            <p :class="dateBadgeClass(poll.duedate)">
                                                {{ formattedDateTime(poll.duedate) }}</p>
                                        </div>
                                        <div>
                                            <strong>Status:</strong>
                                            <p>
                                                <span :class="statusClass(poll.status)">{{ poll.status }}</span>
                                            </p>
                                        </div>
                                        <div>
                                            <strong>Vote:</strong>
                                            <p>
                                                <span v-html="calculateVoteStats(poll)"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <strong>Assignees:</strong>
                                        <div class="row">
                                            <div class="col-6">
                                                <ul class="list-unstyled">
                                                    <li v-for="(assignees, idx) in 
                                                            poll.pollassignees.slice(0, Math.ceil(poll.pollassignees.length / 2))" 
                                                        :key="assignees.id">
                                                        {{ idx + 1 }}. {{ assignees.user.full_name }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-6">
                                                <ul class="list-unstyled">
                                                    <li v-for="(assignees, idx) in 
                                                            poll.pollassignees.slice(Math.ceil(poll.pollassignees.length / 2))" 
                                                        :key="assignees.id">
                                                        {{ idx + 1 + Math.ceil(poll.pollassignees.length / 2) }}. 
                                                        {{ assignees.user.full_name }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <strong>Description:</strong>
                                        <p v-html="poll.description" class="mt-2"></p>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center min-h-screen">
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
                                    <FormQuillEditor
                                        label="Poll description"
                                        name="description"
                                        theme="snow"
                                        placeholder="Enter Poll Description"
                                        toolbar="full"
                                        contentType="html"
                                        class="col-span-2"
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
                                                <button @click.prevent="addEmptyOption"
                                                        class="btn btn-primary h-10 mt-2">
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
                                    <div class="form-group col-span-3" v-if="assigneestatus === 'individuals'">
                                        <label class="text-bold font-medium tracking-wide">
                                            People To Vote
                                        </label>
                                        <div :class="[
                                            'multiselect-container',
                                            { error: !!pollassigneeserrorMessage },
                                        ]">
                                            <Multiselect
                                                id="pollassignees"
                                                v-model="selectedMembershipIds"
                                                mode="tags"
                                                required
                                                placeholder="Choose your stack"
                                                :close-on-select="false"
                                                :filter-results="false"
                                                :min-chars="1"
                                                :resolve-on-load="false"
                                                :delay="0"
                                                :searchable="true"
                                                :options="Memberships"
                                                :valueProp="'membership_id'"
                                                :trackBy="'membership_id'"
                                                :label="'full_name'"
                                                class="col-span-3"
                                                :object="true"
                                                :class="[
                                                    'multiselect-container',
                                                    { error: !!pollassigneeserrorMessage },
                                                ]" 
                                                @select="selectedMembers()"
                                                @deselect="removeselectedUsers()" />
                                            <div v-if="pollassigneeserrorMessage" class="message"> 
                                                {{ pollassigneeserrorMessage }} 
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
    </div>
    <div v-else>
        <p class="m-0">
            <span class="h3  text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div>    
</template>
<style lang="scss">
.danger-color {
    color: #ff0000; /* Or any color/style for "danger" */
}

.ok-color {
    color: #008000; /* Or any color/style for "OK" */
}
</style>



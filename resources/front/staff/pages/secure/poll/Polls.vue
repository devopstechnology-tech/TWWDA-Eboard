<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {object} from 'yup';
import {useCreatePollRequest} from '@/common/api/requests/modules/meeting/usePollRequest';
import {useGetMembershipsRequest} from '@/common/api/requests/modules/membership/useMembershipRequest';
import {
    useCreateMeetingPollRequest,
    useGetMeetingPollsRequest,
    useGetPollsRequest,
    useUpdateMeetingPollRequest,
    useUpdatePollRequest,
} from '@/common/api/requests/modules/poll/usePollRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';
import {Membership, SelectedResult} from '@/common/parsers/membershipParser';
import {Poll, PollRequestPayload} from '@/common/parsers/PollParser';
import useAuthStore from '@/common/stores/auth.store';


const authStore = useAuthStore();
// v-if="authStore.hasPermission(['view meeting'])"

const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const boardId = '1234' as string;
const meetingId = route.params.meetingId as string;
const pollId = ref<string | null>(null);
const selectedMembershipIds = ref<string[]>([]);
const selectedOptionsTitles = ref<string[]>([]);
const allMemberships = ref<Membership[]>([]);
const selectedPoll = ref<Poll | null>(null);
const PollModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();

const {errorMessage} = useField('duedate');

// const hasDueDatePassed = (duedate: string): boolean => {
//     const now = new Date();
//     const dueDate = new Date(duedate);
//     return now > dueDate;
// };
//poll
// question
// description
// duedate
// meeting_id
// board_id
// committee_id
// status
const pollschema = yup.object({
    question: yup.string().required(),
    description: yup.string().required(),
    duedate: yup.string().required(),
    meeting_id: yup.string().nullable(),
    board_id: yup.string().nullable(),
    committee_id: yup.string().nullable(),
    poll_id: yup.string().nullable(),
    status: yup.string(),
    options: yup.array().of(yup.object({
        optiona:yup.object(
            {
                id:yup.string().nullable(),
                title:yup.string().required(),
                poll_id:yup.string().nullable(),
            },
        ),
        optionb:yup.object(
            {
                id:yup.string().nullable(),
                title:yup.string().required(),
                poll_id:yup.string().nullable(),
            },
        ),
    }).required('At least one set of options is required'),
    ),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    question:string;
    description:string;
    duedate:string;
    meeting_id:string|null;
    board_id:string|null;
    committee_id:string|null;
    poll_id:string|null;
    status:string;
    options:[
        {
            optiona: {
                id:string,
                title:string,
                poll_id:string,
            },
            optionb: {
                id:string,
                title:string,
                poll_id:string,
            },
        }
    ];
}>({
    validationSchema: pollschema,
    initialValues: {
        question:'',
        description:'',
        duedate:'',
        meeting_id:meetingId,
        board_id:null,
        committee_id:null,
        poll_id:null,
        status:'active',
        options: [
            {
                optiona: {
                    id:'',
                    title:'',
                    poll_id:'',
                },
                optionb: {
                    id:'',
                    title:'',
                    poll_id:'',
                },
            },
        ],
    },
});

const openCreatePollModal = () => {
    action.value = 'create';
    showCreate.value = true;
    PollModal.value?.showModal();
};
const openEditPollModal = (poll:Poll) => {
    selectedPoll.value = poll;
    pollId.value = poll.id;

    setFieldValue('question',poll.question);
    setFieldValue('description',poll.description);
    setFieldValue('duedate',poll.duedate);
    setFieldValue('meeting_id', poll.meeting_id);
    setFieldValue('board_id', poll.board_id);
    setFieldValue('committee_id',poll.committee_id);
    setFieldValue('poll_id', poll.id);
    setFieldValue('status', poll.status);
    const options = poll.options; // This would be fetched and prepared similarly

    if (options && options.length >= 2) {
        setFieldValue('options', [{
            optiona: {
                id: options[0].id.toString(),
                title: options[0].title,
                poll_id: options[0].poll_id.toString(),
            },
            optionb: {
                id: options[1].id.toString(),
                title: options[1].title,
                poll_id: options[1].poll_id.toString(),
            },
        }]);
    } else {
        // Reset or set default values if not enough options are available
        setFieldValue('options', [{
            optiona: {id: '', title: '', poll_id: ''},
            optionb: {id: '', title: '', poll_id: ''},
        }]);
    }
    // schedules
    action.value = 'edit';
    showCreate.value = true;
    PollModal.value?.showModal();
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        // setFieldValue('pollassignees', selectedMembershipIds.value);
        const payload: PollRequestPayload = {
            question: values.question,
            description: values.description,
            duedate: values.duedate,
            meeting_id: values.meeting_id,
            board_id: values.board_id,
            committee_id: values.committee_id,
            poll_id: values.poll_id,
            status: values.status,
            options: values.options,
        };
        if (action.value === 'create') {
            // await useCreatePollRequest(payload, payload.meeting_id);
        } else {
            const poll_id = pollId.value ? pollId.value.toString() : null;
            payload.poll_id = poll_id;
            const meeting_id = values.meeting_id ? values.meeting_id.toString() : null;
            await useUpdatePollRequest(payload, meeting_id, boardId);
        }
        await fetchPolls();
        reset();
        PollModal.value?.close();
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
    selectedPoll.value = null;
    pollId.value = null;
    setFieldValue('question',''),
    setFieldValue('description',''),
    setFieldValue('duedate',''),
    setFieldValue('meeting_id', ''),
    setFieldValue('board_id', null),
    setFieldValue('committee_id',null),
    setFieldValue('poll_id', null),
    setFieldValue('status', 'active'),
    setFieldValue('options', [
        {
            optiona: {id: '', title: '', poll_id: ''},
            optionb: {id: '', title: '', poll_id: ''},
        },
    ]);
};


const getmemberships = async () => {
    const response = await useGetMembershipsRequest(meetingId, boardId, {paginate: 'false'});
    allMemberships.value = response.data;
};

const getPolls = () => {
    return useQuery({
        queryKey: ['getPollsKey'],
        queryFn: async () => {
            const response = await useGetPollsRequest({paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading, data: Polls, refetch: fetchPolls} = getPolls();
onMounted(async () => {
    fetchPolls();
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Meeting Polls'}));
});

// const polls = ref([]);

// // Mock function to load polls data
// const fetchPolls = () => {
//     // This should actually fetch data from your backend
//     polls.value = [
//         {
//             id: '1',
//             question: 'Annual General Meeting',
//             description: 'Description for the annual general meeting.',
//             duedate: '2024-05-16T18:00:00Z',
//             status: 'On Progress',
//             votes: '120',
//             totalMembers: '150', // Assuming this data comes from backend calculations
//             options: [
//                 {id: '1', title: 'Option A', voteCount: '84'},
//                 {id: '2', title: 'Option B', voteCount: '36'},
//             ],
//         },
//     ];
// };

// onMounted(() => {
//     fetchPolls();
// });

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

// const sendReminder = () => {
//     alert('Reminder sent to all members to vote.');
// };

// const openEditPollModal = (poll) => {
//     console.log('Editing:', poll);
// };

// const calculateVoteStats = (poll) => {
//     if (!poll.options || poll.options.length === 0) return 'No votes yet';

//     const totalVotes = poll.votes;
//     const mostVotedOption = poll.options.reduce((prev, current) =>
//         (prev.voteCount > current.voteCount) ? prev : current);
//     const notVoted = poll.totalMembers - totalVotes;
//     return `${(mostVotedOption.voteCount / totalVotes * 100).toFixed(1)}% voted for ${mostVotedOption.title}<br>${totalVotes} voted / ${notVoted} not yet`;
// };
const calculateVoteStats = (poll) => {
    if (!poll.votes || poll.votes?.length === 0) {
        return 'No votes yet';
    }

    // Recalculate totalVotes to be sure it's correct
    const totalVotes = poll.votes.reduce((acc, option) => acc + option.voteCount, 0);
    const totalMembers = poll.totalMembers;

    // Check if totalVotes exceeds totalMembers which shouldn't normally happen
    if (totalVotes > totalMembers) {
        console.error('Total votes exceed total members, which is unexpected.');
        return 'Voting data error';
    }

    // Proceed if there are votes
    if (totalVotes === 0) {
        return 'No votes yet';
    }

    const mostVotedOption = poll?.votes.reduce((prev, current) => {
        return (prev.voteCount > current.voteCount) ? prev : current;
    });

    const notVoted = totalMembers - totalVotes;
    const votePercentage = (mostVotedOption.voteCount / totalVotes * 100).toFixed(1);

    return `${votePercentage}% voted for ${mostVotedOption.title}<br>${totalVotes} voted / ${notVoted} not yet`;
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
</script>

<style scoped>
</style>
<template>
    <div class="card h-full">
        <div class="card-header flex items-center">
            <div class="flex items-center flex-1 w-full">
                <h2 class="card-header-title h3">
                    Meeting Polls
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <!-- <button type="button" @click.prevent="openCreatePollModal" class="btn btn-tool">
                    <i class="far fa fa-plus mr-2"></i> <span class="sr-only">Add poll</span>
                </button> -->
            </div>
        </div>
        <div id="poll-asignee-list">
            <table class="table table-striped card-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <button class="text-bold btn btn-link btn-sm list-sort asc" data-sort="poll-title">
                                Poll Title
                            </button>
                        </th>
                        <th scope="col">
                            <button class="text-bold btn btn-link btn-sm list-sort" data-sort="due-date">
                                Due Date
                            </button>
                        </th>
                        <th scope="col">
                            <button class="text-bold btn btn-link btn-sm list-sort" data-sort="status">
                                Status
                            </button>
                        </th>
                        <th scope="col">
                            <button class="text-bold btn btn-link btn-sm list-sort"
                                    data-sort="vote-stats">Vote Stats
                            </button>
                        </th>
                        <th scope="col" class="text-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="list">
                    <tr v-for="(poll, idx) in Polls" :key="idx">
                        <td class="poll-title" data-name="poll.name"
                            style="max-width: 200px; word-wrap: break-word;">
                            <div class="font-weight-bold">{{ poll.question }}</div>
                            <p style="white-space: normal;">{{ poll.description }}</p>
                        </td>
                        <td :class="dateBadgeClass(poll.duedate)">
                            {{ formattedDateTime(poll.duedate) }}
                            <button v-if="isDueSoon(poll.duedate)" class="btn btn-warning btn-sm" @click="sendReminder">
                                Send Reminder
                            </button>
                        </td>
                        <td>
                            <span :class="statusClass(poll.status)">{{ poll.status }}</span>
                        </td>
                        <td v-html="calculateVoteStats(poll)"></td>
                        <td class="text-center">
                            <!-- <button class="btn btn-danger btn-sm"
                                    @click.prevent="openEditPollModal(poll)">
                                Edit
                            </button> -->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="pollmodal" class="modal" ref="PollModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{action == 'create' ? 'Create Meeting Poll' : 'Edit Meeting Poll'}}
                </h3>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1">
                            <div class="grid grid-cols-3 gap-2">
                                <FormInput
                                    :labeled="true"
                                    label="Poll Question"
                                    name="question"
                                    class="col-span-3 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Poll Question"
                                    type="text"
                                />
                                <FormInput
                                    :labeled="true"
                                    label="Answer Option A"
                                    name="options[0].optiona.title"
                                    class="col-span-1 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Answer Option A"
                                    type="text"
                                />
                                <FormInput
                                    :labeled="true"
                                    label="Answer Option B"
                                    name="options[0].optionb.title"
                                    class="col-span-1 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Answer Option A"
                                    type="text"
                                />
                                <div :class="[
                                    'formdatetime-container',
                                    { error: !!errorMessage },
                                ]">

                                    <FormDateTimeInput
                                        label="Poll Due Date"
                                        name="duedate"
                                        :flow="['day']"
                                        placeholder="Poll Due Date"
                                    />
                                    <div v-if="errorMessage" class="message"> {{ errorMessage }} </div>
                                </div>
                                <FormTextBox
                                    label="Poll Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Poll Description"
                                    :rows="2"
                                />
                            </div>
                            <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{action == 'create' ? 'Create Meeting Poll' : 'Edit Meeting Poll'}}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </dialog>
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



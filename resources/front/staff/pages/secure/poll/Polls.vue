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
    useGetAssignedPollsRequest,
    useGetMeetingPollsRequest,
    useGetPollsRequest,
    useUpdateMeetingPollRequest,
    useUpdatePollRequest,
    useVotePollRequest,
} from '@/common/api/requests/modules/poll/usePollRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormRadioInput from '@/common/components/FormRadioInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';
import {Membership, SelectedResult} from '@/common/parsers/membershipParser';
import {Poll, PollRequestPayload, PollVoteRequestPayload} from '@/common/parsers/PollParser';
import useAuthStore from '@/common/stores/auth.store';


const authStore = useAuthStore();
authStore.initialize(); 
const currentUserid = authStore.user.id;

const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const boardId = '1234' as string;
const meetingId = route.params.meetingId as string;
const pollId = ref<string | null>(null);
const UserAssignee = ref<string | null>(null);
const selectedMembershipIds = ref<string[]>([]);
const selectedOptionsTitles = ref<string[]>([]);
const allMemberships = ref<Membership[]>([]);
const selectedPoll = ref<Poll | null>(null);
const VoteModal = ref<HTMLDialogElement | null>(null);
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
    poll_id: yup.string().required(),
    poll_assignee_id: yup.string().required(),
    selectedOption: yup.string().required(),    
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    poll_id:string;
    poll_assignee_id:string;
    selectedOption:string;
}>({
    validationSchema: pollschema,
    initialValues: {
        poll_id:'',
        poll_assignee_id:'',
        selectedOption:'',
    },
});


const onSubmit = handleSubmit(async (values) => {
    try {
        // setFieldValue('pollassignees', selectedMembershipIds.value);
        const payload: PollVoteRequestPayload = {
            poll_id: values.poll_id,
            poll_assignee_id: values.poll_assignee_id,
            selectedOption: values.selectedOption,
        };
       
        await useVotePollRequest(payload, payload.poll_id);
        await fetchPolls();
        reset();
        VoteModal.value?.close();
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
    setFieldValue('poll_id','');
    setFieldValue('poll_assignee_id','');
    setFieldValue('selectedOption','');
};


const getPolls = () => {
    return useQuery({
        queryKey: ['getOwnPollsKey'],
        queryFn: async () => {
            const response = await useGetAssignedPollsRequest({paginate: 'false'});
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
const poll = computed(() => {    
    return selectedPoll.value;
});
const Userassignee = computed(() => {    
    return UserAssignee.value;
});

function checkIfVoted(poll: Poll, currentUserId: string): boolean {
    // Find the current user's assignee information
    const currentUserAssignee = poll.pollassignees.find(assignee => assignee.user.id === currentUserId);
    
    if (!currentUserAssignee) {
        return false;
    }
    
    const user = {
        assignee_id: currentUserAssignee.id,
        user_id: currentUserAssignee.user.id,
        full_name: currentUserAssignee.user.full_name,
    };

    // Check if there's a vote in poll.votes that matches the poll_id and assignee_id
    const hasVoted = poll.votes.some(vote => vote.poll_id === poll.id && vote.assignee_poll_id === user.assignee_id);

    console.log('hasVoted', hasVoted);
    return hasVoted;
}

const viewPoll = (poll:Poll) => {
    const currentUserAssignee = poll.pollassignees.find(assignee => assignee.user.id === currentUserid);
    
    const user = {
        assignee_id:currentUserAssignee.id,
        user_id:currentUserAssignee.user.id,
        full_name:currentUserAssignee.user.full_name,
    };
    selectedPoll.value = poll;
    UserAssignee.value = user;
    setFieldValue('poll_id', poll.id);
    setFieldValue('poll_assignee_id', currentUserAssignee.id);
    action.value = 'create';
    showCreate.value = true;
    VoteModal.value?.showModal();
    console.log(UserAssignee.value);
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
                            <div v-html="poll.description"></div>
                        </td>
                        <td >
                            {{ formattedDateTime(poll.duedate) }}
                            <!-- <button v-if="isDueSoon(poll.duedate)" class="btn btn-warning btn-sm" @click="sendReminder">
                                Send Reminder
                            </button> -->
                        </td>
                        <td>
                            <span :class="statusClass(poll.status)">{{ poll.status }}</span>
                        </td>
                        <td v-html="calculateVoteStats(poll)"></td>
                        <td class="text-center" >
                            <div v-if="checkIfVoted(poll)">
                                <button type="button" @click.prevent="viewPoll(poll)"
                                        title="" class="mx-2 btn btn-sm btn-primary">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            <div v-else>
                                You Have Voted
                            </div>                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-center items-center min-h-screen">
        <dialog id="voteModal" class="modal w-full max-w-4xl mx-auto p-0" ref="VoteModal">
            <form method="dialog" class="modal-box rounded-xl relative bg-white shadow-xl">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" >✕</button>            
                <div class="overflow-auto p-4" style="max-height: 80vh;" v-if="poll">  
                    <div class="card-header">
                        <h3 class="card-title">Poll Details</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">Due</dt>
                            <dd class="col-sm-9">{{ formattedDateTime(poll.duedate) }}</dd>
                            <!-- <dt class="col-sm-3">Groups</dt>
                            <dd class="col-sm-9">
                                <a class="badge badge-primary" href="https://app.boardable.com/fffffffffffffff/groups/cce720-board">Board</a>
                            </dd>

                            <dt class="col-sm-3">Posted by</dt>
                            <dd class="col-sm-9 d-flex align-items-center">
                                <div class="avatar avatar-xs">
                                    <img src="https://app.boardable.com/img/default_user.svg" class="avatar-img rounded-circle" alt="Nyariki Felix profile image">
                                </div>
                                <p class="ml-2 mb-0">
                                    <a href="#" class="person-card" tabindex="0" >
                                        Nyariki Felix
                                    </a>
                                </p>
                            </dd> -->
                        </dl>
                        <hr>
                        <div class="user-content text-primary">
                            <dl>
                                <dt class="text-muted">Description</dt>
                                <dd><p v-html="poll.description"></p></dd>
                                <dd><p>{{ poll.question }}</p></dd>
                            </dl>
                        </div>
                        <div id="form">
                            <div class="alert alert-danger d-none" id="validation-message"></div>
                            <form novalidate @submit.prevent="onSubmit">
                                <div class="form-group">                                    
                                    <FormRadioInput
                                        label="Poll Options"
                                        name="selectedOption"
                                        :options="poll.options"
                                        :inline="true"
                                    />
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
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



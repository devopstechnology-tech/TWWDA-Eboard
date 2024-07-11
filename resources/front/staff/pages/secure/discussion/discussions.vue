<template>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Search Discussions</h3>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control rounded-end" 
                               placeholder="Search discussions" 
                               aria-label="Search discussions">
                    </div>
                    <div class="flex gap-x-2">
                        <div class="dropdown">
                            <button  class="nav-link dropdown-toggle btn-sm btn btn-secondary btn-block p-1" 
                                     href="#" id="sortDropdown"
                                     type="button" role="button" data-toggle="dropdown" 
                                     aria-haspopup="true"
                                     aria-expanded="false">
                                <span>{{ currentSortName }}</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a v-for="option in sortOptions" :key="option.id"
                                   href="#" class="dropdown-item"
                                   @click.prevent="applySort(option.id)">
                                    {{ option.name }}
                                </a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button  class="nav-link dropdown-toggle btn-sm btn btn-secondary btn-block p-1" 
                                     href="#" id="sortGroupDropdown"
                                     type="button" role="button" data-toggle="dropdown" 
                                     aria-haspopup="true"
                                     aria-expanded="false">
                                <span>{{ currentGroupSortName }}</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a v-for="option in sortGroupOptions" :key="option.id"
                                   href="#" class="dropdown-item"
                                   @click.prevent="applyGroupSort(option.id)">
                                    {{ option.name }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="card-body p-0" style="height: 500px; overflow-y: auto;">
                        <div v-for="discussion in discussions" :key="discussion.id" 
                             class="card mb-2 border border-primary hover:cursor-pointer">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-user-circle fa-2x me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ discussion.topic }}</h6>
                                    <small class="text-muted">Nyariki Felix</small>
                                    <p class="mb-0">{{ discussion.content }}</p>
                                    <small class="text-muted">{{ discussion.lastPost }}</small>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-secondary">
                                    <i class="far fa-star"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class=" flex items-center bg-success">
                    <h3 class="ml-2 card-title">Discussion</h3>
                    <div class="ml-auto flex self-end">
                        <a class="nav-link " href="#" id="navbarDropdown"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a v-for="option in discussionOptions" :key="option.id"
                               class="dropdown-item" href="#" 
                               @click.prevent="handleDiscussionOption(option.id)">
                                <i :class="option.icon"></i> {{ option.name }}
                            </a>
                        </div>
                        <button class="btn btn-sm  text-white mr-2" @click.prevent="openMemberModal()">
                            <i class="fas fa-users "></i>
                        </button>
                    </div>
                </div>
                <div class="card-header">
                    <h5>Topic testing</h5>
                    <span class="badge bg-secondary">Board</span>
                </div>
                <div class="card-body">
                    <div class="flex-1 mb-8">
                        <div class="bg-gray-200 text-gray-700 rounded-lg px-4 pt-1 pb-1">
                            <div class="text-xs font-medium subpixel-antialiased mb-2 text-gray-900">
                                <a href="#" class="text-gray-800" data-bs-original-title="" title="">
                                    Nyariki Felix
                                </a>
                                created this discussion on June 29, 2024
                            </div>
                            <div><p>&nbsp;testing &nbsp;testing &nbsp;testing&nbsp;&nbsp;</p></div>
                        </div>
                    </div>
                    <div class="direct-chat-messages">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                            </div>
                            <!-- <img class="direct-chat-img" src="../dist/img/user1-128x128.jpg" alt="Message User Image" /> -->
                            <i class="fas fa-user-circle fa-2x me-3"></i>
                            <div class="direct-chat-text">
                                Is this template really for free? That's unbelievable!
                            </div>
                        </div>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                            </div>
                            <!-- <img class="direct-chat-img" src="../dist/img/user3-128x128.jpg" alt="Message User Image" /> -->
                            <i class="fas fa-user-circle fa-2x me-3"></i>
                            <div class="direct-chat-text">
                                You better believe it!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Leave a comment">
                        <button class="btn btn-primary" type="button">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted,ref, watch} from 'vue';
import {ValidationError} from 'yup';
import * as yup from 'yup';
import {useCreateDiscussionRequest, useGetUserDiscussionsRequest,useUpdateDiscussionRequest} from '@/common/api/requests/modules/discussion/useDiscussionRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {DiscussionAssignee} from '@/common/parsers/DiscussionAssigneeParser';
import {Discussion, DiscussionRequestPayload} from '@/common/parsers/discussionParser';
import useAuthStore from '@/common/stores/auth.store';
import { useGetBoardsRequest } from '@/common/api/requests/modules/board/useBoardRequest';
import { Board } from '@/common/parsers/boardParser';
import { User } from '@/common/parsers/userParser';
import { useGetCommitteesRequest } from '@/common/api/requests/modules/committee/useCommitteeRequest';
import { useGetUsersRequest } from '@/common/api/requests/modules/user/useUserRequest';
import { Committee } from '@/common/parsers/committeeParser';


const authStore = useAuthStore();
authStore.initialize(); 
const currentSort = ref('latest');
const currentGroupName = ref('board');

const showCreate = ref(false);
const action = ref('create');
const userId = authStore.user?.id as string;
const discussionId = ref<string | null>(null);
const selectedUserAssigneeIds = ref<DiscussionAssignee[]>([]);
const selectedBoardAssigneeIds = ref<DiscussionAssignee[]>([]);
const selectedCommitteeAssigneeIds = ref<DiscussionAssignee[]>([]);
const selectedDiscussion = ref<Discussion | null>(null);
const DiscussionModal = ref<HTMLDialogElement | null>(null);
const assigneestatus = ref('individuals');
const selectedAssigneeType = ref('');
// Reactive properties to store fetched data
const allBoards = ref<Board[]>([]);
const allCommittees = ref<Committee[]>([]);
const allUsers = ref<User[]>([]);

const handleUnexpectedError = useUnexpectedErrorHandler();

const {errorMessage: duedateerrorMessage} = useField('duedate');
const {errorMessage: discussionassigneeserrorMessage} = useField('discussionassignees');

const hasDueDatePassed = (duedate: string): boolean => {
    const now = new Date();
    const dueDate = new Date(duedate);
    return now > dueDate;
};


const userSchema = yup.object({
    id: yup.string().required(),
    full_name: yup.string().required(),
});

const discussionassigneeSchema = yup.object({
    id: yup.string().required(),
    discussion_id: yup.string().nullable(),
    assignee_id: yup.string().required(),
    user: userSchema,
});
const discussionschema = yup.object({
    id: yup.string().nullable(),
    topic: yup.string().required(),
    description: yup.string().required(),
    closestatus: yup.string().required(),
    archivestatus: yup.string().required(),
    assigneetype: yup.string().required(),
    assigneestatus: yup.string().required(),
    discussionassignees: yup.array().of(discussionassigneeSchema).nullable(),
});

const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    id: string;
    topic: string;
    description: string;
    closestatus: string;
    archivestatus: string;
    assigneetype: string;
    assigneestatus: string;
    discussionassignees: {
        id: string;
        discussion_id: string | null;
        assignee_id: string;
        user: {
            id: string;
            full_name: string;
        };
    }[] | [];
}>({
    validationSchema: discussionschema,
    initialValues: {
        id: '',
        topic: '',
        description: '',
        closestatus: 'opened',
        archivestatus: 'none',
        assigneetype: '',
        assigneestatus: '',
        discussionassignees: [],        
    },
});

const openCreateDiscussionModal = () => {
    reset();
    action.value = 'create';
    showCreate.value = true;
    DiscussionModal.value?.showModal();
};

const openEditDiscussionModal = (discussion: Discussion) => {
    reset();
    selectedDiscussion.value = discussion;
    discussionId.value = discussion.id;
    setFieldValue('topic', discussion.topic);
    setFieldValue('description', discussion.description);
    setFieldValue('closestatus', discussion.closestatus);
    setFieldValue('archivestatus', discussion.archivestatus);
    setFieldValue('assigneetype', discussion.assigneetype);
    setFieldValue('assigneestatus', discussion.assigneestatus);
    assigneestatus.value = discussion.assigneestatus;
    mapdiscussionassigneesToReactiveRef(discussion.discussionassignees);
    action.value = 'edit';
    showCreate.value = true;
    DiscussionModal.value?.showModal();
};

function mapdiscussionassigneesToReactiveRef(discussionassignees: DiscussionAssignee[]) {
    selectedAssigneeIds.value = discussionassignees.map(discussionassignee => ({
        id: discussionassignee.id,
        full_name: discussionassignee.user.full_name,
        discussion_id: discussionassignee.discussion_id,
        assignee_id: discussionassignee.assignee_id,
        user: discussionassignee.user,
    }));
    setFieldValue('discussionassignees', selectedAssigneeIds.value);
}

const selectedAssignees = () => {
    setFieldValue('discussionassignees', selectedAssigneeIds.value);
};

const removeselectedUsers = () => {
    setFieldValue('discussionassignees', selectedAssigneeIds.value);
};

const onSubmit = handleSubmit(async (values) => {
    try {
        const payload: DiscussionRequestPayload = {
            id: values.id,
            topic: values.topic,
            description: values.description,
            closestatus: values.closestatus,
            archivestatus: values.archivestatus,
            assigneetype: values.assigneetype,
            assigneestatus: values.assigneestatus,
            discussionassignees: values.discussionassignees,
        };
        if (action.value === 'create') {
            await useCreateDiscussionRequest(payload, userId);
        } else {
            await useUpdateDiscussionRequest(payload, userId, payload.id);
        }
        DiscussionModal.value?.close();
        await fetchDiscussions();
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
    discussionId.value = null;
    assigneestatus.value = 'all_members';
    selectedAssigneeIds.value = [];
    setFieldValue('id', '');
    setFieldValue('topic', '');
    setFieldValue('description', 'description ................');
    setFieldValue('closestatus', 'opened');
    setFieldValue('archivestatus', 'none');
    setFieldValue('assigneetype', 'all_members');
    setFieldValue('assigneestatus', 'all_members');
    setFieldValue('discussionassignees', []);
};

const handleAssigneeTypeChange = (selectedAssignee: string) => {
    selectedAssigneeIds.value = [];
    selectedAssigneeType.value = selectedAssignee;
    assigneestatus.value = selectedAssignee;
    setFieldValue('assigneetype', selectedAssignee);
    setFieldValue('assigneestatus', selectedAssignee);
};

//data

// Sort options
const sortGroupOptions = [
    {id: 'all-groups', name: 'All Groups'},
    {id: 'board', name: 'Board'},
];

// Sort options
const sortOptions = [
    {id: 'latest', name: 'Latest'},
    {id: 'starred', name: 'Starred'},
    {id: 'unread', name: 'Unread'},
    {id: 'mentions', name: 'Mentions'},
    {id: 'archived', name: 'Archived'},
];
// Discussion options
const discussionOptions = [
    {id: 'leave', name: 'Leave Discussion', icon: 'fas fa-sign-out-alt'},
    // {id: 'copy', name: 'Copy Link', icon: 'fas fa-copy'},
    {id: 'unread', name: 'Mark as Unread', icon: 'fas fa-envelope-open-text'},
    {id: 'print', name: 'Print', icon: 'fas fa-print'},
    {id: 'edit', name: 'Edit Description', icon: 'fas fa-edit'},
    {id: 'close', name: 'Close Discussion', icon: 'fas fa-times'},
    // {id: 'archive', name: 'Archive Discussion', icon: 'fas fa-archive'},
    {id: 'delete', name: 'Delete Discussion', icon: 'far fa-trash-alt text-danger'},
];
// Sample discussions data
const discussions = ref([
    {id: 1, topic: 'Vue 3 Composition API', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
]);
const assigneeTypes = [
    {name: 'Individuals', value: 'individuals'},
    {name: 'Assign All Meeting Members', value: 'all_members'},
];
// filtering sort
function applySort(option: string) {
    currentSort.value = option;
    // Implement sorting logic here
}
// Computed property to return the name of the current sort
const currentSortName = computed(() => {
    const option = sortOptions.find(option => option.id === currentSort.value);
    return option ? option.name : 'Latest';  // Default to 'Unknown' if not found

});

// filtering sort
function applyGroupSort(option: string) {
    currentGroupName.value = option;
    // Implement sorting logic here
}
// Computed property to return the name of the current sort
const currentGroupSortName = computed(() => {
    const option = sortOptions.find(option => option.id === currentSort.value);
    return option ? option.name : 'Board';  // Default to 'Unknown' if not found

});

// Handle discussion options
function handleDiscussionOption(optionId: string) {
    // Implement the functionality for each discussion option
    console.log('optionId', optionId);
}

onMounted(() => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Discussions'}));
});


const AssigneeTypes = computed(() => assigneeTypes);

const getDiscussions = () => {
    return useQuery({
        queryKey: ['getDiscussionsKey', userId],
        queryFn: async () => {
            const response = await useGetUserDiscussionsRequest(userId, {paginate: 'false'});
            return response.data;
        },
    });
};

const {isLoading: isLoadingDiscussions, data: Discussions, refetch: fetchDiscussions} = getDiscussions();

// Fetch functions
const getBoards = async () => {
    const response = await useGetBoardsRequest({paginate: 'false'});
    allBoards.value = response.data.map(board => ({
        id: board.id,
        name: board.name,
        class: 'board',
    }));
};
const getCommittees = async () => {
    const response = await useGetCommitteesRequest({paginate: 'false'});
    allCommittees.value = response.data.map(committee => ({
        id: committee.id,
        name: committee.name,
        class: 'committee',
    }));
};

const fetchUsers = async () => {
    const data = await useGetUsersRequest({paginate: 'false'});
    allUsers.value = data.data.map(user => ({
        id: user.id,
        name: user.full_name,
        class: 'user',
    }));
};

// Fetch all member types on component mount or when dependencies change
const getAllMembers = async () => {
    await fetchUsers();
    await getBoards();
    await getCommittees();
};

onMounted(async() => {
    getAllMembers();
    authStore.initialize();
    fetchDiscussions();
});

</script>
  
  <style scoped>
  .card-header .card-title {
    color: white;
  }
  .input-group .form-control.rounded-end {
    border-radius: 0 0.375rem 0.375rem 0;
  }

  </style>
  
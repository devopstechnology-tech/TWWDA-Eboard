
<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted,ref} from 'vue';
import {ValidationError} from 'yup';
import * as yup from 'yup';
import {useGetBoardsRequest} from '@/common/api/requests/modules/board/useBoardRequest';
import {useGetCommitteesRequest} from '@/common/api/requests/modules/committee/useCommitteeRequest';
import {useCreateChatRequest, useUpdateChatRequest} from '@/common/api/requests/modules/discussion/useChatRequest';
import {
  useCloseDiscussionRequest,
    useCreateDiscussionRequest, 
    useDeleteDiscussionRequest, 
    useGetUserDiscussionsRequest,
    useLeaveDiscussionRequest,
    useUpdateDiscussionRequest,
} from '@/common/api/requests/modules/discussion/useDiscussionRequest';
import {useGetUsersRequest} from '@/common/api/requests/modules/user/useUserRequest';
import FormInput from '@/common/components/FormInput.vue';
import FormQuillEditor from '@/common/components/FormQuillEditor.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formatDate,loadAvatar} from '@/common/customisation/Breadcrumb';
import {Board} from '@/common/parsers/boardParser';
import {Chat, ChatRequestPayload} from '@/common/parsers/chatParser';
import {Committee} from '@/common/parsers/committeeParser';
import {DiscussionAssignee} from '@/common/parsers/DiscussionAssigneeParser';
import {Discussion, DiscussionRequestPayload} from '@/common/parsers/discussionParser';
import {User} from '@/common/parsers/userParser';
import useAuthStore from '@/common/stores/auth.store';


const authStore = useAuthStore();
authStore.initialize(); 
const currentUser = authStore.user.id;
const currentSort = ref('latest');
const currentGroupName = ref('board');

const action = ref('create');
const showCreate = ref(false);
const hide = ref(false);

const editingChatIndex = ref(-1);
const is_editing = ref(false);
const isAddingNewChat = ref(false);
const userId = authStore.user?.id as string;
const discussionId = ref<string | null>(null);
const selectedGroupMembers = ref<[]>([]);
const selectedChats = ref<Chat[]>([]);
const selectedChat = ref<Chat | null>(null);
const selectedDiscussion = ref<Discussion | null>(null);
const selectedAssignees = ref<[]>([]);
const DiscussionModal = ref<HTMLDialogElement | null>(null);
// Reactive properties to store fetched data
const allBoards = ref<Board[]>([]);
const allCommittees = ref<Committee[]>([]);
const allUsers = ref<User[]>([]);

const handleUnexpectedError = useUnexpectedErrorHandler();

const {errorMessage: discussionassigneeserrorMessage} = useField('discussionassignees');

const hasDueDatePassed = (duedate: string): boolean => {
    const now = new Date();
    const dueDate = new Date(duedate);
    return now > dueDate;
};


const userSchema = yup.object({
    id: yup.string().nullable(),
    full_name: yup.string().nullable(),
});

const discussionassigneeSchema = yup.object({
    id: yup.string().nullable(),
    discussion_id: yup.string().nullable(),
    assignee_id: yup.string().nullable(),
    user: userSchema,
});
const discussionschema = yup.object({
    id: yup.string().nullable(),
    topic: yup.string().required(),
    description: yup.string().required(),
    closestatus: yup.string().required(),
    archivestatus: yup.string().required(),
    message: yup.string().nullable(),
    assignee_sender_id: yup.string().nullable(),
    discussion_id: yup.string().nullable(),
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
    message: string|null;
    assignee_sender_id: string|null;
    discussion_id: string|null;
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
        message: null,
        assignee_sender_id: null,
        discussion_id: null,
        discussionassignees: [],        
    },
});

const openCreateDiscussionModal = () => {
    reset();
    action.value = 'create';
    hide.value = false;
    showCreate.value = true;
    DiscussionModal.value?.showModal();
};

const openEditDiscussionModal = (discussion: Discussion) => {
    reset();
    selectedDiscussion.value = discussion;
    setFieldValue('id', discussion.id);
    setFieldValue('topic', discussion.topic);
    setFieldValue('description', discussion.description);
    setFieldValue('closestatus', discussion.closestatus);
    setFieldValue('archivestatus', discussion.archivestatus);
    selectedGroupMembers.value = discussion.dassignees;
    setFieldValue('discussionassignees', selectedGroupMembers.value);

    action.value = 'edit';
    showCreate.value = true;
    DiscussionModal.value?.showModal();
    console.log(values, action.value);
};
const openMemberModal = (discussion: Discussion) => {
    reset();
    hide.value = true;
    selectedDiscussion.value = discussion;
    setFieldValue('id', discussion.id);
    setFieldValue('topic', discussion.topic);
    setFieldValue('description', discussion.description);
    setFieldValue('closestatus', discussion.closestatus);
    setFieldValue('archivestatus', discussion.archivestatus);
    selectedGroupMembers.value = discussion.dassignees;
    setFieldValue('discussionassignees', selectedGroupMembers.value);

    action.value = 'edit';
    showCreate.value = true;
    DiscussionModal.value?.showModal();
    console.log(values, action.value);
};

// function mapdiscussionassigneesToReactiveRef(discussionassignees: DiscussionAssignee[]) {
//     selectedGroupMembers.value = discussionassignees.map(discussionassignee => ({
//         id: discussionassignee.id,
//         full_name: discussionassignee.user.full_name,
//         discussion_id: discussionassignee.discussion_id,
//         assignee_id: discussionassignee.assignee_id,
//         user: discussionassignee.user,
//     }));
//     setFieldValue('discussionassignees', selectedGroupMembers.value);
// }



const onSubmit = handleSubmit(async (values) => {
    try {
        if (action.value === 'create' || action.value === 'edit'){
            const payload: DiscussionRequestPayload = {
                id: values.id,
                topic: values.topic,
                description: values.description,
                closestatus: values.closestatus,
                archivestatus: values.archivestatus,
                discussionassignees: values.discussionassignees,
            };
            if (action.value === 'create') {
                await useCreateDiscussionRequest(payload, userId);
            } else {
                await useUpdateDiscussionRequest(payload, userId, payload.id);
            }
        }else if(action.value === 'create chat' || action.value === 'edit chat'){
            const payload: ChatRequestPayload = {
                id: values.id? values.id :'',
                topic: values.topic,
                description: values.description,
                message: values.message?  values.message : '',
                assignee_sender_id: values.assignee_sender_id? values.assignee_sender_id: '',                
                discussion_id: values.discussion_id? values.discussion_id: '',                
            };
            if (action.value === 'create chat'){
                const response = await useCreateChatRequest(payload, userId, {paginate: 'false'});
                selectedChats.value = response.data;
            } else if (action.value === 'edit chat'){
                const response = await useUpdateChatRequest(payload, {paginate: 'false'});
                selectedChats.value = response.data;
            }
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
    hide.value = false;
    editingChatIndex.value = -1;
    is_editing.value = false;
    isAddingNewChat.value = false;
    showCreate.value = false;
    discussionId.value = null;
    selectedGroupMembers.value = [];
    selectedChat.value = null;
    setFieldValue('id', '');
    setFieldValue('topic', '');
    setFieldValue('description', 'description ................');
    setFieldValue('closestatus', 'opened');
    setFieldValue('archivestatus', 'none');
    setFieldValue('discussionassignees', []);
    setFieldValue('message', '');
    setFieldValue('assignee_sender_id', null);
    setFieldValue('discussion_id', null);
};

//data

// Sort options
const sortGroupOptions = [
    {id: 'all-groups', name: 'All Groups'},
    {id: 'user', name: 'User'},
    {id: 'board', name: 'Board'},
    {id: 'committee', name: 'committee'},
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
    {id: 'leave', name: 'Leave Discussion', icon: 'fas fa-sign-out-alt', permissions: ['leave discussion']},
    // {id: 'copy', name: 'Copy Link', icon: 'fas fa-copy', permissions: ['copy link discussion']},
    // {id: 'unread', name: 'Mark as Unread', icon: 'fas fa-envelope-open-text', permissions: ['mark read discussion']},
    // {id: 'print', name: 'Print', icon: 'fas fa-print', permissions: ['print discussion']},
    {id: 'edit', name: 'Edit Description', icon: 'fas fa-edit', permissions: ['edit discussion']},
    {id: 'close', name: 'Close Discussion', icon: 'fas fa-times', permissions: ['close discussion']},
    // {id: 'archive', name: 'Archive Discussion', icon: 'fas fa-archive', permissions: ['archive discussion']},
    {id: 'delete', name: 'Delete Discussion', icon: 'far fa-trash-alt text-danger', permissions: ['delete discussion']},
];

const filterdiscussionOptions = computed(()=>{
    return discussionOptions.filter(discussionOption => {
        if (discussionOption.permissions) {
            return discussionOption.permissions.every(permission => authStore.hasPermission([permission]));
        }
        return true;
    });
});

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
function handleDiscussionOption(
    name: string, 
    discussion:Discussion,
) {    // Implement the functionality for each discussion option
    console.log('optionId', name);
    if(name === 'Leave Discussion' ){
        // if(naem = '@click.prevent="openEditDiscussionModal(discussion)"' ){
        leaveDiscussion(discussion);
    }else if(name === 'Edit Description'){
        openEditDiscussionModal(discussion);
    }else if(name === 'Close Discussion'){
        closeDiscussion(discussion);
    }else if(name === 'Delete Discussion'){
        deleteDiscussion(discussion);
    }
}

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
    allBoards.value = response.data;
};
const getCommittees = async () => {
    const response = await useGetCommitteesRequest({paginate: 'false'});
    allCommittees.value = response.data;
};
const getUsers = async () => {
    const response = await useGetUsersRequest({paginate: 'false'});    
    allUsers.value = response.data;
};
const processedGroups = computed(() => {
    const groups =  [
        {
            label: 'Boards',
            options: allBoards.value.map(board => ({
                id: board.id,
                name: board.name,
                class: 'board',
            })),
        },
        {
            label: 'Committees',
            options: allCommittees.value.map(committee => ({
                id: committee.id,
                name: committee.name,
                class: 'committee',
            })),
        },
        {
            label: 'Users',
            options: allUsers.value.map(user => ({
                id: user.id,
                name: user.full_name,
                class: 'user',
            })),
        },
    ];
    return groups;
});
const selectedBoards = computed(() => {
    return selectedGroupMembers.value.filter(member => member.class === 'board');
});

const selectedCommittees = computed(() => {
    return selectedGroupMembers.value.filter(member => member.class === 'committee');
});

const selectedUsers = computed(() => {
    return selectedGroupMembers.value.filter(member => member.class === 'user');
});
const Chats = computed(() => {
    return selectedChats.value;
});
const discussion = computed(() => {
    return selectedDiscussion.value;

});
const chat = computed(() => {
    return selectedChat.value;

});


const handleSelectedDiscussion = (discussion:Discussion)=>{
    reset();
    selectedChats.value = discussion.chats;
    selectedDiscussion.value = discussion;
};

const onSubmitChat = (discussion:Discussion)=>{
    //discussion
    setFieldValue('topic', discussion.topic);
    setFieldValue('description', discussion.description);
    setFieldValue('closestatus', discussion.closestatus);
    setFieldValue('archivestatus', discussion.archivestatus);
    setFieldValue('discussion_id', discussion.id);;
    selectedGroupMembers.value = discussion.dassignees;
    setFieldValue('discussionassignees', selectedGroupMembers.value);
    onSubmit();
};

const selectedGroupMember = ()=>{
    setFieldValue('discussionassignees', selectedGroupMembers.value);    
};
const removeselectedGroupMembers = ()=>{
    setFieldValue('discussionassignees', selectedGroupMembers.value);
};
const leaveDiscussion = (discussion:Discussion)=>{
    useLeaveDiscussionRequest(discussion.id);
    fetchDiscussions();
    reset();
};
const closeDiscussion = (discussion:Discussion)=>{
    useCloseDiscussionRequest(discussion.id);
    fetchDiscussions();
    reset();
};
const deleteDiscussion = (discussion:Discussion)=>{
    useDeleteDiscussionRequest(discussion.id);
    fetchDiscussions();
    reset();
};
// Fetch all member types on component mount or when dependencies change
const getAllMembers = async () => {
    await getUsers();
    await getBoards();
    await getCommittees();
};

onMounted(async() => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Discussions'}));   
    getAllMembers();
    fetchDiscussions();
});

const enableAddingNewChat = () => {
    reset();
    isAddingNewChat.value = true;
    is_editing.value = false;
    editingChatIndex.value = -1;
    action.value = 'create chat';
};
// edit functionality of minutes
const enableEditing = (chatIndex: number, chat:Chat) => {
    reset();
    is_editing.value = true;
    isAddingNewChat.value = false;
    editingChatIndex.value = chatIndex;
    action.value = 'edit chat';
 
    //chat
    selectedChat.value = chat;
    setFieldValue('id', chat.id);
    setFieldValue('message', chat.message);
    setFieldValue('assignee_sender_id', chat.assignee_sender_id);
    
};
</script>
<template>
    <div v-if="authStore.hasPermission(['view discussion'])">
        <div class="card h-full">
            <div class="card-header flex items-center">
                <div class="flex items-center flex-1 w-full">
                    <h2 class="card-header-title h3">Discussion</h2>
                </div>
                <div class="flex items-center space-x-2" v-if="authStore.hasPermission(['create discussion'])">
                    <button type="button" @click.prevent="openCreateDiscussionModal" class="btn btn-tool">
                        <i class="far fa fa-plus mr-2"></i> <span class="text-primary">Add Discussion</span>
                    </button>
                </div>
            </div>
            <div class="card-container">
                <div v-if="isLoadingDiscussions">Loading Meeting Discussions...</div>
                <div v-else>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title">Discussions</h3>
                                </div>
                                <div class="card-body">
                                    <!-- <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control rounded-end" 
                                               placeholder="Search discussions" 
                                               aria-label="Search discussions">
                                    </div> -->
                                    <!-- <div class="flex gap-x-2">
                                        <div class="dropdown">
                                            <button  class="nav-link dropdown-toggle
                                                            btn-sm btn btn-secondary 
                                                            btn-block p-1" 
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
                                            <button  class="nav-link dropdown-toggle 
                                                            btn-sm btn btn-secondary 
                                                            btn-block p-1" 
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
                                    </div> -->
                                    <div class="dropdown-divider"></div>
                                    <div class="card-body p-0" style="height: 500px; overflow-y: auto;">
                                        <div v-for="discussion in Discussions" :key="discussion.id" 
                                             class="card mb-2 border border-primary hover:cursor-pointer">
                                            <div class="card-body d-flex align-items-center" >
                                                <i class="fas fa-user-circle fa-2x me-3"></i>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ discussion.topic }}</h6>
                                                    <small class="text-muted">{{ discussion.author.full_name }}</small>
                                                    <p v-html="discussion.description" class="mb-0"></p>
                                                </div>
                                                <a href="#" @click.prevent="handleSelectedDiscussion(discussion)"
                                                   class="btn btn-sm btn-outline-secondary m-1">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="#" @click.prevent="openEditDiscussionModal(discussion)"
                                                   class="btn btn-sm btn-outline-secondary m-1">
                                                    <i class="fa fa-edit" ></i>
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
                                    <div class="ml-auto flex self-end" v-if="discussion">
                                        <a class="nav-link " href="#" id="navbarDropdown"
                                           role="button" 
                                           data-toggle="dropdown" 
                                           aria-haspopup="true" 
                                           aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a v-for="option in filterdiscussionOptions" :key="option.id"
                                               class="dropdown-item" href="#" 
                                               @click.prevent="handleDiscussionOption(option.name, discussion)">
                                                <i :class="option.icon"></i> {{ option.name }}
                                            </a>
                                        </div>
                                        <button class="btn btn-sm  text-white mr-2" 
                                                @click.prevent="openMemberModal(discussion)">
                                            <i class="fas fa-users "></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Discussion
                                Chats -->
                                <div v-if="discussion">
                                    <div class="card-header">
                                        <h5>{{discussion.topic}}</h5>
                                        <span class="badge bg-secondary">Board</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="flex-1 mb-8">
                                            <div class="bg-gray-200 text-gray-700 rounded-lg px-4 pt-1 pb-1">
                                                <div class="text-xs font-medium 
                                                subpixel-antialiased mb-2 text-gray-900">
                                                    <a href="#" class="text-gray-800" 
                                                       data-bs-original-title="" title="">
                                                        {{ discussion.author.full_name }}
                                                    </a>
                                                    created this discussion on {{formatDate(discussion.created_at)}}
                                                </div>
                                                <div>
                                                    <p v-html="discussion.description" class="mb-0"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="direct-chat-messages">
                                            <div v-for="(chat, chatIndex) in Chats" :key="chat.id">
                                                <div class="flex gap-2 items-start mb-4">
                                                    <div class="font-medium flex-1" 
                                                         v-if="editingChatIndex === chatIndex 
                                                             && action === 'edit chat'">
                                                        <form novalidate 
                                                              @submit.prevent="onSubmitChat(discussion)">
                                                            <div class="flex gap-x-2">
                                                                <FormQuillEditor
                                                                    label="Chat Description"
                                                                    name="message"
                                                                    theme="snow"
                                                                    placeholder="Enter Message Content"
                                                                    toolbar="minimal"
                                                                    contentType="html" 
                                                                    class="w-full"
                                                                />
                                                                <button type="submit" 
                                                                        class="btn btn-primary h-10 mt-12">
                                                                    Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div v-else class="font-medium flex-1">
                                                        <div class="direct-chat-msg" 
                                                             v-if="chat.sender.id !== currentUser">
                                                            <div class="direct-chat-infos clearfix">
                                                                <span class="direct-chat-name float-left">
                                                                    {{ chat.sender.full_name }}
                                                                </span>
                                                                <span class="direct-chat-timestamp float-right">
                                                                    {{ formatDate(chat.created_at)}}
                                                                </span>
                                                            </div>
                                                            <div class="direct-chat-infos clearfix"  
                                                                 v-if="chat.editstatus === 'edited'">
                                                                <span class="direct-chat-timestamp float-right">
                                                                    {{ chat.editstatus}}
                                                                </span>
                                                            </div>
                                                            <img :src="loadAvatar(chat.sender.profile?.avatar)" 
                                                                 class="direct-chat-img float-left mr-1"
                                                                 alt="User Image">
                                                            <div v-html="chat.message" class="direct-chat-text"></div>
                                                        </div>
                                                        <div v-else class="direct-chat-msg right" >
                                                            <div class="direct-chat-infos clearfix">
                                                                <span class="direct-chat-name float-right">
                                                                    {{ chat.sender.full_name }}
                                                                </span>
                                                                <span class="direct-chat-timestamp float-left">
                                                                    {{ formatDate(chat.created_at)}}
                                                                    <span 
                                                                        @click="enableEditing(
                                                                            chatIndex,
                                                                            chat,
                                                                        )">
                                                                        <i class="fa fa-edit" ></i>
                                                                    </span>
                                                                </span>
                                                            </div>                                                    
                                                            <div class="direct-chat-infos clearfix" 
                                                                 v-if="chat.editstatus === 'edited'">
                                                                <span class="direct-chat-timestamp float-left">
                                                                    {{ chat.editstatus}}
                                                                </span>
                                                            </div>                                                    
                                                            <img :src="loadAvatar(chat.sender.profile?.avatar)" 
                                                                 class="direct-chat-img float-right ml-1"
                                                                 alt="User Image">
                                                            <div @click="enableEditing(
                                                                     chatIndex,
                                                                     chat,
                                                                 )" 
                                                                 v-html="chat.message" 
                                                                 class="direct-chat-text bg-white"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="font-medium flex-1" 
                                                 v-if="isAddingNewChat && action === 'create chat'">
                                                <form novalidate 
                                                      @submit.prevent="onSubmitChat(discussion)">
                                                    <div class="flex gap-x-2">
                                                        <FormQuillEditor
                                                            label="Chat Description"
                                                            name="message"
                                                            theme="snow"
                                                            placeholder="Enter Message Content"
                                                            toolbar="minimal"
                                                            contentType="html" 
                                                            class="w-full"
                                                        />
                                                        <button type="submit" 
                                                                class="btn btn-primary h-10 mt-12">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- <button v-if="authStore.hasPermission(['create agenda'])" -->
                                            <div class="mt-2" v-if="!isAddingNewChat && action !== 'create chat'">
                                                <button 
                                                    @click="enableAddingNewChat" 
                                                    class="btn btn-secondary block w-full mt-4">
                                                    Add Chat
                                                </button>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="card-body">
                                        Kindly select any Discussion Topic To view the Chat
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <dialog id="discussionmodal" class="modal" ref="DiscussionModal">
                            <form method="dialog" class="modal-box rounded-xl">
                                <h3 class="font-bold text-lg justify-center flex">
                                    {{ action == 'create' ? 
                                        'Create Discussion' : 'Edit Discussion' }} {{ action }}</h3>
                                      
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                <div class="overflow-auto p-4" style="max-height: 100vh;">
                                    <div class="grid grid-cols-3 md:grid-cols-3 gap-2 p-2">
                                        <div class="col-span-3">
                                            <form novalidate @submit.prevent="onSubmit" class="">
                                                <div v-if="hide">
                                                    <div class="flex flex-wrap -mx-2 mt-2">
                                                        <div class="w-full px-1 md:px-2">
                                                            <FormInput
                                                                :labeled="true"
                                                                label="Discussion Topic"
                                                                name="topic"
                                                                placeholder="Enter Discussion Topic"
                                                                type="text"
                                                            />
                                                        </div>
                                                    </div>
                                                    <FormQuillEditor
                                                        label="Discussion Description"
                                                        name="description"
                                                        theme="snow"
                                                        placeholder="Enter Discussion Description"
                                                        toolbar="full"
                                                        contentType="html"
                                                        class="col-span-3"
                                                    />
                                                </div>                                                
                                                <div v-else>
                                                    <div class="flex flex-wrap -mx-2 mt-2">
                                                        <div class="w-full px-1 md:px-2">
                                                            <FormInput
                                                                :labeled="true"
                                                                label="Discussion Topic"
                                                                name="topic"
                                                                placeholder="Enter Discussion Topic"
                                                                type="text"
                                                            />
                                                        </div>
                                                    </div>
                                                    <FormQuillEditor
                                                        label="Discussion Description"
                                                        name="description"
                                                        theme="snow"
                                                        placeholder="Enter Discussion Description"
                                                        toolbar="full"
                                                        contentType="html"
                                                        class="col-span-3"
                                                    />
                                                </div>                                                
                                                <div class="flex flex-wrap -mx-2 mt-2">
                                                    <div class="w-full md:w-1/3 px-1 md:px-2">
                                                        <div v-if="selectedBoards.length" >
                                                            <h3 class="font-bold">Selected Boards</h3>
                                                            <ul> 
                                                                <li v-for="(board, idx) in selectedBoards" 
                                                                    :key="board.id">
                                                                    {{ idx+1 }}. {{ board.name }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="w-full md:w-1/3 px-1 md:px-2">
                                                        <div v-if="selectedCommittees.length">
                                                            <h3 class="font-bold">Selected Committees</h3>
                                                            <ul>
                                                                <li v-for="(committee, idx) in selectedCommittees" 
                                                                    :key="committee.id">
                                                                    {{ idx+1 }}. {{ committee.name }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="w-full md:w-1/3 px-1 md:px-2">
                                                        <div v-if="selectedUsers.length">
                                                            <h3 class="font-bold">Selected Users</h3>
                                                            <ul>
                                                                <li v-for="(user, idx) in selectedUsers" 
                                                                    :key="user.id">
                                                                    {{ idx+1 }}. {{ user.name }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="form-group col-span-3" >
                                                    <label class="text-bold font-medium tracking-wide">
                                                        Group Members to the Discucssion
                                                    </label>
                                                    <div :class="[
                                                        'multiselect-container', 
                                                        { error: !!discussionassigneeserrorMessage }]">
                                                        <Multiselect
                                                            id="discussionassignees"
                                                            v-model="selectedGroupMembers"
                                                            mode="tags"
                                                            required
                                                            placeholder="Choose your stack"
                                                            :close-on-select="false"
                                                            :filter-results="false"
                                                            :min-chars="1"
                                                            :resolve-on-load="false"
                                                            :delay="0"
                                                            :searchable="true"
                                                            :options="processedGroups"
                                                            :groups="true"
                                                            :valueProp="'id'"
                                                            :trackBy="'id'"
                                                            :label="'name'"
                                                            class="multiselect-container multiselect-wrapper"
                                                            :object="true"
                                                            :class="[
                                                                'multiselect-container ', 
                                                                { error: !!discussionassigneeserrorMessage }]"
                                                            @select="selectedGroupMember()"
                                                            @deselect="removeselectedGroupMembers()"
                                                        />
                                                        <div v-if="discussionassigneeserrorMessage" 
                                                             class="message">{{ discussionassigneeserrorMessage }}</div>
                                                    </div>
                                                </div>
                                                <div v-if="selectedGroupMembers && selectedGroupMembers.length">
                                                    <button type="submit" class="btn btn-primary 
                                                        btn-md w-full mt-6">{{ action == 'create' ? 
                                                        'Create Discussion' : 'Edit Discussion' }}
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
            </div>
        </div>
    </div>
    <div v-else>
        <p class="m-0">
            <span class="h3 text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div>
    

</template>
  
  <style scoped>
  .card-header .card-title {
    color: white;
  }
  .input-group .form-control.rounded-end {
    border-radius: 0 0.375rem 0.375rem 0;
  }
  .multiselect-container .multiselect-tags {
    display: flex;
    flex-wrap: wrap;
}

.multiselect-container .multiselect-tag {
    margin: 0.25em;
}
.multiselect-container .multiselect-wrapper {
    width:1197px!important;
}

  </style>
  
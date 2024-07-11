<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {Task} from 'vitest';
import {computed, onMounted,ref} from 'vue';
import {useRoute} from 'vue-router';
import {ValidationError} from 'yup';
import * as yup from 'yup';
import {useCreateDiscussionRequest, useGetDiscussionsRequest,useUpdateDiscussionRequest} from '@/common/api/requests/modules/meeting/useDiscussionRequest';
import {
    useCreateMeetingTaskRequest, 
    useGetMeetingTasksRequest,
    useUpdateMeetingTaskRequest,
} from '@/common/api/requests/modules/task/useTaskRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {DiscussionAssignee} from '@/common/parsers/DiscussionAssigneeParser';
import {Discussion, DiscussionRequestPayload} from '@/common/parsers/discussionParser';
import {TaskAssignee} from '@/common/parsers/TaskAssigneeParser';
import {TaskRequestPayload} from '@/common/parsers/TaskParser';
import useAuthStore from '@/common/stores/auth.store';
import { useGetUserDiscussionsRequest } from '@/common/api/requests/modules/discussion/useDiscussionRequest';



const authStore = useAuthStore();
authStore.initialize(); 
const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const userId = authStore.user?.id as string;
const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const discussionId = ref<string | null>(null);
const selectedAssigneeIds = ref<DiscussionAssignee[]>([]);
const selectedDiscussion = ref<Discussion | null>(null);
const DiscussionModal = ref<HTMLDialogElement | null>(null);
const assigneestatus = ref('individuals');
const selectedAssigneeType = ref('');
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
    meeting_id: yup.string().nullable(),
    board_id: yup.string().nullable(),
    committee_id: yup.string().nullable(),
    topic: yup.string().required(),
    description: yup.string().required(),
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
    meeting_id: string | null;
    board_id: string | null;
    committee_id: string | null;
    topic: string;
    description: string;
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
        meeting_id: meetingId,
        board_id: boardId,
        committee_id: null,
        topic: '',
        description: '',
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

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        const payload: DiscussionRequestPayload = {
            meeting_id: values.meeting_id,
            board_id: values.board_id,
            committee_id: values.committee_id,
            topic: values.topic,
            description: values.description,
            assigneetype: values.assigneetype,
            assigneestatus: values.assigneestatus,
            discussionassignees: values.discussionassignees,
        };
        if (action.value === 'create') {
            await useCreateDiscussionRequest(payload, meetingId, boardId);
        } else {
            const discussion_id = discussionId.value as string;
            await useUpdateDiscussionRequest(payload, meetingId, boardId, discussion_id);
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
    setFieldValue('meeting_id', meetingId);
    setFieldValue('board_id', boardId);
    setFieldValue('committee_id', null);
    setFieldValue('topic', '');
    setFieldValue('description', 'description ................');
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

const assigneeTypes = [
    {name: 'Individuals', value: 'individuals'},
    {name: 'Assign All Meeting Members', value: 'all_members'},
];

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

onMounted(async () => {
    authStore.initialize();
    fetchDiscussions();
});


</script>

<style scoped>
</style>
<template>
    <div class="row">
        <div class="col-md-4">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user-2 shadow-sm">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-warning">
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="" alt="User Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">Nadia Carmichael</h3>
                    <h5 class="widget-user-desc">Lead Developer</h5>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Projects <span class="float-right badge bg-primary">31</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Tasks <span class="float-right badge bg-info">5</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Completed Projects <span class="float-right badge bg-success">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Followers <span class="float-right badge bg-danger">842</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <div class="col-md-8">
            <!-- DIRECT CHAT SUCCESS -->
            <div class="card card-success card-outline direct-chat direct-chat-success shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Shadow - Small</h3>

                    <div class="card-tools">
                        <span title="3 New Messages" class="badge bg-success">3</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                            <i class="fas fa-comments"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                        <!-- Message. Default to the left -->
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="" alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                Is this template really for free? That's unbelievable!
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->

                        <!-- Message to the right -->
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="" alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                You better believe it!
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->
                    </div>
                    <!--/.direct-chat-messages-->

                    <!-- Contacts are loaded here -->
                    <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="" alt="User Avatar">

                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Count Dracula
                                            <small class="contacts-list-date float-right">2/28/2015</small>
                                        </span>
                                        <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                            <!-- End Contact Item -->
                        </ul>
                        <!-- /.contatcts-list -->
                    </div>
                    <!-- /.direct-chat-pane -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-success">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
                <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
        </div>
    </div>
</template>


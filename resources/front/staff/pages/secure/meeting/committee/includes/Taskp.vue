<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import Multiselect from '@vueform/multiselect';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {useCreateMeetingTaskRequest, useGetMeetingTasksRequest, useUpdateMeetingTaskRequest} from '@/common/api/requests/modules/task/useTaskRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormQuillEditor from '@/common/components/FormQuillEditor.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {formattedDateTime} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {TaskAssignee} from '@/common/parsers/TaskAssigneeParser';
import {Task, TaskRequestPayload} from '@/common/parsers/TaskParser';
import useAuthStore from '@/common/stores/auth.store';
import { useGetMembershipsRequest } from '@/common/api/requests/modules/membership/useMembershipRequest';
import { Membership } from '@/common/parsers/membershipParser';

const authStore = useAuthStore();
const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const committeeId = route.params.committeeId as string;
const meetingId = route.params.meetingId as string;
const taskId = ref<string | null>(null);
const selectedMembershipIds = ref<TaskAssignee[]>([]);
const selectedTask = ref<Task | null>(null);
const TaskModal = ref<HTMLDialogElement | null>(null);
const assigneestatus = ref('individuals');
const selectedAssigneeType = ref('');
const handleUnexpectedError = useUnexpectedErrorHandler();

const {errorMessage: duedateerrorMessage} = useField('duedate');
const {errorMessage: taskassigneeserrorMessage} = useField('taskassignees');

const hasDueDatePassed = (duedate: string): boolean => {
    const now = new Date();
    const dueDate = new Date(duedate);
    return now > dueDate;
};

const userSchema = yup.object({
    id: yup.string().nullable(),
    full_name: yup.string().nullable(),
});

const taskassigneesSchema = yup.object({
    id: yup.string().nullable(),
    task_id: yup.string().nullable(),
    membership_id: yup.string().nullable(),
    user: userSchema,
});

const taskschema = yup.object({
    meeting_id: yup.string().nullable(),
    committee_id: yup.string().nullable(),
    title: yup.string().required(),
    duedate: yup.string().required(),
    description: yup.string().required(),
    status: yup.string().required(),
    assigneetype: yup.string().required(),
    assigneestatus: yup.string().required(),
    taskassignees: yup.array().of(taskassigneesSchema).nullable(),
});

const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    meeting_id: string | null;
    committee_id: string | null;
    title: string;
    duedate: string;
    description: string;
    status: string;
    assigneetype: string;
    assigneestatus: string;
    taskassignees: {
        id: string;
        task_id: string | null;
        membership_id: string;
        user: {
            id: string;
            full_name: string;
        };
    }[] | [];
}>({
    validationSchema: taskschema,
    initialValues: {
        meeting_id: meetingId,
        committee_id: committeeId,
        title: '',
        duedate: '',
        description: '',
        status: 'pending',
        assigneetype: '',
        assigneestatus: '',
        taskassignees: [],
    },
});

const openCreateTaskModal = () => {
    reset();
    action.value = 'create';
    showCreate.value = true;
    TaskModal.value?.showModal();
};

const openEditTaskModal = (task: Task) => {
    reset();
    selectedTask.value = task;
    taskId.value = task.id;
    setFieldValue('title', task.title);
    setFieldValue('duedate', task.duedate);
    setFieldValue('description', task.description);
    setFieldValue('status', task.status);
    setFieldValue('assigneetype', task.assigneetype);
    setFieldValue('assigneestatus', task.assigneestatus);
    assigneestatus.value = task.assigneestatus;
    maptaskassigneesToReactiveRef(task.taskassignees);
    action.value = 'edit';
    showCreate.value = true;
    TaskModal.value?.showModal();
};

function maptaskassigneesToReactiveRef(taskassignees: TaskAssignee[]) {
    selectedMembershipIds.value = taskassignees.map(taskassignee => ({
        id: taskassignee.id,
        full_name: taskassignee.user.full_name,
        task_id: taskassignee.task_id,
        membership_id: taskassignee.membership_id,
        user: taskassignee.user,
    }));
    setFieldValue('taskassignees', selectedMembershipIds.value);
}

const selectedMembers = () => {
    setFieldValue('taskassignees', selectedMembershipIds.value);
};

const removeselectedUsers = () => {
    setFieldValue('taskassignees', selectedMembershipIds.value);
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        const payload: TaskRequestPayload = {
            meeting_id: values.meeting_id,
            committee_id: values.committee_id,
            title: values.title,
            duedate: values.duedate,
            description: values.description,
            status: values.status,
            assigneetype: values.assigneetype,
            assigneestatus: values.assigneestatus,
            taskassignees: values.taskassignees,
        };
        if (action.value === 'create') {
            await useCreateMeetingTaskRequest(payload, meetingId);
        } else {
            const task_id = taskId.value as string;
            await useUpdateMeetingTaskRequest(payload, meetingId, task_id);
        }
        TaskModal.value?.close();
        await fetchMeetingTasks();
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
    taskId.value = null;
    assigneestatus.value = 'all_members';
    selectedMembershipIds.value = [];
    setFieldValue('meeting_id', meetingId);
    setFieldValue('committee_id', committeeId);
    setFieldValue('title', '');
    setFieldValue('duedate', '');
    setFieldValue('description', 'description ................');
    setFieldValue('status', 'pending');
    setFieldValue('assigneetype', 'all_members');
    setFieldValue('assigneestatus', 'all_members');
    setFieldValue('taskassignees', []);
};

const handleAssigneeTypeChange = (selectedAssignee: string) => {
    selectedMembershipIds.value = [];
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
const getMeetingTasks = () => {
    return useQuery({
        queryKey: ['getMeetingTasksKey', meetingId],
        queryFn: async () => {
            const response = await useGetMeetingTasksRequest(meetingId, {paginate: 'false'});
            return response.data;
        },
    });
};

const {isLoading: isLoadingMeetingTasks, data: Tasks, refetch: fetchMeetingTasks} = getMeetingTasks();

onMounted(async () => {
    fetchMeetingTasks();
    fetchMemberships();
});
</script>

<template>
    <div v-if="authStore.hasPermission(['view task'])">
        <div class="card h-full">
            <div class="card-header flex items-center">
                <div class="flex items-center flex-1 w-full">
                    <h2 class="card-header-title h3">Meeting Tasks</h2>
                </div>
                <div class="flex items-center space-x-2" v-if="authStore.hasPermission(['create task'])">
                    <button type="button" @click.prevent="openCreateTaskModal" class="btn btn-tool">
                        <i class="far fa fa-plus mr-2"></i> <span class="sr-only">Add task</span>
                    </button>
                </div>
            </div>
            <div class="card-container">
                <div v-if="isLoadingMeetingTasks">Loading Meeting Tasks...</div>
                <div v-else>
                    <div class="row overflow-auto p-4" style="max-height: 100vh;">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2" v-for="(task, idx) in Tasks" :key="idx">
                            <div class="card card-outline card-primary h-100">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <button v-if="authStore.hasPermission(['edit task'])" 
                                                class="btn btn-tool" 
                                                @click.prevent="openEditTaskModal(task)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-primary text-bold uppercase">{{task.title}}</div>
                                    <div class="d-flex justify-content-between">
                                        <div>                                                
                                            <strong>Due Date:</strong>
                                            <p :class="{
                                                'text-danger': hasDueDatePassed(task.duedate) && task.status !== 'completed',
                                                'text-success': !hasDueDatePassed(task.duedate) || task.status === 'completed'
                                            }">{{ formattedDateTime(task.duedate) }}</p>
                                        </div>
                                        <div>
                                            <strong>Status:</strong>
                                            <p>
                                                <span v-if="task.status === 'backlog'" class="badge bg-warning">Backlog</span>
                                                <span v-else-if="task.status === 'pending'" class="badge bg-info">Pending</span>
                                                <span v-else-if="task.status === 'onprogress'" class="badge bg-primary">On Progress</span>
                                                <span v-else-if="task.status === 'completed'" class="badge bg-success">Completed</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <strong>Assignees:</strong>
                                        <div class="row">
                                            <div class="col-6">
                                                <ul class="list-unstyled">
                                                    <li v-for="(assignees, idx) in task.taskassignees.slice(0, Math.ceil(task.taskassignees.length / 2))" :key="assignees.id">
                                                        {{ idx + 1 }}. {{ assignees.user.full_name }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-6">
                                                <ul class="list-unstyled">
                                                    <li v-for="(assignees, idx) in task.taskassignees.slice(Math.ceil(task.taskassignees.length / 2))" :key="assignees.id">
                                                        {{ idx + 1 + Math.ceil(task.taskassignees.length / 2) }}. {{ assignees.user.full_name }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <strong>Description:</strong>
                                        <p v-html="task.description" class="mt-2"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center col-md-6">
            <dialog id="taskmodal" class="modal" ref="TaskModal">
                <form method="dialog" class="modal-box rounded-xl">
                    <h3 class="font-bold text-lg justify-center flex">{{ action == 'create' ? 'Create Meeting Task' : 'Edit Meeting Task' }}</h3>
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    <div class="overflow-auto p-4" style="max-height: 80vh;">
                        <div class="grid grid-cols-3 md:grid-cols-3 gap-2 p-2">
                            <div class="col-span-3">
                                <form novalidate @submit.prevent="onSubmit" class="">
                                    <div class="flex flex-wrap -mx-2 mt-2">
                                        <div class="w-full md:w-1/2 px-1 md:px-2">
                                            <FormInput
                                                :labeled="true"
                                                label="Task Title"
                                                name="title"
                                                placeholder="Enter Task Title"
                                                type="text"
                                            />
                                        </div>
                                        <div class="w-full md:w-1/2 px-1 md:px-2">
                                            <FormDateTimeInput
                                                label="Task Due Date"
                                                name="duedate"
                                                :flow="['month']"
                                                placeholder="Task Due Date"
                                            />
                                        </div>
                                    </div>
                                    <FormQuillEditor
                                        label="Task Description"
                                        name="description"
                                        theme="snow"
                                        placeholder="Enter Task Description"
                                        toolbar="full"
                                        contentType="html"
                                        class="col-span-3"
                                    />
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
                                                <h2 class="font-bold text-primary text-sm text-center">All Members Will be assigned this Task</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-span-3" v-if="assigneestatus === 'individuals'">
                                        <label class="text-bold font-medium tracking-wide">People to Assign</label>
                                        <div :class="['multiselect-container', { error: !!taskassigneeserrorMessage }]">
                                            <Multiselect
                                                id="taskassignees"
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
                                                :class="['multiselect-container', { error: !!taskassigneeserrorMessage }]"
                                                @select="selectedMembers()"
                                                @deselect="removeselectedUsers()"
                                            />
                                            <div v-if="taskassigneeserrorMessage" class="message">{{ taskassigneeserrorMessage }}</div>
                                        </div>
                                    </div>
                                    <div v-if="selectedMembershipIds && selectedMembershipIds.length || assigneestatus === 'all_members'">
                                        <button type="submit" class="btn btn-primary btn-md w-full mt-6">{{ action == 'create' ? 'Create Task' : 'Edit Task' }}</button>
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
            <span class="h3 text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div>
</template>

<style scoped>
.danger-color {
  color: #ff0000;
}

.ok-color {
  color: #008000;
}

.bg-primary {
  background-color: #007bff !important;
}

.bg-warning {
  background-color: #ffc107 !important;
}

.bg-info {
  background-color: #17a2b8 !important;
}

.bg-success {
  background-color: #28a745 !important;
}

.text-danger {
  color: #dc3545;
}

.text-success {
  color: #28a745;
}

.text-primary {
  color: #007bff;
}

.card-title {
  margin: 0;
}
</style>



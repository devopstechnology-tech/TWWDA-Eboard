<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetMembershipsRequest} from '@/common/api/requests/modules/membership/useMembershipRequest';
import {useCreateMeetingTaskRequest, useGetMeetingTasksRequest, useUpdateMeetingTaskRequest} from '@/common/api/requests/modules/task/useTaskRequest';
import FormDateInput from '@/common/components/FormDateInput.vue';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formattedDateTime} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Membership, SelectedResult} from '@/common/parsers/membershipParser';
import {TaskAssignee} from '@/common/parsers/TaskAssigneeParser';
import {Task, TaskRequestPayload} from '@/common/parsers/TaskParser';
import Multiselect from '@@/@vueform/multiselect';

const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const boardId = route.params.boardId as string;
const meetingId = route.params.meetingId as string;
const taskId = ref<string | null>(null);
const selectedMembershipIds = ref<TaskAssignee[]>([]);
const selectedTask = ref<Task | null>(null);
const TaskModal = ref<HTMLDialogElement | null>(null);
const assigneestatus = ref('individuals');
const selectedAssigneeType = ref('');
const handleUnexpectedError = useUnexpectedErrorHandler();

const {errorMessage:duedateerrorMessage} = useField('duedate');
const {errorMessage:taskassigneeserrorMessage} = useField('taskassignees');

const hasDueDatePassed = (duedate: string): boolean => {
    const now = new Date();
    const dueDate = new Date(duedate);
    return now > dueDate;
};

const userSchema = yup.object({
    id: yup.string().required(),
    full_name: yup.string().required(),
});
const taskassigneesSchema = yup.object({
    id: yup.string().required(),
    task_id: yup.string().nullable(),
    membership_id: yup.string().required(),
    user: userSchema,
});
const taskschema = yup.object({
    meeting_id: yup.string().nullable(),
    board_id: yup.string().nullable(),
    committee_id: yup.string().nullable(),
    title: yup.string().required(),
    duedate: yup.string().required(),
    description: yup.string().required(),
    status: yup.string().required(),    
    assigneetype:yup.string().required(),
    assigneestatus:yup.string().required(),
    taskassignees: yup.array().of(taskassigneesSchema).nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    meeting_id:string| null;
    board_id:string| null;
    committee_id:string| null;
    title:string;
    duedate:string;
    description:string;
    status:string;
    assigneetype:string;
    assigneestatus:string;
    taskassignees:{
        id:string;
        poll_id:string | null;
        membership_id:string;
        user:{
            id:string;
            full_name:string;
        };
    }[] | [];

}>({
    validationSchema: taskschema,
    initialValues: {
        meeting_id:meetingId,
        board_id:boardId,
        committee_id:null,
        title: '',
        duedate: '',
        description: '',
        status: 'pending',  
        assigneetype:'',
        assigneestatus:'',      
        taskassignees: [],
    },
});

const openCreateTaskModal = () => {
    reset();
    // fetchMemberships();
    action.value = 'create';
    showCreate.value = true;
    TaskModal.value?.showModal();
};
const openEditTaskModal = (task:Task) => {
    reset();
    // fetchMemberships();
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
    // schedules
    action.value = 'edit';
    showCreate.value = true;
    TaskModal.value?.showModal();
};
function maptaskassigneesToReactiveRef(taskassignees: TaskAssignee[]) {
    selectedMembershipIds.value = taskassignees.map(taskassignee => ({
        id: taskassignee.id,// Default value as empty string
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
            board_id: values.board_id,
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
            await useCreateMeetingTaskRequest(payload, meetingId, boardId);
        } else {
            const task_id = taskId.value as string;
            await useUpdateMeetingTaskRequest(payload, meetingId, boardId, task_id);
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
    taskId.value =null;
    assigneestatus.value = 'all_members';
    selectedMembershipIds.value = [];
    setFieldValue('meeting_id', meetingId);
    setFieldValue('board_id', boardId);
    setFieldValue('committee_id', null);
    setFieldValue('title', '');
    setFieldValue('duedate', '');
    setFieldValue('description', '');
    setFieldValue('status', 'pending');
    setFieldValue('assigneetype', 'all_members');
    setFieldValue('assigneestatus', 'all_members');
    setFieldValue('taskassignees',  []);
};
const handleAssigneeTypeChange = (selectedAssignee: string) => {
    selectedMembershipIds.value =[];
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
        queryKey: ['getTaskMembershipsKey'],
        queryFn: async () => {
            const response = await useGetMembershipsRequest(meetingId, boardId, {paginate: 'false'});
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
const {isLoading:isLoadingMeetingTasks, data: Tasks, refetch: fetchMeetingTasks} = getMeetingTasks();
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Meeting Tasks'}));
    fetchMemberships();
    fetchMeetingTasks();
});
</script>

<style scoped>
</style>
<template>
    <div class="card h-full">
        <div class="card-header flex items-center">
            <div class="flex items-center flex-1 w-full">
                <h2 class="card-header-title h3">
                    Meeting Tasks 
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" @click.prevent="openCreateTaskModal" class="btn btn-tool">
                    <i class="far fa fa-plus mr-2"></i> <span class="sr-only">Add task</span>
                </button>
            </div>
        </div>
        <div id="task-asignee-list">
            <table class="table table-striped card-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <button class="text-bold btn btn-link btn-sm list-sort asc" data-sort="task-title">
                                Task Title
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
                                    data-sort="assignment-members">Assignment Members
                            </button>
                        </th>
                        <th scope="col" class="text-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="list" v-if="isLoadingMeetingTasks">
                    <div>Loading MeetingTasks...</div>
                </tbody>
                <tbody class="list" v-else>
                    <tr v-for="(task, idx) in Tasks" :key="idx">
                        <td class="task-title" data-name="task.name"
                            style="max-width: 200px; word-wrap: break-word;">
                            <div class="font-weight-bold">{{ task.title }}</div>
                            <p style="white-space: normal;">{{ task.description }}</p>
                        </td>
                        <td
                            :class="{
                                'danger-color': hasDueDatePassed(task.duedate) && task.status !== 'completed',
                                'ok-color': !hasDueDatePassed(task.duedate) || task.status === 'completed'}">
                            {{ formattedDateTime(task.duedate) }}
                        </td>
                        <td>
                            <span v-if="task.status === 'backlog'"
                                  class="badge bg-warning">
                                Backlog
                            </span>
                            <span v-else-if="task.status === 'pending'"
                                  class="badge bg-info">
                                Pending
                            </span>
                            <span v-else-if="task.status === 'onprogress'"
                                  class="badge bg-primary">
                                On Progress
                            </span>
                            <span v-else-if="task.status === 'completed'"
                                  class="badge bg-success">
                                Completed
                            </span>
                        </td>
                        <td>
                            <ul class="list-none m-0 p-0">
                                <li v-for="(assignees, idx) in task.taskassignees" :key="assignees.id">
                                    {{ idx+1 }}. {{ assignees.user.full_name }}
                                </li>
                            </ul>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm"
                                    @click.prevent="openEditTaskModal(task)">
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-center col-md-6">
        <dialog id="taskmodal" class="modal" ref="TaskModal">
            <form method="dialog" class="modal-box rounded-xl">
                <h3 class="font-bold text-lg justify-center flex">
                    {{action == 'create' ? 'Create Meeting Task' : 'Edit Meeting Task'}}
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
                                <FormTextBox
                                    label="Task Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Task Description"
                                    :rows="2"
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
                                        { error: !!taskassigneeserrorMessage },
                                    ]">
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
                                            :class="[
                                                'multiselect-container',
                                                { error: !!taskassigneeserrorMessage },
                                            ]" 
                                            @select="selectedMembers()"
                                            @deselect="removeselectedUsers()" />
                                        <div v-if="taskassigneeserrorMessage" class="message"> 
                                            {{ taskassigneeserrorMessage }} 
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
</template>
<style lang="scss">
.danger-color {
    color: #ff0000; /* Or any color/style for "danger" */
}

.ok-color {
    color: #008000; /* Or any color/style for "OK" */
}
</style>


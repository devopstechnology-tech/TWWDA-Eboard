<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetMembershipsRequest} from '@/common/api/requests/modules/membership/useMembershipRequest';
import {useCreateMeetingTaskRequest, useGetTasksRequest, useUpdateMeetingTaskRequest, useUpdateTaskRequest} from '@/common/api/requests/modules/task/useTaskRequest';
import FormDateInput from '@/common/components/FormDateInput.vue';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import SimpleTable from '@/common/components/Tables/SimpleTable.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formattedDateTime} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Membership, SelectedResult} from '@/common/parsers/membershipParser';
import {Task, TaskRequestPayload} from '@/common/parsers/TaskParser';
import Multiselect from '@@/@vueform/multiselect';

const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const boardId = '1234' as string;
const meetingId = route.params.meetingId as string;
const taskId = ref<string | null>(null);
const selectedMembershipIds = ref<string[]>([]);
const allMemberships = ref<Membership[]>([]);
const selectedTask = ref<Task | null>(null);
const TaskModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();

const {errorMessage} = useField('taskassignees');

const hasDueDatePassed = (duedate: string): boolean => {
    const now = new Date();
    const dueDate = new Date(duedate);
    return now > dueDate;
};
//oneagnda
const taskschema = yup.object({
    title: yup.string().required(),
    duedate: yup.string().required(),
    description: yup.string().required(),
    status: yup.string().required(),
    meeting_id: yup.string().required(),
    task_id: yup.string().nullable(),
    taskassignees: yup.array().of(yup.string()).nullable(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    title: string;
    duedate: string;
    description: string,
    status: string,
    meeting_id: string,
    task_id: string|null,
    taskassignees: string[],

}>({
    validationSchema: taskschema,
    initialValues: {
        title: '',
        duedate: '',
        description: '',
        status: 'pending',
        meeting_id: '',
        task_id: null,
        taskassignees: [],
    },
});

const openCreateTaskModal = () => {
    action.value = 'create';
    showCreate.value = true;
    TaskModal.value?.showModal();
};
const openEditTaskModal = (task:Task) => {
    getmemberships(task.meeting_id);
    selectedTask.value = task;
    taskId.value = task.id;
    // Set field values here
    setFieldValue('title', task.title);
    setFieldValue('duedate', task.duedate);
    setFieldValue('description', task.description);
    setFieldValue('status', task.status);
    setFieldValue('meeting_id', task.meeting_id);
    if (task.taskassignees){
        const taskassigneeIds = task.taskassignees.map(taskassignee => taskassignee.id);
        selectedMembershipIds.value = taskassigneeIds;
        setFieldValue('taskassignees', taskassigneeIds);
    } else {
        setFieldValue('taskassignees', []);
    }
    // schedules
    action.value = 'edit';
    showCreate.value = true;
    TaskModal.value?.showModal();
};
const selectedUsers = () => {
    setFieldValue('taskassignees', selectedMembershipIds.value);
};
const removeselectedUsers = () => {
    setFieldValue('taskassignees', selectedMembershipIds.value);
};

const onSubmit = handleSubmit(async (values, {resetForm}) => {
    try {
        setFieldValue('taskassignees', selectedMembershipIds.value);
        const payload: TaskRequestPayload = {
            title: values.title,
            duedate: values.duedate,
            description: values.description,
            status: values.status,
            meeting_id: values.meeting_id,
            task_id: null,
            taskassignees: values.taskassignees,
        };
        if (action.value === 'create') {
            // await useCreateTaskRequest(payload, meetingId);
        } else {
            const task_id = taskId.value ? taskId.value.toString() : null;
            payload.task_id = task_id,
            await useUpdateTaskRequest(payload, payload.meeting_id);
        }
        await fetchTasks();
        reset();
        TaskModal.value?.close();
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
    selectedMembershipIds.value = [];
    setFieldValue('title', '');
    setFieldValue('duedate', '');
    setFieldValue('description', '');
    setFieldValue('taskassignees', []);
};

const Memberships = computed(() => {
    const resul:  SelectedResult[] = [];
    if (allMemberships.value && allMemberships.value?.length > 0) {
        allMemberships.value.reduce((accumulator, currentMember) => {
            accumulator.push({
                id: currentMember.id,
                name: `${currentMember.user.full_name}`,
            });
            return accumulator;
        }, resul);
    }
    return resul;
});
const getMemberships = async (meetingId:string) => {
    return useQuery({
        queryKey: ['getTasksKey'],
        queryFn: async () => {
            const response = await useGetMembershipsRequest(meetingId, boardId, {paginate: 'false'});
            console.log(response);
            return response.data;
        },
    });
};
const {isLoading:isLoadingMemberships, data:MembershipData, refetch: fetchMemberships} = getMemberships();


const getTasks = () => {
    return useQuery({
        queryKey: ['getTasksKey'],
        queryFn: async () => {
            const response = await useGetTasksRequest({paginate: 'false'});
            console.log(response);
            return response.data;
        },
    });
};
const {isLoading, data, refetch: fetchTasks} = getTasks();
onMounted(async () => {
    fetchTasks();
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'All Tasks'}));
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
            <!-- <div class="flex items-center space-x-2">
                <button type="button" @click.prevent="openCreateTaskModal" class="btn btn-tool">
                    <i class="far fa fa-plus mr-2"></i> <span class="sr-only">Add task</span>
                </button>
            </div> -->
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
                <tbody class="list">
                    <tr v-for="(task, idx) in data" :key="idx">
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
                            <!-- <button class="btn btn-danger btn-sm"
                                    @click.prevent="openEditTaskModal(task)">
                                Edit
                            </button> -->
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
                <div class="w-full mt-6 p-2">
                    <div class="font-thin text-sm flex flex-col items-center gap-6">
                        <form novalidate @submit.prevent="onSubmit"
                              class="w-full rounded-xl mx-auto p-1">
                            <div class="grid grid-cols-3 gap-2">
                                <FormInput
                                    :labeled="true"
                                    label="Task Title"
                                    name="title"
                                    class="col-span-2 w-full text-sm  text-white tracking-wide"
                                    placeholder="Enter Task Title"
                                    type="text"
                                />
                                <FormDateTimeInput
                                    label="Task Due Date"
                                    name="duedate"
                                    :flow="['day']"
                                    placeholder="Task Due Date"
                                />
                                <FormTextBox
                                    label="Task Description"
                                    name="description"
                                    class="col-span-3"
                                    placeholder="Enter Task Description"
                                    :rows="2"
                                />

                                <div class="form-group col-span-3">
                                    <label class="text-bold font-medium tracking-wide">
                                        People Responsible
                                    </label>
                                    <div :class="[
                                        'multiselect-container',
                                        { error: !!errorMessage },
                                    ]">
                                        <Multiselect
                                            id="taskassignees"
                                            v-model="selectedMembershipIds"
                                            mode="tags"
                                            placeholder="Choose your stack"
                                            :close-on-select="false"
                                            :filter-results="false"
                                            :min-chars="1"
                                            :resolve-on-load="false"
                                            :delay="0"
                                            :searchable="true"
                                            :options="Memberships"
                                            :valueProp="'id'"
                                            :trackBy="'id'"
                                            :label="'name'"
                                            class="col-span-3"
                                            :class="[
                                                'multiselect-container',
                                                { error: !!errorMessage },
                                            ]" @select="selectedUsers()" @deselect="removeselectedUsers()" />
                                        <div v-if="errorMessage" class="message"> {{ errorMessage }} </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
                                {{action == 'create' ? 'Create Meeting Task' : 'Edit Meeting Task'}}
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


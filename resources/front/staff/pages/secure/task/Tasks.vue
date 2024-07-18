<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useField, useForm} from 'vee-validate';
import {computed, nextTick, onMounted, ref} from 'vue';
import {useRoute} from 'vue-router';
import * as yup from 'yup';
import {
    useGetAssignedTasksRequest,
    useGetTasksRequest, useUpdateWorkTaskRequest, useWorkTaskRequest,
} from '@/common/api/requests/modules/task/useTaskRequest';
import FormRadioInput from '@/common/components/FormRadioInput.vue';
import LoadingComponent from '@/common/components/LoadingComponent.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {
    formattedDateTime} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {Task, TaskWorkRequestPayload} from '@/common/parsers/TaskParser';
import useAuthStore from '@/common/stores/auth.store';

const authStore = useAuthStore();
authStore.initialize(); 
const currentUserid = authStore.user.id;
const isCreatingTask = ref(false);
const route = useRoute();
const showCreate = ref(false);
const action = ref('create');
const taskId = ref<string | null>(null);
const UserAssignee = ref<string | null>(null);
const selectedTask = ref<Task | null>(null);
const TaskModal = ref<HTMLDialogElement | null>(null);
const handleUnexpectedError = useUnexpectedErrorHandler();

const {errorMessage} = useField('taskassignees');

const hasDueDatePassed = (duedate: string): boolean => {
    const now = new Date();
    const dueDate = new Date(duedate);
    return now > dueDate;
};
const taskschema = yup.object({    
    taskstatus_id: yup.string().nullable(),
    task_id: yup.string().required(),
    task_assignee_id: yup.string().required(),
    selectedOption: yup.string().required(),    
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    taskstatus_id:string|null;
    task_id:string;
    task_assignee_id:string;
    selectedOption:string;
}>({
    validationSchema: taskschema,
    initialValues: {
        taskstatus_id:null,
        task_id:'',
        task_assignee_id:'',
        selectedOption:'',
    },
});

const onSubmit = handleSubmit(async (values) => {
    try {
        // setFieldValue('taskassignees', selectedMembershipIds.value);
        const payload: TaskWorkRequestPayload = {
            taskstatus_id: values.taskstatus_id,
            task_id: values.task_id,
            task_assignee_id: values.task_assignee_id,
            selectedOption: values.selectedOption,
        };
        if(action.value === 'create' ){
            await useWorkTaskRequest(payload, payload.task_id);
        }else{
            await useUpdateWorkTaskRequest(payload, payload.taskstatus_id);
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
    selectedTask.value = null;
    taskId.value = null;
    setFieldValue('taskstatus_id',null);
    setFieldValue('task_id','');
    setFieldValue('task_assignee_id','');
    setFieldValue('selectedOption','');
};
// const viewTask = (task:Task) => {
//     const currentUserAssignee = task.taskassignees.find(assignee => assignee.user.id === currentUserid);
//     const currentUserTaskstatus = task.Taskstatuses.find(Taskstatus => Taskstatuse.assignee_task_id === currentUserAssignee.id);
//     const user = {
//         assignee_id:currentUserAssignee.id,
//         user_id:currentUserAssignee.user.id,
//         full_name:currentUserAssignee.user.full_name,
//     };
//     selectedTask.value = task;
//     UserAssignee.value = user;
//     setFieldValue('task_id', task.id);
//     setFieldValue('task_assignee_id', currentUserAssignee.id);
//     setFieldValue('selectedOption', currentUserAssignee.id);
//     action.value = 'create';
//     showCreate.value = true;
//     TaskModal.value?.showModal();
//     console.log(UserAssignee.value);
// };
const viewTask = async (task: Task) => {
    reset();
    const assignee = task.taskassignees.find(assignee => assignee.user.id === currentUserid);
    if (!assignee) {
        console.error('Current user is not an assignee of this task');
        return;
    }

    const user = {
        assignee_id: assignee.id,
        user_id: assignee.user.id,
        full_name: assignee.user.full_name,
    };

    selectedTask.value = task;
    // currentUserAssignee.value = assignee;
    // Find the taskstatus for the current assignee
    const currentUserTaskStatus = task.taskstatuses.find(status => status.assignee_task_id === assignee.id);
    console.log('currentUserTaskStatus', currentUserTaskStatus);
    // Check if we are creating a new task status or updating an existing one
    isCreatingTask.value = !currentUserTaskStatus;

    if (!isCreatingTask.value && currentUserTaskStatus) {
        action.value = 'edit';
        // If updating, set form values with the current status
        setFieldValue('taskstatus_id', currentUserTaskStatus.id);
        setFieldValue('task_id', currentUserTaskStatus.task_id);
        setFieldValue('task_assignee_id', currentUserTaskStatus.assignee_task_id);
        setFieldValue('selectedOption', currentUserTaskStatus.status);
        console.log('action.valueselectedOption', values.selectedOption);
    } else {
        // If creating new, set initial form values
        action.value = 'create';
        setFieldValue('task_id', task.id);
        setFieldValue('task_assignee_id', assignee.id);
        setFieldValue('selectedOption', ''); // Set a default or empty status
    }
    await nextTick(); // Wait for the DOM to update
    TaskModal.value?.showModal();
    console.log(values);
    console.log('action.value', action.value);
};
const task = computed(() => {    
    return selectedTask.value;
});
const Options = computed(() => { 
    const options = [
        {id: 'backlog', value: 'backlog'},
        {id: 'pending', value: 'pending'},
        {id: 'onprogress', value: 'onprogress'},
        {id: 'completed', value: 'completed'},
    ];   
    return options;
});

const getTasks = () => {
    return useQuery({
        queryKey: ['getOwnTasksKey'],
        queryFn: async () => {
            const response = await useGetAssignedTasksRequest({paginate: 'false'});
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
const calculateTaskStats = (task: Task) => {
    if (!task.taskstatuses || task.taskstatuses.length === 0) {
        return 'No task statuses yet';
    }

    const totalTaskStatuses = task.taskstatuses.length;
    const totalAssignees = task.taskassignees.length;

    if (totalTaskStatuses > totalAssignees) {
        console.error('Total task statuses exceed total assignees, which is unexpected.');
        return 'Task data error';
    }

    const statusCounts = task.taskstatuses.reduce((acc, taskStatus) => {
        acc[taskStatus.status] = (acc[taskStatus.status] || 0) + 1;
        return acc;
    }, {} as Record<string, number>);

    const completedCount = statusCounts['completed'] || 0;
    const remainingCount = totalAssignees - completedCount;

    const completionPercentage = ((completedCount / totalAssignees) * 100).toFixed(1);
    const remainingPercentage = ((remainingCount / totalAssignees) * 100).toFixed(1);

    const statusPercentages = Object.keys(statusCounts).map(status => {
        const count = statusCounts[status] || 0;
        const percentage = ((count / totalAssignees) * 100).toFixed(1);
        return `${percentage}% ${status}`;
    }).join('<br>');

    return `${statusPercentages}<br>Completed: ${completionPercentage}%<br>Remaining: ${remainingPercentage}%`;
};
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
                            <div v-html="task.description"></div>
                        </td>
                        <td
                            :class="{
                                'danger-color': hasDueDatePassed(task.duedate) && task.status !== 'completed',
                                'ok-color': !hasDueDatePassed(task.duedate) || task.status === 'completed'}">
                            {{ formattedDateTime(task.duedate) }}
                        </td>
                        <td v-html="calculateTaskStats(task)"></td>
                        <td>
                            <ul class="list-none m-0 p-0">
                                <li v-for="(assignees, idx) in task.taskassignees" :key="assignees.id">
                                    {{ idx+1 }}. {{ assignees.user.full_name }}
                                </li>
                            </ul>
                        </td>
                        <td class="text-center">
                            <button type="button" @click.prevent="viewTask(task)"
                                    title="" class="mx-2 btn btn-sm btn-primary">
                                <i class="far fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-center items-center min-h-screen">
        <dialog id="taskModal" class="modal w-full max-w-4xl mx-auto p-0" ref="TaskModal">
            <form method="dialog" class="modal-box rounded-xl relative bg-white shadow-xl">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" >✕</button>            
                <div class="overflow-auto p-4" style="max-height: 80vh;" v-if="task">  
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ action == 'create' ? 'Create Task Status' : 'Edit Task Status' }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">Due</dt>
                            <dd class="col-sm-9">{{ formattedDateTime(task.duedate) }}</dd>
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
                                <dd><p > {{task.title}}</p></dd>
                                <dd><p v-html="task.description"></p></dd>
                            </dl>
                        </div>
                        <div id="form">
                            <div class="alert alert-danger d-none" id="validation-message"></div>
                            <form novalidate @submit.prevent="onSubmit">
                                <div class="form-group">                                    
                                    <FormRadioInput
                                        label="Poll Options"
                                        name="selectedOption"
                                        :options="Options"
                                        :checked="Options[values.selectedOption]"
                                        :inline="true"
                                    />
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        {{ action == 'create' ? 'Create Task Status' : 'Edit Task Status' }}
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


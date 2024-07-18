<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {Task} from 'vitest';
import {computed,onMounted, ref} from 'vue';
import {useGetLatestAlmanacsRequest} from '@/common/api/requests/modules/almanac/useAlmanacRequest';
import {useGetBoardsRequest, useGetLatestBoardsRequest} from '@/common/api/requests/modules/board/useBoardRequest';
import {useGetLatestCommitteesRequest} from '@/common/api/requests/modules/committee/useCommitteeRequest';
import {useGetLatestMeetingsRequest} from '@/common/api/requests/modules/meeting/useMeetingRequest';
import {useGetLatestPollsRequest} from '@/common/api/requests/modules/poll/usePollRequest';
import {useGetLatestTasksRequest} from '@/common/api/requests/modules/task/useTaskRequest';
import {useGetLatestUsersRequest} from '@/common/api/requests/modules/user/useUserRequest';
import {
    AGENDAS,
    ALMANAC,
    BOARDS,
    CALENDAR,
    CHANGE_PASSWORD,
    DASHBOARD,
    DISCUSSIONS,
    FORGOT_PASSWORD,
    LOGIN,
    MEETINGS,
    NOTIFICATIONS,
    POLLS,
    REGISTER,
    SETTINGS,
    TASKS,
    USERS,
} from '@/common/constants/staffRouteNames';
import {
    formatDate,
    loadAvatar,
} from '@/common/customisation/Breadcrumb';
import useAuthStore from '@/common/stores/auth.store';
import Calendar from '@/staff/pages/secure/usinclude/calendar.vue';
// constants

const authStore = useAuthStore();
const taskCount = ref<string | null>(null);
const tasks = ref<Task[]>([]);
const boardCount = ref<string | null>(null);
const boards = ref<any[]>([]); // Change Task[] to any[] to match the expected Board type
const committeeCount = ref<string | null>(null);
const committees = ref<any[]>([]); // Change Task[] to any[] to match the expected Committee type
const meetingCount = ref<string | null>(null);
const meetings = ref<any[]>([]); // Change Task[] to any[] to match the expected Meeting type
const pollCount = ref<string | null>(null);
const polls = ref<any[]>([]); // Change Task[] to any[] to match the expected Poll type
const almanacCount = ref<string | null>(null);
const almanacs = ref<any[]>([]); // Change Task[] to any[] to match the expected Almanac type
const userCount = ref<string | null>(null);
const users = ref<any[]>([]); // Change Task[] to any[] to match the expected User type

const getBoards = () => {
    return useQuery({
        queryKey: ['getLatestBoardsKey'],
        queryFn: async () => {
            const response = await useGetLatestBoardsRequest({paginate: 'false'});
            boardCount.value = response.data.count;
            boards.value = response.data.boards;
            return response.data;
        },
    });
};
const {data:Boardss, refetch: fetchBoards} = getBoards();

const getCommittees = () => {
    return useQuery({
        queryKey: ['getLatestCommitteesKey'],
        queryFn: async () => {
            const response = await useGetLatestCommitteesRequest({paginate: 'false'});
            committeeCount.value = response.data.count;
            committees.value = response.data.committees;
            return response.data;
        },
    });
};
const {data:Committeess, refetch: fetchCommittees} = getCommittees();
const getMeetings = () => {
    return useQuery({
        queryKey: ['getLatestMeetingsKey'],
        queryFn: async () => {
            const response = await useGetLatestMeetingsRequest({paginate: 'false'});
            meetingCount.value = response.data.count;
            meetings.value = response.data.meetings;
            return response.data;
        },
    });
};
const {data:Meetingss, refetch: fetchMeetings} = getMeetings();

const getTasks = () => {
    return useQuery({
        queryKey: ['getLatestTasksKey'],
        queryFn: async () => {
            const response = await useGetLatestTasksRequest({paginate: 'false'});
            taskCount.value = response.data.count;
            tasks.value = response.data.tasks;
            return response.data;
        },
    });
};
const {data:Taskss, refetch: fetchTasks} = getTasks();

const getPolls = () => {
    return useQuery({
        queryKey: ['getLatestPollsKey'],
        queryFn: async () => {
            const response = await useGetLatestPollsRequest({paginate: 'false'});
            pollCount.value = response.data.count;
            polls.value = response.data.polls;
            return response.data;
        },
    });
};
const {data:Pollss, refetch: fetchPolls} = getPolls();

const getAlmanacs = () => {
    return useQuery({
        queryKey: ['getLatestAlmanacsKey'],
        queryFn: async () => {
            const response = await useGetLatestAlmanacsRequest({paginate: 'false'});
            almanacCount.value = response.data.count;
            almanacs.value = response.data.almanacs;
            return response.data;
        },
    });
};
const {data:Almanacss, refetch: fetchAlmanacs} = getAlmanacs();

const getUsers = () => {
    return useQuery({
        queryKey: ['getLatestUsersKey'],
        queryFn: async () => {
            const response = await useGetLatestUsersRequest({paginate: 'false'});
            userCount.value = response.data.count;
            users.value = response.data.users;
            return response.data;
        },
    });
};
const {data:Userss, refetch: fetchUsers} = getUsers();

const Boards = computed(() => {
    return boards.value;
});
const Tasks = computed(() => {
    return tasks.value;
});
const Committees = computed(() => {
    return committees.value;
});
const Meetings = computed(() => {
    return meetings.value;
});
const Polls = computed(() => {
    return polls.value;
});
const Almanacs = computed(() => {
    return almanacs.value;
});
const Users = computed(() => {
    return users.value;
});

onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Dashboard'}));
    await fetchBoards();
    await fetchCommittees();
    await fetchMeetings();
    await fetchTasks();
    await fetchPolls();
    await fetchAlmanacs();
    await fetchUsers();
});
</script>

<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ taskCount }}</h3>
                            <p>Tasks</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <router-link :to="{ 
                            name: TASKS
                        }" class="small-box-footer">
                            More info 
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ pollCount }}
                                <!-- <sup style="font-size: 20px">%</sup> -->
                            </h3>
                            <p>Polls</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <router-link :to="{ 
                            name: POLLS
                        }" class="small-box-footer">
                            More info 
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ almanacCount }}</h3>
                            <p>Almanacs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <router-link :to="{ 
                            name: ALMANAC
                        }" class="small-box-footer">
                            More info 
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ userCount }}</h3>
                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <router-link :to="{ 
                            name: USERS
                        }" class="small-box-footer">
                            More info 
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-6" 
                     v-if="authStore.hasPermission(['view board'])">                 
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Latest Boards</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Board Name</th>
                                            <th>Members Count</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="board in Boards" :key="board.id">
                                            <td>
                                                <h3 class="mb-2">
                                                    <router-link :to="{ 
                                                        name: 'BoardDetails', 
                                                        params: { boardId: board.id } 
                                                    }" class="text-primary">
                                                        {{ board.name }}
                                                    </router-link>
                                                </h3>
                                            </td>
                                            <td>
                                                {{ board.members.length }}
                                            </td>
                                            <td><router-link 
                                                v-if="authStore.hasPermission(['view board'])" 
                                                :to="{ 
                                                    name: 'BoardDetails', 
                                                    params: { 
                                                        boardId: board.id 
                                                    } 
                                                }" 
                                                class="text-green-500 hover:text-green-700 transition 
                                            duration-150 ease-in-out">
                                                <i class="fa fa-eye"></i>
                                            </router-link>
                                            </td>
                                        </tr>                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-if="Boards && Boards.length" class="card-footer clearfix">
                            <router-link :to="{ 
                                name: BOARDS
                            }" class="btn btn-sm btn-secondary float-right">
                                View All Boards
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-6"  
                     v-if="authStore.hasPermission(['view committee'])">                 
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Latest Committees</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Committee Name</th>
                                            <th>Members Count</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="committee in Committees" :key="committee.id">
                                            <td>
                                                <h3 class="mb-2">
                                                    <router-link :to="{ 
                                                        name: 'CommitteeDetails', 
                                                        params: { 
                                                            committeeId: committee.id, 
                                                            boardId: committee.committeeable?.id
                                                        }
                                                    }" class="text-primary">
                                                        {{ committee.name }}
                                                    </router-link>
                                                </h3>
                                            </td>
                                            <td>
                                                {{ committee.members.length }}
                                            </td>
                                            <td><router-link 
                                                v-if="authStore.hasPermission(['view committee'])" 
                                                :to="{ 
                                                    name: 'CommitteeDetails', 
                                                    params: { 
                                                        committeeId: committee.id,
                                                        boardId: committee.committeeable?.id
                                                    } 
                                                }" 
                                                class="text-green-500 hover:text-green-700 transition 
                                            duration-150 ease-in-out">
                                                <i class="fa fa-eye"></i>
                                            </router-link>
                                            </td>
                                        </tr>                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 col-6"  v-if="authStore.hasPermission(['view almanac'])">  
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Latest Almanacs</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Budget</th>
                                            <th>Held</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- {{ Almanacs }} -->
                                        <tr v-for="almanac in Almanacs" :key="almanac.id">
                                            <td>
                                                <h3 class="mb-2">
                                                    <router-link :to="{ 
                                                        name: ALMANAC
                                                    }" class="text-primary">
                                                        {{ almanac.type }}
                                                    </router-link>
                                                </h3>
                                            </td>
                                            <td>Kshs. {{ almanac.budget }}</td>
                                            <td>{{ almanac.held }}</td>
                                            
                                            <td>
                                                <router-link 
                                                    v-if="authStore.hasPermission(['view almanac'])" 
                                                    :to="{ 
                                                        name: ALMANAC
                                                    }" 
                                                    class="text-green-500 hover:text-green-700 transition 
                                                    duration-150 ease-in-out">
                                                    <i class="fa fa-eye"></i>
                                                </router-link>
                                            </td>
                                        </tr>                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-if="authStore.hasPermission(['view almanac']) && 
                            Almanacs && Almanacs.length" class="card-footer clearfix">
                            <router-link :to="{ 
                                name: ALMANAC
                            }" class="btn btn-sm btn-secondary float-right">
                                View All Almanacs
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6" >  
                    <Calendar/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Tasks</h3>
                        </div>
                        <div class="card-body p-0 m-1">
                            <div class="info-box mb-3 bg-primary" 
                                 v-for="task in Tasks" :key="task.id">
                                <span class="info-box-icon"><i class="far fa-comment"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{task.title}}</span>
                                    <span class="info-box-number" >Assingess: {{ task.taskassignees.length }}</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="Tasks && Tasks.length" class="card-footer text-center">
                            <router-link :to="{ 
                                name: TASKS
                            }" class="btn btn-sm btn-secondary float-right">
                                View All Tasks
                            </router-link>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Latest Users</h3>
                            <div class="card-tools">
                                <span class="badge badge-danger">{{ userCount }} New Users</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                                <li v-for="user in Users" :key="user.id">
                                    <img :src="loadAvatar(user.profile?.avatar)" alt="User Image" />
                                    <a class="users-list-name" href="#">{{ user.full_name }}</a>
                                    <span class="users-list-date">{{ formatDate(user.created_at)}}</span>
                                </li>
                            </ul>
                        </div>
                        <div v-if="authStore.hasPermission(['view users'])
                            && Users && Users.length" class="card-footer text-center">
                            <router-link :to="{ 
                                name: USERS
                            }" class="btn btn-sm btn-secondary float-right">
                                View All Users
                            </router-link>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Polls</h3>
                        </div>
                        <div class="card-body p-0 m-1">
                            <div class="info-box mb-3 bg-primary" 
                                 v-for="poll in Polls" :key="poll.id">
                                <span class="info-box-icon"><i class="far fa-comment"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{poll.question}}</span>
                                    <span class="info-box-number" >{{ poll.pollassignees.length }}</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="Polls && Polls.length" class="card-footer text-center">
                            <router-link :to="{ 
                                name: POLLS
                            }" class="btn btn-sm btn-secondary float-right">
                                View All Polls
                            </router-link>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.info-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border: 1px solid #e3e6f0;
    border-radius: .35rem;
    box-shadow: 0 0 1rem rgba(0, 0, 0, .15);
}
.info-box img {
    border-radius: 50%;
}
.info-box h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}
.info-box p {
    margin: 0;
    font-size: 1rem;
}
</style>

<template>
    <div class="row">
        <!-- Boards Table -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Latest Boards</h3>
                    <RouterLink to="/boards" class="btn btn-sm btn-info float-right mr-3">View All</RouterLink>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="board in boards" :key="board.id">
                                    <td><router-link :to="{ name: 'BoardDetails', params: { boardId: board.id } }">{{ board.title }}</router-link></td>
                                    <td>{{ board.description }}</td>
                                    <td>{{ board.status }}</td>
                                    <td>{{ board.date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Meetings Table -->
        <div class="col-md-6">
            <div class="card">                
                <div class="card-header border-transparent">
                    <h3 class="card-title">Latest Meetings</h3>
                    <RouterLink to="/meetings" class="btn btn-sm btn-info float-right mr-3">View Meetings</RouterLink>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- <form>
                        <Multiselect
                            v-model="value"
                            mode="multiple"
                            :close-on-select="false"
                            :groups="true"
                            :options="[
                                {
                                    label: 'DC',
                                    options: ['Batman', 'Robin', 'Joker'],
                                },
                                {
                                    label: 'Marvel',
                                    options: ['Spiderman', 'Iron Man', 'Captain America'],
                                },
                            ]"
                        />
                    </form> -->
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="meeting in meetings" :key="meeting.id">
                                    <td><router-link :to="{ name: 'MeetingDetails', params: { id: meeting.id } }">{{ meeting.title }}
                                    </router-link></td>
                                    <td>{{ meeting.description }}</td>
                                    <td>{{ meeting.status }}</td>
                                    <td>{{ meeting.date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Tasks</h3>
                    <RouterLink to="/tasks" class="btn btn-sm btn-info float-right mr-3">View Tasks</RouterLink>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="task in tasks" :key="task.id">
                                    <td><router-link :to="{ name: 'TaskDetails', params: { id: task.id } }">{{ task.title }}</router-link></td>
                                    <td>{{ task.description }}</td>
                                    <td>{{ task.status }}</td>
                                    <td>{{ task.date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Polls</h3>
                    <RouterLink to="/polls" class="btn btn-sm btn-info float-right mr-3">View Polls</RouterLink>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="poll in polls" :key="poll.id">
                                    <td><router-link :to="{ name: 'PollDetails', params: { id: poll.id } }">{{ poll.title }}</router-link></td>
                                    <td>{{ poll.description }}</td>
                                    <td>{{ poll.status }}</td>
                                    <td>{{ poll.date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendar</h3>
                </div>
                <div class="card-body">
                    <p>Current Month: {{ currentMonth }}</p>
                    <p>Year: {{ currentYear }}</p>
                    <!-- More sophisticated calendar UI would go here -->
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Discussion Topics</h3>
                    <RouterLink to="/discussions" class="btn btn-sm btn-info float-right mr-3">View Discussions</RouterLink>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Replies</th>
                                    <th>Last Post</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="discussion in discussions" :key="discussion.id">
                                    <td><router-link :to="{ name: 'DiscussionDetails', params: { id: discussion.id } }">{{ discussion.topic }}
                                    </router-link></td>
                                    <td>{{ discussion.replies }}</td>
                                    <td>{{ discussion.lastPost }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users</h3>
                    <RouterLink to="/users" class="btn btn-sm btn-info float-right mr-3">View Users</RouterLink>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.role }}</td>
                                    <!-- <td><router-link :to="{ name: 'UserProfileDetails', params: { userId: user.id } }">View</router-link></td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup lang="ts">
import Multiselect from '@vueform/multiselect';
import {onMounted,ref} from 'vue';
import {useRouter} from 'vue-router';
import {useSettingsStore} from '@/common/stores/settings.store';
const settingsStore = useSettingsStore();
const value =ref('');
const boards = ref([
    {id: 1, title: 'Board A', description: 'Description A', status: 'Active', date: '2024-05-03'},
    {id: 2, title: 'Board B', description: 'Description B', status: 'Inactive', date: '2024-06-04'},
]);

const meetings = ref([
    {id: 1, title: 'Meeting A', description: 'Description for Meeting A', status: 'Scheduled', date: '2024-07-05'},
    {id: 2, title: 'Meeting B', description: 'Description for Meeting B', status: 'Completed', date: '2024-08-06'},
]);
const tasks = ref([
    {id: 1, title: 'Task 1', description: 'Task 1 Description', status: 'In Progress', date: '2024-05-03'},
    {id: 2, title: 'Task 2', description: 'Task 2 Description', status: 'Completed', date: '2024-06-04'},
]);
const polls = ref([
    {id: 1, title: 'Poll 1', description: 'Poll 1 Description', status: 'Open', date: '2024-07-05'},
    {id: 2, title: 'Poll 2', description: 'Poll 2 Description', status: 'Closed', date: '2024-08-06'},
]);
const discussions = ref([
    {id: 1, topic: 'Vue 3 Composition API', replies: 42, lastPost: '2024-07-05'},
    {id: 2, topic: 'TypeScript in Vue', replies: 37, lastPost: '2024-08-06'},
]);
const users = ref([
    {id: 1, name: 'John Doe', email: 'john.doe@example.com', role: 'Administrator'},
    {id: 2, name: 'Jane Doe', email: 'jane.doe@example.com', role: 'User'},
    // Add more users as needed
]);
const currentDate = new Date();
const currentMonth = ref(currentDate.toLocaleString('default', {month: 'long'}));
const currentYear = ref(currentDate.getFullYear());

const router = useRouter();

function navigateToDetail(type: 'board' | 'meeting', id: number) {
    router.push(`/${type}/${id}`);
}
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Dashboard'}));
    // getUsers();
    console.log('settingsStore', settingsStore.settings);
});
</script>

<style scoped>
</style>

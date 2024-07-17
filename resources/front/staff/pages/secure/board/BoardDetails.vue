<script setup lang="ts">
import {computed, onMounted, ref, watchEffect} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import {useGetSingleBoardRequest} from '@/common/api/requests/modules/board/useBoardRequest'; // Import your API function
import {
    BOARDS,
} from '@/common/constants/staffRouteNames';
import {loadCover, loadIcon, truncateDescription} from '@/common/customisation/Breadcrumb';
import {Board} from '@/common/parsers/boardParser';
import useAuthStore from '@/common/stores/auth.store';
import Committees from './includes/Committees.vue';
// import Discussion from './includes/Discussion.vue';
import Documents from './includes/Documents.vue';
import Goals from './includes/Goals.vue';
import HomeDashBoard from './includes/HomeDashboard.vue';
import Members from './includes/Members.vue';
import TaskPolls from './includes/TaskPolls.vue';
const authStore = useAuthStore();
// v-if="authStore.hasPermission(['edit board'])"

// Define a reactive reference for storing board data
const board = ref<Board>();

// Get the route instance
const route = useRoute();
const router = useRouter();

const currentTab = ref('home');
const previousTab = ref('');

const tabs = [
    {id: 'home', name: 'Meeting Details', component: HomeDashBoard,permissions: ['view meeting']},
    {id: 'documents', name: 'Documents', component: Documents, permissions: ['view documents']},
    {id: 'tasks', name: 'Task & Polls', component: TaskPolls, permissions: ['view task', 'view poll']},
    {id: 'members', name: 'Members', component: Members, permissions: ['view meeting memberships']},
    {id: 'committees', name: 'Committees', component: Committees, permissions: ['view committee']},
];

const filteredTabs = computed(() => {
    return tabs.filter(tab => {
        if (tab.permissions) {
            return tab.permissions.every(permission => authStore.hasPermission([permission]));
        }
        return true;
    });
});

const setActiveTab = (tabId: string) => {
    previousTab.value = currentTab.value;
    currentTab.value = tabId;
};

const handleMembershipsUpdated = () => {
    if (previousTab.value === 'agenda') {
        setActiveTab('agenda');
        window.dispatchEvent(new CustomEvent('refetchMemberships'));
    }
};

watchEffect(() => {
    if (route.query.previousTab) {
        previousTab.value = route.query.previousTab as string;
    }
    if (route.query.currentTab) {
        currentTab.value = route.query.currentTab as string;
    }
});

function goBack() {
    router.push({
        name: BOARDS,
    });
    
}
// Extract the id parameter from the route
const boardId = route.params.boardId as string;

// Fetch single board data when the component is mounted
onMounted(async () => {
    try {
        // Fetch single board data using the API function
        const data = await useGetSingleBoardRequest(boardId);
        // Update the board data with the fetched data
        const boarddata = data.data;
        board.value = boarddata;
        window.dispatchEvent(new CustomEvent('updateTitle', {detail: boarddata.name}));
    } catch (error) {
        console.error('Error fetching board data:', error);
    }
});
</script>

<template>
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user shadow-lg" v-if="board">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white"
                 :style="{ backgroundImage: `url(${loadCover(board.cover)})`, 
                           backgroundPosition: 'center center', backgroundSize: 'cover', 
                           backgroundRepeat: 'no-repeat' }"
                 style="height: 250px; width: 100%; position: relative;">
                <!-- Optional overlay for better readability -->
                <div style="position: absolute; top: 0; left: 0; 
                width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);"></div>
                <!-- Content goes here -->
            </div>

            <div class="card-footer">
                <div class="">
                    <div class="widget-user-image" 
                         style="left: 4%; 
                        margin-left: -45px; 
                        position: absolute; 
                        top: 190px;">
                        <img class="img-circle elevation-2" 
                             :src="loadIcon(board.icon)" 
                             alt="User Avatar" 
                             style="width:128px; height: 128px">
                    </div>
                    <div class="ml-3 flex-1" style=" margin-top: -28px;">
                        <a href="" @click.prevent="goBack()"
                           class="mb-2 lg:mb-0 text-blue-primary" style="margin-left: 140px; margin-top: -44px;">
                            <i class="fas fa-chevron-left fa-xs"></i> Boards
                        </a>
                        <h3 class="h2 mb-2 lg:mb-0" style="margin-left: 150px;">
                            {{ board.name }}
                        </h3>
                        <div class="card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item" v-for="tab in filteredTabs" :key="tab.id">
                                        <a class="nav-link" 
                                           :class="{ 'active': currentTab === tab.id }" 
                                           @click="setActiveTab(tab.id)">
                                            {{ tab.name }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div v-for="tab in filteredTabs" 
                                         :key="tab.id" class="tab-pane fade" 
                                         :class="{ 'show active': currentTab === tab.id }" 
                                         :id="tab.id" role="tabpanel">
                                        <component 
                                            :is="tab.component" 
                                            @change-tab="setActiveTab" 
                                            @memberships-updated="handleMembershipsUpdated" 
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
        </div>
        <!-- /.widget-user -->
    </div>
</template>

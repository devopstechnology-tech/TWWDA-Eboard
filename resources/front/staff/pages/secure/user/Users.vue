<script setup lang="ts">
import {onMounted,ref, watch, watchEffect} from 'vue';
import {useRoute,useRouter} from 'vue-router';
// Import your API function
import {loadDefaultCover,loadDefaultUserIcon} from '@/common/customisation/Breadcrumb';
import {DASHBOARD} from '../../../../common/constants/staffRouteNames';
import DeletedUsers from './includes/DeletedUsers.vue';
import Everyone from './includes/Everyone.vue';
const route = useRoute();
const router = useRouter();

function goBack() {
    router.back();
}
const currentTab = ref('users');
const previousTab = ref('');

const tabs = [
    {id: 'users', name: 'All Users', component: Everyone},
    {id: 'trashed', name: 'Trashed Users', component: DeletedUsers},
];

const setActiveTab = (tabId: string) => {
    previousTab.value = currentTab.value; // Store the current tab in previousTab before updating currentTab
    currentTab.value = tabId;
};

watch(currentTab, (newTab:string, oldTab:string) => {
    // Emit event to child components to fetch data
    if (newTab === 'users' || newTab === 'trashed') {
        window.dispatchEvent(new CustomEvent('fetchUsersData'));
    }
});

watchEffect(() => {
    if (route.query.previousTab) {
        previousTab.value = route.query.previousTab as string;
    }
    if (route.query.currentTab) {
        currentTab.value = route.query.currentTab as string;
    }
});
watchEffect(() => {
    if (route.query.previousTab) {
        previousTab.value = route.query.previousTab as string;
    }
    if (route.query.currentTab) {
        currentTab.value = route.query.currentTab as string;
    }
});
</script>

<template>
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user shadow-lg" >
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white"
                 :style="{ background: `url(${loadDefaultCover('default.png')}) center center` } "
                 style="height: 250px;">
            </div>
            <div class="card-footer" >
                <div class="">
                    <span class="info-box-icon bg-danger"
                          style="left: 4%; margin-left: -45px; position: absolute; top: 190px;">
                        <img class="img-square" :src="loadDefaultUserIcon('defaulticon.png')" alt="User Avatar"
                             style="width:128px; height: 128px">
                    </span>
                    <div class="ml-3 flex-1" style=" margin-top: -28px;">
                        <a href="" @click.prevent="goBack()"
                           class="mb-2 lg:mb-0 text-blue-primary" style="margin-left: 131px; margin-top: -44px;">
                            <i class="fas fa-chevron-left fa-xs"></i> Dashboard
                        </a>
                        <h3 class="h2 mb-2 lg:mb-0" style="margin-left: 131px;">
                            Users
                        </h3>
                        <div class="card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item" v-for="tab in tabs" :key="tab.id">
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
                                    <div v-for="tab in tabs" 
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




<script setup lang="ts">
import {onMounted,ref} from 'vue';
import {useRoute,useRouter} from 'vue-router';
import {useGetSingleCommitteeRequest} from '@/common/api/requests/modules/committee/useCommitteeRequest'; // Import your API function
import {loadImage,truncateDescription} from '@/common/customisation/Breadcrumb';
import {Committee} from '@/common/parsers/committeeParser';
import Discussion from './includes/Discussion.vue';
import Documents from './includes/Documents.vue';
import Goals from './includes/Goals.vue';
import HomeDashboard from './includes/HomeDashboard.vue';
import Members from './includes/Members.vue';
import TaskPolls from './includes/TaskPolls.vue';

// Define a reactive reference for storing committee data
const committee = ref<Committee>();

// Get the route instance
const route = useRoute();
const router = useRouter();

function goBack() {
    router.back();
}
// Extract the id parameter from the route
const committeeId = route.params.id as string;

// Fetch single committee data when the component is mounted
onMounted(async () => {
    try {
        // Fetch single committee data using the API function
        const data = await useGetSingleCommitteeRequest(committeeId);
        // Update the committee data with the fetched data
        const committeedata = data.data;
        committee.value = committeedata;
        window.dispatchEvent(new CustomEvent('updateTitle', {detail: committeedata.name}));
    } catch (error) {
        console.error('Error fetching committee data:', error);
    }
});

// function truncateDescription(description: string, maxLength: number): string {
//     return description?.length > maxLength ? description.substring(0, maxLength) + '...' : description;
// }
</script>

<template>
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user shadow-lg">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white"
                 :style="{ background: `url(${loadImage('photo1.png')}) center center` } "
                 style="height: 250px;">
            </div>
            <div class="card-footer" v-if="committee">
                <div class="">
                    <span class="info-box-icon bg-danger"
                          style="left: 4%; margin-left: -45px; position: absolute; top: 190px;">
                        <img class="img-square" :src="loadImage('user.jpg')" alt="User Avatar">
                    </span>
                    <div class="ml-3 flex-1" style=" margin-top: -28px;">
                        <a href="" @click.prevent="goBack()"
                           class="mb-2 lg:mb-0 text-blue-primary" style="margin-left: 131px; margin-top: -44px;">
                            <i class="fas fa-chevron-left fa-xs"></i> Boards
                        </a>
                        <h3 class="h2 mb-2 lg:mb-0" style="margin-left: 131px;">
                            {{ committee.name }}
                        </h3>
                        <div class="card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab"
                                           aria-controls="custom-tabs-four-home" aria-selected="true">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-documents-tab" data-toggle="pill"
                                           href="#custom-tabs-four-documents" role="tab"
                                           aria-controls="custom-tabs-four-documents" aria-selected="false">
                                            Documents
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-discussions-tab" data-toggle="pill"
                                           href="#custom-tabs-four-discussions" role="tab"
                                           aria-controls="custom-tabs-four-discussions" aria-selected="false">
                                            Discussions
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-tasks-tab" data-toggle="pill"
                                           href="#custom-tabs-four-tasks" role="tab"
                                           aria-controls="custom-tabs-four-tasks" aria-selected="false">
                                            Task & Polls
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-goals-tab" data-toggle="pill"
                                           href="#custom-tabs-four-goals" role="tab"
                                           aria-controls="custom-tabs-four-goals" aria-selected="false">
                                            Goals
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-members-tab" data-toggle="pill"
                                           href="#custom-tabs-four-members" role="tab"
                                           aria-controls="custom-tabs-four-members" aria-selected="false">
                                            Members
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-four-home"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                        <HomeDashboard/>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-documents"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-documents-tab">
                                        <Documents/>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-discussions"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-discussions-tab">
                                        <Discussion/>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-tasks"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-tasks-tab">
                                        <TaskPolls/>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-goals"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-goals-tab">
                                        <Goals/>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-members"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-members-tab">
                                        <Members/>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
        </div>
        <!-- /.widget-user -->
    </div>
</template>


<script setup lang="ts">
import {onMounted,ref} from 'vue';
import {useRoute,useRouter} from 'vue-router';
// Import your API function
import {loadDefaultCover,loadDefaultUserIcon} from '@/common/customisation/Breadcrumb';
import Everyone from './includes/Everyone.vue';
import { DASHBOARD } from '../../../../common/constants/staffRouteNames';
const route = useRoute();
const router = useRouter();

function goBack() {
    router.back();
}

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
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-everyone-tab" data-toggle="pill"
                                           href="#custom-tabs-four-everyone" role="tab"
                                           aria-controls="custom-tabs-four-everyone" aria-selected="true">Everyone</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-unacceptedinvitations-tab" data-toggle="pill"
                                           href="#custom-tabs-four-unacceptedinvitations" role="tab"
                                           aria-controls="custom-tabs-four-unacceptedinvitations" aria-selected="false">
                                            Unaccepted Invitations
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-unsentinvitations-tab" data-toggle="pill"
                                           href="#custom-tabs-four-unsentinvitations" role="tab"
                                           aria-controls="custom-tabs-four-unsentinvitations" aria-selected="false">
                                            Unsent Invitations
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-four-everyone"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-everyone-tab">
                                        <Everyone/>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-unacceptedinvitations"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-unacceptedinvitations-tab">
                                         <!-- <UnacceptedInvitation/> -->
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-unsentinvitations"
                                         role="tabpanel" aria-labelledby="custom-tabs-four-unsentinvitations-tab">
                                         <!-- <UnsentInvitation/> -->
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




<script setup lang="ts">
import {
    AGENDAS,
    ALMANAC,
    BOARDS,
    CALENDAR,
    DASHBOARD,
    DISCUSSIONS,
    MEETINGS,
    NOTIFICATIONS,
    POLLS,
    SETTINGS,
    TASKS,
    USERS,
} from '@/common/constants/staffRouteNames';
import {
    loadAvatar,
} from '@/common/customisation/Breadcrumb';
import useAuthStore from '@/common/stores/auth.store';
// import useAuthStore from '@/common/stores/auth.store';
// const authStore = useAuthStore();
// v-if="authStore.hasPermission(['view meeting'])"

const authStore = useAuthStore();
</script>
<template>
    <div>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <router-link to="/" class="brand-link">
                <!-- <img src="../../../../assets/img/AdminLTELogo.png"
                     alt="AdminLTE Logo"
                     class="brand-image img-circle elevation-3"
                     style="opacity: .8"> -->
                <span class="brand-text font-weight-light">Eboard</span>
            </router-link>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex" v-if="authStore.user">
                    <div class="image">
                        <img :src="loadAvatar(authStore.user.profile?.avatar)" class="img-circle elevation-2"
                             alt="User Image">
                    </div>
                    <div class="info">
                        <router-link :to="{
                            name: 'ProfileDetails',
                            params:{
                                userId: authStore?.user?.id,
                                profileId: authStore.user.profile?.id,
                            } }" class="d-block">
                            {{ authStore.user.full_name }}
                        </router-link>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <router-link :to="{name: DASHBOARD}" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="authStore.hasPermission(['view committee','view board'])">
                            <router-link :to="{name:  BOARDS}" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Board & Committee
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="authStore.hasPermission(['view meeting'])">
                            <router-link :to="{name:  MEETINGS}"   class="nav-link" active-class="active" >
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Meetings
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="authStore.hasPermission(['view almanac'])">
                            <router-link :to="{name:  ALMANAC}"  class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Almanac
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="authStore.hasPermission(['view discussion'])">
                            <router-link :to="{name: DISCUSSIONS}"  class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-tree"></i>
                                <p>
                                    Discussions
                                </p>
                            </router-link>
                        </li>
                        <!-- <li class="nav-item">
                            <router-link :to="{name: AGENDAS}"  class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Agendas
                                </p>
                            </router-link>
                        </li> -->
                        <li class="nav-item" v-if="authStore.hasPermission(['view poll'])">
                            <router-link :to="{name: POLLS}"  class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Polls
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="authStore.hasPermission(['view task'])">
                            <router-link :to="{name: TASKS}"  class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Tasks
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="authStore.hasPermission(['view users'])">
                            <router-link :to="{name: USERS}" class="nav-link" active-class="active">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Users
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="authStore.hasPermission(['view calendar'])">
                            <router-link :to="{name: CALENDAR}" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-tree"></i>
                                <p>
                                    Calendar
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="authStore.hasPermission(['view settings'])">
                            <router-link :to="{name: SETTINGS}" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-tree"></i>
                                <p>
                                    Settings
                                    
                                </p>
                            </router-link>
                        </li>
                    </ul>
                </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
    </div>
</template>


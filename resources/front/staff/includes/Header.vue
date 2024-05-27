<script setup lang="ts">
import {faMessage, faShoppingBasket} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {ref} from 'vue';
import useStaffLogoutRequest from '@/common/api/requests/useStaffLogoutRequest';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import {DASHBOARD,LOGIN} from '@/common/constants/staffRouteNames';
import useAuthStore from '@/common/stores/auth.store';
import useSettingsStore from '@/common/stores/settings.store';
import router from '@/router';
import Notification from './header/Notifications.vue';

const unreadCount = ref(0);


const authStore = useAuthStore();
const settingsStore = useSettingsStore();
const handleUnexpectedError = useUnexpectedErrorHandler();
async function onLogout() {
    try {
        await useStaffLogoutRequest();

        authStore.setUser(undefined);
        settingsStore.resetSettings();

        await router.push({name: LOGIN});
        const route = router.resolve({name: LOGIN});
        window.location.href = route.href;
    } catch (err) {
        handleUnexpectedError(err);
    }
}
function updateUnreadCount(count) {
    unreadCount.value = count;
}
</script>
<template>
    <nav class="main-header navbar navbar-expand navbar-white">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <router-link :to="{name: DASHBOARD}" class="nav-link">Home</router-link>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell fa-lg mr-2"></i>
                    <span class="badge bg-danger navbar-badge">{{ unreadCount }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <Notification @updateCount="updateUnreadCount"/>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li @click="onLogout" class="nav-item">
                <a class="nav-link" href="#" role="button">
                    Logout
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

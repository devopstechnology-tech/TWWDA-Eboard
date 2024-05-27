<!-- eslint-disable max-len -->


<script setup lang="ts">
import {onBeforeUnmount, onMounted} from 'vue';
import BackendBreadcrumb from './includes/Breadcrumb.vue';
import BackendFooter from './includes/Footer.vue';
import BackendHeader from './includes/Header.vue';
import BackendSidebar from './includes/Sidebar.vue';

onMounted(() => {
    const appDiv = document.getElementById('app');
    document.body.classList.add('hold-transition', 'sidebar-mini', 'layout-fixed', 'layout-navbar-fixed', 'layout-footer-fixed');
    if (appDiv) appDiv.classList.add('wrapper');

});

onBeforeUnmount(() => {
    document.body.classList.remove('hold-transition','sidebar-mini', 'layout-fixed', 'layout-navbar-fixed', 'layout-footer-fixed');
    const appDiv = document.getElementById('app');
    if (appDiv) {
        appDiv.classList.remove('wrapper');
    }
});
</script>
<template>
    <BackendHeader />
    <BackendSidebar />
    <div class="content-wrapper">
        <BackendBreadcrumb />
        <section class="content">
            <div class="container-fluid">
                <RouterView />
            </div>
        </section>
    </div>
    <BackendFooter />
</template>

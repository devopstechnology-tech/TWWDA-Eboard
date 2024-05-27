
<script setup lang="ts">
import {onBeforeUnmount, onMounted} from 'vue';

onMounted(() => {
    const appDiv = document.getElementById('app');
    document.body.classList.add('hold-transition', 'login-page');
    document.body.style.minHeight = '496.781px';
    document.body.style.height = '';
    if (appDiv) {
        appDiv.classList.add('login-box');
    }
});
onBeforeUnmount(() => {
    document.body.classList.remove('login-page');
    const appDiv = document.getElementById('app');
    if (appDiv){
        appDiv.classList.remove('login-box');
    }
});
</script>
<template>
    <div class="card card-outline card-primary">
        <RouterView />
    </div>
</template>

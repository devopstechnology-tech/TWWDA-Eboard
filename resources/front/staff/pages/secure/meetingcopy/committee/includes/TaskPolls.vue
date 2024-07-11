<script setup lang="ts">
import useAuthStore from '@/common/stores/auth.store';
import Pollp from './Pollp.vue';
import Taskp from './Taskp.vue';

const authStore = useAuthStore();
// v-if="authStore.hasPermission(['assign meeting position'])"
</script>

<style scoped>
</style>
<template>
    <div v-if="authStore.hasPermission(['view task', 'view poll'])">
        <div class="row">
            <div class="col-md-6">
                <Taskp/>
            </div>
            <div class="col-md-6">
                <Pollp/>
            </div>
        </div>
    </div>
    <div v-else>
        <p class="m-0">
            <span class="h3  text-primary text-bold text-danger">Sorry, You are not Authorised to view this page</span>
        </p>
    </div>     
</template>
<style lang="scss">
.danger-color {
    color: #ff0000; /* Or any color/style for "danger" */
}

.ok-color {
    color: #008000; /* Or any color/style for "OK" */
}
</style>


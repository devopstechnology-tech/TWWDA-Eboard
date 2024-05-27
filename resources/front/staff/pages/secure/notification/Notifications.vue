<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Notifications</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="notification in notifications" :key="notification.id">
                            <td>{{ notification.message }}</td>
                            <td>{{ notification.date }}</td>
                            <td><router-link :to="`/notification/${notification.id}`">View</router-link></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from 'vue';

const notifications = ref([
    {id: 1, message: 'New update available', date: '2024-07-05', link: '/update-info'},
    {id: 2, message: 'Meeting reminder', date: '2024-08-06', link: '/meeting-reminder'},
]);
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Notifications'}));
    // getUsers();
});
</script>

<style scoped>
</style>

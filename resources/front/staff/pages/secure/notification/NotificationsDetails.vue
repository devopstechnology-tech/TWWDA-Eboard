<template>
    <div class="notification-detail">
        <h1>Notification Detail</h1>
        <!-- Display notification details here -->
        <p>{{ notification.message }}</p>
        <p>{{ notification.date }}</p>
        <!-- Add more details as needed -->
    </div>
</template>

<script setup>
import {onMounted,ref} from 'vue';
import {useRoute} from 'vue-router';

const route = useRoute();
const notificationId = parseInt(route.params.id, 10);

// Simulated data - in a real application, replace this with a fetch call
const notifications = [
    {id: 1, message: 'New update available', date: '2024-07-05'},
    {id: 2, message: 'Meeting reminder', date: '2024-08-06'},
];

const notification = ref(notifications.find(notification => notification.id === notificationId));
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Notification Details'}));
    // getUsers();
});
</script>

<style scoped>
.notification-detail {
    padding: 20px;
    margin: 20px;
}
</style>

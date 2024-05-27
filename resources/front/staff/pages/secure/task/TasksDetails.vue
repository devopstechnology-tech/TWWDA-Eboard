<template>
    <div class="task-detail">
        <h2>{{ task.title }}</h2>
        <p>{{ task.description }}</p>
        <p>Status: {{ task.status }}</p>
        <p>Date: {{ task.date }}</p>
        <!-- Implement a back button to go back to the tasks list -->
        <button @click="goBack">Go Back</button>
    </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';

const route = useRoute();
const router = useRouter();

const task = ref({
    id: 1,
    title: '',
    description: '',
    status: '',
    date: '',
});

// Dummy function to simulate fetching task details
// Replace this with your actual data fetching logic
function fetchTaskDetails(id: number) {
    const tasks = [
        {id: 1, title: 'Task 1', description: 'Task 1 Description', status: 'In Progress', date: '2024-05-03'},
        {id: 2, title: 'Task 2', description: 'Task 2 Description', status: 'Completed', date: '2024-06-04'},
    ];
    return tasks.find(t => t.id === id);
}

onMounted(() => {
    const id = Number(route.params.id);
    const details = fetchTaskDetails(id);
    if (details) {
        task.value = details;
    } else {
        // Handle case where task details are not found
        console.error('Task not found');
        router.push('/'); // Redirect to home or tasks list
    }
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Task Details'}));
});

function goBack() {
    router.back();
}
</script>

<style scoped>
/* Add styles for your task detail page here */
</style>

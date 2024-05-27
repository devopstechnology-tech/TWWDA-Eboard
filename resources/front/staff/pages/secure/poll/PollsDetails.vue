<template>
    <div class="poll-detail">
        <h2>{{ poll.title }}</h2>
        <p>{{ poll.description }}</p>
        <p>Status: {{ poll.status }}</p>
        <p>Date: {{ poll.date }}</p>
        <!-- Implement a back button to go back to the polls list -->
        <button @click="goBack">Go Back</button>
    </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';

const route = useRoute();
const router = useRouter();

const poll = ref({
    id: 1,
    title: '',
    description: '',
    status: '',
    date: '',
});

// Dummy function to simulate fetching poll details
// Replace this with your actual data fetching logic
function fetchPollDetails(id: number) {
    const polls = [
        {id: 1, title: 'Poll 1', description: 'Poll 1 Description', status: 'Open', date: '2024-07-05'},
        {id: 2, title: 'Poll 2', description: 'Poll 2 Description', status: 'Closed', date: '2024-08-06'},
    ];
    return polls.find(p => p.id === id);
}

onMounted(() => {
    const id = Number(route.params.id);
    const details = fetchPollDetails(id);
    if (details) {
        poll.value = details;
    } else {
        // Handle case where poll details are not found
        console.error('Poll not found');
        router.push('/polls'); // Redirect to polls list
    }
});

function goBack() {
    router.back();
}
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Polls Details'}));
    // getUsers();
});
</script>

<style scoped>
/* Add styles for your poll detail page here */
</style>

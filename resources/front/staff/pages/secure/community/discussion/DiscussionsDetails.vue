<template>
    <div class="discussion-detail">
        <h1>{{ discussion.topic }}</h1>
        <p>{{ discussion.description }}</p>
        <div>Replies: {{ discussion.replies }}</div>
        <div>Last post: {{ discussion.lastPost }}</div>
        <!-- Additional details can be added here -->
    </div>
</template>

<script setup>
import {onMounted,ref} from 'vue';
import {useRoute} from 'vue-router';

// Sample data - replace this with a real API call to fetch discussion details
const discussions = [
    {id: 1, topic: 'Vue 3 Composition API', description: 'Discussion about Vue 3 Composition API.', replies: 42, lastPost: '2024-07-05'},
    {id: 2, topic: 'TypeScript in Vue', description: 'How to use TypeScript in Vue projects.', replies: 37, lastPost: '2024-08-06'},
];

const route = useRoute();
const discussionId = parseInt(route.params.id, 10);
const discussion = ref(discussions.find(d => d.id === discussionId));
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Discussion Details'}));
    // getUsers();
});
</script>

<style scoped>
.discussion-detail {
    padding: 20px;
    margin: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
}
</style>

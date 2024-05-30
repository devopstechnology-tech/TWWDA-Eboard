<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Discussion Topics</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>Topic</th>
                            <th>Replies</th>
                            <th>Last Post</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="discussion in discussions" :key="discussion.id">
                            <td><router-link :to="`/discussion/${discussion.id}`">{{ discussion.topic }}
                            </router-link></td>
                            <td>{{ discussion.replies }}</td>
                            <td>{{ discussion.lastPost }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from 'vue';

const discussions = ref([
    {id: 1, topic: 'Vue 3 Composition API', replies: 42, lastPost: '2024-07-05'},
    {id: 2, topic: 'TypeScript in Vue', replies: 37, lastPost: '2024-08-06'},
]);
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Discussions'}));
    // getUsers();
});
</script>

<style scoped>
</style>

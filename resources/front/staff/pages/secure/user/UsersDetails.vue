<template>
    <div class="user-detail">
        <h2>{{ user.name }}</h2>
        <p>Email: {{ user.email }}</p>
        <p>Role: {{ user.role }}</p>
        <!-- Implement a back button to go back to the users list -->
        <button @click="goBack">Go Back</button>
    </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';

const route = useRoute();
const router = useRouter();

const user = ref({
    id: 1,
    name: '',
    email: '',
    role: '',
});

// Dummy function to simulate fetching user details
// Replace this with your actual data fetching logic
function fetchUserDetails(id: number) {
    const users = [
        {id: 1, name: 'John Doe', email: 'john.doe@example.com', role: 'Administrator'},
        {id: 2, name: 'Jane Doe', email: 'jane.doe@example.com', role: 'User'},
        // Add more users as needed
    ];
    return users.find(u => u.id === id);
}

onMounted(() => {
    const id = Number(route.params.id);
    const details = fetchUserDetails(id);
    if (details) {
        user.value = details;
    } else {
        // Handle case where user details are not found
        console.error('User not found');
        router.push('/users'); // Redirect to users list
    }
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'User Details'}));
});

function goBack() {
    router.back();
}

</script>

<style scoped>
/* Add styles for your user detail page here */
</style>

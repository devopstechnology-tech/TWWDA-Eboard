<script setup lang="ts">
import {onMounted, ref,watch} from 'vue';
import {useRoute} from 'vue-router';
import {customTitle, updateBreadcrumbCustomTitle} from '@/common/customisation/Breadcrumb';

const route = useRoute();
const pageTitle = ref(''); // Initialize with a default title
const Title = ref(''); // Initialize with a default title

watch(customTitle, (newValue) => {
    Title.value = newValue;
});

// Listen for the emitted event to update the custom title
window.addEventListener('updateTitle', (event: Event) => {
    const customEvent = event as CustomEvent<string>;
    updateBreadcrumbCustomTitle(customEvent.detail);
});
// Watch for route changes
watch(() => route.path, () => {
    // Update pageTitle based on current route's meta title, or fallback to a default
    pageTitle.value = route.meta.title || '';
}, {immediate: true});
</script>
<template>
    <div>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ Title }}</h1> <!-- Dynamically update the title -->
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                            <li class="breadcrumb-item text-primary">{{ pageTitle }}</li> <!-- Also update here -->
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
</template>


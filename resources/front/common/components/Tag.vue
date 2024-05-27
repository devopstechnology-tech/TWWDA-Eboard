<script lang="ts" setup>
defineProps<{
    theme?: 'error' | 'success';
}>();
</script>

<template>
    <div :class="[theme]">
        <slot />
    </div>
</template>

<style scoped>
div {
    @apply bg-gray-300;
    @apply px-2 py-1;
    @apply rounded-full;
    @apply leading-none text-alt text-sm;
}

.error {
    @apply bg-red-200;
    @apply text-red-600;
}

.success {
    @apply bg-green-200;
    @apply text-green-600;
}
</style>

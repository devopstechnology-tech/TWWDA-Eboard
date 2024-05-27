<script setup lang="ts">
defineProps<{
    theme: 'neutral' | 'warning';
}>();
</script>

<template>
    <div :class="['tag', theme]">
        <slot />
    </div>
</template>

<style scoped>
.tag {
    @apply bg-gray-300;
    @apply px-4 py-0.5;
    @apply rounded-full;
    @apply text-sm;
}

.warning {
    @apply bg-yellow-600;
    @apply text-white;
}
</style>

<script setup lang="ts">
defineProps<{
    title: string;
}>();

const emit = defineEmits<{
    (event: 'submit'): void;
}>();
</script>

<template>
    <div class="content">
        <div class="header">
            <h2>{{ title }}</h2>
        </div>
        <form novalidate @submit.prevent="emit('submit')">
            <slot />
            <div class="buttons">
                <slot name="buttons" />
            </div>
        </form>
    </div>
</template>

<style scoped>
.content {
    @apply flex flex-col gap-4;
}
.header {
    @apply flex flex-col gap-2 items-center;

    & > h2 {
        @apply font-semibold text-lg;
    }
}

.buttons {
    @apply flex flex-col gap-4;

    @apply sm:flex-row;

    & > :slotted(.button) {
        @apply flex-1;
    }
}
</style>

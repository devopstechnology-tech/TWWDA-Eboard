<template>
    <div v-if="props.type === 'warning'" class="flex border border-amber-500 rounded bg-amber-100 text-amber-500">
        <div class="w-18 p-3 text-2xl border-r border-r-amber-500">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="self-center px-4">
            <slot></slot>
        </div>
    </div>
    <div v-if="props.type === 'danger'" class="flex border border-red-500 rounded bg-red-100 text-red-500">
        <div class="w-18 p-3 text-2xl border-r border-r-red-500">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="self-center px-4">
            <slot></slot>
        </div>
    </div>
    <div v-if="props.type === 'success'" class="flex border border-green-500 rounded bg-green-100 text-green-500">
        <div class="w-18 p-3 text-2xl border-r border-r-green-500">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="self-center px-4">
            <slot></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
interface Props {
    type?: string;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'default',
});

</script>

<style scoped>

</style>

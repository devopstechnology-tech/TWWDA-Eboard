<script setup lang="ts">
import {faCircleCheck, faCircleExclamation, faCircleXmark, IconDefinition} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {computed} from 'vue';

const props = defineProps<{
    icon?: IconDefinition;
    state: 'error' | 'success' | 'warning';
    title: string;
}>();

const renderedIcon = computed<IconDefinition|undefined>(() => {
    if (props.icon) {
        return props.icon;
    }

    switch (props.state) {
        case 'error':
            return faCircleXmark;
        case 'success':
            return faCircleCheck;
        case 'warning':
            return faCircleExclamation;
    }

    return undefined;
});
</script>

<template>
    <div class="content">
        <div class="header">
            <div v-if="renderedIcon" :class="['icon', state]">
                <FontAwesomeIcon :icon="renderedIcon" />
            </div>
            <h2>{{ title }}</h2>
        </div>
        <slot />
        <div class="buttons">
            <slot name="buttons" />
        </div>
    </div>
</template>

<style scoped>
.content {
    @apply flex flex-col gap-4;
}
.header {
    @apply flex flex-col gap-2 items-center;

    & > .icon {
        @apply aspect-square h-16;
        @apply bg-gray-200;
        @apply flex items-center justify-center;
        @apply rounded-full;
        @apply text-3xl text-alt;

        &.error {
            @apply bg-red-200;
            @apply text-red-600;
        }
        &.success {
            @apply bg-green-200;
            @apply text-green-600;
        }
        &.warning {
            @apply bg-yellow-200;
            @apply text-yellow-600;
        }
    }

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

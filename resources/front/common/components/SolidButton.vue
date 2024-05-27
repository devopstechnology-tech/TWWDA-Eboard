<script lang="ts" setup>
import {faSpinner} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {computed} from 'vue';
import {RouteLocationRaw} from 'vue-router';

const props = withDefaults(defineProps<{
    disabled?: boolean;
    label: string;
    loading?: boolean;
    size?: 'base' | 'sm';
    theme?: 'error' | 'neutral' | 'primary' | 'secondary' | 'success';
    to?: RouteLocationRaw;
    type?: 'button' | 'submit' | 'reset';
}>(), {
    disabled: false,
    loading: false,
    size: 'base',
    theme: 'primary',
    type: 'button',
});

const attributes = computed(() => {
    const attributes: Record<string, string|boolean|object|undefined> = {
        class: [
            'button',
            {loading: props.loading},
            `size-${props.size}`,
            `theme-${props.theme}`,
        ],
    };

    if (props.to) {
        attributes.to = props.to;
    } else {
        attributes.disabled = props.disabled || props.loading;
        attributes.type = props.type;
    }

    return attributes;
});
</script>

<template>
    <component :is="to ? 'RouterLink' : 'button'" v-bind="attributes">
        <span v-if="loading" class="loader">
            <FontAwesomeIcon v-if="loading" :icon="faSpinner" class="animate-spin" />
        </span>
        {{ label }}
    </component>
</template>

<style scoped>
.button {
    @apply font-bold text-center text-light;
    @apply inline-block;
    @apply rounded-md px-8;
    @apply p-4;
    @apply uppercase;
    @apply text-center;
    @apply justify-center;

    @apply outline-none;
    @apply hover:ring-2;
    @apply focus-visible:ring-4;

    @apply relative;

    &.size-sm {
        @apply px-6 py-3;
        @apply text-sm;
    }

    &.theme-error {
        @apply bg-red-600;

        @apply hover:ring-red-600/50;
        @apply focus-visible:ring-red-600/50;
        @apply disabled:bg-gray-400 disabled:pointer-events-none disabled:text-light;

        &.loading {
            @apply text-transparent;
        }
    }

    &.theme-neutral {
        @apply bg-white;
        @apply text-blue-800;

        @apply hover:ring-blue-800/50;
        @apply focus-visible:ring-blue-800/50;
        @apply disabled:bg-gray-400 disabled:pointer-events-none disabled:text-light;

        &.loading {
            @apply text-transparent;
        }
    }

    &.theme-primary {
        @apply bg-blue-800;

        @apply hover:ring-blue-800/50;
        @apply focus-visible:ring-blue-800/50;
        @apply disabled:bg-gray-400 disabled:pointer-events-none disabled:text-light;

        &.loading {
            @apply text-transparent;
        }
    }

    &.theme-secondary {
        @apply bg-gray-200;
        @apply text-blue-800;

        @apply hover:ring-blue-800/50;
        @apply focus-visible:ring-blue-800/50;
        @apply disabled:bg-gray-400 disabled:pointer-events-none disabled:text-light;

        &.loading {
            @apply text-transparent;
        }
    }

    &.theme-success {
        @apply bg-green-600;
        @apply opacity-70;

        @apply hover:border-none;
        @apply focus-visible:border-none;
        @apply disabled:pointer-events-none;
    }

    .loader {
        @apply absolute;
        @apply top-1/2 left-1/2;
        @apply transform -translate-x-1/2 -translate-y-1/2;
    }

    &.loading {
        @apply text-transparent;

        svg {
            @apply text-light;
        }
    }
}
</style>

<script setup lang="ts">
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from '@headlessui/vue';

const props = defineProps<{
    open: boolean;
}>();
const emit = defineEmits<{
    (e: 'update', value: boolean): void;
}>();

function close() {
    emit('update', false);
}
</script>

<template>
    <TransitionRoot appear :show="props.open" as="template">
        <Dialog as="div" @close="close" class="relative">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-25"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-xl transform bg-gray-300
                             overflow-hidden rounded-2xl p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <slot/>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped>
.modal {
    @apply relative z-50;
}

.backdrop {
    @apply backdrop-blur bg-black/30;
    @apply fixed inset-0;

    &.enter {
        @apply duration-300 ease-out;
    }

    &.enter-from {
        @apply opacity-0;
    }

    &.enter-to {
        @apply opacity-100;
    }

    &.leave {
        @apply duration-200 ease-in;
    }

    &.leave-from {
        @apply opacity-100;
    }

    &.leave-to {
        @apply opacity-0;
    }
}

.scroll-container {
    @apply fixed inset-0;
    @apply overflow-y-auto;
}

.position-container {
    @apply flex min-h-full items-center justify-center p-4;
}

.modal-panel {
    @apply bg-white;
    @apply max-w-2xl w-full;
    @apply p-8;
    @apply rounded-3xl;
    @apply shadow-lg;

    &.enter {
        @apply duration-300 ease-out;
    }

    &.enter-from {
        @apply opacity-0 scale-95;
    }

    &.enter-to {
        @apply opacity-100 scale-100;
    }

    &.leave {
        @apply duration-200 ease-in;
    }

    &.leave-from {
        @apply opacity-100 scale-100;
    }

    &.leave-to {
        @apply opacity-0 scale-95;
    }
}
</style>

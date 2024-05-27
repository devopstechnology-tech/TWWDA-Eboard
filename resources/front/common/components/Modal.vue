<script setup lang="ts">
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';

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
        <Dialog as="div" @close="close" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl
                     bg-white p-6 text-left align-middle shadow-xl transition-all sm:max-w-lg">
                        <slot/>
                    </DialogPanel>
                </TransitionChild>
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black bg-opacity-25" @click="close"></div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped>
/* Ensuring all transitions and modal styles are scoped and correctly applied */
.modal-panel {
    @apply bg-white;
    @apply max-w-md w-full; /* Responsive width */
    @apply mx-auto p-6; /* Horizontal auto margins for centering and padding */
    @apply rounded-lg; /* Rounded corners */
    @apply shadow-lg; /* Drop shadow for modal panel */
    @apply overflow-auto; /* Enables scrolling within the modal content */
    @apply transition-all duration-300 ease-out; /* Smooth transitions for modal */
}
</style>

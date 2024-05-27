<template>
    <div ref="dropdown" @click.outside="closeDropdown">
        <a href="#" @click.prevent="toggleDropdown">
            <slot></slot>
        </a>
        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0">
            <div class="overflow-hidden absolute mt-1 bg-white rounded shadow z-40"
                 v-show="isOpen" :class="dropdownClasses">
                <slot name="items"></slot>
            </div>
        </transition>
    </div>
</template>

<script setup lang="ts">
import {defineProps,onUnmounted, ref} from 'vue';

type Props = {
    classes?: string;
};
const props = defineProps<Props>();
const dropdown = ref<HTMLElement | null>(null);
const isOpen = ref(false);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const closeDropdown = (event: Event) => {
    if (!dropdown.value || !dropdown.value.contains(event.target as Node)) {
        isOpen.value = false;
    }
};

const onClickOutside = (event: MouseEvent) => {
    if (!dropdown.value?.contains(event.target as Node)) {
        isOpen.value = false;
    }
};

// Add event listener to handle clicks outside of the component
document.addEventListener('click', onClickOutside);

onUnmounted(() => {
    document.removeEventListener('click', onClickOutside);
});
</script>

<style scoped>
/* Add your styles here */
</style>

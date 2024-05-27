<script lang="ts" setup>
import 'vue-search-select/dist/VueSearchSelect.css';
import {useField} from 'vee-validate';

interface SelectItem {
    name: string;
    value: string | number | boolean;
}

interface Props {
    label: string;
    name: string;
    options: SelectItem[];
    direction?: string;
    padding?: string;
    height?: string;
    crud?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    direction: 'right',
    crud: false,
});

const {errorMessage, value} = useField(props.name);
const emit = defineEmits(['addNew', 'selectedItem']);
</script>

<template>
    <div :class="['field-container', {error: !!errorMessage}]">
        <label :for="name" class="text-xs uppercase font-medium">{{
            label
        }}</label>
        <select
            v-model="value"
            :name="name"
            :id="name"
            class="bg-base-10"
            :class="[height]"
            @change="emit('selectedItem', value)"
        >
            <option selected disabled v-if="options.length">
                Select option
            </option>
            <option selected disabled v-else>No options Provided</option>
            <option
                v-for="option in options"
                :value="option.value"
                :key="option.name"
            >
                {{ option.name }}
            </option>
        </select>

        <button class="btn btn-xs" v-if="crud" @click.prevent="emit('addNew')">
            Add New
        </button>
        <div v-if="errorMessage" class="message">{{ errorMessage }}</div>
    </div>
</template>

<style scoped>
    .field-container {
        @apply flex flex-col gap-3 items-start;
        @apply dark:text-white text-white;
    }

    label {
        @apply leading-none font-normal text-sm text-black;
        font-weight: 700;
    }

    select {
        @apply py-1 px-3 pr-9 block w-full border-gray-200 shadow-sm text-sm rounded-lg;
        @apply focus:border-blue-500 focus:ring-blue-500;
        @apply bg-white border-gray-700 text-black; /* Adjusted line for text and background color */
        @apply h-10;
        font-weight: 700;
        color: #2a3b92;
    }

    option {
        @apply text-black bg-white; /* Ensure text is black on a white background for all options */
    }

    /* Styling for the disabled option to mimic placeholder appearance */
    select option[disabled] {
        color: black;
        background-color: white;
    }

    .message {
        @apply text-sm;
    }

    &.error .select {
        @apply border-red-600 border;
    }

    .error label {
        @apply text-error;
    }

    .error .message {
        @apply text-error text-xs capitalize;
    }
</style>

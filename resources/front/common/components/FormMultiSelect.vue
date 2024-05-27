<script setup lang="ts">
import {useField} from 'vee-validate';
import {computed} from 'vue';
import Multiselect from '@@/@vueform/multiselect';

interface SelectedResult {
    id: number,
    name: string,
}
interface Props {
    // id: string;
    name: string;
    mode?: string;
    label?: string;
    placeholder?: string;
    closeOnSelect?: boolean;
    filterResults?: boolean;
    minChars?: number;
    resolveOnLoad?: boolean;
    delay?: number;
    searchable?: boolean;
    options: SelectedResult[];// Update the type of options as per your data structure
    valueProp: string;
    trackBy: string;
    labelProp: string;
    crud?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    mode: 'tags',
    placeholder: 'Choose your option',
    closeOnSelect: false,
    filterResults: false,
    minChars: 1,
    resolveOnLoad: false,
    delay: 0,
    searchable: true,
});


const {errorMessage} = useField(props.name);
const emit = defineEmits(['select', 'deselect', 'addNew']);

const onSelect = (value: any) => {
    emit('select', value);
};

const onDeselect = (value: any) => {
    emit('deselect', value);
};

</script>

<template>
    <div :class="['multiselect-container', { error: !!errorMessage }]">
        <label :for="name" class="">{{ label }}</label>
        <Multiselect
            :name="name"
            :mode="mode"
            :placeholder="placeholder"
            :closeOnSelect="closeOnSelect"
            :filterResults="filterResults"
            :minChars="minChars"
            :resolveOnLoad="resolveOnLoad"
            :delay="delay"
            :searchable="searchable"
            :options="options"
            :valueProp="valueProp"
            :trackBy="trackBy"
            :labelProp="labelProp"
            class=""
            @select="onSelect"
            @deselect="onDeselect"
        />
        <option selected disabled v-if="options.length">Select option</option>
        <option selected disabled v-else>No options Provided</option>
        <option v-for="option in options" :value="option.id" :key="option.name">{{option.name}}</option>
        <div v-if="errorMessage"  class="message">{{ errorMessage }}</div>
        <button v-if="crud" @click.prevent="emit('addNew')"
                class="btn btn-md  mb-1 w-full pt-1 text-red-600 mt-6 bg-primary">
            {{'Add New Members'}}
        </button>
    </div>
</template>


<style scoped>
.multiselect-container {
    @apply flex flex-col gap-3 mt-2 items-start;
    @apply dark:text-black text-black;

    label {
        @apply leading-none font-normal text-sm text-black;
        font-weight: 700;
    }

    .message {
        @apply text-sm text-red;
    }

    &.error {
        .message {
            @apply text-accent text-xs capitalize;
        }
    }
}
</style>

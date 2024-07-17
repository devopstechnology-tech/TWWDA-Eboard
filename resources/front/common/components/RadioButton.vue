<template>
    <div>
        <h3>{{ title }}</h3>
        <ul>
            <li v-for="(option, index) in options" :key="index">
                <input type="radio" :id="'radio-' + index" :value="option.value" v-model="selectedValue" @change="emitSelectedOption" />
                <label :for="'radio-' + index">{{ option.title }}</label>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import {ref} from 'vue';

const props = defineProps({
    title: String,
    options: Array,
    name: String, // Ensure this is passed and used correctly if needed
});

const selectedValue = ref('');

const emitSelectedOption = () => {
    // Emit selectedValue back to parent component
    emit('update:modelValue', selectedValue.value);
};
</script>

<style scoped>
/* Add your styles here */
</style>

function emit(arg0: string, value: string) {
  throw new Error('Function not implemented.');


<script lang="ts" setup>
import {useField} from 'vee-validate';
import {defineProps, withDefaults} from 'vue';

interface Props {
    label?: string;
    name: string;
    direction?: string;
    disabled?: boolean;
    padding?: string;
    placeholder?: string;
    type?: 'email' | 'password' | 'text' | 'number';
    labeled?: boolean;
    required?: boolean;
}

// Set default props values
const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: 'Enter details',
    labeled: true,
    required: false,
});

// Use useField to connect input with Vee-Validate
const {errorMessage, value} = useField(props.name);

</script>

<template>
    <div :class="['field-container', { error: !!errorMessage }]">
        <label v-if="props.labeled" :for="props.name">{{ props.label }}</label>
        <input :id="props.name"
               v-model="value"
               :disabled="props.disabled"
               :placeholder="props.placeholder"
               :type="props.type"
               :required="props.required"
               :class="['w-full', props.disabled ? 'input-disabled' : '']"
        >
        <div v-if="errorMessage" class="message">{{ errorMessage }}</div>
    </div>
</template>

<style scoped>
.field-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: start;
}

input {
    padding: 10px 15px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: inset 0 1px 3px #ddd;
}

input:focus {
    border-color: #0056b3;
    box-shadow: 0 0 8px rgba(0, 106, 255, 0.5);
}

.error input {
    border-color: red;
}

.message {
    color: red;
    font-size: 0.875rem;
}
</style>

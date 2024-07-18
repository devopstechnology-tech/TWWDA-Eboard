
<script setup lang="ts">
import {useField} from 'vee-validate';
import {defineEmits, defineProps, onMounted, watch} from 'vue';

interface RadioOption {
    name: string;
    value: string | number | boolean;
    title?: string; // Optional title property
}

interface Props {
    label: string;
    name: string;
    options: RadioOption[];
    inline?: boolean;
    checked?: string | number | boolean;
}

const props = withDefaults(defineProps<Props>(), {
    inline: true,  // Default to inline to match AdminLTE style
    checked: '',
});
console.log('props', props);
const {errorMessage, value} = useField(props.name);
const emit = defineEmits(['update:modelValue']);

const getOptionValue = (option: RadioOption): string | number | boolean => {
    console.log('testing', option.title !== undefined ? option.title : option.value);
    return option.title !== undefined ? option.title : option.value;
};

watch(value, (newVal) => {
    emit('update:modelValue', newVal);
});

onMounted(() => {
    if (props.checked) {
        value.value = props.checked;
        console.log('value.value', value.value);
    }
});
</script>
<template>
    <div :class="['field-container', { 'error': !!errorMessage }]">
        <label :for="props.name" class="text-xs uppercase font-medium">{{ props.label }}</label>
        <div class="form-group clearfix">
            <div v-for="(option, index) in props.options" :key="index" class="icheck-primary d-inline mr-2">
                <input
                    type="radio"
                    :id="`${props.name}-${index}`"
                    :name="props.name"
                    v-model="value"
                    :value="getOptionValue(option)"
                    :checked="value === getOptionValue(option)"
                    class="mr-2"
                />
                <label :for="`${props.name}-${index}`">
                    {{ option.title || option.value }} <!-- Display title if available, otherwise display value -->
                </label>
            </div>
        </div>
        <div v-if="errorMessage" class="message text-error">{{ errorMessage }}</div>
    </div>
</template>

<style scoped>
.field-container {
    @apply flex flex-col gap-3 items-start;
    @apply dark:text-white text-white;
}

label {
    @apply leading-none font-normal text-sm;
    font-weight: 700;
}

.message {
    @apply text-sm;
}

.error input[type="radio"] {
    @apply border-red-600;
}

.error label {
    @apply text-error;
}
</style>

<template>
  
    <div :class="['field-container', { error: !!errorMessage }]">
        <label v-if="props.labeled" :for="props.name">{{ props.label }}</label>
        <VueDatePicker
            :id="props.name"
            :name="props.name"
            v-model="value"
            :model-type="props.modeltype"
            :time-picker="props.mode === 'time-picker'"
            :month-picker="props.mode === 'month-picker'"
            :year-picker="props.mode === 'year-picker'"
          
            :enable-time-picker ="props.enabletimepicker"
            :is-24 ="props.is24"
         
            :placeholder="props.placeholder"
            :min-date="props.minDate"
            :max-date="props.maxDate"
            :disabled-dates="props.disabledDates"
            input-class-name="dp_custom_input"
         
            @update:modelValue="updateValue"
        />
        <div v-if="errorMessage" class="message">{{ errorMessage }}</div>
    </div>
</template>

<script lang="ts" setup>
import '@vuepic/vue-datepicker/dist/main.css';
import VueDatePicker from '@vuepic/vue-datepicker';
import {useField} from 'vee-validate';
import {defineProps, ref,watch,withDefaults} from 'vue';

interface Props {
    label?: string;
    name: string;
    mode: 'time-picker' | 'month-picker' | 'year-picker' | 'date-picker';
    placeholder?: string;
    enabletimepicker?: boolean;
    modeltype?: string;
    is24?: boolean;
    format?: string;
    minDate?: Date | null;
    maxDate?: Date | null;
    disabledDates?: Date[];
    labeled?: boolean;
    required?: boolean;
}

// Set default props values
const props = withDefaults(defineProps<Props>(), {
    labeled: true,
    required: false,
});

// Use useField to connect input with Vee-Validate
const {errorMessage, value: fieldValue} = useField(props.name);
const value = ref<Date | null>(null);

watch(fieldValue, (newVal) => {
    value.value = newVal as string;
});
const updateValue = (newVal: Date | null) => {
    value.value = newVal;
    fieldValue.value = newVal;
};
</script>

<style lang="scss">
.field-container {
@apply flex flex-col gap-3 items-start;
@apply dark:text-black text-black;

label {
@apply leading-none font-normal text-sm text-black;
font-weight: 700;
color: #212121;
}

.v3dp__datepicker {
@apply flex flex-col gap-1 self-stretch;
@apply rounded-md;
@apply dark:text-white text-black;

@apply hover:ring-2 hover:ring-white/50;

&::placeholder {
  @apply italic text-alt text-sm;
}

&:focus-within {
  @apply ring ring-4 ring-white/50;
}
}

.v3dp__input_wrapper {
@apply flex flex-row;
}

.message {
@apply text-sm;
}

&.error {
input {
  @apply border-red-600 border-2;
  // @apply bg-red-500/80;

  &::placeholder {
    @apply italic;
  }
}

label {
  @apply text-yellow-600;
}

.message {
  @apply text-accent text-xs capitalize;
}
}
}

.dp_custom_input {
font-weight: 700!important;
color: #2a3b92!important;
}
</style>

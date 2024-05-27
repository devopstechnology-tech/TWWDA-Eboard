<script lang="ts" setup>
import '@vuepic/vue-datepicker/dist/main.css';
import VueDatePicker from '@vuepic/vue-datepicker';
import {Field,useField} from 'vee-validate';
import {defineProps,ref, watch} from 'vue';

interface Props {
    label: string;
    name: string;
    flow: ('time' | 'calendar' | 'month' | 'year' | 'minutes' | 'hours' | 'seconds')[];
    type?: 'email' | 'password' | 'text' | 'number';
}


const props = defineProps<Props>();
const {errorMessage, value: fieldValue} = useField(props.name);
const value = ref<Date | null>(null);
const emit = defineEmits(['updateTimezone']);
watch(fieldValue, (newVal) => {
    value.value = newVal;
});

watch(value, (newVal) => {
    emit('updateTimezone', newVal);
}, {deep: true});
</script>

<template>
    <div :class="['field-container', { error: !!errorMessage }]">
        <label :for="props.name">{{ props.label }}</label>
        <Field :name="props.name" v-slot="{ field }">
            <VueDatePicker
                v-model="value"
                v-bind="field"
                :flow="props.flow"
                input-class-name="dp_custom_input"
                @update:modelValue="emit('updateTimezone', value)"/>
            <div v-if="errorMessage" class="message">{{ errorMessage }}</div>
        </Field>
    </div>
</template>

<style lang="scss">
.field-container {
    @apply flex flex-col gap-3 items-start;
	@apply dark:text-black text-black;

    label {
        @apply leading-none font-normal text-sm text-black ;
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
            @apply bg-red-500/80;

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



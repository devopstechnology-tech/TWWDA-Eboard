<script lang="ts" setup>
import {Field, useField} from 'vee-validate';
import VueDatepicker from 'vue3-datepicker';

interface Props {
    label: string;
    name: string;
    type?: 'email' | 'password' | 'text' | 'number';
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
});

const {errorMessage, value} = useField(props.name);
// const pickedDate = ref(new Date());
</script>

<template>
    <div :class="['field-container', { error: !!errorMessage }]">
        <label :for="name" class="">{{label}}</label>
        <Field v-slot="{ field }" v-model="value" :name="name">
            <VueDatepicker v-bind="field" :name="name"
                           class="date flex input input-accent  input-bordered w-full "/>
            <!--        >-->
            <div v-if="errorMessage" class="message">{{errorMessage}}</div>
        </Field>
    </div>
</template>

<style scoped>
.field-container {
    @apply flex flex-col gap-3 mt-2 items-start;
    @apply dark:text-black;

    label {
        @apply leading-none font-normal text-sm;
        @apply dark:text-white text-black;
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
</style>

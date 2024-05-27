<script lang="ts" setup>
import {useField} from 'vee-validate';

interface Props {
    label: string;
    name: string;
    direction?: string;
    disabled?: boolean;
    padding?: string;
    placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {});

const {errorMessage, value} = useField(props.name);
</script>

<template>
    <div :class="['field-container', { error: !!errorMessage }]">
        <label :for="name" class="">{{label}}</label>
        <input :id="name"
               v-model="value"
               :name="name"
               :placeholder="placeholder"
               type="checkbox"
               :disabled="disabled"
               :checked="value===true"
               class="checkbox checkbox-primary"
               :class="[disabled?'input-disabled':'']"
        >
        <div v-if="errorMessage" class="message">{{errorMessage}}</div>
    </div>
</template>


<style scoped>
.field-container {
    @apply flex items-center justify-between  mt-6 gap-1 mx-1;

    label {
        @apply leading-none font-normal text-sm;
    }

    input {
        @apply flex flex-col gap-1 self-stretch;
        @apply rounded-md;
        @apply hover:ring hover:ring-white/50;

        &::placeholder {
            @apply italic text-alt text-sm;
        }

        &:focus-within {
            @apply ring ring-white/50;
        }
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
            @apply text-error text-xs capitalize;
        }
    }
}
</style>


<script lang="ts" setup>
import {Field, useField} from 'vee-validate';

interface Props {
    label: string;
    name: string;
    direction?: string;
    rows?: number;
    padding?: string;
    placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
    rows: 5,
});

const {errorMessage, value} = useField(props.name);
</script>

<template>
    <div :class="['field-container', { error: !!errorMessage }]">
        <label :for="name" class="">{{label}}</label>
        <!-- <Field v-slot="{ field }" v-model="value" :name="name"> -->

        <textarea :id="name"
                  v-model="value"
                  :name="name"
                  :placeholder="placeholder"
                  :rows="rows!"
                  class="text-area textarea-accent w-full">
        </textarea>
        <div v-if="errorMessage" class="message">{{errorMessage}}</div>
        <!-- </Field> -->

    </div>
</template>

<style scoped>
.field-container {
    @apply flex flex-col gap-3 items-start w-full;
    @apply bg-transparent border-none;

    label {
        @apply leading-none font-normal text-sm text-black ;
        font-weight: 700;
    }

    textarea {
        @apply flex flex-col gap-1 self-stretch;
        @apply rounded-md;
        @apply dark:text-black text-black;

        @apply hover:ring-2 hover:ring-white/50;
        @apply bg-white;
        font-weight: 700!important;
        color: #2a3b92!important;

        &::placeholder {
            @apply italic text-alt text-sm;
        }
    }

    .message {
        @apply text-sm;
    }

    &.error {
        textarea {
            @apply border-red-600 border-2;
            /* @apply bg-red-500/80; */

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

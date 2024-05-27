<script lang="ts" setup>
import {useField} from 'vee-validate';

interface Props {
    label: string;
    name: string;
    direction?: string;
    disabled?: boolean;
    padding?: string;
    placeholder?: string;
    accept?: string;
}

const props = withDefaults(defineProps<Props>(), {});

const {errorMessage, value} = useField(props.name);

// interface HTMLInputEvent extends Event {
//     target: HTMLInputElement & EventTarget | null;
// }

const updateFile = (e: Event) => {
    const target = e.target as HTMLInputElement;
    value.value = (target.files as FileList)[0];
};
</script>

<template>
    <div :class="['field-container', { error: !!errorMessage }]">
        <label :for="name" class="">{{label}}</label>
        <input :id="name"
               :name="name"
               :placeholder="placeholder"
               type="file"
               ref="file"
               :disabled="disabled"
               @change="updateFile"
               :accept="accept"
               class="form-control file-input file-input-bordered file-input-accent w-full"
               :class="[disabled?'input-disabled':'']"
        >
        <div v-if="errorMessage" class="message">{{errorMessage}}</div>
    </div>
</template>

<style scoped>
.field-container {
    @apply flex flex-col gap-3 mt-2 items-start;

    label {
        @apply leading-none font-normal text-sm text-black ;
        font-weight: 700;
    }

    input {
        @apply flex flex-col gap-1 self-stretch;
        @apply rounded-md;

        @apply hover:ring-2 hover:ring-white/50;

        &::placeholder {
            @apply italic text-alt text-sm;
        }

        &:focus-within {
            @apply ring ring-4 ring-white/50;
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

<script lang="ts" setup>
import {useField} from 'vee-validate';

interface Props {
    label?: string;
    name: string;
    direction?: string;
    disabled?: boolean;
    padding?: string;
    placeholder?: string;
    type?: 'email' | 'password' | 'text' | 'number';
    labeled?: boolean; // Add labeled prop
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: 'Enter details',
    // labeled: true, // Default labeled to true
});

const {errorMessage, value} = useField(props.name);
</script>

<template>
    <div :class="['field-container', { error: !!errorMessage }]">
        <label v-if="props.labeled" :for="name" class="">{{label}}</label>
        <input :id="name"
               :labeled="labeled"
               v-model="value"
               :name="name"
               :placeholder="placeholder"
               :type="type"
               :disabled="disabled"
               class="w-full"
               :class="[disabled?'input-disabled':'']"
        >
        <div v-if="errorMessage" class="message">{{errorMessage}}</div>
    </div>
</template>

<style scoped>
.field-container {
    @apply flex flex-col gap-3 items-start;
	@apply dark:text-black text-black;

    label {
        @apply leading-none font-normal text-sm text-black ;
        font-weight: 700;
    }

    input {
        @apply py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg;
        @apply focus:border-blue-500 focus:ring-blue-500 ;
		@apply bg-white;
        @apply dark:border-gray-700 dark:text-black;
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
        input {
            @apply border-red-600 border;

            &::placeholder {
                @apply italic text-black;
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

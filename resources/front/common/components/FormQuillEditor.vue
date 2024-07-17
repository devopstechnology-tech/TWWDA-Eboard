<template>
    <div :class="['field-container ql-custom', { error: !!errorMessage }]">
        <label v-if="label" :for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ label }}</label>
        <QuillEditor
            v-model:content="localContent"
            :theme="theme"
            :placeholder="placeholder"
            :toolbar="toolbar"
            :contentType="contentType"
            class="text-area textarea-accent w-full"
        />
        <p v-if="errorMessage" class="text-red-500 text-xs mt-1">{{ errorMessage }}</p>
    </div>
</template>
  
<script lang="ts" setup>
import 'quill/dist/quill.snow.css';
import {QuillEditor} from '@vueup/vue-quill';
import {useField} from 'vee-validate';
import {ref, watch} from 'vue';
  
interface Props {
    name: string;
    label?: string;
    theme?: 'snow' | 'bubble' | '';
    toolbar?: string | Array<string> | object;
    placeholder?: string;
    contentType?: 'html' | 'text' | 'delta';
}
  
const props = defineProps<Props>();
  
const {value, errorMessage} = useField(props.name);
const localContent = ref<string | undefined>(value.value as string | undefined);
  
watch(localContent, (newValue) => {
    value.value = newValue;
});
  
watch(value, (newValue) => {
    localContent.value = newValue as string;
});
</script>
  
  <style scoped>
  .field-container {
    margin-bottom: 1rem;
  }
  
  .ql-container {
    @apply flex flex-col gap-1 self-stretch;
    @apply rounded-md;
    @apply dark:text-black text-black;
    @apply hover:ring-2 hover:ring-white/50;
    @apply bg-white;
    font-weight: 700 !important;
    color: #2a3b92 !important;
  }
  
  .text-area {
    @apply border rounded p-2;
  }
  
  .text-red-500 {
    color: #f56565;
  }
  
  .text-xs {
    font-size: 0.75rem;
  }
  
  .mt-1 {
    margin-top: 0.25rem;
  }
  .ql-custom{
    margin-bottom: 3.5rem !important;
}
  </style>
  
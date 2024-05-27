<template>
    <div>
        <label v-if="props.labeled" :for="props.name">{{ props.label }}</label>
        <div class="email-list">
            <div v-for="(field, index) in fields" :key="field.key" class="email-entry">
                <input v-model="field.value" :disabled="props.disabled"
                       :placeholder="props.placeholder" :type="props.type"
                       class="email-input">
                <button @click="() => remove(index)">Remove</button>
            </div>
        </div>
        <input v-model="newEmail" :placeholder="props.placeholder"
               :type="props.type" @keyup.enter="addEmail">
        <button @click="addEmail">Add Email</button>
    </div>
</template>

<script lang="ts" setup>
import {useFieldArray, useForm, yupResolver} from 'vee-validate';
import {defineProps, ref, withDefaults} from 'vue';
import * as yup from 'yup';

interface Props {
    label?: string;
    direction?: string;
    disabled?: boolean;
    padding?: string;
    placeholder?: string;
    type?: 'email' | 'password' | 'text' | 'number';
    labeled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'email',
    placeholder: 'Enter user email and press enter',
    labeled: true,
});

const emailSchema = yup.object({
    emails: yup.array().of(yup.string().email('Invalid email').required()),
});

const {handleSubmit, form} = useForm({
    validationSchema: emailSchema,
    initialValues: {
        emails: [],
    },
    resolver: yupResolver(emailSchema),
});

const {fields, append, remove} = useFieldArray({
    name: 'emails',
    form,
});

const newEmail = ref('');

const addEmail = () => {
    if (newEmail.value) {
        append({value: newEmail.value});
        newEmail.value = ''; // Clear the input after adding
    }
};
</script>

  <style scoped>
  .email-list {
      display: flex;
      flex-direction: column;
  }
  .email-entry {
      margin-bottom: 10px;
  }
  .email-input, .new-email-input {
      margin-right: 5px;
  }
  </style>

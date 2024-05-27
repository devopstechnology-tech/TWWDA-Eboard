<template>
    <h3 class="my-3 text-gray-900 dark:text-white text-xs leading-none font-normal">{{ title }}</h3>
    <ul
        class="items-center w-full text-sm font-medium text-gray-900
        bg-white rounded-lg lg:flex dark:bg-gray-710 dark:border-gray-600 dark:text-black">
        <li class="" v-for="(option,i) in options" :key="i">
            <div class="col-md-12">
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        <input v-model="value" :value="option.value" type="radio" :id="'radio-' + (i + 1)" :name="name"/>
                        <label :for="'radio-' + (i + 1)" class="ml-2">
                            {{ option.name }}
                        </label>
                    </div>
                </div>
            </div>
        </li>
        <div v-if="errorMessage" class="message">{{ errorMessage }}</div>
    </ul>
</template>

<script lang='ts' setup>

import {useField} from 'vee-validate';

type optionsType = {
    name: string,
    value: string
}

interface Props {
    title: string;
    name: string;
    options: optionsType[];
}

const props = withDefaults(defineProps<Props>(), {
    title: 'Select an option',
});
const {errorMessage, value} = useField(props.name);

</script>

<style scoped>


</style>

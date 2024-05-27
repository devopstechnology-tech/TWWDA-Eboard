<script lang="ts" setup>

import {faSpinner} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

withDefaults(defineProps<{
    color?: string
}>(), {
    color: 'text-black',
});
</script>

<template>
    <div class="flex justify-center items-center gap-12 flex-col mt-12 h-full">
        <FontAwesomeIcon :class="['fa-spin  fa-4x', color]" :icon="faSpinner"/>
        <span class="text-xl">Loading ...</span>
    </div>
</template>

<style scoped>

</style>

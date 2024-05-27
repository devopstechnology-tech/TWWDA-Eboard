<script lang="ts" setup>
import useMetaStore from '@/common/stores/meta.store';

// Initialize the meta store to allow errors to bubble up to the root.
useMetaStore().initialize();
</script>

<template>
    <RouterView/>
</template>
<style scoped>
/* * {
	@apply dark:text-white text-black;
} */
</style>

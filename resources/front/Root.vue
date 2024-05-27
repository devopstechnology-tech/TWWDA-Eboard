<script lang="ts" setup>
import {onErrorCaptured, ref} from 'vue';
import App from '@/App.vue';
import ErrorBoundary from '@/common/components/ErrorBoundary.vue';
// import ForbiddenError from '@/common/errors/ForbiddenError';
// import ForbiddenErrorPage from '@/common/pages/ForbiddenErrorPage.vue';
import GenericErrorPage from '@/common/pages/GenericErrorPage.vue';
// import {Permission} from '@/common/parsers/permissionParser';
// import {isErrorClass} from '@/common/utilities/isError';

const errorEncountered = ref<Error>();

onErrorCaptured((err) => {
    errorEncountered.value = err;
    console.error(err);

    return false;
});
</script>

<template>
    <ErrorBoundary>
        <template #default>
            <App/>
            <notifications position="top right"/>
        </template>
        <template #error="{error}">
            <!--            <ForbiddenErrorPage-->
            <!--                v-if="isErrorClass(error, ForbiddenError)"-->
            <!--                :permissions="error.permissions as Permission[]"-->
            <!--            />-->
            <GenericErrorPage
                :error="error"
            />
        </template>
    </ErrorBoundary>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600;700&display=swap');

@tailwind base;
@tailwind components;
@tailwind utilities;


</style>

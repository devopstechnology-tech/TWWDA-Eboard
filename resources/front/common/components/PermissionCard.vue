<script setup lang="ts">

import {faLockOpen, faShieldBlank} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {Permission} from '@/common/parsers/permissionParser';

defineProps<{
    permission: Permission
}>();
</script>

<template>
    <div class="mb-4 rounded-lg">
        <a href="#"
           class="relative inline-block duration-300 rounded-lg
                       ease-in-out transition-transform transform hover:-translate-y-0.5 w-full  text-xs">
            <div class="shadow p-4 bg-gray-400 rounded-lg">
                <div class="mt-4">
                    <h2 class="font-medium text-base md:text-sm text-gray-800 line-clamp-1"
                        title="New York">
                        {{permission.full_name}}
                    </h2>
                </div>

                <div class="flex flex-col gap-4 mt-8">
                    <div class="flex-col xl:flex-row xl:items-center text-gray-800">
                        <FontAwesomeIcon :icon="faShieldBlank"/>
                        <span class="mt-2 ml-2 xl:mt-0 text-xs">
                            {{permission.name}}
                        </span>
                    </div>
                    <div class="flex-col xl:flex-row xl:items-center text-gray-800">
                        <FontAwesomeIcon :icon="faLockOpen"/>
                        <span class="mt-2 ml-2 xl:mt-0 text-xs">
                            {{permission.class}}
                        </span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>

<style scoped>

</style>

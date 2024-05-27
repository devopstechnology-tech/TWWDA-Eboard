<script setup lang="ts">

import {faCheckToSlot, faPencil, faShieldBlank, faTrash, faUsers} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {Role} from '@/common/parsers/roleParser';

defineProps<{
    role: Role
}>();
const emit = defineEmits<{
    (event: 'edit', data: Role): void;
    (event: 'delete', data: Role): void;
}>();
</script>

<template>
    <div class="mb-4 rounded-lg">
        <a href="#"
           class="relative inline-block duration-300 rounded-lg
                       ease-in-out transition-transform transform hover:-translate-y-0.5 w-full  text-xs">
            <div class="shadow p-4 bg-white rounded-lg" :class="`role-${role.type}`">
                <div class="mt-4">
                    <h2 class="font-medium text-base md:text-lg text-gray-800 line-clamp-1"
                        title="New York">
                        {{role.name}}
                    </h2>
                </div>

                <div class="flex flex-col gap-4 mt-8">
                    <div class="flex-col xl:flex-row xl:items-center text-gray-800">
                        <FontAwesomeIcon :icon="faCheckToSlot"/>
                        <span class="mt-2 ml-2 xl:mt-0 text-xs">
                            Type: {{role.type}}
                        </span>
                    </div>
                    <div class="flex-col xl:flex-row xl:items-center text-gray-800">
                        <FontAwesomeIcon :icon="faShieldBlank"/>
                        <span class="mt-2 ml-2 xl:mt-0 text-xs">
                            {{role.permissions_count}} permissions
                        </span>
                    </div>
                    <div class="flex-col xl:flex-row xl:items-center text-gray-800">
                        <FontAwesomeIcon :icon="faUsers"/>
                        <span class="mt-2 ml-2 xl:mt-0 text-xs">
                            {{role.users_count}} users
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8">
                    <button class="btn btn-xs" @click="emit('edit',role)">
                        <FontAwesomeIcon :icon="faPencil"/>
                    </button>
                    <button class="btn btn-xs bg-gray-300"
                            @click="emit('delete',role)">
                        <FontAwesomeIcon :icon="faTrash"/>
                    </button>
                </div>
            </div>
        </a>
    </div>
</template>

<style scoped>
.role-system {
    @apply bg-red-300/60;
}

.role-default {
    @apply bg-green-300/60;
}

.role-admin {
    @apply bg-orange-300/60;
}
</style>

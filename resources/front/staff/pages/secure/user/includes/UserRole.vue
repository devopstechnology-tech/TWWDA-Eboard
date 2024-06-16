<template>
    <div class="role-container w-100 d-flex justify-content-center">
        <div class="dropdown" v-if="dropdownAvailable" ref="dropdownRef">
            <button :class="['btn btn-primary dropdown-toggle text-truncate w-100', roleClass]" type="button"
                    @click="toggleDropdown"
                    aria-haspopup="true" :aria-expanded="dropdownOpen">
                <i :class="roleIcon" class="mr-2"></i> {{ roleText }}
            </button>
            <ul v-if="dropdownOpen" class="dropdown-menu show justify-content" aria-labelledby="role-status">
                <li v-for="role in filteredRoles" :key="role.name">
                    <a href="#" class="dropdown-item"
                       @click.prevent="updateRole(role)">
                        <i :class="role.icon" class="mr-2"></i> {{ role.name }}
                    </a>
                </li>
            </ul>
        </div>
        <div v-else class="text-center">
            <i :class="roleIcon" class="mr-2"></i> {{ 'Super Admin' }}
        </div>
    </div>
</template>

<script setup lang="ts">
import {computed, ref} from 'vue';
import {Role} from '@/common/parsers/roleParser';

const props = defineProps<{
    user: {
        id: string;
        role: string;
        email: string;
        roles: Array<{ name: string, type: string }>;
    };
    roles: Role[];
    disableRemoteRole: number;
}>();

const emit = defineEmits<{
    (e: 'role-updated', event: { userId: string; userEmail: string; role: string }): void;
}>();

const dropdownRef = ref(null);
const dropdownOpen = ref(false);

const toggleDropdown = (event: Event) => {
    event.stopPropagation();
    dropdownOpen.value = !dropdownOpen.value;
};

const closeDropdown = () => {
    if (dropdownOpen.value) {
        dropdownOpen.value = false;
    }
};

const updateRole = (role: Role) => {
    emit('role-updated', {userId: props.user.id, userEmail: props.user.email, role: role.name});
    dropdownOpen.value = false;
};

const roleText = computed(() => props.user.roles[0]?.name || 'Select Role');
const roleClass = computed(() => `bg-${props.user.roles[0]?.name.toLowerCase()} text-white`);
const roleIcon = computed(() => {
    const roleType = props.user.roles[0]?.type;
    return `mr-2 fa ${mapIconToRole(roleType)}`;
});

const dropdownAvailable = computed(() => {
    return props.user.roles[0]?.name !== 'System';
});

const filteredRoles = computed(() => {
    return props.roles.filter(role => role.name !== 'System').map(role => ({
        ...role,
        icon: `mr-2 fa ${mapIconToRole(role.type)}`,
    }));
});

const mapIconToRole = (type: string) => {
    const iconMap: { [key: string]: string } = {
        system: 'fa-cogs',
        admin: 'fa-user-shield',
        ceo: 'fa-user-tie',
        companychairman: 'fa-chess-king',
        companysecretary: 'fa-user-secret',
        chairperson: 'fa-users',
        secretary: 'fa-user-circle',
        guest: 'fa-user-tag',
        observer: 'fa-binoculars',
    };
    return iconMap[type.toLowerCase()] || 'fa-user';
};
</script>

<style scoped>
.role-container {
    display: flex;
    align-items: center;
}

.dropdown {
    position: relative;
}

.btn.dropdown-toggle {
    display: flex;
    align-items: center;
    background-color: #007bff; /* AdminLTE primary color */
    border: 1px solid #ccc;
    padding: 5px 10px;
    cursor: pointer;
    width: auto;
    height: 42px;
    max-width: 100%; /* Ensure the button does not exceed the container width */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.btn.dropdown-toggle {
    margin-left: 5px;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-top: 0.125rem;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
    list-style: none;
    padding: 0;
    z-index: 1000;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    padding: 10px;
    cursor: pointer;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}
</style>

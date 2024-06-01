<template>
    <div class="role-container">
        <!-- Only render the dropdown if the primary role is not 'System' -->
        <div class="dropdown" v-if="dropdownAvailable"  ref="dropdownRef">
            <button :class="['btn btn-icon dropdown-toggle', roleClass]" type="button"
                    @click="toggleDropdown"
                    aria-haspopup="true" :aria-expanded="dropdownOpen">
                <i :class="roleIcon" class="mr-2"></i> {{ roleText }}
            </button>
            <ul v-if="dropdownOpen" class="dropdown-menu show" aria-labelledby="role-status">
                <li v-for="role in filteredRoles" :key="role.name">
                    <a href="#" class="dropdown-item"
                       @click.prevent="updateRole(role)">
                        <i :class="role.icon"></i> {{ role.name }}
                    </a>
                </li>
            </ul>
        </div>
        <div v-else>
            <i :class="roleIcon" class="mr-2"></i> {{ 'Super Admin' }}
        </div>
    </div>
</template>
<script setup lang="ts">
import {computed, onBeforeUnmount, onMounted,ref} from 'vue';
import {useGetRolesRequest} from '@/common/api/requests/roleperm/useRolesRequest';
import {Role} from '@/common/parsers/roleParser';

const dropdownRef = ref(null); // Define ref to hold the dropdown DOM element
const props = defineProps<{
    user: {
        id: string;
        role: string;
        roles: Array<{name: string, type: string}>;
    };
    disableRemoteRole: number;
}>();

const emit = defineEmits<{
    (e: 'role-updated', event: { userId: string; role: string }): void;
}>();

const dropdownOpen = ref(false);
const allRoles = ref<Role[]>([]);

const toggleDropdown = (event:Event) => {
    event.stopPropagation();  // Prevent click from propagating to the document
    dropdownOpen.value = !dropdownOpen.value;
};

const closeDropdown = () => {
    if (dropdownOpen.value) {
        dropdownOpen.value = false;
    }
};


const updateRole = (role: Role) => {
    emit('role-updated', {userId: props.user.id, role: role.name});
    dropdownOpen.value = false;
};
onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});

const handleClickOutside = (event:Event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        closeDropdown();
    }
};
const roleText = computed(() => props.user.roles[0].name || 'Select Role');
const roleClass = computed(() => `bg-${props.user.roles[0].name.toLowerCase()} text-black`);
const roleIcon = computed(() => {
    const roleType = props.user.roles[0]?.type;
    return `mr-2 fa ${mapIconToRole(roleType)}`;
});

// Computed to determine if the dropdown should be available
const dropdownAvailable = computed(() => {
    return props.user.roles[0].name !== 'System';
});

// Filtered roles excluding 'System'
const filteredRoles = computed(() => {
    return allRoles.value.filter(role => role.name !== 'System').map(role => ({
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
    return iconMap[type.toLowerCase()] || 'fa-user'; // Default icon
};


const getRoles = async () => {
    const data = await useGetRolesRequest({paginate: 'false'});
    allRoles.value = data.data;
};

onMounted(async () => {
    await getRoles();
});
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
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 5px 10px;
    cursor: pointer;
    width:auto;
    height: 42px;
  }
  
  .btn.dropdown-toggle{
    margin-left: 5px;
  }
  
  .dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
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
  



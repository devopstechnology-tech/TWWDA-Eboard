<template>
    <div class="role-container w-100 d-flex justify-content-center">
        <div class="dropdown" v-if="dropdownAvailable" ref="dropdownRef">
            <button :class="['btn btn-primary dropdown-toggle text-truncate w-100', positionClass]" type="button"
                    @click="toggleDropdown"
                    aria-haspopup="true" :aria-expanded="dropdownOpen">
                <i :class="'mr-2 fa ' + props.membership?.position.icon" class="mr-2"></i> {{ props.membership?.position.name }}
            </button>
            <ul v-if="dropdownOpen" class="dropdown-menu show justify-content" aria-labelledby="role-status">
                <li v-for="position in Positions" :key="position.name">
                    <a href="#" class="dropdown-item"
                       @click.prevent="updateRole(position)">
                        <i :class="'mr-2 fa ' +  position.icon" class="mr-2"></i> {{ position.name }}
                    </a>
                </li>
            </ul>
        </div>
        <div v-else class="text-center">
            <i :class="'mr-2 fa ' + props.membership?.position.icon" class="mr-2"></i> {{ props.membership?.position.name }}
        </div>
    </div>
</template>

<script setup lang="ts">
import {computed, ref} from 'vue';
import {Position} from '@/common/parsers/positionParser';

const props = defineProps<{
    membership: {
        id: string;
        position:Position;
        position_id: string;
    };
    positions: Position[];
    disableRemotePosition: number;
}>();

const emit = defineEmits<{
    (e: 'position-updated', event: { membershipId: string; positionId: string }): void;
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

const updateRole = (position: Position) => {
    emit('position-updated', {membershipId: props.membership.id, positionId: position.id});
    dropdownOpen.value = false;
};
const positionClass = computed(() => `bg-${props.membership?.position.name.toLowerCase()} text-white`);

const dropdownAvailable = computed(() => {
    return props.membership?.position.name;
});

const Positions = computed(() => {
    return props.positions;
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

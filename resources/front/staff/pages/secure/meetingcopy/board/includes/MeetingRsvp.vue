<template>
    <div class="rsvp-container">
        <div v-if="attendee.membership?.user.id ===  authStore.user.id">
            <div class="dropdown">
                <button
                    :class="['btn btn-icon dropdown-toggle', rsvpClass]"
                    type="button"
                    @click="toggleDropdown"
                    aria-haspopup="true"
                    :aria-expanded="dropdownOpen"
                >
                    <i :class="rsvpIcon" class="mr-2"></i> {{ rsvpText }}
                </button>
                <ul v-if="dropdownOpen" class="dropdown-menu show" aria-labelledby="rsvp-status">
                    <li>
                        <a href="#" class="dropdown-item" @click.prevent="updateRsvp('Yes')">
                            <i class="far fa-check-circle bg-success"></i> Yes
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item" @click.prevent="updateRsvp('No')">
                            <i class="far fa-check-circle bg-warning"></i>No
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item" @click.prevent="updateRsvp('Maybe')">
                            <i class="far fa-check-circle bg-danger"></i> Maybe
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item" @click.prevent="updateRsvp('Online')">
                            <i class="far fa-check-circle bg-info"></i> Online
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item" @click.prevent="updateRsvp('Pending')">
                            <i class="far fa-check-circle bg-info"></i> Pending
                        </a>
                    </li>
                </ul>
            </div>         
        </div>
        <div v-else>
            <button>
                <i :class="rsvpIcon" class="mr-2"></i> {{ rsvpText }}
            </button>
        </div>        
    </div>
</template>
  
<script setup lang="ts">
import {computed,ref} from 'vue';
import useAuthStore from '@/common/stores/auth.store';
const authStore = useAuthStore();
const props = defineProps<{
    attendee: {
        id: string;
        meeting_id: string;
        rsvp_status: string;
        attendance_status: string;
        location: string;
        meeting: object;
        membership: object;
        membership_id: string;
    };
    disableRemoteRsvp: number;
}>();
// Yes
// No
// Maybe
// Online
// Default
const emit = defineEmits<{
    (e: 'rsvp-updated', event: { attendeeId: string; status: string }): void;
}>();
  
const dropdownOpen = ref(false);
  
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};
  
const updateRsvp = (status: string) => {
    emit('rsvp-updated', {attendeeId: props.attendee?.id, status});
    dropdownOpen.value = false;
};
  
const rsvpText = computed(() => props.attendee?.rsvp_status || 'RSVP');
const rsvpClass = computed(() => {
    switch (props.attendee?.rsvp_status) {
        case 'Yes':
            return 'bg-success text-white';
        case 'No':
            return 'bg-warning text-white';
        case 'Maybe':
            return 'bg-danger text-white';
        case 'Online':
            return 'bg-info text-white';
        case 'Pending':
            return 'bg-info text-white';
        default:
            return 'bg-secondary text-white';
    }
});
const rsvpIcon = computed(() => {
    switch (props.attendee?.rsvp_status) {
        case 'Yes':
            return 'far fa-check-circle';
        case 'No':
            return 'far fa-check-circle';
        case 'Maybe':
            return 'far fa-check-circle';
        case 'Online':
            return 'far fa-check-circle';
        case 'Pending':
            return 'far fa-check-circle';
        default:
            return 'far fa-check-circle';
    }
});
</script>
  
  <style scoped>
  .rsvp-container {
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
  
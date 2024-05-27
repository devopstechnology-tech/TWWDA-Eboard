<script setup lang="ts">
import {computed,ref} from 'vue';

const props = defineProps({
    attendee: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['attendance-updated']);

const attendanceStates = ['Attended', 'Absent'];
const nextAttendanceStatus = (currentStatus) => {
    const index = attendanceStates.indexOf(currentStatus);
    return attendanceStates[(index + 1) % attendanceStates.length];
};

const toggleAttendance = () => {
    const newStatus = nextAttendanceStatus(props.attendee.attendance_status);
    emit('attendance-updated', {attendeeId: props.attendee.id, newStatus});
};

const attendanceClass = computed(() => {
    switch (props.attendee.attendance_status) {
        case 'Attended': return ' text-success';
        case 'Absent': return ' text-danger';
        default: return ' text-secondary';
    }
});

const iconClass = computed(() => {
    return 'fas fa-check-circle'; // Using FontAwesome icon class
});
</script>

<template>
    <div class="attendance-button">
        <button :class="['btn btn-icon', attendanceClass]" @click="toggleAttendance">
            <i :class="iconClass"></i>
        </button>
    </div>
</template>
<style scoped>
.attendance-button {
    display: flex;
    justify-content: center;
    width: 100%; /* Ensure it takes full width to center the button inside it */
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px 10px;
    width: auto; /* Adjust based on your design */
    border: none; /* Styling choice */
    background: none;
}

.bg-success {
    background-color: #28a745; /* Green for attended */
}

.bg-danger {
    background-color: #dc3545; /* Red for absent */
}

.bg-secondary {
    background-color: #6c757d; /* Grey for pending */
}

.text-white {
    color: white;
}
</style>

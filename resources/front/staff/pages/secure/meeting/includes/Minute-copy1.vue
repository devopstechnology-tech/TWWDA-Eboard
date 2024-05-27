<script lang="ts" setup>
import {computed,defineProps,onMounted, ref} from 'vue';
import {useGetMeetingAgendasRequest} from '@/common/api/requests/modules/agenda/useAgendaRequest';
import FormInput from '@/common/components/FormInput.vue';
import {Agenda} from '@/common/parsers/agendaParser';


// Define the props the component expects
const props = defineProps({
    boardId: String,
    meetingId: String,
    defaultMinutes: Boolean,
});


const  boardId = props.boardId as string;
const  meetingId = props.meetingId as string;
const  defaultMinutes = props.defaultMinutes;


const minutes = ref<Minute[]>([{text: ''}]);
const allAgendas = ref<Agenda[]>([]);



const Agendas = computed(() => {
    return allAgendas;
});

onMounted(async() => {;
    if (props.defaultMinutes) {
        // Assume there's a function to fetch agendas based on meetingId
        try {
            const response = await useGetMeetingAgendasRequest(meetingId, {paginate: 'false'});
            allAgendas.value = response.data;
        } catch (error) {
            console.error('Failed to fetch agendas:', error);
        }
    } else {
        // Handle the case for default minutes
        minutes.value = [{text: ''}];
    }
});

console.log('Agendas',Agendas.value );



interface Minute {
    text: string;
}



function addMinute() {
    minutes.value.push({text: ''});
}
// function addMinute() {
//     console.log('checkin', minutes.value.length === 0 || minutes.value[minutes.value.length - 1].text.trim() !== '');
//     // Check if the last minute's text is not empty
//     if (minutes.value.length === 0 || minutes.value[minutes.value.length - 1].text.trim() !== '') {
//         minutes.value.push({text: ''}); // Add a new minute if the last one is not empty
//         nextTick(() => {
//             const inputs = document.querySelectorAll('.minute-input');
//             const lastInput = inputs[inputs.length - 1] as HTMLInputElement;
//             lastInput?.focus(); // Ensure this element exists and then focus it
//         });
//     } else {
//         // Optionally, focus the last input to draw attention to it if it's empty
//         const inputs = document.querySelectorAll('.minute-input');
//         const lastInput = inputs[inputs.length - 1] as HTMLInputElement;
//         lastInput?.focus();
//     }
// }
function removeMinute(index: number) {
    minutes.value.splice(index, 1);
}
</script>
<template>
    <div class="card h-full">
        <div class="card-header flex items-center">
            <div class="flex items-center flex-1 w-full">
                <h2 class="card-header-title h3">
                    Meeting Minutes
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" @click.prevent="openCreateTaskModal" class="btn btn-tool">
                    <i class="far fa fa-plus mr-2"></i> Publish To be Viewed by others
                </button>
            </div>
        </div>
        <div id="MinutesEditor" class="container pt-12">
            <div class="codex-editor">
                <div class="codex-editor__redactor" style="padding-bottom: 300px;">
                    <div class="ce-block">
                        <ul>
                            <li v-for="(minute, index) in minutes" :key="index">
                                <div class="input-group">
                                    <button @click="addMinute" class="add-btn">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <FormInput
                                        :value="minute.text"
                                        @keyup.enter="addMinute"
                                        :labeled="true"
                                        :label="`Minute ${index + 1} Description`"
                                        :name="minute.text"
                                        placeholder="Enter minute description"
                                        type="text"
                                        class="minute-input"
                                    />
                                </div>
                                <button v-if="index > 0" @click="removeMinute(index)" class="remove-btn">Remove</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



  <style scoped>
  .input-group {
    display: flex;
    align-items: center; /* Align items vertically in the center */
    gap: 10px; /* Optional: adds space between children */
    width: 100%; /* Ensure the group takes full width */
    margin: 10px 0; /* Vertical spacing between each group */
}

.add-btn {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #333;
    padding: 5px 10px; /* Make button easier to click */
    margin-right: 10px; /* Space between button and input */
}

.minute-input, .form-input {
    flex-grow: 1; /* Makes the input take up the remaining space */
    padding: 8px;
    font-size: 16px;
}
  .meeting-minutes {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
  }

  .minutes-header {
    background-color: #f3f3f3;
    width: 100%;
    padding: 10px 20px;
    text-align: center;
  }

  .minutes-list ul {
    list-style: none;
    width: 100%;
    padding: 0;
  }

  .input-group {
    display: flex;
    align-items: center;
    margin: 10px;
  }

  .add-btn {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #333;
  }

  .minute-input {
    flex: 1;
    padding: 8px;
    margin-left: 5px;
    font-size: 16px;
  }
  </style>
